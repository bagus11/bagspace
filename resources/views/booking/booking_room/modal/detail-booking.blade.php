<div class="modal fade" id="detailBookingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <b>Detail Ticket</b>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <fieldset class="legend1">
                <legend>General Transaction</legend>
                <div class="row mx-2">
                    <div class="col-6 col-sm-6 col-md-2 mt-2">
                        <p>Meeting Id</p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 mt-2">
                        <p id="meeting_id_label"></p>
                    </div>
                </div>
                <div class="row mx-2">
                    <div class="col-6 col-sm-6 col-md-2 mt-2">
                        <p>Type</p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 mt-2">
                        <p id="type_label"></p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-2 mt-2">
                        <p>Start Date</p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4">
                        <input type="date" id="start_date_label" class="form-control">
                    </div>
                    <div class="col-6 col-sm-6 col-md-2 mt-2">
                        <p>Start Time</p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4">
                        <input type="time" id="start_time_label" class="form-control">
                    </div>
                    <div class="col-6 col-sm-6 col-md-2 mt-2">
                        <p>End Time</p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4">
                        <input type="time" id="end_time_label" class="form-control">
                    </div>
                    <div class="col-6 col-sm-6 col-md-2 mt-2">
                        <p>PIC</p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 mt-2">
                        <p id="pic_label"></p>
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
                        <p>Room</p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 mt-2">
                        <p id="room_label"></p>
                    </div>
                                    
                </div>
                <div class="row mx-2" id="last_booking_container">
                    <div class="col-6 col-sm-6 col-md-2 mt-2">
                        <p>Need Meeting Link</p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 mt-2">
                        <p id="meeting_link_type_label"></p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-2 mt-2">
                        <p>Meeting Type</p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 mt-2">
                        <p id="meeting_type_label"></p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-2 mt-2">
                        <p>Meeting Link</p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 mt-2">
                        <p id="meeting_link_label"></p>
                    </div>
                </div>   
            </fieldset>
         
            <fieldset class="legend1 mt-2">
                <legend>Detail Activiy</legend>
                <div class="row ">
                    <div class="col-12 p-1">
                        <table class="datatable-stepper" id="detail_booking_table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" style="text-align: center" class="sort" data-sort="name">Created at</th>
                                    <th scope="col" style="text-align: center" class="sort" data-sort="name">PIC</th>
                                    <th scope="col" style="text-align: center" class="sort" data-sort="name">Remark</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="row mx-2 mt-0">
                    <div class="col-12">
                        <div class="btn-group" style="float:right">
                            <button type="button" class="btn btn-tool btn-info dropdown-toggle" id="btn_history_remark" title="Approver List" style="margin-top:3px" data-toggle="dropdown">
                                <i class="fa-solid fa-users"></i>
                            </button>
                            <input type="hidden" name="pc_code_id" id="pc_code_id">
                            <div class="dropdown-menu dropdown-menu-right" role="menu" style="width: 390px !important">
                                <div class="row p-0">
                                    <div class="col-12 col-sm-12 col-12">
                                        <table class="datatable-stepper" id="approver_list_table" style="width: 100% !important;">
                                            <thead class="thead-light" style="width: 100% !important;background-color:#A34343 !important">
                                                <tr>
                                                    <th style="text-align: center">Step</th>
                                                    <th style="text-align: center"></th>
                                                    <th style="text-align: left">Name</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="modal-footer">
          
        </div>
      </div>
    </div>
  </div>