@extends('admin.layouts.app')
@section('content')
    <style>

        @media print {

            div table {
                width: 80%;
                margin: 0;

            }

            .print-table {
                max-width: 100%;
                border: 1px solid #000;
                border-collapse: collapse;
            }

            .print-table #pri_table {
                max-width: 100%;
                border: 1px solid #000;
                border-collapse: collapse;
            }

        }

    </style>
    @include('admin.flash-message')
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">

                        <div class="col-6"><a class="btn btn-outline-danger"
                                              href="{{route('payment-deduct-report-export-pdf')}}?field={{request()}}">
                                Pdf</a>
                            <button type="button" onclick="ExportToExcel('xlsx')" class="btn btn-outline-success">
                                Excel
                            </button>&nbsp;&nbsp;
                            <a class="btn btn-outline-warning" id="Pairings_by_Table_call"
                               href="#">
                                Print </a>

                            <a href="{{route('payment-deduct-report')}}">
                                <button type="button"
                                        class="btn btn-outline-dark">Back
                                </button>
                            </a>&nbsp</span><br><br>
                        </div>
                    </div>
                </div>
                <br>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body table-responsive" id="sampleTable">
                            <h5 class="card-title">@lang('langs.payment_deduct_report')</h5>
                            <div class="tile-body" id="my_report">
                                <table id="sampleTable" class="table datatable">
                                    <thead>
                                    <tr>
                                        <th>@lang('langs.item_sales_no')</th>
                                        @if(isset($input['field']['CustId']))
                                            <th> @lang('langs.customer_name')</th>

                                        @endif
                                        @if(isset($input['field']['CustId']))
                                            <th> @lang('langs.customer_code')</th>

                                        @endif
                                        @if(isset($input['field']['ItemId']))
                                            <th> @lang('langs.item_name')</th>

                                        @endif

                                        @if(isset($input['field']['ItemQty']))
                                            <th> @lang('langs.itemQuantity')</th>

                                        @endif

                                        @if(isset($input['field']['payment_from_date']))
                                            <th> @lang('langs.payment_from_date')</th>

                                        @endif

                                        @if(isset($input['field']['payment_to_date']))
                                            <th> @lang('langs.payment_to_date')</th>

                                        @endif

                                        @if(isset($input['field']['entry_date']))
                                            <th> @lang('langs.entry_date')</th>

                                        @endif
                                        @if(isset($input['field']['payment']))
                                            <th> @lang('langs.payment')</th>

                                        @endif
                                        @if(isset($input['field']['deduct_payment']))
                                            <th> @lang('langs.deduct_payment')</th>

                                        @endif
                                        @if(isset($input['field']['total']))
                                            <th> @lang('langs.total')</th>

                                        @endif

                                        @if(isset($input['field']['created_at']))
                                            <th> @lang('langs.created_at')</th>

                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($item_saless as $item_sales)
                                        <tr>
                                            @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                <td>{{gujarati_number($loop->iteration)}}</td>
                                            @else
                                                <td>{{$loop->iteration}}</td>
                                            @endif

                                            @if(isset($input['field']['CustId']))
                                                @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                    <td>{{translateToGujarati($item_sales->customers->customer_name)}}</td>
                                                @else
                                                    <td>{{$item_sales->customers->customer_name}}</td>
                                                @endif

                                            @endif
                                            @if(isset($input['field']['CustId']))
                                                @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                    <td>{{gujarati_number($item_sales->customers->customer_code)}}</td>
                                                @else
                                                    <td>{{$item_sales->customers->customer_code}}</td>
                                                @endif

                                            @endif
                                            @if(isset($input['field']['ItemId']))
                                                @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                    <td>{{translateToGujarati($item_sales->item_names->item_name->item_name)}}</td>
                                                @else
                                                    <td>{{$item_sales->item_names->item_name->item_name}}</td>
                                                @endif

                                            @endif

                                            @if(isset($input['field']['ItemQty']))
                                                @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                    <td>{{gujarati_number($item_sales->ItemQty)}}</td>
                                                @else
                                                    <td>{{$item_sales->ItemQty}}</td>
                                                @endif

                                            @endif

                                            @if(isset($input['field']['payment_from_date']))
                                                @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                    <td>{{gujarati_date($item_sales->payment_from_date)}}</td>
                                                @else
                                                    <td>{{$item_sales->payment_from_date}}</td>
                                                @endif

                                            @endif

                                            @if(isset($input['field']['payment_to_date']))
                                                @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                    <td>{{gujarati_date($item_sales->payment_to_date)}}</td>
                                                @else
                                                    <td>{{$item_sales->payment_to_date}}</td>
                                                @endif

                                            @endif

                                            @if(isset($input['field']['entry_date']))
                                                @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                    <td>{{gujarati_date($item_sales->entry_date)}}</td>
                                                @else
                                                    <td>{{$item_sales->entry_date}}</td>
                                                @endif

                                            @endif
                                            @if(isset($input['field']['payment']))
                                                <td>{{get_rupee_currency($item_sales->payment)}}</td>

                                            @endif
                                            @if(isset($input['field']['deduct_payment']))
                                                <td>{{get_rupee_currency($item_sales->deduct_payment)}}</td>

                                            @endif
                                            @if(isset($input['field']['total']))
                                                <td class="amount">{{get_rupee_currency($item_sales->total)}}</td>

                                            @endif

                                            @if(isset($input['field']['created_at']))
                                                @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                                    <td>{{gujarati_date($item_sales->created_at)}}</td>
                                                @else
                                                    <td>{{formate_date($item_sales->created_at)}}</td>
                                                @endif

                                            @endif

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $user = \Illuminate\Support\Facades\Auth::user();
                ?>
                <div id="table_print">
                    <input type="hidden" id="mandali_address" value="{{$user->mandali_address}}">
                    <input type="hidden" id="mandali_code" value="{{$user->mandali_code}}">
                    <table id="pri_table" class="table table-responsive" border="1" width="100%"
                           style="border-collapse: collapse;display: none">
                        <thead>
                        <tr>
                            <th>@lang('langs.item_sales_no')</th>
                            @if(isset($input['field']['CustId']))
                                <th> @lang('langs.customer_name')</th>

                            @endif
                            @if(isset($input['field']['CustId']))
                                <th> @lang('langs.customer_code')</th>

                            @endif
                            @if(isset($input['field']['ItemId']))
                                <th> @lang('langs.item_name')</th>

                            @endif

                            @if(isset($input['field']['ItemQty']))
                                <th> @lang('langs.itemQuantity')</th>

                            @endif

                            @if(isset($input['field']['payment_from_date']))
                                <th> @lang('langs.payment_from_date')</th>

                            @endif

                            @if(isset($input['field']['payment_to_date']))
                                <th> @lang('langs.payment_to_date')</th>

                            @endif

                            @if(isset($input['field']['from_morning_evening']))
                                <th> @lang('langs.from_morning_evening')</th>

                            @endif
                            @if(isset($input['field']['to_morning_evening']))
                                <th> @lang('langs.to_morning_evening')</th>

                            @endif
                            @if(isset($input['field']['deduct_from_date']))
                                <th> @lang('langs.deduct_from_date')</th>

                            @endif
                            @if(isset($input['field']['deduct_to_date']))
                                <th> @lang('langs.deduct_to_date')</th>

                            @endif
                            @if(isset($input['field']['entry_date']))
                                <th> @lang('langs.entry_date')</th>

                            @endif
                            @if(isset($input['field']['payment']))
                                <th> @lang('langs.payment')</th>

                            @endif
                            @if(isset($input['field']['deduct_payment']))
                                <th> @lang('langs.deduct_payment')</th>

                            @endif
                            @if(isset($input['field']['total']))
                                <th> @lang('langs.total')</th>

                            @endif

                            @if(isset($input['field']['created_by']))
                                <th> @lang('langs.created_by')</th>

                            @endif

                            @if(isset($input['field']['created_at']))
                                <th> @lang('langs.created_at')</th>

                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($item_saless))
                            @foreach($item_saless as $item_sales)
                                <tr>
                                    @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                        <td>{{gujarati_number($loop->iteration)}}</td>
                                    @else
                                        <td>{{$loop->iteration}}</td>
                                    @endif

                                    @if(isset($input['field']['CustId']))
                                        @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                            <td>{{translateToGujarati($item_sales->customers->customer_name)}}</td>
                                        @else
                                            <td>{{$item_sales->customers->customer_name}}</td>
                                        @endif

                                    @endif
                                    @if(isset($input['field']['CustId']))
                                        @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                            <td>{{gujarati_number($item_sales->customers->customer_code)}}</td>
                                        @else
                                            <td>{{$item_sales->customers->customer_code}}</td>
                                        @endif

                                    @endif
                                    @if(isset($input['field']['ItemId']))
                                        @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                            <td>{{translateToGujarati($item_sales->item_names->item_name->item_name)}}</td>
                                        @else
                                            <td>{{$item_sales->item_names->item_name->item_name}}</td>
                                        @endif

                                    @endif

                                    @if(isset($input['field']['ItemQty']))
                                        @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                            <td>{{gujarati_number($item_sales->ItemQty)}}</td>
                                        @else
                                            <td>{{$item_sales->ItemQty}}</td>
                                        @endif

                                    @endif

                                    @if(isset($input['field']['payment_from_date']))
                                        @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                            <td>{{gujarati_date($item_sales->payment_from_date)}}</td>
                                        @else
                                            <td>{{$item_sales->payment_from_date}}</td>
                                        @endif

                                    @endif

                                    @if(isset($input['field']['payment_to_date']))
                                        @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                            <td>{{gujarati_date($item_sales->payment_to_date)}}</td>
                                        @else
                                            <td>{{$item_sales->payment_to_date}}</td>
                                        @endif

                                    @endif

                                    @if(isset($input['field']['entry_date']))
                                        @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                            <td>{{gujarati_date($item_sales->entry_date)}}</td>
                                        @else
                                            <td>{{$item_sales->entry_date}}</td>
                                        @endif

                                    @endif
                                    @if(isset($input['field']['payment']))
                                        <td>{{get_rupee_currency($item_sales->payment)}}</td>

                                    @endif
                                    @if(isset($input['field']['deduct_payment']))
                                        <td>{{get_rupee_currency($item_sales->deduct_payment)}}</td>

                                    @endif
                                    @if(isset($input['field']['total']))
                                        <td class="amount">{{get_rupee_currency($item_sales->total)}}</td>

                                    @endif

                                    @if(isset($input['field']['created_at']))
                                        @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                            <td>{{gujarati_date($item_sales->created_at)}}</td>
                                        @else
                                            <td>{{formate_date($item_sales->created_at)}}</td>
                                        @endif

                                    @endif

                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <input type="hidden" id="filter_date" value="{{request()->date}}">
        </section>
    </main>

@endsection
@push('page_scripts')
    <script>
        $(document).ready(function() {
            $('.amount').on('click', function() {
                var amount = $(this).text();
                if (amount.indexOf('-') == 1) {
                    amount = amount.substring(2);
                    $(this).text(amount);
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(function () {
            $("#Pairings_by_Table_call").click(function () {

                $('#pri_table').show();
                var mandali_address = $('#mandali_address').val();
                var mandali_code = $('#mandali_code').val();
                var filter_dates = $('#filter_date').val();
                if (filter_dates != ''){
                    var date = $('#filter_date').val();
                }
                else {
                    var date = $('#reportrange').val();
                }

                var contents = $("#table_print").html();
                var frame1 = $('<iframe />');
                frame1[0].name = "frame1";
                frame1.css({"position": "absolute", "top": "-1000000px"});
                $("body").append(frame1);
                var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
                frameDoc.document.open();
                //Create a new HTML document.

                frameDoc.document.write('<html><head><title> </title><center>' + mandali_address + '-' + mandali_code + '<center>Bank Payment Statement<br><center>Date:' + date + '');
                frameDoc.document.write('</head><body>');
                //Append the external CSS file.
                // frameDoc.document.write('<link href="style.css" rel="stylesheet" type="text/css" />');
                //Append the DIV contents.
                frameDoc.document.write(contents);
                frameDoc.document.write('</body></html>');
                frameDoc.document.close();
                setTimeout(function () {
                    window.frames["frame1"].focus();
                    window.frames["frame1"].print();
                    frame1.remove();
                }, 500);
                $('#pri_table').attr("style", "display:none");
            });
        });

        $(function () {

            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                $('.daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            $('.daterange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(start, end);

        });
    </script>

    @php
        $user = request()->user_id;
        if (isset($user)){
        $user_report = \App\Models\User::findOrfail($user);
        }
    @endphp

    <script>

        function ExportToExcel(type, fn, dl) {
            var elt = document.getElementById('my_report')
            var wb = XLSX.utils.table_to_book(elt, {sheet: "sheet1"});
            return dl ?
                XLSX.write(wb, {bookType: type, bookSST: true, type: 'base64'}) :
                @if(\Illuminate\Support\Facades\Auth::user()->role == config('constants.ROLE.ADMIN'))
                XLSX.writeFile(wb, fn || ('<?php if (isset($user_report)) {
                    echo $user_report->name;
                } ?>_Reports.' + (type || 'xlsx')));
            @else
            XLSX.writeFile(wb, fn || ('<?php if (isset(Auth::user()->name)) {
                echo Auth::user()->name;
            } ?>_Reports.' + (type || 'xlsx')));
            @endif
        }


    </script>

@endpush

