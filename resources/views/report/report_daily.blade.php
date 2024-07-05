<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
  
    <title>Daily Report {{$name}}</title>
</head>
<body>
    <div class="container" style="text-align:center">
        <p style="font-size:10px;margin-top:-10px">
            <b style="font-size:14px">Daily Activity</b> <br>
        </p>
       <br>
    </div>
    <p style="font-size:10px"> Date : {{date('d F Y')}}</p>
    <p style="font-size:10px"> Name : {{$name}}</p>
    <p style="font-size:10px">
        <b>Activity :</b>
    </p>
   

    <p style="font-size:10px">
    </p>
    <table class="table-stepper">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($log as $item)
           @php
               $status = $item->status == 1 ? 'On Progress' : 'DONE';
               $remark = str_replace(['<b>', '</b>'],'', $item->remark);
           @endphp
            <tr>
                <td style="text-align: left;width:25%"><p>{{$item->name}}</p></td>
                <td style="text-align: left"><p>{{$remark}}</p></td>
                <td style="text-align: left;width:10%"><p>{{$status}}   </p></td>
            </tr>
          
      @empty
              <tr>
                  <td colspan="5">
                      Data is empty
                  </td>
              </tr>
      @endforelse
        </tbody>
    </table>
</body>
</html>
<style>
      .table-stepper{
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        border-spacing: 0;
        font-size: 9px;
        width: 100% !important;
        border: 1px solid #ddd;
        
  }
    .table-stepper tr:nth-child(even){background-color: #f2f2f2;}

    .table-stepper tr:hover {background-color: #ddd;}

    .table-stepper th {
        border: 1px solid #ddd;
        padding-top: 10px;
        padding-bottom: 10px;
        font-size: 9px;
        text-align: center;
        background-color: #26577C;
        color: white;
        overflow-x:auto !important;
    }
    .table-stepper td, .datatable-stepper th {
        border: 1px solid #ddd;
        padding: 8px;
       
    }
    table tr:last-child {
        font-weight: bold;  
    }







    .table-general{
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        border-spacing: 0;
        font-size: 9px;
        width: 100% !important;
        border: 1px solid #ddd;
        
  }
    .table-general tr:nth-child(even){background-color: #f2f2f2;}

    .table-general tr:hover {background-color: #ddd;}

    .table-general th {
        border: 1px solid  rgb(182, 181, 181);
        padding-top: 5px;
        font-size: 9px;
        padding-bottom: 5px;
        text-align: center;
        /* background-color: #D61355; */
        color: rgb(123, 121, 121);
        overflow-x:auto !important;
    }
    .table-general td, .datatable-general th {
        /* border: 1px solid #ddd; */
        padding: 8px;
       
    }
    table tr:last-child {
        font-weight: bold;  
    }
</style>