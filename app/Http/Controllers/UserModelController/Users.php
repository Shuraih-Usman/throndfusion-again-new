<?php

namespace App\Http\Controllers\UserModelController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Helpers\ActivityLogHelper;
use Illuminate\Support\Facades\Hash;
class Users extends Controller
{
    //

    public function edit($request) 
    {
        $s = 0;
        $id = $request->id;


            $validator = Validator::make($request->all(), [

                'fullname' => 'required|string',
                'image' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
                'email' => 'required|string|unique:users,email,'.$id,
            ]);

            if($validator->fails()) {
                $m = $validator->errors()->first();
            } else {

                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                    $folder = 'images/users/' . date('y/m/');
                    $subfolder = 'users/' . date('y/m/');
                    $image->move(public_path($folder), $imageName);
                } else {
                    $imageName = $request->img;
                    $subfolder = $request->img_folder;
                }

            $user = User::findOrFail($id);
            $user->fullname = $request->fullname;
            $user->email = $request->email;
            $user->image = $imageName;
            $user->image_folder = $subfolder;
            $user->gender = $request->gender;
            $user->dob = $request->dob;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->organization = $request->organization;
            $user->country = $request->country;
            $user->state = $request->state;
            $user->lga = $request->lga;
            $user->zipcode = $request->zipcode;
            $user->status = $request->has('status') ? 1 : 0;
            $user->save();
            $s = 1;
            $m = "You have successfully Update Your Profile .";
            ActivityLogHelper::log('Profile', Admin('id'), $m);
            }
        

        return ['m' => $m, 's' => $s];
    }

    public function bankDetails($req) {
        $s = 0;
        $id = $req->id;

        $validator = Validator::make($req->all(), [
            'nin' => 'required|numeric|unique:users,nin_number,' . $id,
            'bank' => 'required|string',
            'account' => 'required|numeric',
            'account_name' => 'required|string',
        ]);
        
        if($validator->fails()) {
            $m = $validator->errors()->first();
        } else {
            $user = User::find($id);
            $user->nin_number = $req->nin;
            $user->bank_name = $req->bank;
            $user->account_number = $req->acoount;
            $user->account_name = $req->account_name;
            $user->save();
            $s = 1;
            $m = " Bank details successfully updated";
            ActivityLogHelper::log('Profile', Admin('id'), $m);
        }

        return ['m' => $m, 's' => $s];
    }

    public function changePass(Request $request) {
        $s = 0;
        $messages = [
            'oldpass.required' => 'The old password is required.',
            'newpass.required' => 'The new password is required.',
            'newpass.min' => 'The new password must be at least 8 characters.',
            'newpass.confirmed' => 'The new password confirmation does not match.',
        ];

        $validator = Validator::make($request->all(), [
            'oldpass' => 'required',
            'newpass' => 'required|min:8|confirmed',
        ], $messages);

        if($validator->fails()) {
            $m = $validator->errors()->first();
        } else {

            $id = Admin('id');
            $admin = User::find($id);
            if(!Hash::check($request->oldpass, $admin->password)) {
                $m = "Invalid Old password";
            } else {

                $admin->password = Hash::make($request->newpass);
                $admin->save();
                $s = 1;
                $m = "Successfully Change your password";
                
            }
        }
        return ['m' => $m, 's' => $s];
        
    }
}
