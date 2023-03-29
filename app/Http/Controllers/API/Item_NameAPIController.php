<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\admin\ItemName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Item_NameAPIController extends Controller
{
    /*Store DataBase Api*/
    public function add_item(Request $request)
    {

        $cust_api = Auth::guard('api')->user();

        if ($cust_api) {
            $rules = [
                'item_name' => 'required',
            ];

            $validate = Validator::make($request->all(), $rules);
            if ($validate->fails()) {
                return $this->api_error_response("Invalid input data", $validate->errors()->all());
            }

            $input = $request->all();
            $input['created_by'] = $cust_api->id;
            ItemName::create($input);
            return $this->api_success_response('Success', ['item_name_details' => $input]);
        } else {
            return $this->api_error_response('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    /*Data Listing && Searching Filter Api*/

    public function item_name_list(Request $request)
    {
        $cust_api = Auth::guard('api')->user();

        $search = $request->input('search');
        if ($cust_api) {
            if ($search) {
                $item_name_details = ItemName::where(function ($query) use ($search) {
                    $query->where('item_name', '=', $search)
                        ->orWhere('id', '=', $search);
                })->get();
                return $this->api_success_response('Success', ['item_name_details' => $item_name_details]);
            }
            $item_name_details = ItemName::all();
            return $this->api_success_response('Success', ['item_name_details' => $item_name_details]);
        } else {
            return $this->api_error_response('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    /*Get Api*/

    public function item_name()
    {
        $cust_api = Auth::guard('api')->user();

        if ($cust_api) {
            $item_names = ItemName::all();
            return $this->api_success_response('Success', ['item_name_details' => $item_names]);
        } else {
            return $this->api_error_response('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }


}
