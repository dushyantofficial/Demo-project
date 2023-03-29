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
                <span>@lang('langs.customer_report_table')</span>
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

                            <td style="padding: 7px;">@lang('langs.customer_no')</td>
                            <td style="padding: 7px;">@lang('langs.user_name')</td>
                            <td style="padding: 7px;"> @lang('langs.customer_name')</td>
                            <td style="padding: 7px;"> @lang('langs.customer_code')</td>
                            <td style="padding: 7px;"> @lang('langs.bank_name')</td>
                            <td style="padding: 7px;"> @lang('langs.account_number')</td>
                            <td style="padding: 7px;"> @lang('langs.ifsc_code')</td>
                            <td style="padding: 7px;"> @lang('langs.final_amount')</td>
                            <td style="padding: 7px;"> @lang('langs.created_by')</td>
                            <td style="padding: 7px;"> @lang('langs.created_at')</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($filter_customer_reports as $customer_report)
                            <tr style="text-align: center;">
                                <td style="padding: 7px;">{{ $loop->iteration }}</td>
                                @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                    <td class="ml-1 mr-1"
                                        style="padding: 7px;">{{translateToGujarati($customer_report->user->user_name)}}</td>
                                    <td style="padding: 7px;">{{translateToGujarati($customer_report->customer_name)}}</td>
                                    <td style="padding: 7px;">{{translateToGujarati($customer_report->customer_code)}}</td>
                                    <td style="padding: 7px;">{{translateToGujarati($customer_report->bank_name)}}</td>
                                @else
                                    <td class="ml-1 mr-1"
                                        style="padding: 7px;">{{$customer_report->user->user_name}}</td>
                                    <td style="padding: 7px;">{{$customer_report->customer_name}}</td>
                                    <td style="padding: 7px;">{{$customer_report->customer_code}}</td>
                                    <td style="padding: 7px;">{{$customer_report->bank_name}}</td>
                                @endif
                                <td style="padding: 7px;">{{$customer_report->account_number}} </td>
                                <td style="padding: 7px;">{{$customer_report->ifsc_code}} </td>
                                <td style="padding: 7px;">{{get_rupee_currency($customer_report->final_amount)}} </td>
                                @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                    <td style="padding: 7px;">{{translateToGujarati($customer_report->created_bys->user_name)}} </td>
                                @else
                                    <td style="padding: 7px;">{{$customer_report->created_bys->user_name}} </td>
                                @endif
                                <td style="padding: 7px;">{{$customer_report->created_at}} </td>

                            </tr>

                        @endforeach
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

