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
                            <form data-parsley-validate action="{{route('admin.settings.store')}}" method="POST" enctype="multipart/form-data" id="form" >
                                @csrf
                                <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">Name  <span>*</span></label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="name"
                                                    name="name"
                                                    value="{{ getSetting('name') ?? old('name') }}"
                                                    required
                                                />
                                                @error('name')
                                                    <p class="error">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="address">Address  <span>*</span></label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="address"
                                                    name="address"
                                                    value="{{ getSetting('address') ?? old('address') }}"
                                                    required
                                                />
                                                @error('address')
                                                    <p class="error">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="mobile" class="col-md-12">Mobile  <span>*</span></label>
                                                <input
                                                    type="text"
                                                    class="form-control phone col-md-12"
                                                    id="mobile"
                                                    name="mobile"
                                                    value="{{ getSetting('mobile') ?? '+880' }}"
                                                    required
                                                />
                                                @error('mobile')
                                                    <p class="error">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="tax">Tax</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="tax"
                                                    name="tax"
                                                    value="{{ getSetting('tax') ?? old('tax') }}"
                                                    required
                                                />
                                                @error('tax')
                                                    <p class="error">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="user_img"
                                        >Site Logo </label
                                    >
                                    <input
                                        type="file"
                                        type="file" id="imgInp" name="image" accept="image/*"


                                    />
                                    {{-- <img
                                        src="{{asset('assets/images/dummy_pp_image.jpg')}}"
                                        alt=""
                                        class="img-fluid"
                                        style="height: 250px; width: 250px"
                                        id="uploadPreview"
                                    /> --}}

                                    <img
                                        src="{{!is_null(getSetting('image')) ? get_storage_image('setting',getSetting('image')) : asset('assets/images/dummy_pp_image.jpg')}}"
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
                                                >Email </label
                                            ><svg width="16" height="16"></svg>
                                            <input
                                                type="email"
                                                class="form-control"
                                                id="email"
                                                name="email"
                                                value="{{ getSetting('email') ?? old('email') }}"

                                            />
                                            @error('email')
                                                <p class="error">{{ $message }}</p>
                                            @enderror

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="password" class="form-label"
                                                >BIN/ TIN Number</label
                                            ><svg width="16" height="16"></svg>
                                            <input
                                                type="password"
                                                class="form-control"
                                                id="password"
                                                name="password"
                                                value="{{ getSetting('password') ?? old('password') }}"
                                                required
                                            />
                                            @error('password')
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
