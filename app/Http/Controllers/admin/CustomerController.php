<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Imports\CustomerImport;
use App\Models\admin\Customers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $customers = Customers::orderBy('cust_id','desc')->get();
            return view('admin.customer.index', compact('customers'));
        }
        $customers = Customers::where('user_id', $user->id)->orderBy('cust_id','desc')->get();
        return view('admin.customer.index', compact('customers'));
    }


    public function create()
    {
        $user = Auth::user();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $users = User::all();
            return view('admin.customer.create', compact('users'));
        }
        $users = User::where('id', $user->id)->get();
        return view('admin.customer.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate(Customers::$rules);
        $validatedData = $request->validate([
            'account_number' => 'required|unique:customers,account_number'
        ]);

        $input = $request->all();
        $input['InsertedByUserId'] = Auth::user()->id;
        Customers::create($input);
        return redirect()->route('customer.index')->with('success', Lang::get('langs.flash_suc'));

    }

    public function show($id)
    {

    }

    public function edit(Request $request, $id)
    {
        $customers = Customers::find($id);
        $users = User::all();
        return view('admin.customer.edit', compact('customers', 'users'));
    }

    public function update(Request $request, $id)
    {
        $rules = Customers::$rules;
        $request->validate($rules);
        $customers = Customers::find($id);
        $validatedData = $request->validate([
            'account_number' => 'required|unique:customers,account_number,' . $customers->id,
        ]);

        $input = $request->all();
        $customers->update($input);

        return redirect()->route('customer.index')->with('info', Lang::get('langs.flash_up'));
    }

    public function destroy(Request $request, $id)
    {
        $customers = Customers::find($id);
        if (empty($customers)) {
            return redirect(route('customer.index'));
        }
        $customers->delete($id);
        return redirect(route('customer.index'))->with('danger', Lang::get('langs.flash_del'));

    }


    public function bank_update(Request $request)
    {
        $rules = Customers::$bank;
        $request->validate($rules);
        $customer = Customers::where('user_id', Auth::user()->id)->first();
        $validatedData = $request->validate([
            'account_number' => 'required|unique:customers,account_number,' . $customer->id,
        ]);

        $input = $request->all();
        $customer->update($input);

        return redirect()->back()->with('info', Lang::get('langs.flash_bank'));
    }

    public function import()
    {
        $this->validate(request(), [
            'file' => 'required|mimes:xls,csv,xlsx,txt',
        ]);
//dd(\request()->date);
        Excel::import(new CustomerImport(), request()->file('file'),\request()->date);

        return redirect()->back()->with('success', Lang::get('langs.Import_file_successfully'));
    }


}
