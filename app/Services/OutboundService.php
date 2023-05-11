<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\User;
use App\Models\Inbound;
use App\Models\Outbound;
use App\Models\Log;
use Illuminate\Support\Facades\Hash;
use DB;
use Session;
use Validator;
use Auth;

class OutboundService extends AppService
{

    public function __construct()
    {        
        $this->account_id = Auth::user()->account_id;
    }
    
    /**
     * get pagination data
     */
    public function getPagination($request){
        // Get list data
        $hasQuery = false;
        $startTime = date('Y-m-d', strtotime('today - 30 days'))." 00:00";
        $endTime = date('Y-m-d')." 23:59";
        $maxDateDiff = config('dashboard_constant.REPORT_MAX_DATE_DIFF');

        $queryParam = $request->query();

        //$query = Log::where('account_id','=', $this->account_id)->where('direction','=', 'O');

        // DB::enableQueryLog();
        
        $query = DB::table('log_sms')
                ->leftJoin('contacts', function ($join) {
                    $join->on('log_sms.account_id', '=', 'contacts.account_id');
                    $join->on('log_sms.client_number', '=', 'contacts.phone');
                }) 
                ->where('log_sms.account_id','=', $this->account_id)
                ->where('log_sms.did','=',Auth::user()->cname);

        $stdate = isset($queryParam['start_time']) ? \DateTime::createFromFormat('Y-m-d H:i', $queryParam['start_time']) : false;
        // $stdate = isset($queryParam['start_time']) ? $queryParam['start_time'] : false;
        $endate = isset($queryParam['end_time']) ? \DateTime::createFromFormat('Y-m-d H:i', $queryParam['end_time']): false;
        // $endate = isset($queryParam['end_time']) ? $queryParam['end_time']: false;


        if($stdate !== false && $endate !== false){

            $startTime = $queryParam['start_time'];
            $endTime = $queryParam['end_time'];



            $diff = date_diff($stdate,$endate);
            $daysDiff = $diff->format("%a");

            if($daysDiff > $maxDateDiff){
                // add (REPORT_MAX_DATE_DIFF) days to start time
                $stdate->modify('+'.$maxDateDiff.' days');
                $endTime = $stdate->format('Y-m-d');
            }
            $hasQuery = true;
        }else if($stdate !== false){

            $startTime = $queryParam['start_time'];
            $endTime = date('Y-m-d',strtotime($queryParam['start_time']))." 23:59";
            $hasQuery = true;
        }

        //$query->whereBetween("log_sms.log_time",[$startTime,$endTime]);
        

        if(isset($queryParam['client_name']) && !empty($queryParam['client_name']) ){
            $query->where('contacts.first_name', "LIKE","%".$queryParam['client_name']."%");
            $hasQuery = true;            
        }
        if(isset($queryParam['client']) && !empty($queryParam['client']) ){
            $queryParam['client'] = preg_replace("/[^0-9]/", "", $queryParam['client']);
            $queryParam['client'] = (strlen($queryParam['client'])==10) ? '1'.$queryParam['client'] : $queryParam['client'];
            $query->where("log_sms.client_number",$queryParam['client']);
            $hasQuery = true;           
        }

        //get last 30 days
        if(!$hasQuery){
            $startTime = date('Y-m-d', strtotime('today - 3000 days'))." 00:00";
            $endTime = date('Y-m-d')." 23:59";
            $query->whereBetween("log_sms.log_time",[$startTime,$endTime]);
        }else{
            if($stdate !== false && $endate !== false){
                /*$startTime = date('Y-m-d',strtotime($startTime))." 00:00";
                $endTime = date('Y-m-d',strtotime($endTime))." 23:59";*/
                //dd([$startTime,$endTime]);
                $query->whereBetween("log_sms.log_time",[$startTime,$endTime]);
            }
        }

         // $query->where('log_sms.did','=',Auth::user()->cname);
        $query->where('direction','=', 'O');


        $per_page = (isset($queryParam['per_page']) && !empty($queryParam['per_page']) && $queryParam['per_page']!='undefined') ? $queryParam['per_page'] : config('dashboard_constant.PAGINATION_LIMIT');

        $query = $query->orderBy('log_sms.log_time', 'DESC')->paginate($per_page);
        //dd($query->toArray());
        $authUser = Session::get('loginUser');
        //$tz_offset = $this->getTimeZoneOffset($authUser['timezone']);

        foreach($query as $key => $value){
            //$value->log_time=date('Y-m-d H:i:s', strtotime($value->log_time)+$tz_offset);
            if ($value->delivery_time == '0000-00-00 00:00:00') $value->delivery_time = $value->log_time;
            $value->log_time=$this->convertTime(config('app.timezone'), $authUser['timezone'], $value->log_time);
            $value->delivery_time = $this->convertTime(config('app.timezone'), $authUser['timezone'], $value->delivery_time);
        }
        // DB::getQueryLog();
        // dd(DB::getQueryLog());
        //dd($query->toArray());
        return $this->paginationDataFormat($query->toArray());
    }

    /**
     * get inbox data
     */
    public function getInboxList($request, $from, $to){
        // Get list
        $sms_from = $from;
        $sms_to = $to;

        $page = $request->query('page', 1);
        $paginate = config('dashboard_constant.PAGINATION_LIMIT');

        $authUser = Session::get('loginUser');
        $user_time_zone = $authUser['timezone'];

        //DB::statement("SET time_zone = '".$user_time_zone."';");

        $in = DB::table("log_sms_inbound")->select('log_sms_inbound.sms_from', 'log_sms_inbound.sms_to', 'log_sms_inbound.sms_text', 'log_sms_inbound.log_time')
                    ->where("sms_from", "=", $sms_from)
                    ->where("sms_to", "=", $sms_to);
        $out = DB::table("log_sms_outbound")->select('log_sms_outbound.sms_from', 'log_sms_outbound.sms_to', 'log_sms_outbound.sms_text', 'log_sms_outbound.log_time')
                    ->where("sms_from", "=", $sms_to)
                    ->where("sms_to", "=", $sms_from)
                    ->union($in)
                    ->orderBy('log_time')
                    ->get();
                    
        $offSet = ((int)$page * $paginate) - $paginate;
        $itemsForCurrentPage = array_slice($out->toArray(), $offSet, $paginate, true);
        $data = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($out), $paginate, $page);

        return $this->paginationDataFormat($data->toArray());
    }
	
}
