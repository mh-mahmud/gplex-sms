<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\ContactStatus;
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
        $did = $this->getDid();
//        DB::enableQueryLog();
//        $data = DB::select("select DISTINCT ls.client_number as phone,c.id, c.first_name,c.last_name,c.company, c.state, c.street, c.suite, c.city, c.zip, c.company, c.custom_0, c.custom_1, c.custom_2, c.custom_3, c.custom_4, c.custom_5, c.custom_6, c.custom_7, c.custom_8, c.custom_9 from log_sms as ls LEFT JOIN contacts AS c ON c.phone=ls.client_number AND c.account_id=ls.account_id LEFT JOIN contact_opt_status AS cos ON cos.phone=ls.client_number AND cos.account_id=ls.account_id AND cos.did=ls.did WHERE ls.account_id='{$account_id}' AND ls.did='{$did}' AND (cos.status!='O' OR cos.status IS NULL) ORDER BY log_time DESC limit 20 ");
        $data = DB::select("select c.phone,c.id, c.first_name,c.last_name,c.company, c.state, c.street, c.suite, c.city, c.zip, c.company, c.custom_0, c.custom_1, c.custom_2, c.custom_3, c.custom_4, c.custom_5, c.custom_6, c.custom_7, c.custom_8, c.custom_9, c.last_text_at from contacts AS c LEFT JOIN contact_opt_status AS cos ON cos.phone=c.phone AND cos.account_id=c.account_id AND cos.did=c.last_did WHERE c.account_id='{$account_id}' AND c.last_did='{$did}' AND (cos.status!='O' OR cos.status IS NULL) ORDER BY last_text_at DESC limit 20 ");

//        dd(DB::getQueryLog());
        $allData = [];
        foreach ($data as $datum){
            $uniqueData = DB::select("select ls.log_time, callid, ls.sms_text AS sms_text, ls.status from log_sms as ls WHERE ls.account_id='{$account_id}' AND ls.did='{$did}' and ls.client_number='{$datum->phone}' ORDER BY log_time DESC limit 1 ");
            $allData[$datum->phone] = isset($uniqueData[0]) ? (object) array_merge((array) $datum, (array) $uniqueData[0]) : (object) $datum;

        }

        uasort($allData, function($a, $b) {
            if (strtotime($a->last_text_at) == strtotime($b->last_text_at)) return 0;
            return (strtotime($a->last_text_at) < strtotime($b->last_text_at)) ? 1 : -1;
        });
//        print_r($allData);
//        die();
        return $allData;
    }

    public function getLatestChats($account_id,$date) {

        $did = $this->getDid();
//        $data = DB::select("select DISTINCT ls.client_number as phone,c.first_name,c.last_name,c.company from log_sms as ls LEFT JOIN contacts AS c ON c.phone=ls.client_number AND c.account_id=ls.account_id LEFT JOIN contact_opt_status AS cos ON cos.phone=ls.client_number AND cos.account_id=ls.account_id AND cos.did=ls.did WHERE ls.account_id='{$account_id}' AND ls.did='{$did}' AND ls.log_time > '{$date}' AND (cos.status!='O' OR cos.status IS NULL) ORDER BY log_time DESC limit 20 ");
        $data = DB::select("select c.phone,c.id, c.first_name,c.last_name,c.company, c.state, c.street, c.suite, c.city, c.zip, c.company, c.custom_0, c.custom_1, c.custom_2, c.custom_3, c.custom_4, c.custom_5, c.custom_6, c.custom_7, c.custom_8, c.custom_9, c.last_text_at from contacts AS c LEFT JOIN contact_opt_status AS cos ON cos.phone=c.phone AND cos.account_id=c.account_id AND cos.did=c.last_did WHERE c.account_id='{$account_id}' AND c.last_did='{$did}' AND c.last_text_at > '{$date}' AND (cos.status!='O' OR cos.status IS NULL) ORDER BY last_text_at DESC limit 20 ");

        $allData = [];
        foreach ($data as $datum){
            $uniqueData = DB::select("select ls.log_time, callid, ls.sms_text AS sms_text, ls.status,ls.direction from log_sms as ls WHERE ls.account_id='{$account_id}' AND ls.did='{$did}' and ls.client_number='{$datum->phone}' ORDER BY log_time DESC limit 1 ");
            $allData[$datum->phone] = (object) array_merge((array) $datum, (array) $uniqueData[0]);

        }
        uasort($allData, function($a, $b) {
            if (strtotime($a->log_time) == strtotime($b->log_time)) return 0;
            return (strtotime($a->log_time) < strtotime($b->log_time)) ? 1 : -1;
        });
        return $allData;
    }

    public function getPreviousChats($account_id,$date) {

        $did = $this->getDid();
        $data = DB::select("select c.phone,c.id, c.first_name,c.last_name,c.company, c.state, c.street, c.suite, c.city, c.zip, c.company, c.custom_0, c.custom_1, c.custom_2, c.custom_3, c.custom_4, c.custom_5, c.custom_6, c.custom_7, c.custom_8, c.custom_9, c.last_text_at from contacts as c LEFT JOIN contact_opt_status AS cos ON cos.phone=c.phone AND cos.account_id=c.account_id WHERE c.account_id='{$account_id}' AND c.last_did='{$did}' AND c.last_text_at < '{$date}' AND c.last_text_at != '0000-00-00 00:00:00' AND (cos.status!='O' OR cos.status IS NULL) ORDER BY last_text_at DESC limit 20 ");

        $allData = [];
        foreach ($data as $datum){
            $uniqueData = DB::select("select ls.log_time, callid, SUBSTRING(ls.sms_text, 1, 15) AS sms_text, ls.status from log_sms as ls WHERE ls.account_id='{$account_id}' AND ls.did='{$did}' and ls.client_number='{$datum->phone}' ORDER BY log_time DESC limit 1 ");
            $allData[$datum->phone] = count($uniqueData) > 0 ? (object) array_merge((array) $datum, (array) $uniqueData[0]) : $datum;

        }
//        uasort($allData, function($a, $b) {
//            if (strtotime($a->log_time) == strtotime($b->log_time)) return 0;
//            return (strtotime($a->log_time) < strtotime($b->log_time)) ? 1 : -1;
//        });
        return $allData;
    }

    public function getCloseChats($account_id) {
        $did = $this->getDid();
        $data = DB::select("select c.phone,c.id, c.first_name,c.last_name,c.company, c.state, c.street, c.suite, c.city, c.zip, c.company, c.custom_0, c.custom_1, c.custom_2, c.custom_3, c.custom_4, c.custom_5, c.custom_6, c.custom_7, c.custom_8, c.custom_9, c.last_text_at from contacts AS c LEFT JOIN contact_opt_status AS cos ON cos.phone=c.phone AND cos.account_id=c.account_id AND cos.did=c.last_did WHERE c.account_id='{$account_id}' AND c.last_did='{$did}' AND cos.status='O' ORDER BY last_text_at DESC limit 20 ");
        $allData = [];
        foreach ($data as $datum){
            $uniqueData = DB::select("select ls.log_time, callid, SUBSTRING(ls.sms_text, 1, 15) AS sms_text, ls.status from log_sms as ls WHERE ls.account_id='{$account_id}' AND ls.did='{$did}' and ls.client_number='{$datum->phone}' ORDER BY log_time DESC limit 1 ");
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
        $dataObj = $this->getContactDetailsByDid($clientNumber);

		if(count($dataObj)>0){
            ContactStatus::where('phone','=',$clientNumber)->where('account_id','=',$this->getAccountId())->where('did','=',$this->getDid())->update(['status' => 'O']);
            return $this->processServiceResponse(true, "Chat Close Successfully!",$dataObj);
		}else{
			$dataObj =  new ContactStatus;
			$dataObj->account_id = $this->getAccountId();
			$dataObj->did = $this->getDid();
			$dataObj->phone = $clientNumber;
			$dataObj->status = 'O';
			$dataObj->updated_at = time();
            if($dataObj->save()) {

                return $this->processServiceResponse(true, "Chat Close Successfully!",$dataObj);
            }
		}
        return $this->processServiceResponse(false, "Chat Close Failed!",$dataObj);
    }

    public function openLeads($clientNumber) {
        $dataObj = $this->getContactDetailsByDid($clientNumber);

        if($dataObj){
            ContactStatus::where('phone','=',$clientNumber)->where('account_id','=',$this->getAccountId())->where('did','=',$this->getDid())->update(['status' => 'I']);
            return $this->processServiceResponse(true, "Chat Close Successfully!",$dataObj);
        }
        return $this->processServiceResponse(false, "Chat Close Failed!",$dataObj);
    }

    public function getDid(){
        return \Auth::user()->cname;
    }

    public function getChatHistoryByNumber($account_id, $to, $from){
        // Get list
        $sms_from = $this->getDid();
        $sms_to = $to;
//        DB::enableQueryLog();
        $data = Log::select('log_time','userid','client_number','sms_text','status','direction')
            ->where('account_id','=', $account_id)
            ->where('did','=', $sms_from)
            ->where('client_number','=', $sms_to)
            ->orderBy('log_time', 'DESC')
            ->take(config('dashboard_constant.PAGINATION_LIMIT'))
            ->get()
            ->toArray();
//        dd(DB::getQueryLog());
//        $data = $data->toArray();
        $scheduleData = DB::select("select sms_schedule.created_at as log_time, sms_schedule.userid, sms_schedule_contact.phone as client_number, sms_schedule.sms_text, 'Q' as `status`, 'O' as direction from `sms_schedule` LEFT JOIN sms_schedule_contact ON sms_schedule_contact.schedule_id = sms_schedule.id where sms_schedule.account_id = '{$account_id}' and sms_schedule.sms_from = '{$sms_from}' and sms_schedule_contact.phone = '{$sms_to}' order by sms_schedule.created_at desc limit 10");
        $data = json_decode(json_encode($data), true);
        $scheduleData = json_decode(json_encode($scheduleData), true);
        $newData = array_merge((array) $data, (array) $scheduleData);
//        print_r(array_merge((array) $data, (array) $scheduleData));
//        die();
        $authUser = Session::get('loginUser');
        //$tz_offset = $this->getTimeZoneOffset($authUser['timezone']);
        $allData = [];
        foreach($newData as $key => $value){
            //$value->log_time=date('Y-m-d H:i:s', strtotime($value->log_time)+$tz_offset);
            $value['log_time']=$this->convertTime(config('app.timezone'), $authUser['timezone'], $value['log_time']);
            $allData[strtotime($value['log_time']) + $key] = $value;
        }
        uasort($allData, function($a, $b) {
            if (strtotime($a['log_time']) == strtotime($b['log_time'])) return 0;
            return (strtotime($a['log_time']) > strtotime($b['log_time'])) ? 1 : -1;
        });
        // update all chats data to read
        Log::where(['client_number' => $sms_to, 'status'=>'U'])->update(['status' => 'R']);

        return $allData;
    }

    public function getPreviousChatHistoryByNumber($account_id, $to, $lastDate){
        // Get list
        $sms_from = $this->getDid();
        $sms_to = $to;
        $data = Log::where('account_id','=', $account_id)
            ->where('log_time','<', $lastDate)
            ->where('did','=', $sms_from)
            ->where('client_number','=', $sms_to)
            ->orderBy('log_time', 'DESC')
            ->take(config('dashboard_constant.PAGINATION_LIMIT'))
            ->get()
            ->toArray();
        $authUser = Session::get('loginUser');
        $allData = [];
        $i = 1;
        foreach($data as $key => $value){
            //$value->log_time=date('Y-m-d H:i:s', strtotime($value->log_time)+$tz_offset);
            $value['log_time']=$this->convertTime(config('app.timezone'), $authUser['timezone'], $value['log_time']);
            $allData[strtotime($value['log_time']) + $i] = $value;
            $i++;
        }
        uasort($allData, function($a, $b) {
            if (strtotime($a['log_time']) == strtotime($b['log_time'])) return 0;
            return (strtotime($a['log_time']) > strtotime($b['log_time'])) ? 1 : -1;
        });

        return $allData;
    }

    public function getTotalDispositionByNumber($account_id, $phone){
        $data = Disposition::where('account_id','=', $account_id)
            ->where('cli','=', $phone)
            ->count();
        return $data;
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
            $value->tstamp = date('m/d/Y h:m A',$value->tstamp);
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
            $to = $endate->modify('+1 day')->getTimestamp();
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
        return Contact::where('phone','=',$clientNumber)->where('account_id','=',$this->getAccountId())->firstOrFail();

    }

    public function getContactDetailsByDid($clientNumber){
        //Get detail
        return ContactStatus::where('phone','=',$clientNumber)->where('account_id','=',$this->getAccountId())->where('did','=',$this->getDid())->limit(1)->get();

    }

}
