@extends('layouts.admin.admin-master')

@section('page_title',get_page_meta('title', true))

@section('content')
<div id="enrollment_auto">
    <div class="container">
        <div class="row">
            <div class="col">
                <h3 class="mb-25">
                    <a href="{{route('admin.updated.profiles.list')}}">{{ get_page_meta('title', true) }}</a>
                    <!-- <button type="button" class="btn btn-default btn-rounded print pull-right" data-bs-toggle="modal" data-bs-target="#basicsModal">+ Add Information</button> -->
                </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-12 mt-5">




                    <table class="table table-light table-hover table-striped table-sm table-bordered" id="myTable">
                        <thead>
                            <tr>
                                {{-- <th class="text-center" style="max-width: max-content"><input type="checkbox" name="select_all" value="1" id="example-select-all"></th> --}}
                                <th class="text-center" style="max-width: max-content">
                                  No
                                </th>
                                <th>Name</th>
                                <th>Email</th>

                                <th>Gender</th>
                                <th>Mobile</th>
                                <th>Created</th>

                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($memberUpdateProfiles) > 0)
                            @foreach ($memberUpdateProfiles  as $key => $data)
                                <tr>
                                    <td style="text-align:center">
                                       {{$loop->iteration}}
                                    </td>
                                    <td>
                                        {{optional($data->member)->name}}

                                    </td>
                                    <td>{{optional($data->member)->email}}</td>

                                    <td>{{optional($data->member)->gender}}</td>
                                    <td>{{optional($data->member)->mobile}}</td>
                                    <td>{{$data->created_at->diffForHumans()}}</td>


                                    <td>

                                        <a href="{{route('admin.updated.profiles.view',$data->id)}}" class="btn btn-primary">View</a>

                                    </td>
                                </tr>

                            @endforeach
                            @endif
                        </tbody>
                    </table>



            </div>
        </div>
    </div>
</div>

@push('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<style>
    .image_main{
        display: flex;
    justify-content: flex-start;
    gap: 6px;
    flex-direction: row;
    /* flex-wrap: wrap; */
    height: auto;
    width: 100%;

    }
    .image_main_inner{
        width: 100%;

    }
    .image_main img{
        height: 150px;
    width: 150px;
    }
</style>
@endpush
@push('script')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script src="{{ asset('plugins/Image-PDF-Viewer-EZView/EZView.js') }}"></script>
<script src="{{ asset('plugins/Image-PDF-Viewer-EZView/draggable.js') }}"></script>

<script>
    let table = new DataTable('#myTable');
</script>
<script>
    $(document).ready(function(){
        $(document).on('change','.status_change', function(e){
            e.preventDefault();
            let user_id = $(this).data('userid');
            $(`#status_form_${user_id}`).submit();
            // console.log(user_id);
        })
        // console.log('chck');

        $('img').EZView();

    });
</script>
@endpush
@endsection
