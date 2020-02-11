@extends('layouts.admin')

@section('contentheader')
<div class="page-title">
    <div class="title_left">
        <h3>Opening Balance</h3>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_content">
                <form id="formCreate" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                    <div class="col-md-3 col-sm-2 col-xs-2">
                    </div>
                    <div class="col-md-6 col-sm-2 col-xs-2">
                        <p> Anda akan melakukan proses tutup buku untuk periode finansial: </p>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Dari
                                    Tanggal</label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input type="text" class="form-control date" name="start_period" id="from_date"
                                        value="{{$start_period}}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                    style="text-align: left;">Sampai Tanggal
                                </label>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <input type="text" class="form-control date" name="end_period" id="to_date"
                                        value="{{$end_period}}">
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="form-group">
                            <div class="col-md-9 col-sm-6 col-xs-12 col-md-offset-1">
                                <p> Setelah proses tutup buku,
                                    Anda tidak dapat melakukan perubahan terhadap buku
                                    Anda pada tanggal SEBELUM 31/12/2019
                                </p>
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-8 col-sm-6 col-xs-12 col-md-offset-4">
                                <button class="btn btn-danger" type="button"
                                    onclick="window.location.href = '/chart_of_accounts';">Batal</button>
                                <button id="click" type="submit" class="btn btn-success">Lanjut</button>
                                @if($id)
                                <input hidden name="hidden_id" value="{{$id}}">
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!--<script src="{{ asset('js/accounts/dataTableindex.js?v=5-20200211-1624') }}" charset="utf-8"></script>-->
<script src="{{asset('js/other/zebradatepicker.js?v=5-20200211-1624') }}" charset="utf-8"></script>
<script src="{{asset('js/accounts/opening_balance/createForm.js?v=5-20200211-1624') }}" charset="utf-8"></script>
<script src="{{asset('js/other/select2.js')}}" charset="utf-8"></script>
<script src="{{asset('js/other/duedate_format.js')}}" charset="utf-8"></script>
@endpush