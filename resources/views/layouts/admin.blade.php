<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Argon Dashboard - Free Dashboard for Bootstrap 4</title>
  <link rel="icon" href="{{asset('assets/img/brand/favicon.png')}}" type="image/png">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <link rel="stylesheet" href="{{asset('assets/vendor/nucleo/css/nucleo.css')}}" type="text/css">
  <link rel="stylesheet" href="{{asset('assets/css/argon.css?v=1.2.0')}}" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  {{-- Customization --}}
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  {{-- Customization --}}
  <style>
    @import url('https://fonts.cdnfonts.com/css/poppins');
    html {
        font-family: Poppins !important;
        line-height: 1.15;
        -webkit-text-size-adjust: 100%;
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        }
        .datatable-stepper{
        font-family: Poppins;
        border-collapse: collapse;
        border-spacing: 0;
        font-size: 9px;
        width: 100% !important;
        /* border: 1px solid #ddd; */
        }
        .datatable-stepper tr:nth-child(even){background-color: #f2f2f2;}

        .datatable-stepper tr:hover {background-color: #ddd;}

        .datatable-stepper th {
        /* border: 1px solid #ddd; */
        padding-top: 10px;
        padding-bottom: 10px;
        text-align: center;
        
        color: black;
        overflow-x:auto !important;
        }
        .datatable-stepper td, .datatable-stepper th {
              /* border: 1px solid #ddd; */
              padding: 8px;
          }
          p{
            font-size: 9px !important;
          }
          .form-control{
            height: 30px;
            font-size: 9px !important;
          }
          .select2{
              width: 100% !important;
              font-size:9px;
          }
          .select2-selection__rendered {
              line-height: 30px !important;
              margin-top:-7px;
              font-size:9px;
          }
          .select2-container .select2-selection--single {
              height: 35px !important;
              font-size:9px;
          }
          .modal {
            overflow-y:auto !important;
          }
          .select2-selection__arrow {
              height: 34px !important;
              font-size:9px;
          }
          .dataTables_length, .dataTables_length select{ font-size: 9px !important;}
          .dataTables_info{
            font-size: 9px !important;
          }
          .dataTables_filter{
            font-size: 9px !important;
          }
          .select2-dropdown{
            font-size: 9px !important;
          }
          .selectOption2{
            font-size: 9px !important;
          }
          .select2-dropdown--below{
            font-size: 9px !important;
          }
          .select2-results__option{
            font-size: 9px !important;
          }
          .select2-search__field{
            height: 35px !important;
            font-size: 9px !important;
          }
          .title-head{
            font-size: 14px !important;
            font-weight:bold
          }

  </style>
</head>

<body>
  <!-- Sidenav -->
    @include('layouts.sidebar')
  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Topnav -->
    @include('layouts.navbar')
    <!-- Main Content -->
    <div class="mt-4">
        @yield('content')
    </div>
    <!-- Main Content -->
  
  </div>
  <!-- Argon Scripts -->

  <script src="{{asset('assets/vendor/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/vendor/js-cookie/js.cookie.js')}}"></script>
  <script src="{{asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js')}}"></script>
  <script src="{{asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js')}}"></script>

    <!-- Core -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!-- Core -->
  <!-- Argon JS -->
  <script src="{{asset('assets/js/argon.js?v=1.2.0')}}"></script>
  <script>
     $(document).ready(function(){
                $(".select2").select2();
                $('.select2').select2({ dropdownCssClass: "selectOption2" });
                $.ajaxSetup({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                })
                // $('.summernote').summernote({
                //     tabsize: 2,
                //     height: '270px',
                //     toolbar: [
                //     ['style', ['style']],
                //     ['font', ['bold', 'underline', 'clear']],
                //     ['color', ['color']],
                //     ['para', ['ul', 'ol', 'paragraph']],
                //     ['table', ['table']],
                //     ['insert', ['link', 'picture', 'video']],
                //     ['view', ['fullscreen', 'codeview', 'help']]
                //     ],
                //     fontSizes: ['11']
                // });

                var url = window.location;
              // for sidebar menu entirely but not cover treeview
              $('ul.navbar-nav a').filter(function() {
                  return this.href == url;
              }).addClass('active');
          
              // for treeview
              $('ul.nav-sm a').filter(function() {
                  return this.href == url;
              }).parentsUntil(".nav-sidebar > .navbar-nav").addClass('show').prev('a').addClass('active');
          
            });
            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-bottom-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            function SwalLoading(html = 'Loading ...', title = '') {
              return Swal.fire({
                  title: title,
                  html: html,
                  customClass: 'swal-wide',
                  timerProgressBar: true,
                  allowOutsideClick: false,
                  didOpen: () => {
                      Swal.showLoading()
                  }
              });
          }
       
          $(".select2").select2({ width: '300px', dropdownCssClass: "bigdrop" });
  </script>
  @include('helper.helper')
  @stack('custom-js')
</body>
</html>