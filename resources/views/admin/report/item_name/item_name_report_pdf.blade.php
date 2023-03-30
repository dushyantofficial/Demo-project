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
                <span>@lang('langs.item_name_report')</span>
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
                            @if(isset($input['field']['item_name']))
                                <td style="padding: 7px;"> @lang('langs.item_name')</td>

                            @endif
                            @if(isset($input['field']['insertedByUserId']))
                                <td style="padding: 7px;"> @lang('langs.created_by')</td>

                            @endif

                            @if(isset($input['field']['created_at']))
                                <td style="padding: 7px;"> Created Date</td>

                            @endif

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($item_name_reports as $item_name_report)
                            <tr style="text-align: center;">
                                <td style="padding: 7px;">{{ $loop->iteration }}</td>
                                @if(isset($input['field']['item_name']))
                                    @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                        <td>{{translateToGujarati($item_name_report->item_name)}} </td>
                                    @else
                                        <td>{{$item_name_report->item_name}} </td>
                                    @endif
                                @endif
                                @if(isset($input['field']['insertedByUserId']))
                                    @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                        <td>{{translateToGujarati($item_name_report->created_bys->user_name)}} </td>
                                    @else
                                        <td>{{$item_name_report->created_bys->user_name}} </td>
                                    @endif
                                @endif
                                @if(isset($input['field']['created_at']))
                                    <td style="padding: 7px;">{{$item_name_report->created_at}} </td>
                                @endif

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

