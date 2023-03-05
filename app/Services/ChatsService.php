<?php

namespace App\Services;

use Illuminate\Http\Request;
use DB;

class ChatsService extends AppService {

	public function getTemplateList($account_id){    
		return $data = DB::table('sms_template')->where('account_id', $account_id)->get(['name', 'message'])->toArray();
	}

}
