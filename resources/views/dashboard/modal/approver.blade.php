<div class="modal fade" id="editBookingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
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
                        <p>Meeting ID</p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 mt-2">
                        <input type="hidden" id="meetingId" name="meetingId">
                        <p id="meetingIdLabel"></p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-2 mt-2">
                        <p>Title</p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 mt-2">
                        <p id="titleLabel"></p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-2 mt-2">
                        <p>Type</p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 mt-2">
                        <p id="typeLabel"></p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-2 mt-2">
                        <p>Room</p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 mt-2">
                        <p id="roomLabel"></p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-2 mt-2">
                        <p>Request By</p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 mt-2">
                        <p id="userLabel"></p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-2 mt-2">
                        <p>Start Date</p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 mt-2">
                        <p id="startDateLabel"></p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-2 mt-2">
                        <p>Start Time</p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 mt-2">
                        <p id="startTimeLabel"></p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-2 mt-2">
                        <p>End Time</p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 mt-2">
                        <p id="endTimeLabel"></p>
                    </div>
                  <div class="col-6 col-sm-6 col-md-2 mt-2">
                    <p>Status</p>
                  </div>
                  <div class="col-6 col-sm-6 col-md-4 mt-2">
                    <p id="statusLabel"></p>
                  </div>
                </div>
                <div class="row mx-2">
                    <div class="col-6 col-sm-6 col-md-2  mt-2">
                        <p>Additional Info</p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-10  mt-2">
                        <p id="descriptionLabel"></p>
                    </div>
                </div>
          </fieldset>
          <fieldset class="legend1 mt-2" id="lastApproverContainer">
            <legend>Meeting Form</legend>
            <div class="row mx-2">
                <div class="col-6 col-sm-6 col-md-2 mt-2">
                    <p>Need Online Meet</p>
                </div>
                <div class="col-6 col-sm-6 col-md-4">
                    <select name="select_option_meet" id="select_option_meet" class="select2">
                        <option value="">Choose Option</option>
                        <option value="1">Yes</option>
                        <option value="2">No</option>
                    </select>
                    <input type="hidden" id="option_meet_id">
                </div>
                <div class="col-6 col-sm-6 col-md-2 mt-2">
                    <p>Type</p>
                </div>
                <div class="col-6 col-sm-6 col-md-4">
                    <select name="select_option_type" class="select2" id="select_option_type">
                        <option value="">Choose Type</option>
                        <option value="1">Public</option>
                        <option value="2">Private</option>
                    </select>
                    <input type="hidden" id="option_type_id">
                </div>
                <div class="col-6" id="userMeetContainer">
                    <table class="datatable-stepper" id="userMeetTable" style="width: 100% !important">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" style="text-align: center;width : 10% !important" class="sort" data-sort=""></th>
                                <th scope="col" style="text-align: center;width : 90% !important" class="sort" data-sort="name">Name</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="col-6" id="userListContainer">
                    <table class="datatable-stepper" id="userListTable" style="width: 100% !important">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" style="text-align: center;width : 90% !important" class="sort" data-sort="name">Name</th>
                                <th scope="col" style="text-align: center;width : 10% !important" class="sort" data-sort="">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
          </fieldset>
          <fieldset class="legend1 mt-2">
                <legend>Approval Transaction</legend>
                <div class="row mx-2">
                    <div class="col-6 col-sm-6 col-md-2 mt-2">
                        <p>Approval</p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4">
                        <select name="selectApproval" class="select2" id="selectApproval">
                            <option value="">Choose Approval</option>
                            <option value="1">Approve</option>
                            <option value="2">Reject</option>
                        </select>
                        <input type="hidden" name="approval_id" id="approval_id">
                    </div>
                </div>
                <div class="row mx-2">
                    <div class="col-6 col-sm-6 col-md-2 mt-2">
                        <p>Remark</p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-10 ">
                        <textarea class="form-control" id="remark_approval" rows="3"></textarea>
                        <span  style="color:red;" class="message_error text-red block remark_approval_error"></span>
                    </div>

                </div>
          </fieldset>
        </div>
        <div class="modal-footer">
            <button id="btn_save_approval" type="button" class="btn btn-sm btn-success">
                <i class="fas fa-check"></i>
            </button>
        </div>
      </div>
    </div>
  </div>