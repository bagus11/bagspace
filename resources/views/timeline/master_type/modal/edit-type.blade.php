<div class="modal fade" id="editTypeModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-mainCore">
                <b style="font-size: 12px"> Edit Type</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
               <div class="row mx-2">
                    <div class="col-md-4">
                        <p>Name</p>
                    </div>
                    <div class="col-md-8">
                        <input type="hidden" class="form-control" id="editId">
                        <input type="text" class="form-control" id="name_edit">
                        <span class="message_error name_edit_error text-red block "></span>
                    </div>
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_update_type" type="button" class="btn btn-sm btn-success">
                    <i class="fa-solid fa-check"></i>
                </button>
            </div>
        </div>
    </div>
</div>