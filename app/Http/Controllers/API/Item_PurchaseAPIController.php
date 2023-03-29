<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\admin\ItemPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Item_PurchaseAPIController extends Controller
{
    /*Store DataBase Api*/

    public function add_item_purchase(Request $request)
    {

        $cust_api = Auth::guard('api')->user();
        if ($cust_api) {
            $rules = [
                'item_name_id' => 'required',
                'item_sales_id' => 'required',
                'Purchase_Rate' => 'required',
                'Sales_Rates' => 'required',
            ];

            $validate = Validator::make($request->all(), $rules);
            if ($validate->fails()) {
                return $this->api_error_response("Invalid input data", $validate->errors()->all());
            }

            $input = $request->all();
            $input['created_by'] = $cust_api->id;
            ItemPurchase::create($input);
            return $this->api_success_response('Success', ['item_purchase_details' => $input]);
        } else {
            return $this->api_error_response('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    /*Data Listing && Searching Filter Api*/

    public function item_purchase_list(Request $request)
    {
        $cust_api = Auth::guard('api')->user();

        $search = $request->input('search');
        if ($cust_api) {
            if ($search) {
                $item_purchase_details = ItemPurchase::where(function ($query) use ($search) {
                    $query->where('item_name_id', '=', $search)
                        ->orWhere('item_sales_id', '=', $search)
                        ->orWhere('id', '=', $search)
                        ->orWhere('Purchase_Rate', '=', $search)
                        ->orWhere('Sales_Rates', '=', $search)
                        ->orWhere('customer_name', '=', $search);
                })->get();
                return $this->api_success_response('Success', ['item_purchase_details' => $item_purchase_details]);
            }
            $item_purchase_details = ItemPurchase::all();
            return $this->api_success_response('Success', ['item_purchase_details' => $item_purchase_details]);
        } else {
            return $this->api_error_response('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

}
