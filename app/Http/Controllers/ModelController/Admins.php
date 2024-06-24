<?php

namespace App\Http\Controllers\ModelController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
class Admins extends Controller
{
    //

    public function edit($request) 
    {
        $s = 0;
        $id = $request->id;


            $validator = Validator::make($request->all(), [

                'name' => 'required|string',
                'image' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
                'email' => 'required|string|unique:users,email,'.$id,
                'username' => 'required|string|unique:users,username,'.$id,
            ]);

            if($validator->fails()) {
                $m = $validator->errors()->first();
            } else {

                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                    $folder = 'images/admins/' . date('y/m/');
                    $subfolder = 'admins/' . date('y/m/');
                    $image->move(public_path($folder), $imageName);
                } else {
                    $imageName = $request->img;
                    $subfolder = $request->img_folder;
                }

            $user = Admin::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->image = $imageName;
            $user->image_folder = $subfolder;
            $user->gender = $request->gender;
            $user->dob = $request->dob;
            $user->address = $request->address;
            $user->country = $request->country;
            $user->state = $request->state;
            $user->lga = $request->lga;
            $user->username = $request->username;
            $user->save();
            $s = 1;
            $m = "You have successfully Update Your Profile .";
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
            $admin = Admin::find($id);
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
