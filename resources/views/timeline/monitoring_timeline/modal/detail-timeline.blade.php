<div class="modal fade" id="detailTimelineHeader" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header pb-0 ">
            <b style="font-size: 12px" class="ml-2">Detail Project</b>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <fieldset class="legend1">
                <legend>General Transaction</legend>
                <div class="row mx-2">
                    <div class="col-6 col-sm-6 col-md-2 mt-2">
                        <p>Request Code</p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 mt-2">
                        <p id="request_code_label"></p>
                    </div>
                </div>
                <div class="row mx-2">
                    <div class="col-6 col-sm-6 col-md-2 mt-2">
                        <p>Project Name</p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 mt-2">
                        <p id="name_label"></p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-2 mt-2">
                        <p>User</p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 mt-2">
                        <p id="pic_label"></p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-2 mt-2">
                        <p>Start Date</p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4">
                        <input type="date" id="start_date_label" class="form-control">
                    </div>
                    <div class="col-6 col-sm-6 col-md-2 mt-2">
                        <p>End Date</p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4">
                        <input type="date" id="end_date_label" class="form-control">
                    </div>
                    <div class="col-6 col-sm-6 col-md-2 mt-2">
                        <p>Status</p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 mt-2">
                        <p id="status_label"></p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-2 mt-2">
                        <p>Location</p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 mt-2">
                        <p id="location_label"></p>
                    </div>          
                    <div class="col-6 col-sm-6 col-md-2 mt-2">
                        <p>Team Name</p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 mt-2">
                        <p id="team_name_label"></p>
                    </div>          
                    <div class="col-6 col-sm-6 col-md-2 mt-2">
                        <p>BOT Link</p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 mt-2">
                        <p id="link_label"></p>
                    </div>          
                </div>
                <div class="row mx-2">
                    <div class="col-2 col-sm-2 col-md-2 mt-2">
                        <p>Desc Project</p>
                    </div>
                    <div class="col-10 col-sm-10 col-md-10 mt-2">
                        <p id="description_label"></p>
                    </div>        
                </div>
            </fieldset>
         
            <fieldset class="legend1 mt-2">
                <legend>Detail Team</legend>
                <div class="row ">
                    <div class="col-12 p-1">
                        <table class="datatable-stepper" id="detail_team_table_project">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" style="text-align: center" class="sort" data-sort="name">No</th>
                                    <th scope="col" style="text-align: center" class="sort" data-sort="name">Name</th>
                                    <th scope="col" style="text-align: center" class="sort" data-sort="name">Role</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="modal-footer">
          
        </div>
      </div>
    </div>
  </div>