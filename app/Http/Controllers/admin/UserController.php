<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Imports\CustomerImport;
use App\Models\User;
use App\Rule\CurrentPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $users = User::orderBy('id','desc')->get();
            return view('admin.user.index', compact('users'));
        }
        $users = User::where('id', $user->id)->orderBy('id','desc')->get();
        return view('admin.user.index', compact('users'));
    }


    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {

        $request->validate(User::$rules);
        $validatedData = $request->validate([
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i|unique:users,email',
            'user_name' => 'required|unique:users,user_name',
            'mobile' => 'required|unique:users,mobile'
        ]);
        $input = $request->all();
        $input['password'] = Hash::make(\request('password'));
        $input['role'] = config('constants.ROLE.USER');
        $input['InsertedByUserId'] = Auth::user()->id;
        $input['lang'] = 'en';
        if ($request->hasFile("profile")) {
            $img = $request->file("profile");
            $img->store('public/images');
            $input['profile'] = $img->hashName();
        }
        User::create($input);
        return redirect()->route('user.index')->with('success', Lang::get('langs.flash_suc'));

    }

    public function show($id)
    {

    }

    public function edit(Request $request, $id)
    {
        $users = User::find($id);
        return view('admin.user.edit', compact('users'));
    }

    public function update(Request $request, $id)
    {
        $rules = User::$rules;
        $rules['profile'] = 'nullable';
        $rules['password'] = 'nullable';
        $request->validate($rules);
        $users = User::find($id);
        $request->validate([
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i|unique:users,email,' . $users->id,
            'user_name' => 'required|unique:users,user_name,' . $users->id,
            'mobile_number' => 'required|unique:users,mobile_number,' . $users->id,
        ]);
        $input = $request->all();
        if ($request->hasFile("profile")) {
            $img = $request->file("profile_pic");
            if (Storage::exists('public/images' . $users->profile)) {
                Storage::delete('public/images' . $users->profile);
            }
            $img->store('public/images');
            $input['profile'] = $img->hashName();
            $users->update($input);

        }

        $users->update($input);

        return redirect()->route('user.index')->with('info', Lang::get('langs.flash_up'));
    }

    public function destroy(Request $request, $id)
    {
        $users = User::find($id);
        if (empty($users)) {
            return redirect(route('user.index'));
        }
        $users->delete($id);
        return redirect(route('user.index'))->with('danger', Lang::get('langs.flash_del'));

    }


    public function profile()
    {
        return view('auth.profile');
    }

    public function profile_update(Request $request)
    {
        $rules = User::$profile;
        $rules['profile_pic'] = 'nullable';
        $rules['password'] = 'nullable';
        $request->validate($rules);
        $user = Auth::user();
        $validatedData = $request->validate([
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i|unique:users,email,' . $user->id,
            'user_name' => 'required|unique:users,user_name,' . $user->id,
            'mobile_number' => 'required|unique:users,mobile_number,' . $user->id,
        ]);
        $input = $request->all();
        $input['created_by'] = Auth::user()->id;
        if ($request->hasFile("profile_pic")) {
            $img = $request->file("profile_pic");
            if (Storage::exists('public/images' . $user->profile_pic)) {
                Storage::delete('public/images' . $user->profile_pic);
            }
            $img->store('public/images');
            $input['profile_pic'] = $img->hashName();
            $user->update($input);

        }

        $user->update($input);

        return redirect()->back()->with('info', Lang::get('langs.flash_up'));
    }


    public function change_password(Request $request)
    {
        $input = $request->all();
        $user = User::whereId(Auth::id())->first();
        $request->validate([
            'current_password' => [new CurrentPassword($user->password)],

            'new_password' => 'min:4',
            'conform_password' => 'required|same:new_password'
        ]);

        $new_pass['password'] = Hash::make($request->input('new_password'));
        $user->update($new_pass);
        $user->update($input);
        return redirect()->back()->with('info', Lang::get('langs.flash_change_pass'));
    }

    public function import()
    {
        $this->validate(request(), [
            'file' => 'required|mimes:xls,csv,xlsx,txt',
        ]);

        Excel::import(new CustomerImport(), request()->file('file'));

        return redirect()->back()->with('success', 'Import file SuccessFully!...');
    }

    public function english()
    {
        $user = Auth::user();
        $input['lang'] = 'en';
        $user->update($input);
        return redirect()->back()->with('success', Lang::get('langs.lang'));
    }

    public function gujarati()
    {
        $user = Auth::user();
        $input['lang'] = 'guj';
        $user->update($input);
        return redirect()->back()->with('success', Lang::get('langs.lang'));
    }

}
