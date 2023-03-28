<?php

namespace App\Services;

use App\Models\DispositionCode;
use Illuminate\Http\Request;
use App\User;
use App\Models\Log;
use App\Models\Contact;
use App\Models\Schedule;
use App\Models\ScheduleContact;
use App\Models\ContactGroup;
use Illuminate\Support\Facades\Hash;
use App\Services\ScheduleContactsService;
use App\Services\AuditLogService;
use Validator;
use DB;
use Auth;

class DispositionService extends AppService
{

    public function __construct()
    {
        $this->AuditLogService = new AuditLogService();
    }
    
    /**
     * get pagination data
     */
    public function getPagination($request){
        // Get list
        $queryParam = $request->query();
        $pbxDbName = config('database.pbx_db_name');
        $query = DispositionCode::select('*');
        //$query->whereBetween("start_time",[$startTime,$endTime]);

        if(isset($queryParam['disposition_type']) && !empty($queryParam['disposition_type']) ){
            $query->where("disposition_type",$queryParam['disposition_type']);
        }

        $per_page = (isset($queryParam['per_page']) && !empty($queryParam['per_page']) && $queryParam['per_page']!='undefined') ? $queryParam['per_page'] : config('dashboard_constant.PAGINATION_LIMIT');

        $query = $query->orderBy('disposition_id', 'DESC')->paginate($per_page);
        return $this->paginationDataFormat($query->toArray());
    }
    /**
     * save data
     * @param array request
     */
    public function save($request){
        $validator = Validator::make($request->all(),[
            'title' => 'required|string|max:50',
            'disposition_type' => 'required|string|max:1',
            'status' => 'required|max:1',
        ]);

        if ($validator->fails()){
            return $this->processServiceResponse(false, $validator->errors()->first(),null);           
        }

        // Create or Update 
        $dataObj =  new DispositionCode();
        
        // $dataObj->id = strrev(strtotime(date("Y-m-d H:i:s")));
        $dataObj->account_id = $this->getAccountId();
        $dataObj->disposition_id = $this->genDispositionId() + 1;
        $dataObj->title = $request->input('title');
        $dataObj->disposition_type = $request->input('disposition_type');
        $dataObj->responsible_party = !empty($request->input('responsible_party')) ? $request->input('responsible_party') : '';
        $dataObj->status = $request->input('status');

        if($dataObj->save()) {
            return $this->processServiceResponse(true, "Disposition Added Successfully!",$dataObj);
        }
        return $this->processServiceResponse(false, "Disposition Added Failed!",$dataObj);
    }

    /**
     * GENERATE RANDOM TEMPLATE ID
     */
    public function genTemplateId(){
        $id = $this->genPrimaryKey();        
        $IdExists = Template::find($id);        
        if($IdExists){
            return $this->genTemplateId();
        }
        return $id;
    }

    /**
     * GENERATE RANDOM TEMPLATE ID
     */
    public function genDispositionId(){
        $id = '100000';
        $IdExists = DispositionCode::max('disposition_id');
        if($IdExists){
            return $IdExists;
        }
        return $id;
    }
    /**
     * GENERATE RANDOM SCHEDULE CONTACT ID
     */
    public function genScheduleContactId(){
        $id = $this->genRandNum(10); 
        $idExists = ScheduleContact::find($id); 
        if($idExists){
            return $this->genScheduleContactId();
        }
        return $id;
    }

    

    /**
     * get details
     * $param int $id
     */
    public function getDetail($id){
        //Get detail
        return DispositionCode::where('disposition_id','=',$id)->firstOrFail();

    }

    /**
     * update data
     * @param array request
     */
    public function updateData($request){
        $validator = Validator::make($request->all(),[
            'title' => 'required|string|max:50',
            'disposition_type' => 'required|string|max:1',
            'status' => 'required|max:1',
        ]);
        if ($validator->fails()){
            return $this->processServiceResponse(false, $validator->errors()->first(),null);
        }
        
        // get detail
        $dataObj = $this->getDetail($request->disposition_id);
        $dataObj->title = $request->input('title');
        $dataObj->disposition_type = $request->input('disposition_type');
        $dataObj->responsible_party = !empty($request->input('responsible_party')) ? $request->input('responsible_party') : '';
        $dataObj->status = $request->input('status');

        if($dataObj->save()) {
            return $this->processServiceResponse(true, "Disposition Update Successfully!",$dataObj);
        }
        return $this->processServiceResponse(false, "Disposition Update Failed!",$dataObj);
    }

    /**
     * delete data
     * @param int $id
     */
    public function delete($id){
        $dataObj = $this->getDetail($id);

        if($dataObj->delete()) {
            return $this->processServiceResponse(true, "Schedule Deleted Successfully!", $dataObj);
        }
        return $this->processServiceResponse(false, "Schedule Deleted Failed!", $dataObj);   
    }


    /**
     * detail data
     * @param int $id
     */
    public function getScheduleDetail($id, $withbr = false){
        $dataObj = Schedule::with('contacts')->find($id);        
        $dataObj->groupContacts = $dataObj->getGroupContacts($dataObj);
        if($withbr)
            $dataObj->sms_text = nl2br($dataObj->sms_text);
        return $dataObj;
    }

    /**
     * detail data
     * @param int $id
     */
    public function getScheduleDetailForCompose($id, $withbr = false){
        $dataObj = Schedule::find($id);
        $dataObj->contacts = $dataObj->getContacts($id);
        $dataObj->groupContacts = $dataObj->getContactsByGroupId($id);
        if($withbr)
            $dataObj->sms_text = nl2br($dataObj->sms_text);
        return $dataObj;
    }
    /**
     * save schedule contacts
     * @param array $reqData
     * @param str $colname
     */
    public function saveScheduleContacts($reqData, $colname){ 
        $contacts = $reqData[$colname]; 
        if(!empty($contacts)){
            unset($reqData[$colname]);
            $insData = [];
            foreach($contacts as $key => $val){
                $reqData['id'] = $this->genScheduleContactId();
                $insData[$key] = array_merge([$colname => $val],$reqData);
            }            
            $result = ScheduleContact::insert($insData);
            if($result){
                return $this->processServiceResponse(true, "Compose Save Successfully!",$reqData);
            }
        }
        return $this->processServiceResponse(false, "Compose Save Failed!",$reqData);
    }


    /**
     * update schedule status
     * @param int $id
     * @param string $status 
     */
    public function changeScheduleStatus($log_time, $account_id, $did, $client_number, $callid, $status){
        
        $res = Log::where('log_time',$log_time)
                    ->where('account_id',$account_id)
                    ->where('did',$did)
                    ->where('client_number',$client_number)
                    ->where('callid',$callid)
                    ->update(['status' => $status]);
        if($res){
            $this->AuditLogService->createLog(array('status' => $status), 'U');
        }
        return $this->processServiceResponse($res ? true : false, $res ? "Update Successfully!" : "Update Failed!",$status);
    }
    

    /**
     * delete schedule contacts by Schedule Id
     * @param int $id     
     */
    public function deleteScheduleContacts($schedule_id){        
        $res = ScheduleContact::where('schedule_id',$schedule_id)->delete();

        return $this->processServiceResponse($res ? true : false, $res ? "Delete Successfully!" : "Delete Failed!",$schedule_id);
    }

}
