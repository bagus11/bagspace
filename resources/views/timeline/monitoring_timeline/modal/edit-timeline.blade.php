<div class="modal fade" id="editTimelineHeader" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header pb-0 ">
            <b style="font-size: 12px"class="ml-2">Form Update Project</b>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <fieldset class="legend1">
                <legend>General Transaction</legend>
                <input type="hidden" id="request_code_edit">
                <input type="hidden" id="team_id_edit">
                <input type="hidden" id="editId">
                <div class="row mx-2">
                    <div class="col-6 col-sm-6 col-md-2 mt-2">
                        <p>Request Code </p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 mt-2">
                        <p id="request_code_label_edit"></p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-2 mt-2">
                        <p>Project Name </p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 mt-2">
                        <p id="project_name_edit"></p>
                    </div>
                </div>
                <div class="row mx-2">
                    <div class="col-6 col-sm-6 col-md-2 mt-2">
                        <p>Start Date</p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4">
                        <input type="date" id="start_date_edit" class="form-control">
                    </div>
                    <div class="col-6 col-sm-6 col-md-2 mt-2">
                        <p>End Date</p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4">
                        <input type="date" id="end_date_edit" class="form-control">
                    </div>  
                    <div class="col-12">
                        <button id="btn_update_timeline_header" type="button" style="float: right" title="update date" class="btn btn-sm btn-success">
                            <i class="fa-solid fa-check"></i>
                        </button>
                    </div>
                </div>
            </fieldset>
            <fieldset class="legend1 mt-2">
                    <legend>Log History</legend>
                    <div class="row ">
                        <div class="col-12 p-1">
                            <table class="datatable-stepper" id="log_history_update">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" style="text-align: center" class="sort" data-sort="name">Created At</th>
                                        <th scope="col" style="text-align: center" class="sort" data-sort="name">Name</th>
                                        <th scope="col" style="text-align: center" class="sort" data-sort="name">Start Date</th>
                                        <th scope="col" style="text-align: center" class="sort" data-sort="name">End Date</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
            </fieldset>
        </div>
      </div>
    </div>
  </div>