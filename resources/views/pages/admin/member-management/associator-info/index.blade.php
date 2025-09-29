@extends('layouts.admin.admin-master')

@section('page_title',get_page_meta('title', true))

@section('content')
<div id="enrollment_auto">
    <div class="container">
        <div class="row">
            <div class="col">
                <h3 class="mb-25">
                    <a href="{{route('admin.associators-info.index')}}">{{ get_page_meta('title', true) }}</a>
                    <!-- <button type="button" class="btn btn-default btn-rounded print pull-right" data-bs-toggle="modal" data-bs-target="#basicsModal">+ Add Information</button> -->
                </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-12 mt-5">


                <table class="table table-light table-hover table-striped table-sm table-bordered" id="example">
                    <thead>
                        <tr>
                            {{-- <th class="text-center" style="max-width: max-content"><input type="checkbox" name="select_all" value="1" id="example-select-all"></th> --}}
                            <th>No</th>
                            <th>Name</th>
                            <th>Mobile</th>

                            <th>Membership Number</th>
                            <th>Date of approval</th>
                            <th>Number of share/s
                            </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assoc_infos  as $info)
                            <tr>
                                <td style="text-align:center">
                                    {{$loop->iteration}}
                                </td>

                                <td >{{$info->user->name}}</td>

                                <td>{{$info->user->mobile}}</td>

                                <td>  {{ $info->membershp_number ?? ''}}</td>
                                <td>  {{ $info->approval_date ?? ''}}</td>
                                <td>  {{ $info->num_or_shares ?? ''}}</td>


                                <td class="td-button" data-id="{{$info->id}}">
                                    {{-- @can('Associators Info Edit')
                                    <a href="{{route('admin.associators-info.edit',$info->id)}}" class="btn btn-success">Edit</a>
                                    @endcan --}}
                                </td>


                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@push('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endpush
@push('script')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
   var table = $('#example').DataTable();
    $(document).on('click', '#example tbody tr', function(){
    // $("#example tbody tr").click(function(){
        if (! $(this).find("button").length)
        {
            $(this).find("td").each(function(index ){

                let data_id='';
                var dataid = $(this).attr('data-id');
                if (typeof dataid !== 'undefined' && dataid !== false) {
                        // console.log($(this).attr('name'));
                        data_id = dataid;
                }
                if (!$(this).hasClass("td-button"))
                {
                    var text = $(this).text();


                    if(index == 3){

                        $(this).html ('<input type="text" name="membershp_number" value="' +  text + '">')
                    }else if(index == 4){

                    $(this).html ('<input type="date" name="approval_date" value="' +  text + '">')
                    }else if(index == 5){

                    $(this).html ('<input type="text" name="num_or_shares" value="' +  text + '">')
                    }
                    // else{

                    //     $(this).html ('<input type="text" value="' +  text + '">')
                    // }
                } else{

                    $(this).html ('<button data-id="'+data_id+'" class="button-save">Save</button>')
                }
            })
        }
    })

    $(document).on("click", ".button-save",function(){
        var tr = $(this).parent().parent();
        let data_id = $(this).attr('data-id');
        let asso_info = {};

        tr.find("td").each(function(){
            if (!$(this).hasClass("td-button"))
            {
                var text = $(this).find("input").val();

                $(this).find("input").each(function(){
                    var attr = $(this).attr('name');
                    if (typeof attr !== 'undefined' && attr !== false) {
                    // console.log($(this).attr('name'));
                    asso_info[$(this).attr('name')] = $(this).val()
                    }

                })
                $(this).text(text)
            } else
                $(this).html('');
        })
        associaiton_info_update(asso_info, data_id)
        // console.log(asso_info);
    })

    function associaiton_info_update(data, id){
        $.ajax({
            url:"{{url('admin/member-management/associators-info/update')}}/"+id,
            method:'POST',
            data:data,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success:function(response){
                if($.trim(response) != '' && response.status == 'success'){
                    toastr.options =
                    {
                        "closeButton": true,
                        "progressBar": true,
                        "timeOut": 2000
                    }
                    toastr.success('Data Updated Successfully');
                }
                // console.log(response);
            },
            error: function(xhr, status, error) {
            var err = JSON.parse(xhr.responseText);
            toastr.options =
            {
                "closeButton": true,
                "progressBar": true,
                "timeOut": 2000
            }
            toastr.error(err.message);
            }
        });
    }

</script>

@endpush
@endsection

