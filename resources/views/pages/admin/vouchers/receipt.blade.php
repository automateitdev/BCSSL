@extends('layouts.admin.admin-master')

@section('page_title', get_page_meta('title', true))
@section('content')
    <div id="bcs">
        <div class="container">
            <div class="row">
                <p>Voucher Entry: Receipt</p>
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

            $("#recieptBy").change(function(event) {
                $.each($(this).find('option'), function(key, value) {
                    $(value).removeClass('active');
                })
                $('option:selected').addClass('active');

                $acc_balance = $('option:selected').attr('data-amount');

                $("#recieptByWrapper").tooltip({
                    placement: 'bottom',
                    trigger: 'manual',
                    container: 'body',
                    title: function(e) {
                        return $('#recieptBy').find('.active').attr('title')
                    }
                });
                $("#recieptByWrapper").tooltip('show')
            });

            $("#recieptFund").change(function(event) {
                $.each($(this).find('option'), function(key, value) {
                    $(value).removeClass('active');
                })
                $('option:selected').addClass('active');
                $("#recieptFundWrapper").tooltip({
                    placement: 'bottom',
                    trigger: 'manual',
                    container: 'body',
                    title: function(e) {
                        return $('#recieptFund').find('.active').attr('title')
                    }
                });
                $("#recieptFundWrapper").tooltip('show')
            });

            $('#recieptFor').on('change', function() {
                // let payFor = $(this).val();
                // $("#holdWrap").load(location.href + " #holdWrap");
                $("#holdWrap").html("");
                $("#paymentAmountInfo").html("");
                $("#paymentAmountSum").html("");
                $('#notify').html(``)
                $('#totalAmountShow').html(``)
                $("#recieptFor option:selected").each(function() {
                    var $this = $(this);
                    if ($this.length) {
                        var selText = $this.text();
                        var selTextEscaped = selText.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g,
                            '-');
                        // console.log(selText);
                        $("#holdWrap").append(
                            `<div class="col-md-6 mb-3"><label>${selText} <span style="color:tomato">*</span></label></div><div class="col-md-6 mb-3"><input type="number" name="reciept_amount[]" class="form-control" id="reciept_amount" data-title=${selTextEscaped} placeholder="Write Amount"></div>`
                        )

                        $("#paymentAmountInfo").append(
                            `<div class="col-md-6 mb-3"><label>${selText} <span style="color:tomato">*</span></label></div><div class="col-md-6 mb-3"><input type="text" data-title=${selTextEscaped} class="form-control" placeholder="No Amount Set" disabled></div>`
                        )
                        // console.log(divs);
                    }
                });
            });
            $('#recieptFund').on('change', function() {
                let fundname = $('#recieptFund option:selected').text();
                var amount_arr = $("input[id='reciept_amount']")
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

                if (fundname != '') {
                    $('#paymentAmountSum').html(
                        `<div class="alert alert-info">Total Reciept for: ${amount_sum}/- at ${fundname}</div>`
                    );
                } else {
                    // $('#paymentAmountSum').html(`<div class="alert alert-info">No Fund Selected</div>`);
                }
            })



            $(document).on("keyup", "#reciept_amount", function() { // works with .del that are dynamcially added!
                var fund_balance = $('#recieptFund option:selected').attr('data-amount');
                var amount_arr = $("input[id='reciept_amount']")
                    .map(function() {
                        let amountTitle = $(this).attr('data-title');
                        let amount = $(this).val();
                        // console.log(amountTitle);
                        $(`#paymentAmountInfo.row input[data-title=${amountTitle}]`).val(amount);
                        // console.log($(`#paymentAmountInfo.row input[data-title=${amountTitle}]`));
                        return amount;
                    }).get();

                var amount_sum = 0;
                for (var i = 0; i < amount_arr.length; i++) {
                    amount_sum += amount_arr[i] << 0;
                }

                let fundname = $('#recieptFund option:selected').text();
                if (fundname != '') {
                    $('#paymentAmountSum').html(
                        `<div class="alert alert-info">Total Reciept for: ${amount_sum}/- at ${fundname}</div>`
                    );
                } else {
                    // $('#paymentAmountSum').html(`<div class="alert alert-info">No Fund Selected</div>`);
                }


                total_amount_pay = amount_sum;
                $('#totalAmountShow').html(`<div class="alert alert-info">Total: ${amount_sum}</div>`)

            });
        });
    </script>

@endsection
