<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pralon - @yield('title', 'Admin')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{asset('60.png')}}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/vendor/nucleo/css/nucleo.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/css/argon.css?v=1.2.0')}}" type="text/css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    @include('timeline.kanban.navbar')
    <input type="hidden" id="authId" value="{{auth()->user()->id}}">
    @yield('content')
 
    <script src="{{asset('assets/vendor/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/vendor/js-cookie/js.cookie.js')}}"></script>
    <script src="{{asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js')}}"></script>
    <script src="{{asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0/dist/chart.min.js"></script>


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
  <style>
    body{
        /* background-color: #35374B !important; */
        /* background-color: #61677A !important; */
        background-image:url('{{ asset('bg-kanban-1.png')}}');
        /* background-image:url('{{ asset('men.jpg')}}'); */
        &::after {
            content: '';
            opacity: 3.8;
            position: cover;
            background-image: url('https://images.unsplash.com/photo-1503602642458-232111445657?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=bf884ad570b50659c5fa2dc2cfb20ecf&auto=format&fit=crop&w=1000&q=100');
        }
        background-size: cover;
        font-family: Poppins;
    }
    .bg-1{
        background-color: #7B113A ;
        color: white;
    }
    .bg-2{
        background-color: #7B113A ;
        color: white;
    }
    .bg-3{
        background-color: #7B113A ;
        color: white;
    }
    .bg-4{
        background-color: #7B113A ;
        color: white;
    }
    .b-head{
        font-size: 12px !important;
        color: white;

    }
    .radius{
        border-radius: 50%;
        background-color: #35374B;
    }
    .card-parent{
        border-radius: 20px  !important;
    }
    .card-child{
        border-radius: 10px  !important;
        background: #31363F;
        color: white;
    }
    .card-parent-footer{
        border-radius: 0px 0px 20px 20px !important;
        color: white;
    }
    .kanban-cards{
      max-height: 500px !important;
      overflow-y: auto !important; 
    }
</style>

<style>
       .selectOption2{
        font-size:9px;
    }
    .datatable-bordered{
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100% !important;
  font-size: 9px;
  overflow-x:auto !important;
  
  }
  .nav-sidebar{
    overflow-y: auto;
  }
  .dataTables_filter input { width: 300px }
  .datatable-bordered td, .datatable-bordered th {
  padding: 8px;
  }
  .datatable-bordered tr:nth-child(even){background-color: #f2f2f2;}

  .datatable-bordered tr:hover {background-color: #ddd;}
  .countMoney{
    text-align: end
  }
  .datatable-bordered th {
  border: 1px solid #ddd;
  padding-top: 10px;
  padding-bottom: 10px;
  text-align: center;
  background-color: white;
  color: black;
  overflow-x:auto !important;
  }
    ion-icon
        {
        zoom: 1.5;
        margin:auto
        }
    .select2{
        width: 100% !important;
        font-size:9px;
    }
    .select2-selection__rendered {
        line-height: 25px !important;
        font-size:9px;
    
    }
    .select2-container .select2-selection--single {
        height: 35px !important;
        font-size:9px;
    }
    .select2-selection__arrow {
        height: 34px !important;
        font-size:9px;
    }

    .dataTables_scrollHeadInner, .table{
        width:100%!important; 
        font-size:9px;
    }
    p{
    font-size: 12px !important;
    color: #cacaca !important;
    }
    .open\:bg-green-200[open] {
    --tw-bg-opacity: 1;
    background-color: rgb(187 247 208 / var(--tw-bg-opacity));
    }
    .open\:bg-red-600[open] {
    --tw-bg-opacity: 1;
    background-color: rgb(220 38 38 / var(--tw-bg-opacity));
    }
    .open\:bg-red-200[open] {
    --tw-bg-opacity: 1;
    background-color: rgb(254 202 202 / var(--tw-bg-opacity));

    }
    .open\:bg-amber-200[open] {
    --tw-bg-opacity: 1;
    background-color: rgb(253 230 138 / var(--tw-bg-opacity));
    }
    th.details-control {
    background-color: #04AA6D;
    color: white;
    }
    td.details-control {
    background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
    cursor: alias;
    }
    tr.shown td.details-control {
        background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
    }

    td.details-click {
        background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
        cursor: alias;
    }
    tr.shown td.details-click {
        background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
    }

    th.subdetails-control {
    background-color: #04AA6D;
    color: white;
    }
    td.subdetails-control {
    background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
    cursor: alias;
    }
    tr.shown td.subdetails-control {
        background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
    }

    td.subdetails-click {
        background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
        cursor: alias;
    }
    tr.shown td.subdetails-click {
        background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
    }
    .rating {
    position: relative;
    width: 180px;
    background: transparent;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: .3em;
    padding: 5px;
    overflow: hidden;
    border-radius: 20px;
    box-shadow: 0 0 2px #b3acac;
    }

    .rating__result {
    position: absolute;
    top: 0;
    left: 0;
    transform: translateY(-10px) translateX(-5px);
    z-index: -9;
    font: 3em Arial, Helvetica, sans-serif;
    color: #ebebeb8e;
    pointer-events: none;
    }

    .rating__star {
    font-size: 1.3em;
    cursor: pointer;
    color: #dabd18b2;
    transition: filter linear .3s;
    }

    .rating__star:hover {
    filter: drop-shadow(1px 1px 4px gold);
    }
    .datatable-stepper{
    /* font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    font-size: 12px;
    overflow-x:auto !important; */
    width: 100% !important;
    font-family: Poppins;
    border-collapse: collapse;
    border-spacing: 0;
    font-size: 9px;
    width: 100% !important;
    border: 1px solid #ddd;
    
    }
    .datatable-stepper tr:nth-child(even){background-color: #f2f2f2;}

    .datatable-stepper tr:hover {background-color: #ddd;}

    .datatable-stepper th {
    border: 1px solid #ddd;
    padding-top: 10px;
    padding-bottom: 10px;
    text-align: center;
    
    color: black;
    overflow-x:auto !important;
    }
    .datatable-stepper td, .datatable-stepper th {
            border: 1px solid #ddd;
            padding: 8px;
        
        }
    .headerTitle{
        font-size: 14px;

    }
        fieldset.scheduler-border {
            border: 1px groove #ddd !important;
            padding: 0 1.5em 1.5em 1.5em !important;
            margin: 0 0 1.5em 0 !important;
            -webkit-box-shadow:  0px 0px 0px 0px #000;
                    box-shadow:  0px 0px 0px 0px #000;
        }

        legend.scheduler-border {
        font-size: 12px !important;
        font-weight: bold !important;
        text-align: left !important;
    }
        .legend1
        {
        margin-bottom:0px;
        margin-left:16px;
        }
        .btnAction  {
        appearance: none;
        backface-visibility: hidden;
        background-color: #27ae60;
        border-radius: 8px;
        border-style: none;
        box-shadow: rgba(39, 174, 96, .15) 0 4px 9px;
        box-sizing: border-box;
        color: #fff;
        cursor: pointer;
        display: inline-block;
        font-family: Inter,-apple-system,system-ui,"Segoe UI",Helvetica,Arial,sans-serif;
        font-size: 16px;
        font-weight: 600;
        letter-spacing: normal;
        line-height: 1.5;
        outline: none;
        overflow: hidden;
        padding: 13px 20px;
        position: relative;
        text-align: center;
        text-decoration: none;
        transform: translate3d(0, 0, 0);
        transition: all .3s;
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
        vertical-align: top;
        white-space: nowrap;
        }

        .btnAction :hover {
        background-color: #1e8449;
        opacity: 1;
        transform: translateY(0);
        transition-duration: .35s;
        }

        .btnAction :active {
        transform: translateY(2px);
        transition-duration: .35s;
        }

        .btnAction :hover {
        box-shadow: rgba(39, 174, 96, .2) 0 6px 12px;
        }
        .myFont{
        font-size:9px !important
        }
        .bg-core {
        background-color: #213555 !important;
        color: white;
        }
        .desk {
        display: flex;
        justify-content: center;
        }
            
        .cursor-grab {
        cursor: -webkit-grab;
        cursor: grab;
        }

        .tasks {
        min-height: 450px;
        }
       
        .mask-custom {
            background: rgba(24, 24, 16, .2);
            border-radius: 2em;
            backdrop-filter: blur(15px);
            border: 2px solid rgba(255, 255, 255, 0.05);
            background-clip: padding-box;
            box-shadow: 10px 10px 10px rgba(46, 54, 68, 0.03);
        }
        .gu-mirror {
            position: fixed !important;
            margin: 0 !important;
            z-index: -1 !important;
            opacity: 0.8;
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=80)";
            filter: alpha(opacity=80);
        }
        .gu-hide {
            display: none !important;
        }
        .gu-unselectable {
            -webkit-user-select: none !important;
            -moz-user-select: none !important;
            -ms-user-select: none !important;
            user-select: none !important;
        }
        .gu-transit {
            opacity: 0.2;
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=20)";
            filter: alpha(opacity=20);
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
      background-color:#EEEEEE;
      padding: 5px;
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
  .toast-message{
    font-size: 9px !important;
    font-family: Poppins !important;
    font-weight: bold !important
  }
  legend {
    /* background-color: #76ABAE; */
    color: #fff;
    /* color:black; */
    margin-top:-20px;
    margin-left: auto;
    margin-right: auto;
    min-width: 10%;
    max-width : 40%;
    padding-right: 20px !important;
    font-size: 12px !important;
    }
    .legend1 {
        border: 1px solid #35374B; /* Adding border */
        padding: 10px; /* Adding padding for spacing */
        margin: 20px; /* Adding margin for spacing */
    }
    .legend1 legend {
        display: inline; /* Making the legend display inline */
    }

  .dataTables_wrapper .dataTables_paginate .paginate_button
    {
        width: 40px !important;
        font-size: 9px !important;
    }
    .dataTables_scroll{
      width: 100% !important;
    }
    .fa-arrow-right{
      color: #008DDA;
    }
    .fa-arrow-left{
      color: #008DDA;
    }
    
</style>

<style>
.flex-wrapper {
  display: flex;
  flex-flow: row nowrap;
}

.single-chart {
  width: 33%;
  justify-content: space-around ;
}

.circular-chart {
  display: block;
  margin: 10px auto;
  max-width: 100%;
  min-width: 100px !important;
  max-height: 250px;
}

.circle-bg {
  fill: none;
  stroke: #eee;
  stroke-width: 3.8;
}

.circle {
  fill: none;
  stroke-width: 2.8;
  stroke-linecap: round;
  animation: progress 1s ease-out forwards;
}

@keyframes progress {
  0% {
    stroke-dasharray: 0 100;
  }
}

.circular-chart.orange .circle {
  stroke: #ff9f00;
}

.circular-chart.green .circle {
  stroke: #4CC790;
}

.circular-chart.blue .circle {
  stroke: #3c9ee5;
}
.circular-chart.red .circle {
  stroke: #FF204E;
}

.percentage {
  /* fill: #666; */
  fill: white;

  font-family: sans-serif;
  font-size: 0.5em;
  text-anchor: middle;
}

#addCardModal{
  overflow-y : auto;
}
.custom-select{
  width: 50px !important;
  /* margin-top:10px !important; */
}
.dataTables_length label{
  margin-top:10px !important;
}
.paging_simple_numbers{
  float: right !important;
}
.message {
    transition: opacity 0.5s ease;
}

.fade-out {
    opacity: 0;
}
</style>
  </html>