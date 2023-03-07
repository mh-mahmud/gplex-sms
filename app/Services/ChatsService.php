<?php

namespace App\Services;

use Illuminate\Http\Request;
use DB;
use App\Models\Log;
use Session;

class ChatsService extends AppService {

	public function getTemplateList($account_id){    
		return DB::table('sms_template')->where('account_id', $account_id)->get(['name', 'message'])->toArray();
	}

	public function getOpenChats($account_id) {
		return DB::table('contacts')->where(['account_id'=>$account_id, 'lead_status'=>1])->get(['first_name', 'last_name', 'phone'])->toArray();
	}

	public function getCloseChats($account_id) {
		return DB::table('contacts')->where(['account_id'=>$account_id, 'lead_status'=>0])->get(['first_name', 'last_name', 'phone'])->toArray();
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

}
