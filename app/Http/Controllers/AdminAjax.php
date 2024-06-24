<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;
use App\Models\User;
use App\Models\AdminModel\Payment;
use App\Models\AdminModel\Wallet;
use Carbon\Carbon;

class AdminAjax extends Controller
{
    //

    public function handleLogin(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $credentials = $request->only('email', 'password');
    
        if (Auth::guard('admin')->attempt($credentials)) {
            Session::flash('login_m', 'You successfully Login.');
            return redirect()->intended('/admin/dashboard');
        }
    
        throw ValidationException::withMessages(['error' => 'Invalid credentials']);
    }

    public function handleLogout(Request $request) {
        Auth::guard('admin')->logout();
        Session::flash('logout_message', 'You have been logged out successfully.');
        return redirect()->route('admin.login');
    }


    public function index(Request $request, $modelname) {

        $action = $request->action;

        if($action ==  'add') {
            $ModeName = ucfirst($modelname);
            $add = "\App\Http\Controllers\ModelController\\$ModeName";
            $add_instance = new $add();
            $adding = $add_instance->add($request);
            return response()->json($adding);
        } else if($action == 'list') {

            if($modelname == 'transactions') {
                $class =  new \App\Http\Controllers\ModelController\Wallets;
                $list = $class->Transactions($request);
                return response()->json($list);
            } else {

                $ModeName = ucfirst($modelname);
                $class = "\App\Http\Controllers\ModelController\\$ModeName";
                $List = new $class();
                $data = $List->list($request);
                return response()->json($data);
            }


        } else if($action == 'settingStatus') {

            $ModeName = ucfirst($modelname);
            $class = "\App\Http\Controllers\ModelController\\$ModeName";
            $List = new $class();
            $data = $List->toStatus($request);
            return response()->json($data);
        }  else if($action == 'edit') {

            $ModeName = ucfirst($modelname);
            $class = "\App\Http\Controllers\ModelController\\$ModeName";
            $instance = new $class();
            $data = $instance->edit($request);
            return response()->json($data);
        } else if($action == "getRow") {

            $ModeName = ucfirst($modelname);
            $class = "\App\Http\Controllers\ModelController\\$ModeName";
            $List = new $class();
            $data = $List->getRow($request);
            return response()->json($data);
        } else if($action == 'changepass') {

            $ModeName = ucfirst($modelname);
            $class = "\App\Http\Controllers\ModelController\\$ModeName";
            $List = new $class();
            $data = $List->changePass($request);
            return response()->json($data);
        }
    }

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
            ->whereYear('created_at', '=', $year)
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'))
            ->get();

            $withdraw =  Wallet::select(
                DB::raw('SUM(amount) as amount'),
                DB::raw('DATE_FORMAT(created_at, "%M") as month' )
            )
            ->where('type', '=', 'widthrawal')
            ->where('status', '=', 1)
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
}
