<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use DB;
use App\User;
use App\Services\AuditLogService;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '#/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->AuditLogService = new AuditLogService();
    }
    public function logout(){
        $this->AuditLogService->createLog(Auth::user(), 'O');
        Auth::logout();
        return redirect('/login');
    }
    
     /**
     * Check extension
     * @return string
     */
    public function extension()
    {
        $extn  = request()->get('extn');
        $fieldName = 'extn';
        request()->merge([$fieldName => $extn]);

        return $fieldName;
    }

    /**
     * Validate the user login.
     * @param Request $request
     */
    protected function validateLogin(Request $request)
    { 
        $this->validate(
            $request,
            [
                'extn' => 'required|string',
                'account_id' => 'required|string',
                'password' => 'required|string',
            ],
            [
                'extn.required' => 'Extension is required',
                'account_id.required' => 'Account Id is required',
                'password.required' => 'Password is required',
            ]
        );
    }

    /**
     * @param Request $request
     * @throws ValidationException
     * this is working for laravel 5.6
     */
    // protected function sendFailedLoginResponse(Request $request)
    // { 
    //     throw ValidationException::withMessages(
    //         [
    //             'login_error' => [trans('auth.login_failed')],
    //         ]
    //     );
    // }

     /**
     * @param Request $request
     * @throws ValidationException
     * this is working for laravel 5.4
     */

    protected function sendFailedLoginResponse(Request $request)
    { 
        return redirect()->back()
            ->withInput($request->only('account_id', 'extn'))
            ->withErrors(['login_error' => [trans('auth.login_failed')]]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {      
        $pbxDbName = config('database.pbx_db_name');
        $user = User::selectRaw("user.*, up.email, IF(up.timezone='', ap.timezone, up.timezone) as timezone, up.password")
        ->leftJoin($pbxDbName.'.user_profile as up','user.userid','up.userid')
        ->leftJoin($pbxDbName.'.account_profile as ap','user.account_id','ap.account_id')
        ->where(['user.account_id' => $request->account_id,'user.extn' => $request->extn,'user.active' => 'Y', 'user.allow_sms' => 'Y'])
        ->first();
        if ($user && $user->password == md5($user->userid.$request->password)) {
            $user->password = '';            
            $userData = array('account_id'=>$user->account_id,'userid'=>$user->userid,'department_id'=>$user->department_id,'fname'=>$user->fname,'lname'=>$user->lname,'cname'=>$user->cname);
            $this->guard()->login($user, $request->has('remember'));
            $this->AuditLogService->createLog($userData, 'L');
            return true;
        }
        return false;
        
    }
    
    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function adminLogin(Request $request)
    {
        //$this->logout();
        $userId = $request->query('uid');
        if(!empty($userId)){
            $auser = $this->CheckUserSessionData();
            //print_r($auser);
            //print_r($userId);
            if (empty($auser) || $userId != $auser->userid) {
               abort(403, 'Unauthorized action.');
            }
            $pbxDbName = config('database.pbx_db_name');
            $user = User::selectRaw("user.*, up.email, IF(up.timezone='', ap.timezone, up.timezone) as timezone, up.password")
                ->leftJoin($pbxDbName.'.user_profile as up','user.userid','up.userid')
                ->leftJoin($pbxDbName.'.account_profile as ap','user.account_id','ap.account_id')
        	//->where(['user.account_id' => $request->account_id,'user.extn' => $request->extn,'user.status' => 'A'])
        	->where(['user.account_id' => $auser->account_id,'user.extn' => $auser->extn,'user.active' => 'Y', 'user.allow_sms' => 'Y'])
        	->first(); 
        	//print_r($user);
        	//die();
            if ($user && $user->userid == $auser->userid) {
                $user->password = '';            
                $userData = array('account_id'=>$user->account_id,'userid'=>$user->userid,'department_id'=>$user->department_id,
		    'fname'=>$auser->admin_id,'lname'=>$auser->admin_name,'cname'=>$user->cname);
                $this->guard()->login($user, false);
                $this->AuditLogService->createLog($userData, 'L');
                return redirect('/dashboard');
                //return true;
            }
        
        }
        return false;
        
    }

    /**
     * Check user session
     * @return bool/null
     */
    public function CheckUserSessionData() {
        $prefix="NPABXAD_";
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION[$prefix.'LAccId']) && !empty($_SESSION[$prefix.'LAccId']) && isset ($_SESSION[$prefix.'LExtn']) && !empty($_SESSION[$prefix.'LExtn'])) {
            $user = new \stdClass();
            $user->account_id = $_SESSION[$prefix.'LAccId'];
            $user->extn = $_SESSION[$prefix.'LExtn'];
            $user->userid = $_SESSION[$prefix.'LUId'];
            $user->admin_name = $_SESSION[$prefix.'LADName'];
            $user->admin_id = $_SESSION[$prefix.'LADId'];
            return $user;
        }
        return null;
    }

    
    /**
     * set user session data after login
     */
    protected function authenticated(Request $request, $user)
    {
        $originalData = $user->getOriginal();$originalData['password']='';        
        $request->session()->put('loginUser', $originalData);
    }

}