<x-layouts.app-master  >

    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="card">
                @php
                    $active = false;
                    $active_two = false;
                    if (empty(Session::get('navtab'))) {
                        $active = true;
                    }
                    if (!empty(Session::get('navtab')) && Session::get('navtab') == 'pills-login-tab') {
                        $active = true;
                    } elseif (!empty(Session::get('navtab')) && Session::get('navtab') == 'pills-reg-tab') {
                        $active_two = true;
                    }

                    if ($active) {
                        $class_name = 'active';
                    } else {
                        $class_name = '';
                    }
                    if ($active_two) {
                        $class_name_two = 'active';
                    } else {
                        $class_name_two = '';
                    }
                @endphp
                <div class="card-header">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $class_name }}" id="pills-login-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-login" type="button" role="tab"
                                aria-controls="pills-login" aria-selected="true">Login</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $class_name_two }}" id="pills-reg-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-reg" type="button" role="tab" aria-controls="pills-reg"
                                aria-selected="false">Registration</button>
                        </li>
                    </ul>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                @endif
                <div class="card-body">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade {{ 'show ' . $class_name }}" id="pills-login" role="tabpanel"
                            aria-labelledby="pills-login-tab">

                            <form method="POST" action="{{route('member.login')}}">
                                @csrf
                                <input type="hidden" value="pills-login-tab" name="nav_tab">
                                <div class="row mb-3">
                                    <label for="email"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="text"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password" required autocomplete="current-password">

                                            <span class="input-group-text" onclick="togglePasswordVisibility()" style="cursor: pointer">
                                                <i class="fa fa-eye" id="togglePasswordIcon"></i>
                                            </span>
                                        </div>


                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember"
                                                id="remember" {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Login') }}
                                        </button>

                                        @if (Route::has('password.request'))
                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade {{ 'show ' . $class_name_two }}" id="pills-reg" role="tabpanel"
                            aria-labelledby="pills-reg-tab">
                            {{-- {{$user_gender}} --}}
                            <member-register :user-gender="{{$user_gender}}" :user-blood-group="{{ $user_blood_group }}"/>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById("password");
            const icon = document.getElementById("togglePasswordIcon");

            const isPassword = passwordInput.type === "password";
            passwordInput.type = isPassword ? "text" : "password";
            icon.classList.toggle("fa-eye");
            icon.classList.toggle("fa-eye-slash");
        }
    </script>
</x-layouts.app-master  >
