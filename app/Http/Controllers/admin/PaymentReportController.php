<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Customers;
use App\Models\admin\ItemSales;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentReportController extends Controller
{
    //Payment register Report
    public function payment_register_report(Request $request){
        $user = Auth::user();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $filter_payment_register = Customers::orderBy('id', 'desc')->get();
            $bank_names = Customers::orderBy('bank_name', 'asc')->distinct()->get();
            if ($request->date) {
                $date = $request->date;
                $name = explode(' ', $date);
                $start = date('Y-m-d', strtotime($name[0]));
                $end = date('Y-m-d', strtotime($name[2]));

                $filter_payment_register = Customers::where(function ($query) use ($request,$start,$end){
                    $query->whereBetween('customer_code',[$request->customer_from_code,$request->customer_to_code]);
                    $query->orWhere('bank_name','==',$request->bank_name);
                    $query->whereDate('created_at', '>=', $start);
                    $query->whereDate('created_at', '>=', $end);
                })->get();

            }
            return view('admin.payment.payment_register.payment_register_report', compact('filter_payment_register', 'bank_names'));
        }
        $filter_payment_register = Customers::where('user_id', $user->id)->orderBy('id', 'desc')->get();
        $bank_names = Customers::where('user_id', $user->id)->orderBy('bank_name', 'desc')->get();
        if ($request->date) {
            $date = $request->date;
            $name = explode(' ', $date);
            $start = date('Y-m-d', strtotime($name[0]));
            $end = date('Y-m-d', strtotime($name[2]));
            $filter_customers = Customers::where('user_id', $user->id)->where(function ($query) use ($request,$start,$end){
                $query->whereBetween('customer_code',[$request->customer_from_code,$request->customer_to_code]);
                $query->orWhere('bank_name','==',$request->bank_name);
                $query->whereDate('created_at', '>=', $start);
                $query->whereDate('created_at', '>=', $end);
            })->get();
        }
        return view('admin.payment.payment_register.payment_register_report', compact('filter_payment_register', 'bank_names'));
    }


    public function payment_register_report_pdf(Request $request)
    {

        $user = Auth::user();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $payment_register_report_pdfs = Customers::orderBy('id','desc')->get();
            if ($request->date) {
                $date = $request->date;
                $name = explode(' ', $date);
                $start = date('Y-m-d', strtotime($name[0]));
                $end = date('Y-m-d', strtotime($name[2]));
                $payment_register_report_pdfs = Customers::where(function ($query) use ($request,$start,$end){
                    $query->whereBetween('customer_code',[$request->customer_from_code,$request->customer_to_code]);
                    $query->orWhere('bank_name','==',$request->bank_name);
                    $query->whereDate('created_at', '>=', $start);
                    $query->whereDate('created_at', '>=', $end);
                })->get();
            }
            $item_purchasePaper = array(0, 0, 1000.00, 900.80);
            $pdf = PDF::loadView('admin.payment.payment_register.payment_register_report_pdf', compact('payment_register_report_pdfs'))->setPaper($item_purchasePaper)->set_option('font_dir', storage_path(''))->set_option('font_cache', storage_path(''));

            if (isset($start)) {
                return $pdf->download($start . '_to_' . $end . '_' . 'payment_register_report.pdf');
            } else {
                return $pdf->download('payment_register_report.pdf');
            }
        }
        $payment_register_report_pdfs = Customers::where('user_id', $user->id)->orderBy('id','desc')->get();
        if ($request->date) {
            $date = $request->date;
            $name = explode(' ', $date);
            $start = date('Y-m-d', strtotime($name[0]));
            $end = date('Y-m-d', strtotime($name[2]));
            $payment_register_report_pdfs = Customers::where('user_id', $user->id)->where(function ($query) use ($request,$start,$end){
                $query->whereBetween('customer_code',[$request->customer_from_code,$request->customer_to_code]);
                $query->orWhere('bank_name','==',$request->bank_name);
                $query->whereDate('created_at', '>=', $start);
                $query->whereDate('created_at', '>=', $end);
            })->get();
        }
        $item_purchasePaper = array(0, 0, 1000.00, 900.80);
        $pdf = PDF::loadView('admin.payment.payment_register.payment_register_report_pdf', compact('payment_register_report_pdfs'))->setPaper($item_purchasePaper)->set_option('font_dir', storage_path(''))->set_option('font_cache', storage_path(''));

        if (isset($start)) {
            return $pdf->download($start . '_to_' . $end . '_' . 'payment_register_report.pdf');
        } else {
            return $pdf->download('payment_register_report.pdf');
        }

    }


    public function payment_register_report_export(Request $request)
    {

        $request->validate(
            [
                'field' => 'required'
            ]
        );

        $input = $request->all();
        $val = array_keys($input['field']);
        $user = Auth::user();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $customers = Customers::select($val)->get();
            if ($request->date) {
                $date = $request->date;
                $name = explode(' ', $date);
                $start = date('Y-m-d', strtotime($name[0]));
                $end = date('Y-m-d', strtotime($name[2]));
                $customers = Customers::whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->select($val)->get();
            }

            return view('admin.payment.payment_register.payment_register_report_export', compact('customers', 'input'));
        }
        $customers = Customers::where('user_id', $user->id)->select($val)->get();
        if ($request->date) {
            $date = $request->date;
            $name = explode(' ', $date);
            $start = date('Y-m-d', strtotime($name[0]));
            $end = date('Y-m-d', strtotime($name[2]));
            $customers = Customers::where('user_id', $user->id)->whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->select($val)->get();
        }

        return view('admin.payment.payment_register.payment_register_report_export', compact('customers', 'input'));

    }

    public function payment_register_report_export_pdf(Request $request)
    {

        $input = $request->all();
        $val = array_keys($input['field']);
        $user = Auth::user();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $customer_reports = Customers::select($val)->get();
            if ($request->date) {
                $date = $request->date;
                $name = explode(' ', $date);
                $start = date('Y-m-d', strtotime($name[0]));
                $end = date('Y-m-d', strtotime($name[2]));
                $customer_reports = Customers::whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->select($val)->get();
            }

            $customerPaper = array(0, 0, 1000.00, 900.80);
            $pdf = PDF::loadView('admin.payment.payment_register.payment_register_report_export_pdf', compact('customer_reports', 'input'))->setPaper($customerPaper)->set_option('font_dir', storage_path(''))->set_option('font_cache', storage_path(''));
            if (isset($start)) {
                return $pdf->download($start . '_to_' . $end . '_' . 'customer_report.pdf');
            } else {
                return $pdf->download('payment_register_report.pdf');
            }
        }
        $customer_reports = Customers::where('user_id', $user->id)->select($val)->get();
        if ($request->date) {
            $date = $request->date;
            $name = explode(' ', $date);
            $start = date('Y-m-d', strtotime($name[0]));
            $end = date('Y-m-d', strtotime($name[2]));
            $customer_reports = Customers::where('user_id', $user->id)->whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->select($val)->get();
        }

        $customerPaper = array(0, 0, 1000.00, 900.80);
        $pdf = PDF::loadView('admin.payment.payment_register.payment_register_report_export_pdf', compact('customer_reports', 'input'))->setPaper($customerPaper)->set_option('font_dir', storage_path(''))->set_option('font_cache', storage_path(''));
        if (isset($start)) {
            return $pdf->download($start . '_to_' . $end . '_' . 'payment_register_report.pdf');
        } else {
            return $pdf->download('payment_register_report.pdf');
        }
    }

    //Payment deduct Report
    public function payment_deduct_report(Request $request)
    {
        $user = Auth::user();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $filter_payment_deduct = ItemSales::orderBy('id', 'desc')->get();
            $bank_names = Customers::orderBy('bank_name', 'asc')->distinct()->get();
            if ($request->date) {
                $date = $request->date;
                $name = explode(' ', $date);
                $start = date('Y-m-d', strtotime($name[0]));
                $end = date('Y-m-d', strtotime($name[2]));

                $filter_payment_deduct = ItemSales::whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->whereHas('customers', function ($query) use ($request) {
                    $query->whereBetween('customer_code', [$request->customer_from_code, $request->customer_to_code]);
                })->get();

            }
            return view('admin.payment.payment_deduct.payment_deduct_report', compact('filter_payment_deduct', 'bank_names'));
        }
        $filter_payment_deduct = ItemSales::where('created_by', $user->id)->orderBy('id', 'desc')->get();
        $bank_names = Customers::where('user_id', $user->id)->orderBy('bank_name', 'desc')->get();
        if ($request->date) {
            $date = $request->date;
            $name = explode(' ', $date);
            $start = date('Y-m-d', strtotime($name[0]));
            $end = date('Y-m-d', strtotime($name[2]));
            $filter_customers = Customers::where('user_id', $user->id)->whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->whereHas('customers', function ($query) use ($request) {
                $query->whereBetween('customer_code', [$request->customer_from_code, $request->customer_to_code]);
            })->get();
        }
        return view('admin.payment.payment_deduct.payment_deduct_report', compact('filter_payment_deduct', 'bank_names'));
    }

    public function payment_deduct_report_pdf(Request $request)
    {

        $user = Auth::user();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $payment_deduct_report_pdfs = ItemSales::orderBy('id','desc')->get();
            if ($request->date) {
                $date = $request->date;
                $name = explode(' ', $date);
                $start = date('Y-m-d', strtotime($name[0]));
                $end = date('Y-m-d', strtotime($name[2]));
                $payment_deduct_report_pdfs = ItemSales::whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->whereHas('customers', function ($query) use ($request) {
                    $query->whereBetween('customer_code', [$request->customer_from_code, $request->customer_to_code]);
                })->get();
            }
            $item_purchasePaper = array(0, 0, 1000.00, 900.80);
            $pdf = PDF::loadView('admin.payment.payment_deduct.payment_deduct_report_pdf', compact('payment_deduct_report_pdfs'))->setPaper($item_purchasePaper)->set_option('font_dir', storage_path(''))->set_option('font_cache', storage_path(''));

            if (isset($start)) {
                return $pdf->download($start . '_to_' . $end . '_' . 'payment_deduct_report.pdf');
            } else {
                return $pdf->download('payment_deduct_report.pdf');
            }
        }
        $payment_deduct_report_pdfs = ItemSales::where('user_id', $user->id)->orderBy('id','desc')->get();
        if ($request->date) {
            $date = $request->date;
            $name = explode(' ', $date);
            $start = date('Y-m-d', strtotime($name[0]));
            $end = date('Y-m-d', strtotime($name[2]));
            $payment_deduct_report_pdfs = ItemSales::where('user_id', $user->id)->whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->whereHas('customers', function ($query) use ($request) {
                $query->whereBetween('customer_code', [$request->customer_from_code, $request->customer_to_code]);
            })->get();
        }
        $item_purchasePaper = array(0, 0, 1000.00, 900.80);
        $pdf = PDF::loadView('admin.payment.payment_deduct.payment_deduct_report_pdf', compact('payment_deduct_report_pdfs'))->setPaper($item_purchasePaper)->set_option('font_dir', storage_path(''))->set_option('font_cache', storage_path(''));

        if (isset($start)) {
            return $pdf->download($start . '_to_' . $end . '_' . 'payment_deduct_report.pdf');
        } else {
            return $pdf->download('payment_deduct_report.pdf');
        }

    }


    public function payment_deduct_report_export(Request $request)
    {

        $request->validate(
            [
                'field' => 'required'
            ]
        );

        $input = $request->all();
        $val = array_keys($input['field']);
        $user = Auth::user();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $item_saless = ItemSales::select($val)->get();
            if ($request->date) {
                $date = $request->date;
                $name = explode(' ', $date);
                $start = date('Y-m-d', strtotime($name[0]));
                $end = date('Y-m-d', strtotime($name[2]));
                $item_saless = ItemSales::whereDate('created_at', '>=', $start)
                    ->whereDate('created_at', '<=', $end)->select($val)->get();
            }
            return view('admin.payment.payment_deduct.payment_deduct_report_export', compact('item_saless', 'input'));
        }
        $item_saless = ItemSales::where('created_by', $user->id)->select($val)->get();
        if ($request->date) {
            $date = $request->date;
            $name = explode(' ', $date);
            $start = date('Y-m-d', strtotime($name[0]));
            $end = date('Y-m-d', strtotime($name[2]));
            $item_saless = ItemSales::where('created_by', $user->id)->whereDate('created_at', '>=', $start)
                ->whereDate('created_at', '<=', $end)->select($val)->get();
        }
        return view('admin.payment.payment_deduct.payment_deduct_report_export', compact('item_saless', 'input'));

    }

    public function payment_deduct_report_export_pdf(Request $request)
    {

        $input = $request->all();
        $val = array_keys($input['field']);
        $user = Auth::user();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $item_sales_reports = ItemSales::select($val)->get();
            if ($request->date) {
                $date = $request->date;
                $name = explode(' ', $date);
                $start = date('Y-m-d', strtotime($name[0]));
                $end = date('Y-m-d', strtotime($name[2]));
                $item_sales_reports = ItemSales::whereDate('created_at', '>=', $start)
                    ->whereDate('created_at', '<=', $end)->select($val)->get();
            }

            $item_purchasePaper = array(0, 0, 1000.00, 900.80);
            $pdf = PDF::loadView('admin.payment.payment_deduct.payment_deduct_report_export_pdf', compact('item_sales_reports', 'input'))->setPaper($item_purchasePaper)->set_option('font_dir', storage_path(''))->set_option('font_cache', storage_path(''));
            if (isset($request->date)) {
                return $pdf->download($start . '_to_' . $end . '_' . 'payment_deduct_report_export.pdf');
            } else {
                return $pdf->download('payment_deduct_report_export.pdf');
            }
        }
        $item_sales_reports = ItemSales::where('created_by', $user->id)->select($val)->get();
        if ($request->date) {
            $date = $request->date;
            $name = explode(' ', $date);
            $start = date('Y-m-d', strtotime($name[0]));
            $end = date('Y-m-d', strtotime($name[2]));
            $item_sales_reports = ItemSales::where('created_by', $user->id)->whereDate('created_at', '>=', $start)
                ->whereDate('created_at', '<=', $end)->select($val)->get();
        }

        $item_purchasePaper = array(0, 0, 1000.00, 900.80);
        $pdf = PDF::loadView('admin.payment.payment_deduct.payment_deduct_report_export_pdf', compact('item_sales_reports', 'input'))->setPaper($item_purchasePaper)->set_option('font_dir', storage_path(''))->set_option('font_cache', storage_path(''));
        if (isset($request->date)) {
            return $pdf->download($start . '_to_' . $end . '_' . 'payment_deduct_report_export.pdf');
        } else {
            return $pdf->download('payment_deduct_report_export.pdf');
        }
    }


}
