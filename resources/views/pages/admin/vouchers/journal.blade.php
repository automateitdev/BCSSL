@extends('layouts.admin.admin-master')

@section('page_title', get_page_meta('title', true))
@section('content')
    <div id="bcs">
        <div class="container">
            <div class="row">
                <p>Voucher Entry: Journal</p>
            </div>
                <form action="{{ route('admin.voucher.receipt.store') }}" method="POST"
                    class="col-md-8 mx-auto px-3 py-5 bg-light border-rounded bg-white"
                    style="border:  2px groove seagreen; border-radius:5px">
                    @csrf


                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session()->get('error') }}
                        </div>
                    @endif
                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif

                    @if (session()->has('invoice'))
                        <div class="alert alert-info">
                            <div><button class="btn btn-sm btn-primary d-block mx-auto fa-fade" id="voucherInvoiceDownload"
                                    data-invoice={{ session()->get('invoice') }} data-type="Reciept Voucher"
                                    data-user={{ Auth::user()->institute_id }}>Download Voucher</button></div>
                        </div>
                    @endif

                    <div class="row mx-auto" id="myModal" style="overflow: hidden">
                        <div class="col-md-6 col-sm-12 mb-3  ">
                            <label class=" text-dark " for="recieptDate">Reciept Date <span
                                    style="color: tomato">*<span></label>
                            <input type="date" name="recieptDate" class="form-control">
                        </div>
                        <div class="col-md-6 col-sm-12 mb-3" id="recieptByWrapper" title="">
                            <label class=" text-dark " for="recieptBy">Reciept Type <span
                                    style="color: tomato">*<span></label>
                            <select name="recieptBy" id="recieptBy" class="form-control single-selection float-right">
                                <option></option>
                                @if (!empty($getCashLedger))
                                    @foreach ($getCashLedger as $DebitLedger)
                                        <option value={{ $DebitLedger->id }}
                                            title="{{ $DebitLedger->ledger_name }} : {{ $DebitLedger->ledger_traces_sum_debit - $DebitLedger->ledger_traces_sum_credit }}/-"
                                            data-amount={{ $DebitLedger->ledger_traces_sum_debit - $DebitLedger->ledger_traces_sum_credit }}>
                                            {{ $DebitLedger->ledger_name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>

                        </div>


                        {{-- <div class="col-md-6 col-sm-12 mb-3" id="recieptFundWrapper">
                            <label class=" text-dark " for="recieptFund">Reciept Fund <span
                                    style="color: tomato">*<span></label>
                            <select name="recieptFund" id="recieptFund" class="form-control fund-selection">
                                <option></option>
                                @if (!empty($fundlist))
                                    @foreach ($fundlist as $fund)
                                        <option value="{{ $fund->id }}" data-amount={{ $fund->fund_balance }}
                                            title="{{ $fund->fund_name }} : {{ $fund->fund_balance }}/-">
                                            {{ $fund->fund_name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div> --}}




                        <div class="col-md-12 mb-3 clone-scope mx-auto">
                            <label class=" text-dark " for="recieptFor">Reciept For <span
                                    style="color: tomato">*<span></label>
                            <div id="notify" class="col-md-12"></div>
                            <select name="recieptFor[]" id="recieptFor" class="form-control multiple-selection" multiple>
                                <option></option>
                                @foreach ($getDebitLedger as $debitLedger)
                                    <option value="{{ $debitLedger->id }}">{{ $debitLedger->ledger_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="holdWrap" class="row col-md-10 col-sm-12 mx-auto"></div>
                        <div class="col-md-12">
                            <div id="totalAmountShow"></div>
                        </div>

                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="col-md-6 col-sm-12 mb-3  ">
                            <label class=" text-dark " for="recieptRef">Reference (maximum 200 characters)</label>
                            <input type="dacte" name="recieptRef" class="form-control">
                        </div>

                        <div class="col-md-12">
                            <label class=" text-dark" for="recieptDesc">Description</label>
                            <textarea name="recieptDesc" id="" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                        <div>
                            {{-- <button type="submit" class="btn btn-info btn-sm float-right my-2"> </button> --}}
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary btn-sm float-right my-2" data-bs-toggle="modal"
                                data-bs-target="#receiptModal">
                                <i class="fa fa-check"></i>
                                Confirm
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel"
                                aria-hidden="true" style="z-index:2000;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-primary" id="exampleModalLabel showAmountData">
                                                Please
                                                re-confirm Amount(s)</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="paymentAmountSum">No Amount to total</div>
                                            <div class="row" id="paymentAmountInfo">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i>
                                                Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
        </div>
    </div>
@endsection
