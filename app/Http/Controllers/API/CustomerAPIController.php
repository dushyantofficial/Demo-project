<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\admin\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerAPIController extends Controller
{

    /*Store DataBase Api*/
    public function add_customer(Request $request)
    {

        $cust_api = Auth::guard('api')->user();

        if ($cust_api) {
            $rules = [
                'user_id' => 'required',
                'bank_name' => 'required',
                'account_number' => 'required',
                'ifsc_code' => 'required',
                'final_amount' => 'required',
            ];

            $validate = Validator::make($request->all(), $rules);
            if ($validate->fails()) {
                return $this->api_error_response("Invalid input data", $validate->errors()->all());
            }

            $input = $request->all();
            $input['created_by'] = $cust_api->id;
            Customers::create($input);
            return $this->api_success_response('Success', ['customer_details' => $input]);
        } else {
            return $this->api_error_response('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }


    /*Data Listing && Searching Filter Api*/

    public function customer_list(Request $request)
    {
        $cust_api = Auth::guard('api')->user();

        $search = $request->input('search');
        if ($cust_api) {
            if ($search) {
                $customer_details = Customers::where(function ($query) use ($search) {
                    $query->where('user_id', '=', $search)
                        ->orWhere('bank_name', '=', $search)
                        ->orWhere('id', '=', $search)
                        ->orWhere('ifsc_code', '=', $search)
                        ->orWhere('final_amount', '=', $search)
                        ->orWhere('account_number', '=', $search);
                })->get();
                return $this->api_success_response('Success', ['customer_details' => $customer_details]);
            }
            $customer_details = Customers::all();
            return $this->api_success_response('Success', ['customer_details' => $customer_details]);
        } else {
            return $this->api_error_response('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }


}
