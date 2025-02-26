<div class="modal fade" id="updateTaskModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header p-0 mx-2 my-2 ">
                <b style="font-size: 12px;">Form Edit Task</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0 my-0 mx-2 ">
                <fieldset class="legend1 mx-0 my-0" style="border-radius: 15px !important;">
                    <legend>General Transaction</legend>
                    <div class="row">
                        <div class="col-2 mt-2">
                            <p>Start Date</p>
                        </div>
                        <div class="col-4">
                            <input type="hidden" id="taskId" class="form-control">
                            <input type="date" id="start_date_edit_sub_module" class="form-control">
                            <span style="color:red;" class="message_error text-red block start_date_edit_sub_module_error"></span>
                        </div>
                        <div class="col-2 mt-2">
                            <p>End Date</p>
                        </div>
                        <div class="col-4">
                            <input type="date" id="end_date_edit_sub_module" class="form-control">
                            <span style="color:red;" class="message_error text-red block end_date_edit_sub_module_error"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2 mt-2">
                            <p>Title</p>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control" id="name_edit_sub_module">
                            <span style="color:red;" class="message_error text-red block name_edit_sub_module_error"></span>
                        </div>
                        <div class="col-2 mt-2" id="actual_label_edit">
                            <p>Plan</p>
                        </div>
                        <div class="col-4" id="amount_container_edit">
                            <input type="text" class="form-control" id="plan_sub_module_edit">
                            <span style="color:red;" class="message_error text-red block plan_sub_module_edit_error"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2 mt-2">
                            <p>Description</p>
                        </div>
                        <div class="col-10">
                            <textarea class="form-control" id="description_edit_sub_module" rows="3"></textarea>
                            <span style="color:red;" class="message_error text-red block description_edit_sub_module_error"></span>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-2 mt-2">
                            <p>PIC</p>
                        </div>
                        <div class="col-4">
                            <select name="select_pic_edit" class="select2" id="select_pic_edit"></select>
                            <input type="hidden" class="form-control" id="pic_id_edit">
                            <span style="color:red;" class="message_error text-red block pic_id_edit_error"></span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-2 mt-2">
                            <p>Remark</p>
                        </div>
                        <div class="col-10">
                            <textarea class="form-control" id="remark_edit" rows="3"></textarea>
                            <span style="color:red;" class="message_error text-red block remark_edit_error"></span>
                        </div>
                    </div>
                </fieldset>
                <br>
             
            </div>
            <div class="modal-footer justify-content-end p-0 mx-2">
                <button id="btn_edit_task" type="button" class="btn btn-sm btn-success">
                    <i class="fa-solid fa-check"></i>
                </button>
            </div>
        </div>
    </div>
</div>
