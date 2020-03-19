@extends('layouts.admin')

@section('contentheader')
<div class="page-title">
    <div class="title_left">
        <h3>Audit List</h3>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action" id="dataTable" style="width:100%">
                        <thead>
                            <tr class="headings">
                                <th scope="col">Model</th>
                                <th scope="col">Action</th>
                                <th scope="col">User</th>
                                <th scope="col">Time</th>
                                <th scope="col">Old Values</th>
                                <th scope="col">New Values</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($audits as $audit)
                            <tr>
                                <td>{{ $audit->auditable_type }} (id: {{ $audit->auditable_id }})</td>
                                <td>{{ $audit->event }}</td>
                                <td>{{ $audit->user->name }}</td>
                                <td>{{ $audit->created_at }}</td>
                                @if($audit->old_values)
                                <td>
                                    <table class="table">
                                        @foreach($audit->old_values as $attribute => $value)
                                        <tr>
                                            <td><b>{{ $attribute }}</b></td>
                                            <td>{{ $value }}</td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </td>
                                @else
                                <td>-</td>
                                @endif
                                @if($audit->new_values)
                                <td>
                                    <table class="table">
                                        @foreach($audit->new_values as $attribute => $value)
                                        <tr>
                                            <td><b>{{ $attribute }}</b></td>
                                            <td>{{ $value }}</td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </td>
                                @else
                                <td>-</td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $audits->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
{{--
@push('scripts')
<script src="{{ asset('js/otherlists/audits/dataTable.js?v=5-20200319-0916') }}" charset="utf-8"></script>
@endpush
--}}