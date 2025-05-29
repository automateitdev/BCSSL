@extends('layouts.admin.admin-master')

@section('page_title',get_page_meta('title', true))

@section('content')
    <div id="bcs">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2 class="mb-25">
                        <a href="#">{{get_page_meta('title', true)}}</a>
                        <!-- <button type="button" class="btn btn-default btn-rounded print pull-right" data-bs-toggle="modal" data-bs-target="#basicsModal">+ Add Information</button> -->
                    </h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            {{-- <user-create :user-gender="{{$user_gender}}" /> --}}
                            <form data-parsley-validate action="{{route('admin.users.store')}}" method="POST" enctype="multipart/form-data" id="form" >
                                @csrf
                                <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="name"
                                                    name="name"
                                                    value="{{ old('name') }}"
                                                    required
                                                />
                                                @error('name')
                                                    <p class="error">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="gender">Gender</label>
                                                <select class="form-control" id="gender" name="gender">
                                                    <option selected="selected" disabled>
                                                        Choose One
                                                    </option>
                                                   @foreach ($user_gender as $gender )
                                                       <option value="{{$gender}}" {{ old('gender') == $gender ? 'selected': '' }}>{{$gender}}</option>
                                                   @endforeach
                                                </select>
                                                @error('gender')
                                                    <p class="error">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="mobile" class="col-md-12">Mobile</label>
                                                <input
                                                    type="text"
                                                    class="form-control col-md-12"
                                                    id="mobile"
                                                    name="mobile"
                                                    value="{{ old('mobile') }}"
                                                />
                                                @error('mobile')
                                                    <p class="error">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="nid">Nid</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="nid"
                                                    name="nid"
                                                    value="{{ old('nid') }}"
                                                />
                                                @error('nid')
                                                    <p class="error">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="user_img"
                                        >Image <span>*</span></label
                                    >
                                    <input
                                        type="file"
                                        type="file" id="imgInp" name="image" accept="image/*"

                                    />
                                    <img
                                        src="{{asset('assets/images/dummy_pp_image.jpg')}}"
                                        alt=""
                                        class="img-fluid"
                                        style="height: 250px; width: 250px"
                                        id="uploadPreview"
                                    />

                                </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label"
                                                >Email <span>*</span></label
                                            ><svg width="16" height="16"></svg>
                                            <input
                                                type="email"
                                                class="form-control"
                                                id="email"
                                                name="email"
                                                value="{{ old('email') }}"
                                                required
                                            />
                                            @error('email')
                                                <p class="error">{{ $message }}</p>
                                            @enderror

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="password" class="form-label"
                                                >Password <span>*</span></label
                                            ><svg width="16" height="16"></svg>
                                            <input
                                                type="password"
                                                class="form-control"
                                                id="password"
                                                name="password"
                                                value="{{ old('password') }}"
                                                required
                                            />
                                            @error('password')
                                                <p class="error">{{ $message }}</p>
                                            @enderror

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label"
                                                >Status <span>*</span></label
                                            >
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="" selected disabled>Select One</option>
                                                @foreach ($user_status as $status )

                                                <option value="{{$status}}">{{$status}}</option>
                                                @endforeach

                                            </select>
                                                @error('status')
                                                    <p class="error">{{ $message }}</p>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="role" class="form-label"
                                                >Roles <span>*</span></label
                                            >
                                            <select class="form-control js-example-basic-single" id="role" name="roles[]" multiple required>
                                                @foreach ($roles as $role )

                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endforeach

                                            </select>
                                            @error('status')
                                                    <p class="error">{{ $message }}</p>
                                                @enderror
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>


@endsection
@push('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{asset('plugins/parsleyjs/parsley.css')}}">
<style>
    .iti__flag-container{
        margin-left: 2%;
    }
</style>
@endpush
@push('script')
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
{{-- //parsleyjs --}}
<script src="{{ asset('plugins/parsleyjs/parsley.min.js') }}"></script>
<script>
     $('#form').parsley();
  var input = document.querySelector(".phone");
  window.intlTelInput(input, {
    utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js",
  });

  $('.js-example-basic-single').select2();

</script>
@endpush
