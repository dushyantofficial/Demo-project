<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Customers;
use App\Models\admin\ItemName;
use App\Models\admin\ItemPurchase;
use App\Models\admin\ItemSales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;

class ItemSalesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $item_saless = ItemSales::orderBy('ItemSalesId','desc')->get();
            return view('admin.item_sales.index', compact('item_saless'));
        }
        $item_saless = ItemSales::where('InsertedByUserId', $user->id)->orderBy('ItemSalesId','desc')->get();
        return view('admin.item_sales.index', compact('item_saless'));
    }


    public function create()
    {
        $user = Auth::user();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $customers = Customers::all();
            $item_namess = ItemPurchase::all();
            return view('admin.item_sales.create', compact('item_namess', 'customers'));
        }
        $customers = Customers::where('user_id', $user->id)->get();
        $item_namess = ItemPurchase::where('InsertedByUserId', $user->id)->get();
        return view('admin.item_sales.create', compact('item_namess', 'customers'));
    }

    public function store(Request $request)
    {

        $request->validate(ItemSales::$rules);
        $input = $request->all();
        $input['InsertedByUserId'] = Auth::user()->id;
        if ($request->hasFile("CustPhoto")) {
            $img = $request->file("CustPhoto");
            $img->store('public/images');
            $input['CustPhoto'] = $img->hashName();
        }
        ItemSales::create($input);
        return redirect()->route('item_sales.index')->with('success', Lang::get('langs.flash_suc'));

    }

    public function show($id)
    {

    }

    public function edit(Request $request, $id)
    {
        $customers = Customers::all();
        $item_namess = ItemName::all();
        $item_saless = ItemSales::find($id);

        return view('admin.item_sales.edit', compact('customers', 'item_namess', 'item_saless'));
    }

    public function update(Request $request, $id)
    {
        $rules = ItemSales::$rules;
        $rules['CustPhoto'] = 'nullable';
        $request->validate($rules);
        $item_saless = ItemSales::find($id);
        $input = $request->all();
        if ($request->hasFile("CustPhoto")) {
            $img = $request->file("CustPhoto");
            if (Storage::exists('public/images' . $item_saless->CustPhoto)) {
                Storage::delete('public/images' . $item_saless->CustPhoto);
            }
            $img->store('public/images');
            $input['CustPhoto'] = $img->hashName();
            $item_saless->update($input);

        }

        $item_saless->update($input);

        return redirect()->route('item_sales.index')->with('info', Lang::get('langs.flash_up'));
    }

    public function destroy(Request $request, $id)
    {
        $item_saless = ItemSales::find($id);
        if (empty($item_saless)) {
            return redirect(route('item_sales.index'));
        }
        $item_saless->delete($id);
        return redirect(route('item_sales.index'))->with('danger', Lang::get('langs.flash_del'));


    }

    public function getQuantity(Request $request)
    {
        $quantity = ItemPurchase::select('item_quantity')->where('id', $request->id)->first();
        return $quantity;
    }
    public function edit_get_quantity(Request $request)
    {
        $quantity = ItemPurchase::select('item_quantity')->where('item_name_id', $request->id)->first();

        return $quantity;
    }

    public function getPayment(Request $request)
    {
        //, ['deduct_to_date', $request->to_date], ['deduct_from_date', $request->from_date]
        $quantity = ItemSales::where('customer_id', $request->id)->whereBetween('created_at', [$request->from_date, $request->to_date])->sum('deduct_payment');
        $final_amount = Customers::select('final_amount')->where('id', $request->id)->first();
        $data = array();
        $data['deduct_payment'] = $quantity;
        $data['final_amount'] = $final_amount['final_amount'];
        return $data;
    }

    public function get_item_price(Request $request)
    {

         $quantity = ItemPurchase::where('id',$request->id)->first();
                $data = array();
                $data['deduct_payment'] = $quantity->Sales_Rates;
                return $data;
            }

// edit_get_payment
    public function edit_get_payment(Request $request)
    {
        $quantity = ItemSales::where('customer_id', $request->id)->whereBetween('created_at', [$request->from_date, $request->to_date])->sum('deduct_payment');
        $final_amount = Customers::select('final_amount')->where('id', $request->id)->first();
        $data = array();
        $data['deduct_payment'] = $quantity;
        $data['final_amount'] = $final_amount['final_amount'];
        return $data;
    }
}
