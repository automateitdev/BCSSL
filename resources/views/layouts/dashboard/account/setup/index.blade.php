@extends('home')

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
                            <form action="{{ route('ledger.store') }}" method="POST">
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
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-info"><i class="fa fa-plus-circle"></i>
                                        Save</button>
                                </div>
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
        </div>
    </div>
@endsection
