<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Services\UsersService;
use App\Services\LogService;
use App\Services\ChatsService;
use Auth;
use Session;

class ChatsController extends AppController
{
    public $Service;
    public $ChatsService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->account_id = Auth::user() ? Auth::user()->account_id : '';
        $this->Service = new UsersService();
        $this->LogService = new LogService();
        $this->ChatsService = new ChatsService();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('chats.chats', [
            'title' => 'Chats',
            'search' => '',
            'sub_header' => 'Chats',
            'sidebar_menu_active' => 'chats',
            'sidebar_submenu_active' => '',
            'sidebar_subsubmenu_active' => '',
        ]);
    }

    /*
        get chats data
    */
    public function getChatsData()
    {
        $authUser = Session::get('loginUser'); 
        $layoutData['js_plugin'] = $this->getJsPlugin(["JSP_BOOTSTRAP_BOOTBOX"]);
        $layoutData['userType'] = config("dashboard_constant.USER_TYPE");
        $layoutData['userStatus'] = config("dashboard_constant.USER_STATUS");
        $layoutData['logSmsStatus'] = config("dashboard_constant.LOG_SMS_STATUS");
        $layoutData['smsDirection'] = config("dashboard_constant.SMS_DIRECTION");
        $layoutData['title'] = 'Chats | '.config("app.name");
        $layoutData['sidebar_menu_active'] = 'chats';
        $layoutData['timezone'] =  $authUser['timezone'];
        $layoutData['breadcrumb'] = [
            "links" => [
                [
                    "name" => "Chats",
                    "url" => url("#/chats"),
                    "icon" => "flaticon-chat"
                ]
            ]  
        ];
        $layoutData['unreadLog'] = $this->LogService->getLogUnreadSummary($this->account_id);
        $layoutData['inboundLog'] = $this->LogService->getLogInboundSummary($this->account_id);
        $layoutData['outboundLog'] = $this->LogService->getLogOutboundSummary($this->account_id);
        $layoutData['accountInfo'] = $this->Service->getAccountInfo($this->account_id);
        $layoutData['smsInfo'] = $this->LogService->getSmsInfo($this->account_id);
        $layoutData['templateInfoNew'] = $this->ChatsService->getTemplateList($this->account_id);
        $layoutData['openChat'] = $this->ChatsService->getOpenChats($this->account_id);
        $layoutData['closeChat'] = $this->ChatsService->getCloseChats($this->account_id);
        
        // Return collection of list as a reosurce
        return response()->json($layoutData);   
    }

    public function chatsByUserId($phone) {
        return $this->ChatsService->getChatHistoryByNumber($this->account_id, $phone, $did="19723182200");
    }

    /*
        -- End
    */

    /**
     * Check for auto login.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAuthCheck(Request $request, $account_id, $extn)
    {
        if(!$this->CheckUserSessionData($account_id, $extn)) {
            echo 'User not Found!';
            die();
        }
        $pbxDbName = config('database.pbx_db_name');
        $user = User::selectRaw("user.*, up.email, IF(up.timezone='', ap.timezone, up.timezone) as timezone, up.password")
        ->leftJoin($pbxDbName.'.user_profile as up','user.userid','up.userid')
        ->leftJoin($pbxDbName.'.account_profile as ap','user.account_id','ap.account_id')
        //->where(['user.account_id' => $account_id,'user.extn' => $extn,'user.status' => 'A'])
        ->where(['user.account_id' => $account_id,'user.extn' => $extn,'user.active' => 'Y', 'user.allow_sms' => 'Y'])
        ->first();
        if($user){
            Auth::login($user);
            $request->session()->put('loginUser', $user->getOriginal());
            return redirect('/');
        }else{
            echo 'User authentication failed!';
            die();
        }
    }

}
