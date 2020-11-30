@extends('layouts.app')

@section('content')
    <h3 class="page-title">    {{trans('tictic/title.dashboard')}} </h3>
        <p>
            <a  class="btn btn-success" href="{{ route('admin.music.create') }}">
                {{trans('tictic/button.add')}}
            </a>

        </p>

    <div class="panel panel-default">
        <div class="panel-heading">
            {{trans('tictic/title.list')}}
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    @can('product_delete')
                     <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>

                    <th>@lang('quickadmin.products.fields.name')</th>
                    <th>@lang('quickadmin.products.fields.description')</th>
                    <th>@lang('quickadmin.products.fields.created-by')</th>
                    <th>@lang('quickadmin.products.fields.created-by-team')</th>
                    @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                    @else
                        <th>&nbsp;</th>
                    @endif
                </tr>
                </thead>

                <tbody>

                        <tr data-entry-id="1"
                         <td></td>

                            <td field-key='name'>ddd</td>
                            <td field-key='description'>ddd</td>
                            <td field-key='created_by'>dd</td>
                            <td field-key='created_by_team'>ddd</td>
                                <td>

                                </td>
                    <tr>
                        <td colspan="9">@lang('quickadmin.qa_no_entries_in_table')</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript')

@endsection
