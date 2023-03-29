<?php

namespace App\Imports;

use App\Models\admin\Customers;
use App\Models\admin\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomerImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
//        dd(\request()->date);
        Validator::make($row, [
            'user_id' => 'required',
            'customer_name' => 'required',
            'customer_code' => 'required',
            'bank_name' => 'required',
            'account_number' => 'required',
            'ifsc_code' => 'required',
            'final_amount' => 'required',
        ])->validate();

        $input = collect($row)->toArray();

//        dd((new Date($input['created_at']))->format('Y-m-d'));


        if (request()->date) {
            $date = request()->date;
            $name = explode(' ', $date);
            $start = date('Y-m-d', strtotime($name[0]));
            $end = date('Y-m-d', strtotime($name[2]));
//            dd((date_formate($input['created_at'])),$start,$end);
            $customer_filters = $input;
            $customer_filter = Customers::whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->get();
            dd($customer_filter);
            if (count($customer_filter) > 0){
                return redirect()->back()->with('danger','No Record Found');
            }

            $customer = Customers::upsert([$input],['customer_name', 'customer_code','user_id'
                ,'bank_name', 'account_number','ifsc_code',
                'final_amount', 'created_by','updated_at','created_at']);

            $payment_input['payment_from_date'] = $start;
            $payment_input['payment_to_date'] = $end;
            $payment_input['created_by'] = Auth::user()->id;
            $payment_input['customer_id'] = Auth::user()->id;
            $payment = Payment::upsert([$payment_input],['payment_from_date',
                'payment_to_date','created_by','customer_id']);
        }


//        $payment = $customer->customer()->create($input);
    }

}
