<div class="modal fade" id="addDailyModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark">
            <div class="modal-header bg-mainCore">
                <b style="font-size: 12px;color:white">Update Progress</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <input type="hidden" id="daily_task">
                <div class="col-2">
                    <p>Description</p>
                </div>
                <div class="col-10">
                    <textarea class="form-control" id="daily_description" rows="3"></textarea>
                    <span  style="color:red;" class="message_error text-red block daily_description_error"></span>
                </div>
              </div>
              <div class="row mt-2">
                <div class="col-2 mt-2">
                    <p>Attachment</p>
                </div>
                <div class="col-4">
                    <input type="file" class="form-control" id="daily_attachment">

                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_save_daily" type="button" class="btn btn-sm btn-success">
                    <i class="fa-solid fa-check"></i>
                </button>
            </div>
        </div>
    </div>
</div>
