<html>
<head>
    <style>

        @media print {
            .player-chart nice {
                width: 100%;
            }

            div table {
                width: 100%;
                margin: 0;

            }

            .print-table {
                max-width: 100%;
                border: 1px solid #000;
                border-collapse: collapse;
            }

            .print-table #leader {
                max-width: 100%;
                border: 1px solid #000;
                border-collapse: collapse;
            }
        }

        @font-face {
            font-family: "HindVadodara-SemiBold";
            font-style: normal;
            font-weight: normal;
            src: url('{{base_path().'/storage/'}}HindVadodara-SemiBold.ttf') format('truetype');
        }

        * {
            font-family: "HindVadodara-SemiBold", sans-serif;
        }

    </style>
</head>
<body>
<section class="content-header">
    <div class="container-fluid">
        @php
            $user = \Illuminate\Support\Facades\Auth::user();
            if (request()->date) {
                $date = request()->date;
                $name = explode(' ', $date);
                $start = date('Y-m-d', strtotime($name[0]));
                $end = date('Y-m-d', strtotime($name[2]));
            }
        @endphp
        <div class="row mb-2">
            <center><h2>{{$user->mandali_address}} - {{$user->mandali_code}}</h2>
                <h2>Bank Payment Statement</h2>
                @if (request()->date)
                    <h2>Date :{{$start}} To :{{$end}} Shift :Morning To :Evening</h2>
                @endif
            </center>
            <div class="col-sm-6">
                <span>@lang('langs.payment_deduct_report')</span>
            </div>
        </div>
    </div>
</section>

<div class="content px-3">
    <div class="clearfix"></div>
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <div id="leaderBoardSwissTable" class="print-table">
                    <table id="leader" class="table table-responsive" border="1" width="100%"
                           style="border-collapse: collapse">
                        <thead>
                        <tr class="text-center">
                            <td style="padding: 7px;">@lang('langs.item_sales_no')</td>
                            @if(isset($input['field']['customer_id']))
                                <td style="padding: 7px;"> @lang('langs.customer_name')</td>

                            @endif
                            @if(isset($input['field']['customer_id']))
                                <td style="padding: 7px;"> @lang('langs.customer_code')</td>

                            @endif
                            @if(isset($input['field']['item_name_id']))
                                <td style="padding: 7px;"> @lang('langs.item_name')</td>

                            @endif

                            @if(isset($input['field']['item_quantity']))
                                <td style="padding: 7px;"> @lang('langs.itemQuantity')</td>

                            @endif

                            @if(isset($input['field']['payment_from_date']))
                                <td style="padding: 7px;"> @lang('langs.payment_from_date')</td>

                            @endif

                            @if(isset($input['field']['payment_to_date']))
                                <td style="padding: 7px;"> @lang('langs.payment_to_date')</td>

                            @endif

                            @if(isset($input['field']['entry_date']))
                                <td style="padding: 7px;"> @lang('langs.entry_date')</td>

                            @endif
                            @if(isset($input['field']['payment']))
                                <td style="padding: 7px;"> @lang('langs.payment')</td>

                            @endif
                            @if(isset($input['field']['deduct_payment']))
                                <td style="padding: 7px;"> @lang('langs.deduct_payment')</td>

                            @endif
                            @if(isset($input['field']['total']))
                                <td style="padding: 7px;"> @lang('langs.total')</td>

                            @endif

                            @if(isset($input['field']['created_at']))
                                <td style="padding: 7px;"> @lang('langs.created_at')</td>

                            @endif
                        </tr>

                        </thead>
                        <tbody>
                        @if(count($item_sales_reports)>0)
                            @foreach($item_sales_reports as $item_sales)
                                <tr style="text-align: center;">
                                    <td style="padding: 7px;">{{$loop->iteration}}</td>

                                    @if(isset($input['field']['customer_id']))
                                        @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                            <td style="padding: 7px;">{{translateToGujarati($item_sales->customers->customer_name)}}</td>
                                        @else
                                            <td style="padding: 7px;">{{$item_sales->customers->customer_name}}</td>
                                        @endif

                                    @endif
                                    @if(isset($input['field']['customer_id']))
                                        <td style="padding: 7px;">{{$item_sales->customers->customer_code}}</td>

                                    @endif
                                    @if(isset($input['field']['item_name_id']))
                                        @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                            <td style="padding: 7px;">{{translateToGujarati($item_sales->item_names->item_name->item_name)}}</td>
                                        @else
                                            <td style="padding: 7px;">{{$item_sales->item_names->item_name->item_name}}</td>
                                        @endif

                                    @endif

                                    @if(isset($input['field']['item_quantity']))
                                        <td style="padding: 7px;">{{$item_sales->item_quantity}}</td>

                                    @endif

                                    @if(isset($input['field']['payment_from_date']))
                                        <td style="padding: 7px;">{{$item_sales->payment_from_date}}</td>

                                    @endif

                                    @if(isset($input['field']['payment_to_date']))
                                        <td style="padding: 7px;">{{$item_sales->payment_to_date}}</td>

                                    @endif

                                    @if(isset($input['field']['entry_date']))
                                        <td style="padding: 7px;">{{$item_sales->entry_date}}</td>

                                    @endif
                                    @if(isset($input['field']['payment']))
                                        <td style="padding: 7px;">{{get_rupee_currency($item_sales->payment)}}</td>

                                    @endif
                                    @if(isset($input['field']['deduct_payment']))
                                        <td style="padding: 7px;">{{get_rupee_currency($item_sales->deduct_payment)}}</td>

                                    @endif
                                    @if(isset($input['field']['total']))
                                        <td style="padding: 7px;">{{get_rupee_currency($item_sales->total)}}</td>

                                    @endif


                                    @if(isset($input['field']['created_at']))
                                        <td style="padding: 7px;">{{$item_sales->created_at}}</td>

                                    @endif

                                </tr>

                            @endforeach
                        @else
                            <h2 class="text-center" style="color: red">Record Not Found</h2>
                        @endif
                        </tbody>
                    </table>
                    @php
                        $year = \Carbon\Carbon::now()->format('Y')
                    @endphp
                    <br>
                    <center><span class="copyright" id="year"><b style="color: red">{{$year-1}}-{{$year}}</b>&copy; Copyright <strong><span>Dairy-Report</span></strong>. All Rights Reserved</span></center>
                </div>
            </div>

        </div>

    </div>
</div>
</body>
</html>

