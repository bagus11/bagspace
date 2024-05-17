@extends('layouts.admin')
@section('title', 'Monitoring Timeline')
@section('content')

<nav aria-label="breadcrumb" class="mx-3" style="font-size: 12px !important;">
  <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
  <li class="breadcrumb-item"> <i class="ni ni-ruler-pencil text-danger"></i> Timeline Project</li>
  <li class="breadcrumb-item" aria-current="page"><i class="ni ni-atom"></i> Monitoring Timeline</li>
  </ol>
</nav>
<div class="row justify-content-center mx-1">
  <div class="col-md-12">
      <div class="card p-0">
          <div class="card-header pb-0">
            <div class="row">
              <div class="col-3">
                <p class="title-head">Project List</p>
              </div>
              <div class="col-9">
                <button class="btn btn-sm btn-success" id="btn_add_ticket" style="float: right"   data-toggle="modal" data-target="#addTimelineHeader">
                  <i class="fas fa-plus"></i>
                </button>
                <button class="btn btn-sm btn-info mr-1" id="btnRefresh" style="float: right">
                  <i class="fa-solid fa-arrows-rotate"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="card-body p-0">
        
              <table class="datatable-stepper" id="timeline_header_table">
                  <thead class="thead-light">
                      <tr>
                          <th scope="col" class="sort" style="text-align: center" data-sort="request_code">Request Code</th>
                          <th scope="col" class="sort" style="text-align: center" data-sort="type">Type</th>
                          <th scope="col" class="sort" style="text-align: center" data-sort="team">Team</th>
                          <th scope="col" class="sort" style="text-align: center" data-sort="name">Name</th>
                          <th scope="col" class="sort" style="text-align: center" data-sort="status">Status</th>
                          <th scope="col" class="sort" style="text-align: center" data-sort="action">Action</th>
                      </tr>
                  </thead>
              </table>
          </div>
          <div class="card-footer">

          </div>
        </div>
  </div>

</div>
<div class="container">
  <div id="chart_div" hidden></div>
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['gantt']});
  google.charts.setOnLoadCallback(drawChart);

  function daysToMilliseconds(days) {
    return days * 24 * 60 * 60 * 1000;
  }

  function drawChart() {

    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Task ID');
    data.addColumn('string', 'Task Name');
    data.addColumn('date', 'Start Date');
    data.addColumn('date', 'End Date');
    data.addColumn('number', 'Duration');
    data.addColumn('number', 'Percent Complete');
    data.addColumn('string', 'Dependencies');

    data.addRows([
      ['Research', 'Analisa',
       new Date(2015, 0, 1), new Date(2015, 0, 5), null,  100,  null],
      ['Write', 'Design',
       null, new Date(2015, 0, 9), daysToMilliseconds(3), 25, 'Research,Outline'],
      ['Cite', 'Development',
       null, new Date(2015, 0, 7), daysToMilliseconds(1), 20, 'Research'],
      ['Complete', 'UAT',
       null, new Date(2015, 0, 10), daysToMilliseconds(1), 0, 'Cite,Write'],
      ['Outline', 'Deployment',
       null, new Date(2015, 0, 6), daysToMilliseconds(1), 100, 'Research']
    ]);

    var options = {
      height: 275
    };

    var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

    chart.draw(data, options);
  }
</script>
@include('timeline.monitoring_timeline.modal.botTimeline')
@include('timeline.monitoring_timeline.modal.add-timeline_header')
@include('timeline.monitoring_timeline.modal.detail-timeline')
@include('timeline.monitoring_timeline.modal.edit-timeline')
@endsection
@push('custom-js')
    @include('timeline.monitoring_timeline.monitoring_timeline-js')
@endpush
