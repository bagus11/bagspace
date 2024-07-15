<div class="modal fade" id="taskDoneModal">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header p-0 mx-2 my-2 ">
                <b style="font-size: 12px;">Update Progress</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="done_id">
                <input type="hidden" id="done_status">
              <div class="row" id="actual_done_label">
                <div class="col-2">
                    <p>Actual</p>
                </div>
                <div class="col-10">
                    <input type="text" class="form-control" id="actual_done">
                    <span style="color:red;" class="message_error text-red block actual_done_error"></span>
                </div>
              </div>
              <div class="row mt-2" id="attachment_done_label">
                <div class="col-2 mt-2">
                    <p>Attachment</p>
                </div>
                <div class="col-4">
                    <input type="file" class="form-control" id="attachment_done">
                </div>
              </div>
              <div class="row mt-2" id="reason_done_label">
                <div class="col-2 mt-2">
                    <p>Reason</p>
                </div>
                <div class="col-10">
                    <textarea class="form-control" id="reason_done" rows="3"></textarea>
                    <span  style="color:red;" class="message_error text-red block reason_done_error"></span>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_done_task" type="button" class="btn btn-sm btn-success">
                    <i class="fa-solid fa-check"></i>
                </button>
            </div>
        </div>
    </div>
</div>
