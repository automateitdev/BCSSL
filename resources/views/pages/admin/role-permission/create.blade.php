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
                <form action="{{ route('admin.roles.store') }}" method="post">
                    @csrf
                    <div class="col-lg-12">
                        <div class="form-group row">
                            <label for="name" class="col-lg-2 col-sm-12 col-form-label">Role Name <span class="text-danger">*</span></label>
                            <div class="col-lg-6 col-sm-12">
                                <input type="text" id="name" value="{{ old('name') }}" class="form-control" name="name" placeholder="Enter role name" autofocus required>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead class="thead-light">
                                      <tr>
                                        <th scope="col" width="50%">Feature</th>
                                        <th scope="col" width="12%">
                                            View
                                            <input type="checkbox" id="View_all"  >
                                        </th>
                                        <th scope="col" width="12%">Add   <input type="checkbox" id="Add_all"  > </th>
                                        <th scope="col" width="12%">Edit <input type="checkbox" id="Edit_all"  ></th>
                                        <th scope="col" width="12%">Delete <input type="checkbox" id="Delete_all"  ></th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($permissions as $permission)
                                            @if($permission->parent_id == null)
                                                <tr>
                                                    <td colspan="5">{{ $permission->name }}</td>
                                                </tr>
                                                @if(count($permission->children) > 0)
                                                    @foreach ($permission->children as $permission_children)
                                                        <tr>
                                                            <td> => {{ $permission_children->name }}</td>
                                                            {{-- @if(count($permission_children->children) > 0) --}}
                                                                @foreach(['View','Add','Edit','Delete'] as $key => $value)
                                                                    @php
                                                                        $haveCheck = 0;
                                                                        $subchildId='';
                                                                        $type = '';
                                                                    @endphp
                                                                       @foreach ($permission_children->children as $key_sub_chilren => $sub_children)
                                                                                @if(str_contains($sub_children->name, $value))
                                                                                    @php
                                                                                        $haveCheck = 1;
                                                                                        $subchildId =  $sub_children->id;
                                                                                        $type = $value;
                                                                                        break;
                                                                                    @endphp
                                                                                @endif
                                                                        @endforeach
                                                                        @if($haveCheck == 1)
                                                                        <td class="text-center">
                                                                            <input type="checkbox"
                                                                            class="{{$type}}"
                                                                            name="permissions[]" value="{{$permission_children->children->where('id',$subchildId)->first()->name }}">
                                                                        </td>
                                                                        @else
                                                                        <td></td>
                                                                        @endif
                                                                @endforeach

                                                            {{-- @endif --}}

                                                        </tr>

                                                    @endforeach
                                                @endif
                                            @endif
                                        @endforeach



                                    </tbody>
                                  </table>
                            </div>
                        </div>





                        <div class="form-group">
                            <div>
                                <button class="btn btn-primary waves-effect waves-lightml-2" type="submit">
                                    <i class="fa fa-save"></i> Submit
                                </button>
                                <a class="btn btn-secondary waves-effect" href="{{ route('admin.roles.index') }}">
                                    <i class="fa fa-times"></i> Cancel
                                </a>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('style')

@endpush
@push('script')

@endpush
@endsection

