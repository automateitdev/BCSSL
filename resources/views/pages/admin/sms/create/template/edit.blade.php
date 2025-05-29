@extends('school_admin')

@section('content')
<div id="fee_amount">
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="mb-25">
                    <a href="#">Edit SMS Template ({{$data->title}})</a>
                    <button type="button" class="btn btn-default btn-rounded print pull-right" data-bs-toggle="modal" data-bs-target="#smstemplateModal">
                        Add SMS
                    </button>
                </h2>
                <form action="{{route('sms.temp.update', $data->id)}}" method="POST">
                    @csrf
                    <input type="hidden" name="title" value="{{$data->title}}">
                    <div class="mb-3">
                    <label for="sms" class="form-label">SMS</label>
                    <textarea name="sms" class="form-control" id="sms" cols="30" rows="10" value="">{{$data->sms}}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection