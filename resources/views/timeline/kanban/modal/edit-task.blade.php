<div class="modal fade" id="updateTaskModal">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content bg-dark">
            <div class="modal-header bg-mainCore">
                <b style="font-size: 12px;color:white">Form Add Task</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body my-0">
                <fieldset class="legend1 mx-0 my-0">
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
                            <p>Actual</p>
                        </div>
                        <div class="col-4" id="amount_container_edit">
                            <input type="text" class="form-control" id="actual_amount_edit">
                            <span style="color:red;" class="message_error text-red block actual_amount_edit_error"></span>
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
                </fieldset>
                <fieldset class="legend1  mx-0 my-0 mt-2">
                    <legend>Log Transaction</legend>
                    <div class="row mx-1">
                        <div class="col-12">
                            <table class="datatable-stepper" id="log_task_table">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" style="text-align: center" class="sort" data-sort="start_date">Created at</th>
                                        <th scope="col" style="text-align: center" class="sort" data-sort="start_date">Updated By</th>
                                        <th scope="col" style="text-align: center" class="sort" data-sort="start_date">Title</th>
                                        <th scope="col" style="text-align: center" class="sort" data-sort="start_date">PIC</th>
                                        <th scope="col" style="text-align: center" class="sort" data-sort="start_date">Start Date</th>
                                        <th scope="col" style="text-align: center" class="sort" data-sort="start_date">End Date</th>
                                        <th scope="col" style="text-align: center" class="sort" data-sort="start_date">Actual</th>
                                        <th scope="col" style="text-align: center" class="sort" data-sort="start_date">Remark</th>
                                       
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_edit_task" type="button" class="btn btn-sm btn-success">
                    <i class="fa-solid fa-check"></i>
                </button>
            </div>
        </div>
    </div>
</div>
