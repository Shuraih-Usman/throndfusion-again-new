<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\AdminModel\Payment;
use App\Models\AdminModel\Wallet;
use App\Models\UserModel\Service;
use App\Models\UserModel\Campaign;
use Carbon\Carbon;

class AdminController extends Controller
{
    //

    public function loginPage() {
        return view('admin.login');
    }

    public function addUser() {
        return view('admin.users.add-user', ['admin']);
    }

    public function Users() {
        return view('admin.users.users');
    }

    public function editUser($id) {
        $user = User::find($id);
        return view('admin.users.edit-user', ['user' => $user]);
    }

    public function Profile() {

        $row = Admin::find(Admin('id'));
        return view('admin.profile.index', compact('row'));
    }

    public function editProfile() {
        $user = Admin::find(Admin('id'));
        return view('admin.profile.edit', compact('user'));
    }

    public function Campaign_type() {
        return view('admin.campaigns.campaign-type');
    }

    public function Donation() {
        return view('admin.campaigns.donation');
    }

    public function Investment() {
        return view('admin.campaigns.investment');
    }

    public function Campaigns() {
        return view('admin.campaigns.index');
    }


    public function serviceCats() {
        return view('admin.services.service-cat');
    }

        public function Services() {
        return view('admin.services.index');
    }

    public function Enrollservices() {
        return view('admin.services.enroll');
    }

     public function wishlistsCats() {
        return view('admin.wish.type');
    }

      public function wishesItems() {
        return view('admin.wish.items');
    }

    public function WithdrawalRequests() {
        return view('admin.wallet.index');
    }

        public function Transactions() {
        return view('admin.wallet.transactions');
    }

            public function Payments() {
        return view('admin.wallet.payments');
    }

    public function editPass() {
        return view('admin.profile.password');
    }

                public function Activity() {
        return view('admin.helpers.activity');
    }

    public function Context_cats() {
        return view('admin.context.cats');
    }

                    public function Review() {
        return view('admin.helpers.reviews');
    }


    public function Dashboard() {
        $year = Carbon::now()->year;
        $allPayments = Payment::where('status', '=', 1)->where('verify', '=', 1)->sum('price');
        $payment_this_year = Payment::where('status', '=', 1)->where('verify', '=', 1)
                                        ->whereYear('created_at', '=', $year)
                                        ->sum('price');
        $withdrawal_this_year = Wallet::where('status', '=', 1)->where('type', '=','widthrawal')
                                        ->whereYear('created_at', '=', $year)
                                        ->sum('amount');                                
        $allWithdraw = Wallet::where('status', '=', 1)->where('type', '=', 'widthrawal')->sum('amount');

        $total_users = User::where('status', '=', 1)->count();
        $total_users_year = User::where('status', '=', 1)->whereYear('created_at', '=', $year)->count();

        $total_services = Service::where('status', '=', 1)->count();
        $total_campaign = Campaign::where('status', '=', 1)->count();
        return view('admin.dashboard', compact('allPayments', 'allWithdraw', 'payment_this_year', 'withdrawal_this_year', 'total_users', 'total_services', 'total_campaign', 'total_users_year'));
    }
}
