<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserModel\Wallet;
use App\Models\UserModel\Service;
use App\Models\UserModel\Service_enroll;
use App\Models\UserModel\Campaign;
use App\Models\AdminModel\Payment;
use Carbon\Carbon;
class UserController extends Controller
{
    //


    public function Dashboard() {
        $year = Carbon::now()->year;
        $allPayments = Payment::where('status', '=', 1)->where('user_id', '=', Admin('id'))->where('verify', '=', 1)->sum('price');
        $payment_this_year = Payment::where('status', '=', 1)->where('verify', '=', 1)
                                        ->whereYear('created_at', '=', $year)
                                        ->where('user_id', Admin('id'))
                                        ->sum('price');
        $withdrawal_this_year = Wallet::where('status', '=', 1)->where('type', '=','widthrawal')
                                        ->whereYear('created_at', '=', $year)
                                        ->where('user_id', '=', Admin('id'))
                                        ->sum('amount');                                
        $allWithdraw = Wallet::where('status', '=', 1)->where('user_id', '=', Admin('id'))->where('type', '=', 'widthrawal')->sum('amount');

        $total_users = Service_enroll::where('buyer_id', Admin('id'))->where('status', '=', 1)->count();
        $total_users_year = User::where('status', '=', 1)->whereYear('created_at', '=', $year)->count();

        $total_services = Service::where('status', '=', 1)->where('user_id', '=', Admin('id'))->count();
        $total_campaign = Campaign::where('status', '=', 1)->where('user_id', '=', Admin('id'))->count();
        return view('user.dashboard', compact('allPayments', 'allWithdraw', 'payment_this_year', 'withdrawal_this_year', 'total_users', 'total_services', 'total_campaign', 'total_users_year'));
    }

    public function loginPage() {
        return view('user.login');
    }

     public function Register() {
        return view('main.auth.register');
    }

    public function Campaigns() {
        return view('user.campaigns-project');
    }

     public function Services() {
        return view('user.services.index');
    }

      public function Wishes() {
        return view('user.wish.index');
    }

        public function Wallet() {
        return view('user.wallet.add');
    }

    public function changePass() {
        return view('user.profile.password');
    }

    public function Context() {
        return view('user.context.index');
    }

    Public function Messages() {
        $id = Admin('id');

        $conversations = DB::table('conversations')
                            ->join('users as u', 'conversations.user_id_1', 'u.id')
                            ->where('conversations.user_id_1', Admin('id'))
                            ->orWhere('conversations.user_id_2', Admin('id'))
                            ->select('conversations.*', 'u.fullname', 'u.username', 'u.id as uid', 'u.status as ustatus', 'u.image', 'u.image_folder')
                            ->get();
                            ;
        return view('user.messages.index', ['conversations' => $conversations]);
    }

    public function ServiceRequirement(Request $request) {
        $transa = $request->trans;
        if(empty($transa)) {
            return redirect()->route('home');
        } else {
            $enrol = new \App\Models\UserModel\Service_enroll();

            $service = $enrol::where('transaction_id', $transa)->first();

            if(!$service) {
                return redirect()->route('home');
            } else {
                $id = $service->id;
                return view('user.services.requirement', ['id' => $id]);
            }

        }
    }


    public function Profile() {
        $row = User::find(Admin('id'));

        return view('user.profile.index', compact('row'));
    }

    public function editProfile() {
        $user = User::find(Admin('id'));

        return view('user.profile.edit', compact('user'));
    }

    public function editBank() {
        $user = User::find(Admin('id'));

        return view('user.profile.bank', compact('user'));
    }

    public function Payments() {
        return view('user.payment');
    }

    public function Activity() {
        return view('user.activity');
    }

     public function Reviews() {
        return view('user.review');
    }
}
