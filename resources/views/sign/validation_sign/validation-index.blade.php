<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Pralon - @yield('title', 'Admin')</title>
  <link rel="icon" href="{{asset('61.png')}}" type="image/png">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <link rel="stylesheet" href="{{asset('assets/vendor/nucleo/css/nucleo.css')}}" type="text/css">
  <link rel="stylesheet" href="{{asset('assets/css/argon.css?v=1.2.0')}}" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  {{-- Customization --}}
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="{{ asset('assets/select2/select2.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sf-bootstrap-pincode-input@1.5.0/css/bootstrap-pincode-input.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
  
  

  {{-- <link href="{{ asset('assets/sweetalert2/sweetalert2.css') }}" rel="stylesheet"> --}}
  {{-- Customization --}}
  <style>
    @import url('https://fonts.cdnfonts.com/css/poppins');
    .message_error{
      font-size: 9px !important;
      color: red !important;
    }
    .nav-tabs .nav-link {
            font-size: 12px; 
            color: #45474B;
            font-weight: normal !important;
            height: 30px;
            background: #FCF8F3;
             border-top-left-radius: 0 !important;
            border-top-right-radius: 0 !important;
        }
        .nav-tabs .nav-link.active {
             color: white;
            border-color: transparent;
            background-color: #4793AF;
        }
        .nav-tabs .nav-link :hover{
          color: #F6995C !important;
          background-color: #4793AF;
        }
    .card-footer{
      border-bottom-right-radius: 15px;
      border-bottom-left-radius: 15px;
    }
    fieldset
    {
      /* max-width:500px; */
      padding:500px;	
    }
    .legend1
    {
      margin-bottom:0px;
      margin-left:16px;
    }
    label{
      font-family: Poppins !important;
      font-size: 12px !important;
    }
    .card{
      border-radius: 20px !important;
    }
    .card-header{
      border-radius: 20px 20px 0px 0px !important; 
    }
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
        text-align: center;
        color: white;
        /* color: black; */
        overflow-x:auto !important;
        background-color: #F6995C !important;
        padding: 10px;
          font-weight: bold;
        } 
    
        .datatable-stepper td {
              /* border: 1px solid #ddd; */
              padding: 5px;
          }
          p{
            font-size: 11px !important;
          }
          .form-control{
            height: 30px;
            font-size: 9px !important;
          }
          .select2{
              width: 100% !important;
              font-size:11px;
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
          #toast-container{
            font-size: 9px !important;
            font-family: Poppins !important;
            font-weight: bold !important
          }
          fieldset {
              border: 1px solid#ddd;
              font-family: Poppins !important;
             
              padding: 10px;
          }
       
          legend {
              font-size: 12px;
              padding: 0 10px;
          }
          .dataTables_wrapper .dataTables_paginate .paginate_button
            {
                width: 40px !important;
                font-size: 9px !important;
            }
            .dataTables_scroll{
              width: 100% !important;
            }
            .card.card-tabs .card-tools {
              margin: .3rem .5rem;
            }
            .card.card-outline-tabs .card-tools {
              margin: .5rem .5rem .3rem;
            }
            .card-header > .card-tools {
              float: right;
              margin-right: -0.625rem;
            }
            .card-header > .card-tools .input-group,
            .card-header > .card-tools .nav,
            .card-header > .card-tools .pagination {
              margin-bottom: -0.3rem;
              margin-top: -0.3rem;
            }
            .card-header > .card-tools [data-toggle='tooltip'] {
              position: relative;
            }
                    
            ::-webkit-scrollbar {
            width: 5px;
            }

            ::-webkit-scrollbar-track {
            box-shadow: inset 0 0 5px grey; 
            border-radius: 10px;
            }

            ::-webkit-scrollbar-thumb {
            background:#FF8A08; 
            border-radius: 10px;
            }

            ::-webkit-scrollbar-thumb:hover {
            background:#EEEDEB;
            }
  </style>
</head>

<body class="g-sidenav-show nav-open g-sidenav-pinned">
  <!-- Sidenav -->
  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Topnav -->
    {{-- @include('sign.layout.navbar-sign') --}}
    <!-- Main Content -->
    <div class="mt-2">
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
  <script src="{{ asset('assets/sweetalert2/sweetalert.min.js') }}"></script>
  <script src="{{ asset('assets/pdf/pdf.min.js') }}"></script>
  <script src="{{ asset('assets/select2/select2.full.min.js') }}"></script>
  {{-- <script src="{{ asset('assets/select2/select2.min.js') }}"></script> --}}
  <script src="{{ asset('assets/select2/select2.full.min.js') }}"></script>

    <!-- Core -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    {{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>  --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sf-bootstrap-pincode-input@1.5.0/js/bootstrap-pincode-input.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
    <!-- Core -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
  <!-- Argon JS -->
  <script src="{{asset('assets/js/argon.js?v=1.2.0')}}"></script>

  <script>
     $(document).ready(function(){
                $(".select2").select2();
                $('.select2').select2({ dropdownCssClass: "selectOption2" });
                $.ajaxSetup({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                })
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
  @stack('custom-js')
  @include('helper.helper')
</body>
</html>