@extends('admin.layouts.app')

@section('content')

    <main id="main" class="main">
        <section class="section">
            @php
                $englishText = 'Hello, how are you?';
    $gujaratiText = translateToGujarati($englishText);
            @endphp

            @include('admin.flash-message')
            <div class="row">
                <div class="col-lg-12 float-right mb-5">
            <span class="pull-right float-right">&nbsp;&nbsp;
 <a class="btn btn-outline-primary" href="{{ route('item_name.create') }}" style="float: right">
                + @lang('langs.add')
            </a>
            </span></div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body table-responsive" id="sampleTable">
                            <h5 class="card-title">@lang('langs.item_name_table')</h5>
                            <table id="sampleTable" class="table datatable">
                                <thead>
                                <tr>
                                    <th scope="col">@lang('langs.item_name_no')</th>
                                    <th scope="col">@lang('langs.item_name')</th>
                                    <th scope="col">@lang('langs.item_name_action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($item_names as $item_name)
                                    <tr>
                                        @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                            <th scope="row">{{gujarati_number($loop->iteration)}}</th>
                                            <td>{{translateToGujarati($item_name->item_name)}}</td>
                                        @else
                                            <th scope="row">{{$loop->iteration}}</th>
                                            <td>{{$item_name->item_name}}</td>
                                        @endif
                                        <td>
                                            {!! Form::open(['route' => ['item_name.destroy', $item_name->id], 'method' => 'delete']) !!}
                                            <div class='btn-group'>
                                                <a href="{{ route('item_name.edit', [$item_name->id]) }}"
                                                   class='btn btn-info btn-xs'>
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                {!! Form::button('<i class="bi bi-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                                            </div>
                                            {!! Form::close() !!}
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection


