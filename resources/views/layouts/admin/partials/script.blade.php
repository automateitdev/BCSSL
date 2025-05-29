 <!-- Scripts -->
 <script src="{{ asset('js/app.js') }}"></script>
<!-- jquery latest version -->
 <script src="{{ asset('assets/js/vendor/jquery-2.2.4.min.js')}}"></script>

 <!-- bootstrap 4 js -->
 <script src="{{ asset('assets/js/popper.min.js')}}"></script>
 <script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
 {{-- <script src="{{ asset('assets/js/owl.carousel.min.js')}}"></script> --}}
 <script src="{{ asset('assets/js/metisMenu.min.js')}}"></script>
 <script src="{{ asset('assets/js/jquery.slimscroll.min.js')}}"></script>
 <script src="{{ asset('assets/js/jquery.slicknav.min.js')}}"></script>


 <!-- others plugins -->
 <script src="{{ asset('assets/js/plugins.js')}}"></script>
 <script src="{{ asset('assets/js/scripts.js')}}"></script>

 <script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{asset('assets/plugins/toastr/toastr.min.js')}}"></script>

<script>
    toastr.options =
    {
        "closeButton": true,
        "progressBar": true,
        "timeOut": 2000
    }

    @if(Session::has('success'))
        toastr.success("{{ session('success') }}");
    @endif
    @if(Session::has('error'))
        toastr.error("{{ session('error') }}");
    @endif
    @if(Session::has('update'))
        toastr.info("{{ session('update') }}");
    @endif
    @if(Session::has('delete'))
    toastr.success("{{ session('delete') }}");
    @endif
    @if(Session::has('info'))
        toastr.info("{{ session('info') }}");
    @endif
    @if(Session::has('warning'))
        toastr.warning("{{ session('warning') }}");
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    @endif

    // Toaster notify
    const notify = (type, msg) => {
        if (type == 'success') {
            toastr.success(msg);
        } else {
            toastr.warning(msg);
        }
    }

    function showValidationError(err) {
        let error_string = '<div class="error-sa-v text-left">';
        for (const [key, value] of Object.entries(
        err.response.data.errors
        )) {
            error_string = error_string + value[0] + "<br>";

            if (value[1] != "undefined" && value[1] != undefined) {
                error_string = error_string + value[1] + "<br>";
            }
        }
        error_string = error_string + "<div>";

        Swal.fire({
            icon: "error",
            html: error_string,
        });
    }

    function showSomethingWrong() {
        Swal.fire({
            icon: "error",
            html: "<span>Something is wrong!</span>" + "<br>",
            showConfirmButton: true,
        });
    }

    const uploadFileCustom = (selector, type = "image") => {
        const file = $(`.${selector}`).filemanager(`${type}`);
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>


 @stack('script')
