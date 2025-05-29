@extends('home')

@section('content')
    <div id="bcs">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2 class="mb-25">
                        <a href="#">Fee Setup</a>
                        <!-- <button type="button" class="btn btn-default btn-rounded print pull-right" data-bs-toggle="modal" data-bs-target="#basicsModal">+ Add Information</button> -->
                    </h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
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
                    <div class="rkj">
                        <form action="{{ route('fees.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="feehead" class="form-label">Fee Head</label>
                                <input type="text" name="fee_head" id="feehead" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="monthly" class="form-label">Fee Type</label>
                                <select name="monthly" id="monthly" class="form-control">
                                    <option selected>Choose One</option>
                                    <option value="1">Monthly</option>
                                    <option value="0">One Time</option>
                                </select>
                            </div>
                            <div class="mb-3" id="activeDate" style="display:none;">
                                <label for="date" class="form-label">Activate Date</label>
                                <input type="date" name="date" id="date" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="ledger_id" class="form-label">Ledger</label>
                                <select name="ledger_id" id="ledger_id" class="form-control single">
                                    <option selected>Select Ledger</option>
                                    @foreach ($ledgers as $ledger)
                                        <option value="{{ $ledger->id }}">{{ $ledger->ledger_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="fine" class="form-label">Fine (%)</label>
                                <input type="text" onkeypress="return /[0-9]/i.test(event.key)" name="fine"
                                    min="0" max="100" id="fine" class="form-control">
                                <div class="err" style="display:none; color: #f41313;"><small>Please, Select 0 to
                                        100</small></div>
                            </div>
                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="text" name="amount" id="amount" class="form-control">
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-info"> <i class="fa fa-plus-cirlce"></i>Save</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
            @if (isset($feesetups))
            <div class="row mt-5">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <table class="table table-striped table-bordered table-light table-hover table-sm" id="feeheads">
                        <thead>
                            <tr>
                                <th>Fee Head</th>
                                <th>Fine</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($feesetups as $fee)
                            <tr>
                                <td>{{$fee->fee_head}}</td>
                                <td>{{$fee->fine}}</td>
                                <td>{{$fee->amount}}</td>
                                <td>{{$fee->date}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-1"></div>
            </div>
            @endif
        </div>
    </div>
    <script>
        $(function(){
            $('#feeheads').DataTable();
        })
    </script>
@endsection
