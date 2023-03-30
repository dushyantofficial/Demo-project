<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\ItemName;
use App\Models\admin\ItemPurchase;
use App\Models\admin\ItemSales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class ItemPurchaseController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $item_purchases = ItemPurchase::orderBy('purchase_id','desc')->get();
            return view('admin.item_purchase.index', compact('item_purchases'));
        }
        $item_purchases = ItemPurchase::where('created_by', $user->id)->orderBy('purchase_id','desc')->get();
        return view('admin.item_purchase.index', compact('item_purchases'));
    }


    public function create()
    {
        $item_names = ItemName::all();
        $item_sales = ItemSales::all();
        return view('admin.item_purchase.create', compact('item_names', 'item_sales'));
    }

    public function store(Request $request)
    {
        $request->validate(ItemPurchase::$rules);
        $input = $request->all();
        $input['InsertedByUserId'] = Auth::user()->id;
        ItemPurchase::create($input);
        return redirect()->route('item_purchase.index')->with('success', Lang::get('langs.flash_suc'));

    }

    public function show($id)
    {

    }

    public function edit(Request $request, $id)
    {
        $item_purchases = ItemPurchase::find($id);
        $item_names = ItemName::all();
        $item_sales = ItemSales::all();
        return view('admin.item_purchase.edit', compact('item_purchases', 'item_sales', 'item_names'));
    }

    public function update(Request $request, $id)
    {
        $rules = ItemPurchase::$rules;
        $request->validate($rules);
        $item_purchases = ItemPurchase::find($id);
        $input = $request->all();
        $item_purchases->update($input);

        return redirect()->route('item_purchase.index')->with('info', Lang::get('langs.flash_up'));
    }

    public function destroy(Request $request, $id)
    {
        $item_purchases = ItemPurchase::find($id);
        if (empty($item_purchases)) {
            return redirect(route('item_purchase.index'));
        }
        $item_purchases->delete($id);
        return redirect(route('item_purchase.index'))->with('danger', Lang::get('langs.flash_del'));

    }

}
