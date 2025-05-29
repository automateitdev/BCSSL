@extends('layouts.admin.admin-master')

@section('page_title', get_page_meta('title', true))
@section('content')
    <div id="bcs">
        <div class="container">
            <div class="row">
                <p>Voucher Entry: Payment</p>

                <form action="{{ route('admin.voucher.payment.store') }}" method="POST"
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
                            <div>
                                <button type="button" class="btn btn-sm btn-primary d-block mx-auto fa-fade"
                                    id="voucherInvoiceDownload" data-invoice={{ session()->get('invoice') }}
                                    data-type="Payment Voucher" data-user={{ Auth::user()->institute_id }}>Download
                                    Voucher</button>
                            </div>
                        </div>
                    @endif

                    <div class="row mx-auto" id="myModal" style="overflow: hidden">
                        <div class="col-md-6 col-sm-12 mb-3  ">
                            <label class=" text-dark " for="paymentDate">Payment Date <span
                                    style="color: tomato">*<span></label>
                            <input type="date" name="paymentDate" class="form-control">
                        </div>
                        <div class="col-md-6 col-sm-12 mb-3" id="paymentByWrapper" title="">
                            <label class=" text-dark " for="paymentBy">Payment By <span
                                    style="color: tomato">*<span></label>
                            <select name="paymentBy" id="paymentBy" class="form-control single-selection float-right">
                                <option></option>
                                @if (!empty($getCashLedger))
                                    @foreach ($getCashLedger as $CashLedger)
                                        <option value={{ $CashLedger->id }}
                                            title="{{ $CashLedger->ledger_name }} : {{ $CashLedger->ledger_traces_sum_debit - $CashLedger->ledger_traces_sum_credit }}/-"
                                            data-amount={{ $CashLedger->ledger_traces_sum_debit - $CashLedger->ledger_traces_sum_credit }}>
                                            {{ $CashLedger->ledger_name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>


                        {{-- <div class="col-md-6 col-sm-12 mb-3" id="paymentFundWrapper">
                        <label class=" text-dark " for="paymentFund">From Fund <span style="color: tomato">*<span></label>
                        <select name="paymentFund" id="paymentFund" class="form-control fund-selection">
                            <option></option>
                            @if (!empty($fundlist))
                                @foreach ($fundlist as $fund)
                                    <option value="{{ $fund->id }}" data-amount={{ $fund->ledger_balance }}
                                        title="{{ $fund->fund_name }} : {{ $fund->ledger_balance }}/-">
                                        {{ $fund->fund_name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div> --}}

                        <div class="col-md-12 mb-3 clone-scope mx-auto">
                            <label class=" text-dark " for="paymentFor">Payment For <span
                                    style="color: tomato">*<span></label>
                            <div id="notify" class="col-md-12"></div>
                            <select name="paymentFor[]" id="paymentFor" class="form-control multiple-selection" multiple>
                                <option></option>
                                @foreach ($getCreditLedger as $creditLedger)
                                    <option value="{{ $creditLedger->id }}">{{ $creditLedger->ledger_name }}</option>
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
                            <label class=" text-dark " for="paymentRef">Reference <small>(max: 200
                                    characters)</small></label>
                            <input type="dacte" name="paymentRef" class="form-control">
                        </div>

                        <div class="col-md-12">
                            <label class=" text-dark" for="paymentDesc">Description</label>
                            <textarea name="paymentDesc" id="" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary btn-sm float-right my-2" data-bs-toggle="modal"
                                data-bs-target="#voucherModal">
                                <i class="fa fa-check"></i>
                                Confirm
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="voucherModal" tabindex="-1" aria-labelledby="voucherModalLabel"
                                aria-hidden="true" style="z-index:2000;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-primary" id="voucherModalLabel showAmountData">
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
    </div>
    <script>
        $(function() {

            //prevent sccrolling on number input
            $('form').on('focus', 'input[type=number]', function(e) {
                $(this).on('wheel.disableScroll', function(e) {
                    e.preventDefault()
                })
            })
            $('form').on('blur', 'input[type=number]', function(e) {
                $(this).off('wheel.disableScroll')
            })


            let total_amount_pay = 0;
            $(".fund-selection").select2({
                placeholder: "Choose Fund",
                allowClear: true
            });


            $(".single-selection").select2({
                placeholder: "Choose Ledger",
                allowClear: true
            });

            $(".multiple-selection").select2({
                placeholder: "Choose Ledger"
            });

            $('.single-selection').val(null).trigger('change');
            // $('.multiple-selection').val(null).trigger('change');

            $("#paymentBy").change(function(event) {
                $.each($(this).find('option'), function(key, value) {
                    $(value).removeClass('active');
                })
                $('option:selected').addClass('active');

                $acc_balance = $('option:selected').attr('data-amount');
                // console.log(typeof($acc_balance));

                if (parseFloat($acc_balance) <= 0) {
                    var acc_name = $('#paymentBy option:selected').text();
                    $('#notify').html(
                        `<div class="alert alert-danger">Insufficient balance in ${acc_name}</div>`)
                    $("#paymentFor option:selected").prop("selected", false);
                    $('#paymentFor').val([])
                    $('#paymentFor').prop('disabled', true);
                    $("#holdWrap").html("");
                    $("#paymentAmountInfo").html("");


                } else {
                    $('#notify').html(``)
                    $('#paymentFor').prop('disabled', false);
                }

                $("#paymentByWrapper").tooltip({
                    placement: 'bottom',
                    trigger: 'manual',
                    container: 'body',
                    title: function(e) {
                        return $('#paymentBy').find('.active').attr('title')
                    }
                });
                $("#paymentByWrapper").tooltip('show')
            });


            $('#add_clone-scope').click(function(e) {
                $(".clone-scope").clone().appendTo("#clone_hold");
            })

            $('#paymentFor').on('change', function() {
                // let payFor = $(this).val();
                // $("#holdWrap").load(location.href + " #holdWrap");
                $("#holdWrap").html("");
                $('#notify').html(``);
                $("#paymentAmountInfo").html("");
                $("#paymentAmountSum").html("");
                $('#totalAmountShow').html(``)
                $("#paymentFor option:selected").each(function() {
                    var $this = $(this);
                    if ($this.length) {
                        var selText = $this.text();
                        var selTextEscaped = selText.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g,
                            '-');
                        // console.log(selText);
                        // console.log(selTextEscaped);
                        $("#holdWrap").append(
                            `<div class="col-md-6 mb-3"><label>${selText} <span style="color:tomato">*</span></label></div><div class="col-md-6 mb-3"><input type="number" name="payment_amount[]" class="form-control" id="payment_amount" data-title=${selTextEscaped} placeholder="Write Amount"></div>`
                        )
                        // console.log(divs);
                        $("#paymentAmountInfo").append(
                            `<div class="col-md-6 mb-3"><label>${selText} <span style="color:tomato">*</span></label></div><div class="col-md-6 mb-3"><input type="text" data-title=${selTextEscaped} class="form-control" placeholder="No Amount Set" disabled></div>`
                        )
                    }
                });
            });

            $(document).on("keyup", "#payment_amount", function() { // works with .del that are dynamcially added!
                var ledger_balance = $('#paymentBy option:selected').attr('data-amount');

                var amount_arr = $("input[id='payment_amount']")
                    .map(function() {
                        let amountTitle = $(this).attr('data-title');
                        let amount = $(this).val();
                        $(`#paymentAmountInfo.row input[data-title=${amountTitle}]`).val(amount);
                        return amount;
                    }).get();


                var amount_sum = 0;
                for (var i = 0; i < amount_arr.length; i++) {
                    amount_sum += amount_arr[i] << 0;
                }
                console.log(amount_sum);

                let paymentByLedger = $('#paymentBy option:selected').text();
                if (paymentByLedger != '') {
                    $('#paymentAmountSum').html(
                        `<div class="alert alert-info">Total Payment of ${amount_sum}/- from: ${paymentByLedger}</div>`
                    );
                } else {
                    $('#paymentAmountSum').html(`<div class="alert alert-info">Not found</div>`);
                }
                total_amount_pay = amount_sum;
                $('#totalAmountShow').html(`<div class="alert alert-info">Total: ${amount_sum}</div>`)
                if (ledger_balance != undefined && amount_sum > ledger_balance) {
                    var fund_acc = $('#paymentFund option:selected').text();
                    $('#notify').html(
                        `<div class="alert alert-danger">Insufficient balance in ${paymentByLedger}</div>`
                        )
                    $('#paymentFor').prop('disabled', true);
                    $("#holdWrap").html("");
                    $("#paymentAmountInfo").html("");
                } else {
                    $('#notify').html(``)
                }
            });
        });
    </script>
@endsection
