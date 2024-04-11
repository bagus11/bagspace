<div class="modal fade" id="editApprover" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <b>Edit Approval</b>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
           
            <div class="row">
                <div class="col-md-4 mt-2">
                    <p>Location</p>
                </div>
                <div class="col-md-8">
                    <input type="hidden" disabled class="form-control" id="masterId">
                    <input type="text" disabled class="form-control" id="edit_location">
                </div>
                <div class="col-md-4 mt-2">
                    <p>Step Approval</p>
                </div>
                <div class="col-md-4">
                    <input type="number" class="form-control" id="edit_step">
                    <span  style="color:red;font-size:9px;" class="message_error text-red block edit_step_error"></span>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button id="btn_edit_approval" type="button" class="btn btn-sm btn-success">
                <i class="fas fa-check"></i>
            </button>
        </div>
      </div>
    </div>
  </div>
