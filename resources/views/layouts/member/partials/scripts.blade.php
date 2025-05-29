
<script>
    window.data = {!! json_encode([
        'base_url' => url('/'),
    ]) !!}
</script>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>

{{-- <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script> --}}
<script type="text/javascript"
src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.2/af-2.5.2/b-2.3.4/b-colvis-2.3.4/b-html5-2.3.4/b-print-2.3.4/cr-1.6.1/date-1.3.0/fc-4.2.1/fh-3.3.1/kt-2.8.1/r-2.4.0/rg-1.3.0/rr-1.3.2/sc-2.1.0/sb-1.4.0/sp-2.1.1/sl-1.6.0/sr-1.2.1/datatables.min.js" defer>
</script>
<link rel="stylesheet" type="text/css"
href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.2/af-2.5.2/b-2.3.4/b-colvis-2.3.4/b-html5-2.3.4/b-print-2.3.4/cr-1.6.1/date-1.3.0/fc-4.2.1/fh-3.3.1/kt-2.8.1/r-2.4.0/rg-1.3.0/rr-1.3.2/sc-2.1.0/sb-1.4.0/sp-2.1.1/sl-1.6.0/sr-1.2.1/datatables.min.css" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>



<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
{{-- <!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('lugins/jqvmap/maps/jquery.vmap.usa.js') }}p"></script> --}}
<!-- jQuery Knob Chart -->
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
{{-- <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script> --}}
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
{{-- <!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script> --}}
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
{{-- <script src="{{ asset('dist/js/demo.js') }}"></script> --}}
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{-- <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>

<script src="{{asset('js/global.js')}}"></script>

<script>
    $(document).ready(function() {
        if($('.single').length > 0){
            $('.single').select2();
        }

    });
</script>
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
