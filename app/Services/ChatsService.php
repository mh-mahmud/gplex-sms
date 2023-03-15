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
		$data = DB::select("SELECT c.first_name, c.phone, c.last_name, c.company, c.lead_status, ls.log_time, ls.account_id, ls.client_number, ls.sms_text, ls.status, ls.did FROM contacts AS c LEFT JOIN log_sms AS ls ON c.phone=ls.client_number WHERE c.lead_status=1 AND c.account_id='{$account_id}' GROUP BY c.phone ORDER BY ls.log_time DESC LIMIT 30");
		return $data;
	}

	public function getLatestChats($account_id) {
		$data = DB::select("SELECT c.first_name, c.phone, c.last_name, c.company, c.lead_status, ls.log_time, ls.account_id, ls.client_number, ls.sms_text, ls.status, ls.did FROM contacts AS c LEFT JOIN log_sms AS ls ON c.phone=ls.client_number WHERE c.lead_status=1 AND c.account_id='{$account_id}' GROUP BY c.phone ORDER BY ls.log_time DESC LIMIT 30");
		return $data;
	}

	public function getCloseChats($account_id) {
		$data = DB::select("SELECT c.first_name, c.phone, c.last_name, c.company, c.lead_status, ls.log_time, ls.account_id, ls.client_number, ls.sms_text, ls.status, ls.did FROM contacts AS c LEFT JOIN log_sms AS ls ON c.phone=ls.client_number WHERE c.lead_status=0 AND c.account_id='{$account_id}' GROUP BY c.phone ORDER BY ls.log_time DESC");
		return $data;
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
