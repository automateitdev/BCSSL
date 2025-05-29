@extends('layouts.admin.admin-master')

@section('page_title', get_page_meta('title', true))
@section('content')
    <div id="bcs">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2 class="mb-25">
                        <a href="#">Ladger Setup</a>
                        <!-- <button type="button" class="btn btn-default btn-rounded print pull-right" data-bs-toggle="modal" data-bs-target="#basicsModal">+ Add Information</button> -->
                    </h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
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
                    <div class="row">
                        <div class="rkj">
                            <form action="{{ route('admin.ledger.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="acc_cat" class="form-label">Account Category</label>
                                    <select name="acc_cat" id="acc_cat" class="form-control single">
                                        <option selected>Choose One</option>
                                        @foreach ($acccats as $acccat)
                                            <option value="{{ $acccat->id }}">{{ $acccat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="acc_group_id" class="form-label">Account Group</label>
                                    <select name="acc_group_id" id="acc_group_id" class="form-control single">
                                        <option selected>Choose One</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="ledger_name" class="form-label">Ledger Name</label>
                                    <input type="text" name="ledger_name" id="ledger_name" class="form-control">
                                </div>
                                @can('Create Ledger Add')
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-info"><i class="fa fa-plus-circle"></i>
                                            Save</button>
                                    </div>
                                @endcan

                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="rkj">
                        <div class="mb-3">
                            <label for="note" class="form-label">Note</label>
                            <textarea disabled name="note" id="note" rows="10" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card p-3 my-2">
                    <table class="table table-sm table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Ledger Name</th>
                                <th>Account Category</th>
                                <th>Account Group</th>
                                <th>Nature</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ledgers as $ledger)
                                <tr>
                                    <td>{{ $ledger['ledger_name'] }}</td>
                                    <td>{{ $ledger['account_group']['account_category']['name'] }}</td>
                                    <td>{{ $ledger['account_group']['group_name'] }}</td>
                                    <td class="text-capitalize">{{ $ledger['account_group']['nature'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
