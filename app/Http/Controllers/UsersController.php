<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Http\Controllers\Controller;
// use App\Http\Requests\StoreUsersRequest;
// use App\Http\Requests\UpdateUsersRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function index()
    {
        $data = Users::get();
        return response()->json(['succes' => true, 'data' => $data], 200);
    }

    public function create(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'string|required|max:255',
            'email' => 'string|required|unique:users,email|max:255',
            'password'=> 'string|required|min:7|regex:/[A-Z]/|regex:/[^a-zA-Z0-9]/',
        ]);

        /*
            name = [the name field is required, The name field must not be greater than 255 characters]
            email = [the email field is required, The email field must not be greater than 255 characters, The email has already been taken]
            password = [the password field is required, The password field must be at least 7 characters, The password field format is invalid]
        */

        if ($validator->fails()) {
            $validErrors = $validator->errors();
            if($validErrors->has('email')) {
                $error = $validErrors->first('email');
                if($error === "The email has already been taken.") {
                    return response()->json(['success' => false, 'msg' => "Email has already been registered, try to login using this email address", 'info' => $error], 400);
                }
            }
            return response()->json(['success' => false, 'msg' => 'Request not valid', 'info' => $validator->errors()], 400);
        }
        $input['password'] = Hash::make($input['password']);
        $data = Users::create($input);

        return response()->json(['success'=> true,'data'=> $data],201);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'string|max:255',
            'email' => 'string|unique:users,email,'.$id.'|max:255',
            'password'=> 'string|min:7|regex:/[A-Z]/|regex:/[^a-zA-Z0-9]/',
        ]);
        /*
            name = [The name field must not be greater than 255 characters]
            email = [The email field must not be greater than 255 characters, The email has already been taken]
            password = [The password field must be at least 7 characters, The password field format is invalid]
        */
        if ($validator->fails()) {
            $validErrors = $validator->errors();
            if($validErrors->has('email')) {
                $error = $validErrors->first('email');
                if($error === "The email has already been taken.") {
                    return response()->json(['success' => false, 'msg' => "Email has already been registered, please use another email address", 'info' => $error], 400);
                }
            }
            return response()->json(['success' => false, 'msg' => 'Request not valid', 'info' => $validator->errors()], 400);
        }
        if(isset($input['password']) && $input['password'] != '') {
            $input['password'] = Hash::make($input['password']);
        }else if($input['password'] == '') {
            return response()->json(['success' => false, 'msg' => 'password can\'t be empty'], 400);
        }
        $user = Users::find($id)->update($input);
        if($user) {
            return response()->json(['success'=> true,'msg'=> 'success updating'], 200);
        }
    }

    public function destroy($id)
    {
        $user = Users::find($id);
        if($user) {
            $destroy = $user->delete();
            if($destroy){
                return response()->json(['success'=> true, 'msg'=> 'success deleting'], 200);
            }
        }
        else {
            return response()->json(['success'=> false, 'msg'=> 'already deleted / user not found'],410);
        }
    }
}
