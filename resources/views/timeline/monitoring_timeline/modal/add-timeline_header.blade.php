<div class="modal fade" id="addTimelineHeader">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-mainCore">
                <b style="font-size: 12px"> Form Add Timeline Header</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="row">
                    <div class="col-2 mt-2">
                        <p>Title</p>
                    </div>
                    <div class="col-4">
                        <input type="text" class="form-control" id="name">
                        <span  style="color:red;" class="message_error text-red block name_error"></span>
                    </div>
                    <div class="col-2 mt-2">
                        <p>Location</p>
                    </div>
                    <div class="col-4">
                        <select name="select_office" class="select2" id="select_office"></select>
                        <input type="hidden" class="form-control" id="office_id">
                        <span  style="color:red;" class="message_error text-red block office_id_error"></span>
                    </div>
                    <div class="col-2 mt-2">
                        <p>Description</p>
                    </div>
                    <div class="col-10">
                        <textarea class="form-control" id="description" rows="3"></textarea>
                        <span  style="color:red;" class="message_error text-red block description_error"></span>  
                    </div>
               </div>
               <div class="row mt-2">
                <div class="col-2 mt-2">
                    <p>Start Date</p>
                  </div>
                  <div class="col-4">
                    <input type="date" id="start_date" class="form-control" value="{{date('Y-m-d')}}">
                    <span  style="color:red;" class="message_error text-red block start_date_error"></span>
                  </div>
                  <div class="col-2 mt-2">
                    <p>End Date</p>
                  </div>
                  <div class="col-4">
                    <input type="date" id="end_date" class="form-control"  value="{{date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "3 month" ) )}}">
                    <span  style="color:red;" class="message_error text-red block end_date_error"></span>
                  </div>
               </div>
               <div class="row">
                <div class="col-2 mt-2">
                    <p>Team</p>
                </div>
                <div class="col-4">
                    <select name="select_team" class="select2" id="select_team"></select>
                    <input type="hidden" class="form-control" id="team_id">
                    <span  style="color:red;" class="message_error text-red block team_id_error"></span>
                </div>
               </div>
               <div class="row mt-2" id="detail_team_container">
                <div class="col-12">
                    <table class="datatable-stepper" id="table_detail_team">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="sort" style="text-align: center" data-sort="role">No</th>
                                <th scope="col" class="sort" style="text-align: center" data-sort="role">Name</th>
                                <th scope="col" class="sort" style="text-align: center" data-sort="name">Role</th>
                            </tr>
                        </thead>
                    </table>
                </div>
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_save_ticket" type="button" class="btn btn-sm btn-success">
                    <i class="fa-solid fa-check"></i>
                </button>
            </div>
        </div>
    </div>
</div>