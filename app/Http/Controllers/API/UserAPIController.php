<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserAPIController extends Controller
{
    /*Login && LogOut Api*/
    public function login(Request $request)
    {
        $rules = [
            'user_name' => 'required',
            'password' => 'required',
        ];

        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return $this->api_error_response("Invalid input data", $validate->errors()->all());
        }
        if (is_numeric($request->get('user_name'))) {
            if (Auth::attempt(['mobile_number' => $request->user_name, 'password' => $request->password])) {
                $user = Auth::user();;
                $token = $user->createToken('DairyReport')->accessToken;
                return $this->api_success_response('User login successfully.', ['token' => $token, 'user_details' => $user]);
            } else {
                return $this->api_error_response('Unauthorised.', ['error' => 'Unauthorised']);
            }
        } elseif (filter_var($request->get('user_name'))) {
            if (Auth::attempt(['user_name' => $request->user_name, 'password' => $request->password])) {
                $user = Auth::user();
                $token = $user->createToken('DairyReport')->accessToken;

                return $this->api_success_response('User login successfully.', ['token' => $token, 'user_details' => $user]);
            } else {
                return $this->api_error_response('Unauthorised.', ['error' => 'Unauthorised']);
            }
        }
    }

    public
    function user_logout(Request $request)
    {

        if (Auth::guard('api')->user()) {
            Auth::guard('api')->user()->token()->revoke();
        }
        return $this->api_success_response("Logged out successfully !");
    }


    /*Store DataBase Api*/
    public function add_user(Request $request)
    {


        $user_api = Auth::guard('api')->user();

        if ($user_api) {
            $rules = [
                'mandali_code' => 'required',
                'customer_name' => 'required',
                'password' => 'required',
                'gender' => 'required',
                'email' => 'required|regex:/(.+)@(.+)\.(.+)/i|unique:users,email',
                'user_name' => 'required|unique:users,user_name',
                'mobile_number' => 'required|unique:users,mobile_number',
            ];

            $validate = Validator::make($request->all(), $rules);
            if ($validate->fails()) {
                return $this->api_error_response("Invalid input data", $validate->errors()->all());
            }

            $input = $request->all();
            $input['password'] = Hash::make(\request('passport'));
            $input['role'] = config('constants.ROLE.USER');
            $input['created_by'] = $user_api->id;
            if ($request->hasFile("profile_pic")) {
                $img = $request->file("profile_pic");
                $img->store('public/images');
                $input['profile_pic'] = $img->hashName();
            }
            User::create($input);
            return $this->api_success_response('Success', ['customer_details' => $input]);
        } else {
            return $this->api_error_response('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    /*Data Listing && Searching Filter Api*/

    public function user_list(Request $request)
    {

        $cust_api = Auth::guard('api')->user();

        $search = $request->input('search');
        if ($cust_api) {
            if ($search) {
                $user_details = User::where(function ($query) use ($search) {
                    $query->where('user_name', '=', $search)
                        ->orWhere('mobile_number', '=', $search)
                        ->orWhere('id', '=', $search)
                        ->orWhere('customer_name', '=', $search);
                })->get();
                return $this->api_success_response('Success', ['user_details' => $user_details]);
            }
            $user_details = User::all();
            return $this->api_success_response('Success', ['user_details' => $user_details]);
        } else {
            return $this->api_error_response('Unauthorised.', ['error' => 'Unauthorised']);
        }

    }

    /*Get Api*/

    public function customer()
    {
        $cust_api = Auth::guard('api')->user();

        if ($cust_api) {
            $users = User::where('role', '!=', config('constants.ROLE.ADMIN'))->get();
            return $this->api_success_response('Success', ['users' => $users]);
        } else {
            return $this->api_error_response('Unauthorised.', ['error' => 'Unauthorised']);
        }

    }

}
