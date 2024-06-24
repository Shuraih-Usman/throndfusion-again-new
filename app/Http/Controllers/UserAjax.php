<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use App\Helpers\ActivityLogHelper;
use Illuminate\Validation\ValidationException;
use App\Models\UserModel\Wallet;
use App\Models\AdminModel\Payment;
use Carbon\Carbon;
use App\Models\User;
class UserAjax extends Controller
{
    //

        public function Ajax(Request $request) {
        $action = $request->action;

        if($action == 'getchart1') {

            $year = Carbon::now()->year;
            $payment = Payment::select(
                DB::raw('SUM(price) as total_amount'),
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month')
            )
            ->where('status', '=', 1)
            ->where('verify', '=', 1)
            ->where('user_id', '=', Admin('id'))
            ->whereYear('created_at', '=', $year)
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'))
            ->get();

            $withdraw =  Wallet::select(
                DB::raw('SUM(amount) as amount'),
                DB::raw('DATE_FORMAT(created_at, "%M") as month' )
            )
            ->where('type', '=', 'widthrawal')
            ->where('status', '=', 1)
            ->where('user_id', '=', Admin('id'))
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%M")'))
            ->get();

            $users = User::select(
                DB::raw('count(id) as total'),
                DB::raw('DATE_FORMAT(created_at, "%M") as month')
            )
                ->where('status', '=', 1)
                ->groupBy(DB::raw('DATE_FORMAT(created_at, "%M")'))
                ->get();

            return response()->json(['payment' => $payment, 'withdraw' => $withdraw, 'user' => $users]); 

        }
    }
    public function index(Request $request, $model) 
    {
        $action = $request->action;

        if($action == 'login') {

            return $this->HandleLogin($request);
        } else if($action == 'get_campaign_types') {
            $data = DB::table('campaign_type')
                        ->where('status', 1)
                        ->orderBy('id','desc')
                        ->select('id', 'title')
                        ->get();
            return response()->json($data);            
        } else if($action == 'add') {
            $ModeName = ucfirst($model);
            $add = "\App\Http\Controllers\UserModelController\\$ModeName";
            $add_instance = new $add();
            $adding = $add_instance->add($request);
            return response()->json($adding);
        } else if($action == 'list') {

            $ModeName = ucfirst($model);
            $class = "\App\Http\Controllers\UserModelController\\$ModeName";
            $List = new $class();
            $data = $List->list($request);
            return response()->json($data);
        } else if($action == 'settingStatus') {

            $ModeName = ucfirst($model);
            $class = "\App\Http\Controllers\UserModelController\\$ModeName";
            $List = new $class();
            $data = $List->toStatus($request);
            return response()->json($data);
        } else if($action == "getRow") {

            $ModeName = ucfirst($model);
            $class = "\App\Http\Controllers\UserModelController\\$ModeName";
            $List = new $class();
            $data = $List->getRow($request);
            return response()->json($data);
        } else if ($action == 'getselect') {
            $id = $request->id;
            $type = $request->type;
        
            $mode = DB::table($type)->get();
        
            $data = [];
        
            foreach ($mode as $row) {
                if ($row->id == $id) {
                    $data[] = "<option value='$row->id' selected> $row->title </option>";
                } else {
                    $data[] = "<option value='$row->id'> $row->title </option>"; 
                }
            }
        
            return response()->json($data);
        } else if( $action == "edit")  {
            $ModeName = ucfirst($model);
            $class = "\App\Http\Controllers\UserModelController\\$ModeName";
            $List = new $class();
            $data = $List->edit($request);
            return response()->json($data);
        } else if($action == 'services_cats') {
            $data = DB::table('service_cats')
                        ->where('status', 1)
                        ->orderBy('id','desc')
                        ->select('id', 'title')
                        ->get();
            return response()->json($data);            
        } else if($action == 'wishlists_types') {
            $data = DB::table('wishlists_types')
                        ->where('status', 1)
                        ->orderBy('id','desc')
                        ->select('id', 'title')
                        ->get();
            return response()->json($data);            
        } else if($action == 'investment_list') {

            $ModeName = ucfirst($model);
            $class = "\App\Http\Controllers\UserModelController\\$ModeName";
            $List = new $class();
            $data = $List->list_investment($request);
            return response()->json($data);
        } else if($action == 'donation_list') {

            $ModeName = ucfirst($model);
            $class = "\App\Http\Controllers\UserModelController\\$ModeName";
            $List = new $class();
            $data = $List->list_donations($request);
            return response()->json($data);
        } else if($action == 'real_message') {
            
            $ModeName = ucfirst($model);
            $class = "\App\Http\Controllers\UserModelController\\$ModeName";
            $List = new $class();
            $data = $List->message($request);
            return response()->json($data);
        } else if($action == 'service_requirement') {
            $s = 0;
            $m = "Error";
            $enrol = new \App\Models\UserModel\Service_enroll();
            $service = $enrol::find($request->id);

            if(!$service) {
                $m = "Enrollment to this service never existed pls contact Support";
            } else {
                if(empty($request->requirement)) {
                    $m = "Pls input your description / requirement to help in servicing you";
                } else {
                    if(!empty($service->requirements)) {
                        $m = "You have already submitted";
                    } else {
                        $service->requirements = $request->input('requirement');
                        $service->save();
                        $s = 1;
                        $m = "Successfully submitted pls wait for your work to be accomplishe";
                    }
                }
            }

            return response()->json(['s' => $s, 'm' => $m]); 

        } else if($action == 'get_messages') {

            $id = $request->conversation_id;
            $mess = new \App\Http\Controllers\UserModelController\Messages;
            $messages = $mess->get_message($id);

            return response()->json($messages);
        } else if($action == 'onwork_service_lists') {
            $ModeName = ucfirst($model);
            $class = "\App\Http\Controllers\UserModelController\\$ModeName";
            $List = new $class();
            $data = $List->list_onwork_services($request);
            return response()->json($data);
        } else if($action == 'deliver_service') {
            $ModeName = ucfirst($model);
            $class = "\App\Http\Controllers\UserModelController\\$ModeName";
            $List = new $class();
            $data = $List->deliver_service($request);
            return response()->json($data);
        } else if($action == 'purchase_services') {
            $ModeName = ucfirst($model);
            $class = "\App\Http\Controllers\UserModelController\\$ModeName";
            $List = new $class();
            $data = $List->purchase_services($request);
            return response()->json($data);
        }  else if($action == 'approve_service') {
            $ModeName = ucfirst($model);
            $class = "\App\Http\Controllers\UserModelController\\$ModeName";
            $List = new $class();
            $data = $List->approve_service($request);
            return response()->json($data);
        } else if($action == 'updatebank') {
            $userClass = new \App\Http\Controllers\UserModelController\Users;
            $data = $userClass->bankDetails($request);
            return response()->json($data);
        } else if($action == 'changepass') {
            $userClass = new \App\Http\Controllers\UserModelController\Users;
            $data = $userClass->changePass($request);
            return response()->json($data);
        }
        
    }


    public function HandleLogin(Request $request)
     {
        $s = 0;
        $cred = $request->only('email', 'password');

        if(Auth::attempt($cred)) {
            $m = "Successfully Login";
            $s = 1;
            ActivityLogHelper::log('Login', Admin('id'), $m);
            Session::flash('login', 'You successfully Login.');
            return redirect()->intended('/user/dashboard');
        } else {
            $m = "Invalid credentials";
        }

        throw ValidationException::withMessages(['error' => 'Invalid credentials']);
     }

     public function Logout(Request $request) 
     {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        Session::flash('logout', 'You successfully Logout.');
        return redirect(route('login'));
     }
}
