<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\Disposition;
use App\Models\DispositionCode;
use Illuminate\Http\Request;
use DB;
use App\Models\Log;
use Session;
use Auth;
use App\Models\Template;

class ChatsService extends AppService {

    public function getTemplateList($account_id){
        return DB::table('sms_template')->where('account_id', $account_id)->get(['name', 'message'])->toArray();
    }

    public function getOpenChats($account_id) {
        $data = DB::select("select DISTINCT ls.client_number as phone,c.id, c.first_name,c.last_name,c.company, c.state, c.street, c.suite, c.city, c.zip, c.company, c.custom_0, c.custom_1, c.custom_2, c.custom_3, c.custom_4, c.custom_5, c.custom_6, c.custom_7, c.custom_8, c.custom_9 from log_sms as ls LEFT JOIN contacts AS c ON c.phone=ls.client_number AND c.account_id=ls.account_id WHERE ls.account_id='{$account_id}' AND (c.lead_status!=0 OR c.lead_status IS NULL) ORDER BY log_time DESC limit 15 ");


        $allData = [];
        foreach ($data as $datum){
            $uniqueData = DB::select("select ls.log_time, callid, SUBSTRING(ls.sms_text, 1, 15) AS sms_text, ls.status from log_sms as ls WHERE ls.account_id='{$account_id}' and ls.client_number='{$datum->phone}' ORDER BY log_time DESC limit 1 ");
            $allData[$datum->phone] = (object) array_merge((array) $datum, (array) $uniqueData[0]);

        }
        uasort($allData, function($a, $b) {
            if (strtotime($a->log_time) == strtotime($b->log_time)) return 0;
            return (strtotime($a->log_time) < strtotime($b->log_time)) ? 1 : -1;
        });

        return $allData;
    }

    public function getLatestChats($account_id,$date) {


        $data = DB::select("select DISTINCT ls.client_number as phone,c.first_name,c.last_name,c.company from log_sms as ls LEFT JOIN contacts AS c ON c.phone=ls.client_number AND c.account_id=ls.account_id WHERE ls.account_id='{$account_id}' AND ls.log_time > '{$date}' AND (c.lead_status!=0 OR c.lead_status IS NULL) ORDER BY log_time DESC limit 15 ");

        $allData = [];
        foreach ($data as $datum){
            $uniqueData = DB::select("select ls.log_time, callid, SUBSTRING(ls.sms_text, 1, 15) AS sms_text, ls.status from log_sms as ls WHERE ls.account_id='{$account_id}' and ls.client_number='{$datum->phone}' ORDER BY log_time DESC limit 1 ");
            $allData[$datum->phone] = (object) array_merge((array) $datum, (array) $uniqueData[0]);

        }
        uasort($allData, function($a, $b) {
            if (strtotime($a->log_time) == strtotime($b->log_time)) return 0;
            return (strtotime($a->log_time) < strtotime($b->log_time)) ? 1 : -1;
        });
        return $allData;
    }

    public function getCloseChats($account_id) {

        $data = DB::select("select DISTINCT ls.client_number as phone,c.first_name,c.last_name,c.company from log_sms as ls LEFT JOIN contacts AS c ON c.phone=ls.client_number AND c.account_id=ls.account_id WHERE ls.account_id='{$account_id}' AND c.lead_status=0 ORDER BY log_time DESC limit 15 ");

        $allData = [];
        foreach ($data as $datum){
            $uniqueData = DB::select("select ls.log_time, callid, SUBSTRING(ls.sms_text, 1, 15) AS sms_text, ls.status from log_sms as ls WHERE ls.account_id='{$account_id}' and ls.client_number='{$datum->phone}' ORDER BY log_time DESC limit 1 ");
            $allData[$datum->phone] = (object) array_merge((array) $datum, (array) $uniqueData[0]);

        }
        uasort($allData, function($a, $b) {
            if (strtotime($a->log_time) == strtotime($b->log_time)) return 0;
            return (strtotime($a->log_time) < strtotime($b->log_time)) ? 1 : -1;
        });

        return $allData;

    }

    public function saveDisposition($request) {
        $authUser = \Session::get('loginUser');
//        DB::enableQueryLog();
        $dataObj =  new Disposition;

        $dataObj->account_id = $this->getAccountId();
        $dataObj->record_id = $this->genRandId();
        $dataObj->callid = $request->input('clientCallid');
        $dataObj->cli = $request->input('clientNumber');
        $dataObj->cli = $request->input('clientNumber');
        $dataObj->disposition_id = $request->input('disposition_id');
        $dataObj->tstamp = time();
        $dataObj->agent_id = $authUser['extn'];
        $dataObj->note = $request->input('disposition');
        $dataObj->save();
//        dd(DB::getQueryLog());
        if($dataObj->save()) {
            return $this->processServiceResponse(true, "Disposition Added Successfully!",$dataObj);
        }
        return $this->processServiceResponse(false, "Disposition Added Failed!",$dataObj);
    }

    public function closeLeads($clientNumber) {
//        DB::enableQueryLog();
        $dataObj = $this->getContactDetails($clientNumber);
        $dataObj->lead_status = '0';
//        dd(DB::getQueryLog());
        if($dataObj->save()) {
            return $this->processServiceResponse(true, "Chat Close Successfully!",$dataObj);
        }
        return $this->processServiceResponse(false, "Chat Close Failed!",$dataObj);
    }

    public function openLeads($clientNumber) {
//        DB::enableQueryLog();
        $dataObj = $this->getContactDetails($clientNumber);
        $dataObj->lead_status = '1';
//        dd(DB::getQueryLog());
        if($dataObj->save()) {
            return $this->processServiceResponse(true, "Chat Open Successfully!",$dataObj);
        }
        return $this->processServiceResponse(false, "Chat Open Failed!",$dataObj);
    }

    public function getChatHistoryByNumber($account_id, $to, $from){
        // Get list
        $sms_from = $from;
        $sms_to = $to;

        /*$data = Log::where('account_id','=', $account_id)
            ->where('did','=', $sms_from)
            ->where('client_number','=', $sms_to)
            ->orderBy('log_time', 'DESC')
            ->paginate(config('dashboard_constant.PAGINATION_LIMIT'));*/

        $data = Log::where('account_id','=', $account_id)
            ->where('client_number','=', $sms_to)
            ->orderBy('log_time', 'ASC')
            ->paginate(config('dashboard_constant.PAGINATION_LIMIT'));

        $authUser = Session::get('loginUser');
        //$tz_offset = $this->getTimeZoneOffset($authUser['timezone']);
        foreach($data as $key => $value){
            //$value->log_time=date('Y-m-d H:i:s', strtotime($value->log_time)+$tz_offset);
            $value->log_time=$this->convertTime(config('app.timezone'), $authUser['timezone'], $value->log_time);
        }

        // update all chats data to read
        Log::where(['client_number' => $sms_to, 'status'=>'U'])->update(['status' => 'R']);

        return $this->paginationDataFormat($data->toArray());
    }

    public function getTemplates(){
        $account_id = $this->getAccountId();
        $data = Template::where('account_id', '=', $account_id)->get();
        foreach($data as $key => $value){
            $value->omessage = $value->message;
            $value->message = nl2br($value->message);
        }
        return $data->toArray();
    }

    public function getAllDisposition(){
        $account_id = $this->getAccountId();
        $data = DispositionCode::where('account_id', '=', $account_id)->get();
        $result = [];
        foreach($data as $key => $value){
            $result[$value->disposition_id] = $value->title;
        }
        return $result;
    }

    public function getClientDisposition($clientNumber){
        $account_id = $this->getAccountId();
//        $data = Disposition::where('cli', '=', $clientNumber)->orderBy('tstamp','DESC')->limit(10)->get();
        $sql = 'SELECT lsd.tstamp,sdc.title,lsd.note FROM `log_sms_disposition` as lsd LEFT JOIN sms_disposition_code as sdc ON lsd.disposition_id=sdc.disposition_id ';
        $sql .= 'where lsd.account_id = :account_id AND lsd.cli = :cli ORDER BY lsd.tstamp DESC LIMIT 10';
        $selectConditions = [
            'account_id'  => $account_id,
            'cli'         => $clientNumber
        ];
        $data = DB::select($sql, $selectConditions);
        foreach($data as $key => $value){
            $value->tstamp = date('d/m/Y',$value->tstamp);
        }
        return $data;
    }

    public function getDispositionLog($request){
        $queryParam = $request->query();
//        dump($queryParam);
        $account_id = $this->getAccountId();
//        $data = Disposition::where('cli', '=', $clientNumber)->orderBy('tstamp','DESC')->limit(10)-
//        DB::enableQueryLog();
        $query = DB::table("log_sms_disposition as lsd")
            ->leftJoin("sms_disposition_code as sdc","lsd.disposition_id","=","sdc.disposition_id");

        $stdate = isset($queryParam['start_time']) ? \DateTime::createFromFormat('Y-m-d H:i', $queryParam['start_time']) : false;
        $endate = isset($queryParam['end_time']) ? \DateTime::createFromFormat('Y-m-d H:i', $queryParam['end_time']): false;
        if($stdate !== false && $endate !== false){
            $from = $stdate->getTimestamp();
            $to = $endate->getTimestamp();
            $query->whereBetween("lsd.tstamp",[$from,$to]);
        }
        $query->where("lsd.account_id",$account_id);
        if(isset($queryParam['cli']) && !empty($queryParam['cli']) ){
            $query->where("lsd.cli",$queryParam['cli']);
        }
        if(isset($queryParam['disposition_type']) && !empty($queryParam['disposition_type']) ){
            $query->where("lsd.disposition_id",$queryParam['disposition_type']);
        }
        $data = $query->orderBy("lsd.tstamp","DESC")->paginate(config('dashboard_constant.PAGINATION_LIMIT'));
//        dd(DB::getQueryLog());
        return $this->paginationDataFormat($data->toArray());
    }

    public function getContactDetails($clientNumber){
        //Get detail
        return Contact::where('phone','=',$clientNumber)->firstOrFail();

    }

}
