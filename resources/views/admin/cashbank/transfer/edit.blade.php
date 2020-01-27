@extends('layouts.admin')
@section('content')

<div class="dashboard-wrapper">

    <div class="row form-page-header">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
            <div id="top">
                <small>Transaction </small>
                <h1>Bank Transfer</h1>
            </div>
        </div>
    </div>

    <div class="container-fluid form-content">
        <form method="post" action="{{route('bank_transfers.update',['id' => $transfer->id])}}">
            @csrf
            <div class="jumbotron">
                <div class="row">
                    <div class="col-lg-3">
                        <label class="control-label">* Transfer From </label>
                        <select class="form-control form-control-sm" name="transfer" required>
                            @foreach ($accounts as $account)
                            <option value="{{$account->id}}" @if($transfer->transfers_account_id == $account->id)
                                selected @endif>{{$account->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label class="col-form-label">* Deposit To </label>
                        <select class="form-control form-control-sm" name="deposit" required>
                            @foreach ($accounts as $account)
                            <option value="{{$account->id}}" @if($transfer->deposit_account_id == $account->id) selected
                                @endif>{{$account->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label class="col-form-label">Amount </label>
                        <input type="text" class="form-control form-control-sm" name="amount"
                            value="{{$transfer->amount}}" required>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="memoForm">Memo </label>
                        <textarea class="form-control" name="memo" rows="4" value="{{$transfer->memo}}"></textarea>
                    </div>
                    {{--
                    <div class="form-group">
                        <label for="descForm"> Attachment</label>
                        <textarea class="form-control" name="attachment" rows="2"></textarea>
                    </div>
                    --}}
                </div>
                <div class="col-lg-4">
                    {{--
                    <div class="form-group">
                        <label for="descForm">Tags </label>
                        <input type="text" class="form-control form-control-sm" name="tags">
                    </div>
                    --}}
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="descForm">Transaction No </label>
                        <input type="text" class="form-control form-control-sm" name="number"
                            value="{{$transfer->number}}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="descForm">Transaction Date </label>
                        <input type="date" class="form-control form-control-sm" name="date" value="{{$transfer->date}}"
                            required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-10">
                    <a href="{{ url()->previous() }}" class="btn btn-danger">Cancel</a>
                    <div class="btn-group dropup">
                        <button type="submit" class="btn btn-success">Create </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>
@endsection

@push('scripts')
<script type="text/javascript" src="{{asset('js/multiply.js?v=5-27012020') }}" charset="utf-8"></script>
<script type="text/javascript" src="{{asset('js/sum.js?v=5-27012020') }}" charset="utf-8"></script>
@endpush