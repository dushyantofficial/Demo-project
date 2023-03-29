<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\admin\ItemSales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Item_SalesAPIController extends Controller
{
    /*Store DataBase Api*/
    public function add_item_sales(Request $request)
    {

        $cust_api = Auth::guard('api')->user();

        if ($cust_api) {
            $rules = [
                'PayFromDT' => 'required',
                'PayToDT' => 'required',
                'itemQuantity' => 'required',
                'CustPhoto' => 'required',
                'item_name_id' => 'required',
                'customer_id' => 'required',
                'Payment_Rate' => 'required',
                'DeductFromDT' => 'required',
                'DeductToDT' => 'required',
                'Deduct_Rate' => 'required',
                'Total_DT' => 'required',
                'Total_Rate' => 'required',
            ];

            $validate = Validator::make($request->all(), $rules);
            if ($validate->fails()) {
                return $this->api_error_response("Invalid input data", $validate->errors()->all());
            }

            $input = $request->all();
            $input['created_by'] = $cust_api->id;
            if ($request->hasFile("CustPhoto")) {
                $img = $request->file("CustPhoto");
                $img->store('public/images');
                $input['CustPhoto'] = $img->hashName();
            }
            ItemSales::create($input);
            return $this->api_success_response('Success', ['item_sales_details' => $input]);
        } else {
            return $this->api_error_response('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    /*Data Listing && Searching Filter Api*/

    public function item_sales_list(Request $request)
    {
        $cust_api = Auth::guard('api')->user();

        $search = $request->input('search');
        if ($cust_api) {
            if ($search) {
                $item_sales_details = ItemSales::where(function ($query) use ($search) {
                    $query->where('PayFromDT', '=', $search)
                        ->orWhere('PayToDT', '=', $search)
                        ->orWhere('id', '=', $search)
                        ->orWhere('Payment_Rate', '=', $search)
                        ->orWhere('DeductFromDT', '=', $search)
                        ->orWhere('DeductToDT', '=', $search)
                        ->orWhere('Deduct_Rate', '=', $search)
                        ->orWhere('Total_DT', '=', $search)
                        ->orWhere('itemQuantity', '=', $search)
                        ->orWhere('item_name_id ', '=', $search)
                        ->orWhere('Total_Rate', '=', $search);
                })->get();
                return $this->api_success_response('Success', ['item_sales_details' => $item_sales_details]);
            }
            $item_sales_details = ItemSales::all();
            return $this->api_success_response('Success', ['item_sales_details' => $item_sales_details]);
        } else {
            return $this->api_error_response('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    /*Get Api*/

    public function item_sales()
    {
        $cust_api = Auth::guard('api')->user();

        if ($cust_api) {
            $item_sales = ItemSales::all();
            return $this->api_success_response('Success', ['item_sales' => $item_sales]);
        } else {
            return $this->api_error_response('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

}
