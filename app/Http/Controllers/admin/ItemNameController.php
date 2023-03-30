<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\ItemName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class ItemNameController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $item_names = ItemName::orderBy('item_id','desc')->get();
            return view('admin.item_name.index', compact('item_names'));
        }
        $item_names = ItemName::where('created_by', $user->id)->orderBy('item_id','desc')->get();
        return view('admin.item_name.index', compact('item_names'));
    }


    public function create()
    {
        return view('admin.item_name.create');
    }

    public function store(Request $request)
    {
        $request->validate(ItemName::$rules);
        $input = $request->all();
        $input['InsertedByUserId'] = Auth::user()->id;
        ItemName::create($input);
        return redirect()->route('item_name.index')->with('success', Lang::get('langs.flash_suc'));

    }

    public function show($id)
    {

    }

    public function edit(Request $request, $id)
    {
        $item_names = ItemName::find($id);
        return view('admin.item_name.edit', compact('item_names'));
    }

    public function update(Request $request, $id)
    {
        $rules = ItemName::$rules;
        $request->validate($rules);
        $item_names = ItemName::find($id);

        $input = $request->all();
        $item_names->update($input);

        return redirect()->route('item_name.index')->with('info', Lang::get('langs.flash_up'));
    }

    public function destroy(Request $request, $id)
    {
        $item_names = ItemName::find($id);
        if (empty($item_names)) {
            return redirect(route('item_name.index'));
        }
        $item_names->delete($id);
        return redirect(route('item_name.index'))->with('danger', Lang::get('langs.flash_del'));

    }

}
