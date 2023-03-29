<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Customers;
use App\Models\admin\ItemName;
use App\Models\admin\ItemPurchase;
use App\Models\admin\ItemSales;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
//    Customer Activity
    public function customer_report_show(Request $request)
    {
        $user = Auth::user();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $filter_customers = Customers::orderBy('id','desc')->get();
            if ($request->date) {
                $date = $request->date;
                $name = explode(' ', $date);
                $start = date('Y-m-d', strtotime($name[0]));
                $end = date('Y-m-d', strtotime($name[2]));
                $filter_customers = Customers::whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->get();
            }
            return view('admin.report.customer.customer_report_show', compact('filter_customers'));
        }
        $filter_customers = Customers::where('user_id', $user->id)->orderBy('id','desc')->get();
        if ($request->date) {
            $date = $request->date;
            $name = explode(' ', $date);
            $start = date('Y-m-d', strtotime($name[0]));
            $end = date('Y-m-d', strtotime($name[2]));
            $filter_customers = Customers::where('user_id', $user->id)->whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->get();
        }
        return view('admin.report.customer.customer_report_show', compact('filter_customers'));
    }

    public function customer_report_show_pdf(Request $request)
    {

        $user = Auth::user();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $filter_customer_reports = Customers::orderBy('id','desc')->get();
            if ($request->date) {
                $date = $request->date;
                $name = explode(' ', $date);
                $start = date('Y-m-d', strtotime($name[0]));
                $end = date('Y-m-d', strtotime($name[2]));
                $filter_customer_reports = Customers::whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->get();
            }
            $item_purchasePaper = array(0, 0, 1000.00, 900.80);
            $pdf = PDF::loadView('admin.report.customer.customer_report_show_pdf', compact('filter_customer_reports'))->setPaper($item_purchasePaper)->set_option('font_dir', storage_path(''))->set_option('font_cache', storage_path(''));

            if (isset($start)) {
                return $pdf->download($start . '_to_' . $end . '_' . 'customer_report.pdf');
            } else {
                return $pdf->download('customer_report.pdf');
            }
        }
        $filter_customer_reports = Customers::where('user_id', $user->id)->orderBy('id','desc')->get();
        if ($request->date) {
            $date = $request->date;
            $name = explode(' ', $date);
            $start = date('Y-m-d', strtotime($name[0]));
            $end = date('Y-m-d', strtotime($name[2]));
            $filter_customer_reports = Customers::where('user_id', $user->id)->whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->get();
        }
        $item_purchasePaper = array(0, 0, 1000.00, 900.80);
        $pdf = PDF::loadView('admin.report.customer.customer_report_show_pdf', compact('filter_customer_reports'))->setPaper($item_purchasePaper)->set_option('font_dir', storage_path(''))->set_option('font_cache', storage_path(''));

        if (isset($start)) {
            return $pdf->download($start . '_to_' . $end . '_' . 'customer_report.pdf');
        } else {
            return $pdf->download('customer_report.pdf');
        }

    }

    public function customer_report_pdf(Request $request)
    {
//        dd('customer_report_pdf');
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
            $pdf = PDF::loadView('admin.report.customer.customer_report_pdf', compact('customer_reports', 'input'))->setPaper($customerPaper)->set_option('font_dir', storage_path(''))->set_option('font_cache', storage_path(''));
            if (isset($start)) {
                return $pdf->download($start . '_to_' . $end . '_' . 'customer_report.pdf');
            } else {
                return $pdf->download('customer_report.pdf');
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
        $pdf = PDF::loadView('admin.report.customer.customer_report_pdf', compact('customer_reports', 'input'))->setPaper($customerPaper)->set_option('font_dir', storage_path(''))->set_option('font_cache', storage_path(''));
        if (isset($start)) {
            return $pdf->download($start . '_to_' . $end . '_' . 'customer_report.pdf');
        } else {
            return $pdf->download('customer_report.pdf');
        }
    }

    public function customer_report_export(Request $request)
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

            return view('admin.report.customer.customer_export_report', compact('customers', 'input'));
        }
        $customers = Customers::where('user_id', $user->id)->select($val)->get();
        if ($request->date) {
            $date = $request->date;
            $name = explode(' ', $date);
            $start = date('Y-m-d', strtotime($name[0]));
            $end = date('Y-m-d', strtotime($name[2]));
            $customers = Customers::where('user_id', $user->id)->whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->select($val)->get();
        }

        return view('admin.report.customer.customer_export_report', compact('customers', 'input'));
    }


//    Item Name Activity
    public function item_name_report_show(Request $request)
    {

        $user = Auth::user();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $item_names = ItemName::orderBy('id','desc')->get();
            if ($request->date || $request->item_name) {
                $item_names = ItemName::all();
                $date = $request->date;
                $name = explode(' ', $date);
                $start = date('Y-m-d', strtotime($name[0]));
                $end = date('Y-m-d', strtotime($name[2]));
                $item_names = ItemName::whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->get();
                return view('admin.report.item_name.item_name_report_show', compact('item_names', 'item_names'));

            }
            return view('admin.report.item_name.item_name_report_show', compact('item_names'));
        }
        $item_names = ItemName::where('created_by', $user->id)->orderBy('id','desc')->get();
        if ($request->date || $request->item_name) {
            $item_names = ItemName::all();
            $date = $request->date;
            $name = explode(' ', $date);
            $start = date('Y-m-d', strtotime($name[0]));
            $end = date('Y-m-d', strtotime($name[2]));
            $item_names = ItemName::where('created_by', $user->id)->whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->get();
            return view('admin.report.item_name.item_name_report_show', compact('item_names', 'item_names'));

        }
        return view('admin.report.item_name.item_name_report_show', compact('item_names'));
    }

    public function item_name_report_show_pdf(Request $request)
    {
        $user = Auth::user();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $item_name_reports = ItemName::orderBy('id','desc')->get();
            if ($request->date) {
                $date = $request->date;
                $name = explode(' ', $date);
                $start = date('Y-m-d', strtotime($name[0]));
                $end = date('Y-m-d', strtotime($name[2]));
                $item_name_reports = ItemName::whereDate('created_at', '>=', $start)
                    ->whereDate('created_at', '<=', $end)->get();
            }
            $item_salesPaper = array(0, 0, 1000.00, 900.80);
            $pdf = PDF::loadView('admin.report.item_name.item_name_report_show_pdf', compact('item_name_reports'))->setPaper($item_salesPaper)->set_option('font_dir', storage_path(''))->set_option('font_cache', storage_path(''));
            if (isset($start)) {
                return $pdf->download($start . '_to_' . $end . '_' . 'item_name_report.pdf');
            } else {
                return $pdf->download('item_name_report.pdf');
            }
        }
        $item_name_reports = ItemName::where('created_by', $user->id)->orderBy('id','desc')->get();
        if ($request->date) {
            $date = $request->date;
            $name = explode(' ', $date);
            $start = date('Y-m-d', strtotime($name[0]));
            $end = date('Y-m-d', strtotime($name[2]));
            $item_name_reports = ItemName::where('created_by', $user->id)->whereDate('created_at', '>=', $start)
                ->whereDate('created_at', '<=', $end)->get();
        }
        $item_salesPaper = array(0, 0, 1000.00, 900.80);
        $pdf = PDF::loadView('admin.report.item_name.item_name_report_show_pdf', compact('item_name_reports'))->setPaper($item_salesPaper)->set_option('font_dir', storage_path(''))->set_option('font_cache', storage_path(''));
        if (isset($start)) {
            return $pdf->download($start . '_to_' . $end . '_' . 'item_name_report.pdf');
        } else {
            return $pdf->download('item_name_report.pdf');
        }

    }

    public function item_name_report_pdf(Request $request)
    {
        $input = $request->all();
        $val = array_keys($input['field']);
        $user = Auth::user();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $item_name_reports = ItemName::select($val)->get();
            if ($request->date) {
                $date = $request->date;
                $name = explode(' ', $date);
                $start = date('Y-m-d', strtotime($name[0]));
                $end = date('Y-m-d', strtotime($name[2]));
                $item_name_reports = ItemName::whereDate('created_at', '>=', $start)
                    ->whereDate('created_at', '<=', $end)->select($val)->get();
            }
            $item_namePaper = array(0, 0, 1000.00, 900.80);
            $pdf = PDF::loadView('admin.report.item_name.item_name_report_pdf', compact('item_name_reports', 'input'))->setPaper($item_namePaper)->set_option('font_dir', storage_path(''))->set_option('font_cache', storage_path(''));
            if (isset($request->date)) {
                return $pdf->download($start . '_to_' . $end . '_' . 'item_name_report.pdf');
            } else {
                return $pdf->download('item_name_report.pdf');
            }
        }
        $item_name_reports = ItemName::where('created_by', $user->id)->select($val)->get();
        if ($request->date) {
            $date = $request->date;
            $name = explode(' ', $date);
            $start = date('Y-m-d', strtotime($name[0]));
            $end = date('Y-m-d', strtotime($name[2]));
            $item_name_reports = ItemName::where('created_by', $user->id)->whereDate('created_at', '>=', $start)
                ->whereDate('created_at', '<=', $end)->select($val)->get();
        }
        $item_namePaper = array(0, 0, 1000.00, 900.80);
        $pdf = PDF::loadView('admin.report.item_name.item_name_report_pdf', compact('item_name_reports', 'input'))->setPaper($item_namePaper)->set_option('font_dir', storage_path(''))->set_option('font_cache', storage_path(''));
        if (isset($request->date)) {
            return $pdf->download($start . '_to_' . $end . '_' . 'item_name_report.pdf');
        } else {
            return $pdf->download('item_name_report.pdf');
        }
    }

    public function item_name_report_export(Request $request)
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
            $item_name_reports = ItemName::select($val)->get();
            if ($request->date) {
                $date = $request->date;
                $name = explode(' ', $date);
                $start = date('Y-m-d', strtotime($name[0]));
                $end = date('Y-m-d', strtotime($name[2]));
                $item_name_reports = ItemName::whereDate('created_at', '>=', $start)
                    ->whereDate('created_at', '<=', $end)->select($val)->get();
            }
            return view('admin.report.item_name.item_name_export_report', compact('item_name_reports', 'input'));
        }
        $item_name_reports = ItemName::where('created_by', $user->id)->select($val)->get();
        if ($request->date) {
            $date = $request->date;
            $name = explode(' ', $date);
            $start = date('Y-m-d', strtotime($name[0]));
            $end = date('Y-m-d', strtotime($name[2]));
            $item_name_reports = ItemName::where('created_by', $user->id)->whereDate('created_at', '>=', $start)
                ->whereDate('created_at', '<=', $end)->select($val)->get();
        }
        return view('admin.report.item_name.item_name_export_report', compact('item_name_reports', 'input'));

    }

//    Item Sales Activity
    public function item_sales_report_show(Request $request)
    {
        $user = Auth::user();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $filter_item_sales = ItemSales::orderBy('id','desc')->get();
            if ($request->date) {
                $date = $request->date;
                $name = explode(' ', $date);
                $start = date('Y-m-d', strtotime($name[0]));
                $end = date('Y-m-d', strtotime($name[2]));
                $filter_item_sales = ItemSales::whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->get();
                //    return view('admin.report.item_sales.item_sales_report',compact('filter_item_sales'));

            }
            return view('admin.report.item_sales.item_sales_report_show', compact('filter_item_sales'));
        }
        $filter_item_sales = ItemSales::where('created_by', $user->id)->orderBy('id','desc')->get();
        if ($request->date) {
            $date = $request->date;
            $name = explode(' ', $date);
            $start = date('Y-m-d', strtotime($name[0]));
            $end = date('Y-m-d', strtotime($name[2]));
            $filter_item_sales = ItemSales::where('created_by', $user->id)->whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->get();
            //    return view('admin.report.item_sales.item_sales_report',compact('filter_item_sales'));

        }
        return view('admin.report.item_sales.item_sales_report_show', compact('filter_item_sales'));

    }

    public function item_sales_report_show_pdf(Request $request)
    {
        $user = Auth::user();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $item_sales_reports = ItemSales::orderBy('id','desc')->get();
            if ($request->date) {
                $date = $request->date;
                $name = explode(' ', $date);
                $start = date('Y-m-d', strtotime($name[0]));
                $end = date('Y-m-d', strtotime($name[2]));
                $item_sales_reports = ItemSales::whereDate('created_at', '>=', $start)
                    ->whereDate('created_at', '<=', $end)->get();
            }
            $item_salesPaper = array(0, 0, 1000.00, 900.80);
            $pdf = PDF::loadView('admin.report.item_sales.item_sales_report_show_pdf', compact('item_sales_reports'))->setPaper($item_salesPaper)->set_option('font_dir', storage_path(''))->set_option('font_cache', storage_path(''));
            if (isset($start)) {
                return $pdf->download($start . '_to_' . $end . '_' . 'item_sales_report.pdf');
            } else {
                return $pdf->download('item_sales_report.pdf');
            }
        }
        $item_sales_reports = ItemSales::where('created_by', $user->id)->orderBy('id','desc')->get();
        if ($request->date) {
            $date = $request->date;
            $name = explode(' ', $date);
            $start = date('Y-m-d', strtotime($name[0]));
            $end = date('Y-m-d', strtotime($name[2]));
            $item_sales_reports = ItemSales::where('created_by', $user->id)->whereDate('created_at', '>=', $start)
                ->whereDate('created_at', '<=', $end)->get();
        }
        $item_salesPaper = array(0, 0, 1000.00, 900.80);
        $pdf = PDF::loadView('admin.report.item_sales.item_sales_report_show_pdf', compact('item_sales_reports'))->setPaper($item_salesPaper)->set_option('font_dir', storage_path(''))->set_option('font_cache', storage_path(''));
        if (isset($start)) {
            return $pdf->download($start . '_to_' . $end . '_' . 'item_sales_report.pdf');
        } else {
            return $pdf->download('item_sales_report.pdf');
        }
    }

    public function item_sales_report_export(Request $request)
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
            return view('admin.report.item_sales.item_sales_export_report', compact('item_saless', 'input'));
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
        return view('admin.report.item_sales.item_sales_export_report', compact('item_saless', 'input'));

    }


    public function item_sales_report_pdf(Request $request)
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
            $pdf = PDF::loadView('admin.report.item_sales.item_sales_report_pdf', compact('item_sales_reports', 'input'))->setPaper($item_purchasePaper)->set_option('font_dir', storage_path(''))->set_option('font_cache', storage_path(''));
            if (isset($request->date)) {
                return $pdf->download($start . '_to_' . $end . '_' . 'item_sales_report.pdf');
            } else {
                return $pdf->download('item_sales_report.pdf');
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
        $pdf = PDF::loadView('admin.report.item_sales.item_sales_report_pdf', compact('item_sales_reports', 'input'))->setPaper($item_purchasePaper)->set_option('font_dir', storage_path(''))->set_option('font_cache', storage_path(''));
        if (isset($request->date)) {
            return $pdf->download($start . '_to_' . $end . '_' . 'item_sales_report.pdf');
        } else {
            return $pdf->download('item_sales_report.pdf');
        }
    }


//    Item purchase Activity
    public function item_purchase_report_show(Request $request)
    {
        $user = Auth::user();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $filter_item_purchase = ItemPurchase::orderBy('id','desc')->get();
            if ($request->date) {
                $date = $request->date;
                $name = explode(' ', $date);
                $start = date('Y-m-d', strtotime($name[0]));
                $end = date('Y-m-d', strtotime($name[2]));
                $filter_item_purchase = ItemPurchase::whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->get();
//            return view('admin.report.item_purchase.item_purchase_report',compact('filter_item_purchase'));

            }
            return view('admin.report.item_purchase.item_purchase_report_show', compact('filter_item_purchase'));
        }
        $filter_item_purchase = ItemPurchase::where('created_by', $user->id)->orderBy('id','desc')->get();
        if ($request->date) {
            $date = $request->date;
            $name = explode(' ', $date);
            $start = date('Y-m-d', strtotime($name[0]));
            $end = date('Y-m-d', strtotime($name[2]));
            $filter_item_purchase = ItemPurchase::where('created_by', $user->id)->whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->get();
//            return view('admin.report.item_purchase.item_purchase_report',compact('filter_item_purchase'));

        }
        return view('admin.report.item_purchase.item_purchase_report_show', compact('filter_item_purchase'));

    }

    public function item_purchase_report_show_pdf(Request $request)
    {
        $user = Auth::user();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $item_purchase_reports = ItemPurchase::orderBy('id','desc')->get();
            if ($request->date) {
                $date = $request->date;
                $name = explode(' ', $date);
                $start = date('Y-m-d', strtotime($name[0]));
                $end = date('Y-m-d', strtotime($name[2]));
                $item_purchase_reports = ItemPurchase::whereDate('created_at', '>=', $start)
                    ->whereDate('created_at', '<=', $end)->get();
            }
            $item_purchasePaper = array(0, 0, 1000.00, 900.80);
            $pdf = PDF::loadView('admin.report.item_purchase.item_purchase_report_show_pdf', compact('item_purchase_reports'))->setPaper($item_purchasePaper)->set_option('font_dir', storage_path(''))->set_option('font_cache', storage_path(''));
            if (isset($start)) {
                return $pdf->download($start . '_to_' . $end . '_' . 'item_purchase_report.pdf');
            } else {
                return $pdf->download('item_purchase_report.pdf');
            }
        }
        $item_purchase_reports = ItemPurchase::where('created_by', $user->id)->orderBy('id','desc')->get();
        if ($request->date) {
            $date = $request->date;
            $name = explode(' ', $date);
            $start = date('Y-m-d', strtotime($name[0]));
            $end = date('Y-m-d', strtotime($name[2]));
            $item_purchase_reports = ItemPurchase::where('created_by', $user->id)->whereDate('created_at', '>=', $start)
                ->whereDate('created_at', '<=', $end)->get();
        }
        $item_purchasePaper = array(0, 0, 1000.00, 900.80);
        $pdf = PDF::loadView('admin.report.item_purchase.item_purchase_report_show_pdf', compact('item_purchase_reports'))->setPaper($item_purchasePaper)->set_option('font_dir', storage_path(''))->set_option('font_cache', storage_path(''));
        if (isset($start)) {
            return $pdf->download($start . '_to_' . $end . '_' . 'item_purchase_report.pdf');
        } else {
            return $pdf->download('item_purchase_report.pdf');
        }
    }

    public function item_purchase_report_pdf(Request $request)
    {

        $input = $request->all();

        $val = array_keys($input['field']);
        $user = Auth::user();
        if ($user->role == config('constants.ROLE.ADMIN')) {
            $item_purchase_reports = ItemPurchase::select($val)->get();
            if ($request->date) {
                $date = $request->date;
                $name = explode(' ', $date);
                $start = date('Y-m-d', strtotime($name[0]));
                $end = date('Y-m-d', strtotime($name[2]));
                $item_purchase_reports = ItemPurchase::whereDate('created_at', '>=', $start)
                    ->whereDate('created_at', '<=', $end)->select($val)->get();
            }
            $item_purchasePaper = array(0, 0, 1000.00, 900.80);
            $pdf = PDF::loadView('admin.report.item_purchase.item_purchase_report_pdf', compact('item_purchase_reports', 'input'))->setPaper($item_purchasePaper)->set_option('font_dir', storage_path(''))->set_option('font_cache', storage_path(''));
            if (isset($request->date)) {
                return $pdf->download($start . '_to_' . $end . '_' . 'item_purchase_report.pdf');
            } else {
                return $pdf->download('item_purchase_report.pdf');
            }
        }
        $item_purchase_reports = ItemPurchase::where('created_by', $user->id)->select($val)->get();
        if ($request->date) {
            $date = $request->date;
            $name = explode(' ', $date);
            $start = date('Y-m-d', strtotime($name[0]));
            $end = date('Y-m-d', strtotime($name[2]));
            $item_purchase_reports = ItemPurchase::where('created_by', $user->id)->whereDate('created_at', '>=', $start)
                ->whereDate('created_at', '<=', $end)->select($val)->get();
        }
        $item_purchasePaper = array(0, 0, 1000.00, 900.80);
        $pdf = PDF::loadView('admin.report.item_purchase.item_purchase_report_pdf', compact('item_purchase_reports', 'input'))->setPaper($item_purchasePaper)->set_option('font_dir', storage_path(''))->set_option('font_cache', storage_path(''));
        if (isset($request->date)) {
            return $pdf->download($start . '_to_' . $end . '_' . 'item_purchase_report.pdf');
        } else {
            return $pdf->download('item_purchase_report.pdf');
        }
    }

    public function item_purchase_report_export(Request $request)
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
            $item_purchases = ItemPurchase::select($val)->get();

            if ($request->date) {
                $date = $request->date;
                $name = explode(' ', $date);
                $start = date('Y-m-d', strtotime($name[0]));
                $end = date('Y-m-d', strtotime($name[2]));
                $item_purchases = ItemPurchase::whereDate('created_at', '>=', $start)
                    ->whereDate('created_at', '<=', $end)->select($val)->get();
            }
            return view('admin.report.item_purchase.item_purchase_export_report', compact('item_purchases', 'input'));
        }
        $item_purchases = ItemPurchase::where('created_by', $user->id)->select($val)->get();

        if ($request->date) {
            $date = $request->date;
            $name = explode(' ', $date);
            $start = date('Y-m-d', strtotime($name[0]));
            $end = date('Y-m-d', strtotime($name[2]));
            $item_purchases = ItemPurchase::where('created_by', $user->id)->whereDate('created_at', '>=', $start)
                ->whereDate('created_at', '<=', $end)->select($val)->get();
        }
        return view('admin.report.item_purchase.item_purchase_export_report', compact('item_purchases', 'input'));
    }


}


