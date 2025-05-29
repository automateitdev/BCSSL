@extends('layouts.admin.admin-master')

@section('page_title',get_page_meta('title', true))
@section('content')
<div id="fee_amount">
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="mb-25">
                    <a href="#">SMS Template</a>
                    <button type="button" class="btn btn-default btn-rounded print pull-right" data-bs-toggle="modal" data-bs-target="#smstemplateModal">
                        Add SMS
                    </button>
                </h2>
                <!-- Modal -->
                <div class="modal fade" id="smstemplateModal" tabindex="-1" aria-labelledby="smstemplateModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="smstemplateModalLabel">Add New SMS</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{route('admin.sms.temp.store')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="title" class="form-label">SMS Title</label>
                                        <input type="text" class="form-control" id="title" name="title" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="sms" class="form-label">SMS Body</label>
                                        <textarea name="sms" id="sms" cols="30" rows="10"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                <!-- <li>{{session('errors')->first('error');}}</li> -->
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if(session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
        @endif
        @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
        @endif
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="druyt">
                <table class="table table-bordered table-primary">
                    <thead>
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">SMS Body</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($smstemps as $item)
                        <tr>
                            <td>{{$item->title}}</td>
                            <td>{{$item->sms}}</td>
                            <td>
                                <a href="{{route('admin.sms.temp.edit', $item->id)}}"><i class="fa fa-edit"></i></a>
                                

                                <form method="POST" id="delete-form-{{$item->id}}" action="{{route('admin.sms.temp.delete',$item->id)}}" style="display: none;">
                                    @csrf
                                    {{method_field('delete')}}

                                </form>
                                <button onclick="if(confirm('Are you sure, You want to delete this?')){
                                                            event.preventDefault();
                                                            document.getElementById('delete-form-{{$item->id}}').submit();
                                                            }else{
                                                            event.preventDefault();
                                                            }
                                                            " class="btn" href="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
</div>

@endsection