<div class="modal fade" id="addTaskModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <b style="font-size: 12px;">Form Add Task</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-2 mt-2">
                        <p>Start Date</p>
                    </div>
                    <div class="col-4">
                        <input type="date" id="start_date_sub_module" class="form-control" value="{{date('Y-m-d')}}">
                        <span style="color:red;" class="message_error text-red block start_date_sub_module_error"></span>
                    </div>
                    <div class="col-2 mt-2">
                        <p>End Date</p>
                    </div>
                    <div class="col-4">
                        <input type="date" id="end_date_sub_module" class="form-control" value="{{date('Y-m-d')}}">
                        <span style="color:red;" class="message_error text-red block end_date_sub_module_error"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2 mt-2">
                        <p>Title</p>
                    </div>
                    <div class="col-4">
                        <input type="text" class="form-control" id="name_sub_module">
                        <span style="color:red;" class="message_error text-red block name_sub_module_error"></span>
                    </div>
                    <div class="col-2 mt-2" id="actual_label">
                        <p>Actual</p>
                    </div>
                    <div class="col-4" id="amount_container">
                        <input type="text" class="form-control" id="actual_amount">
                        <span style="color:red;" class="message_error text-red block actual_amount_error"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2 mt-2">
                        <p>Description</p>
                    </div>
                    <div class="col-10">
                        <textarea class="form-control" id="description_sub_module" rows="3"></textarea>
                        <span style="color:red;" class="message_error text-red block description_sub_module_error"></span>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-2 mt-2">
                        <p>PIC</p>
                    </div>
                    <div class="col-4">
                        <select name="select_pic" class="select2" id="select_pic"></select>
                        <input type="hidden" class="form-control" id="pic_id">
                        <span style="color:red;" class="message_error text-red block pic_id_error"></span>
                    </div>
                    <div class="col-2 mt-2">
                        <p>Attachment</p>
                    </div>
                    <div class="col-4">
                        <input type="file" class="form-control" id="attachment_task">
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_save_task" type="button" class="btn btn-sm btn-success">
                    <i class="fa-solid fa-check"></i>
                </button>
            </div>
        </div>
    </div>
</div>
