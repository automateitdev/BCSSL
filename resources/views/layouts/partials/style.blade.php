{{-- <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico"> --}}
<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css')}}">
<link rel="stylesheet" href="{{ asset('assets/css/metisMenu.css')}}">
{{-- <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css')}}"> --}}
<link rel="stylesheet" href="{{ asset('assets/css/slicknav.min.css')}}">
<!-- amchart css -->
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<!-- others css -->
<link rel="stylesheet" href="{{ asset('assets/css/typography.css')}}">
<link rel="stylesheet" href="{{ asset('assets/css/default-css.css')}}">
<link rel="stylesheet" href="{{ asset('assets/css/styles.css')}}">
<link rel="stylesheet" href="{{ asset('assets/css/responsive.css')}}">
<!-- modernizr css -->
<script src="{{ asset('assets/js/vendor/modernizr-2.8.3.min.js')}}"></script>
 <!-- Styles -->
 <link href="{{ asset('css/app.css') }}" rel="stylesheet">

 <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.min.css') }}">
 <link rel="stylesheet" href="{{asset('assets/plugins/toastr/toastr.min.css')}}">

@stack('style')
