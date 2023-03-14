<?php

namespace App\Services;

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
		// $data = DB::table('contacts')->where(['account_id'=>$account_id, 'lead_status'=>1])->get(['first_name', 'last_name', 'phone', 'company'])->toArray();
		// $data = DB::select("SELECT * FROM (SELECT ls.log_time, ls.account_id, ls.client_number, ls.sms_text, ls.status, ls.did FROM log_sms AS ls ORDER BY ls.log_time DESC) AS t GROUP BY t.client_number");

		$data = DB::select("SELECT * FROM (SELECT c.first_name, c.last_name, c.company, c.lead_status, ls.log_time, ls.account_id, ls.client_number, ls.sms_text, ls.status, ls.did FROM contacts AS c LEFT JOIN log_sms AS ls ON c.phone=ls.client_number ORDER BY ls.log_time DESC) AS t GROUP BY t.client_number");
		return $data;
	}

	public function getCloseChats($account_id) {
		return DB::table('contacts')->where(['account_id'=>$account_id, 'lead_status'=>0])->get(['first_name', 'last_name', 'phone', 'company'])->toArray();
	}

    public function getChatHistoryByNumber($account_id, $to, $from){
        // Get list
        $sms_from = $from;
        $sms_to = $to;

        $data = Log::where('account_id','=', $account_id)
            ->where('did','=', $sms_from)
            ->where('client_number','=', $sms_to)
            ->orderBy('log_time', 'DESC')
            ->paginate(config('dashboard_constant.PAGINATION_LIMIT'));
        
        $authUser = Session::get('loginUser');
        //$tz_offset = $this->getTimeZoneOffset($authUser['timezone']);
        foreach($data as $key => $value){
            //$value->log_time=date('Y-m-d H:i:s', strtotime($value->log_time)+$tz_offset);
            $value->log_time=$this->convertTime(config('app.timezone'), $authUser['timezone'], $value->log_time);
        }

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

}
