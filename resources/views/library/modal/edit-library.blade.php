<div class="modal fade" id="editBookModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-mainCore">
               Edit Book
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" id="form_serialize" enctype="multipart/form-data">
                <div class="modal-body">
                <div class="row">
                        <div class="col-2 mt-2">
                            <p>TItle</p>
                        </div>
                        <div class="col-4">
                            <input type="hidden" class="form-control" id="editId">
                            <input type="text" class="form-control" id="name_edit">
                            <span  style="color:red;" class="message_error text-red block name_edit_error"></span>
                        </div>
                </div>
                <div class="row">
                    <div class="col-2 mt-2">
                        <p>Description</p>
                    </div>
                    <div class="col-10">
                        <textarea class="form-control" id="description_edit" rows="3"></textarea>
                        <span  style="color:red;" class="message_error text-red block description_edit_error"></span>  
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-2 mt-2">
                        <p>Location</p>
                    </div>
                    <div class="col-4">
                        <select name="select_location_edit" class="select2" id="select_location_edit"></select>
                        <input type="hidden" class="form-control" id="location_id_edit">
                        <span  style="color:red;" class="message_error text-red block location_id_edit_error"></span>
                    </div>
                    <div class="col-2 mt-2">
                        <p>Department</p>
                    </div>
                    <div class="col-4">
                        <select name="select_department_edit" class="select2" id="select_department_edit">
                            <option value="">Choose Location First</option>
                        </select>
                        <input type="hidden" class="form-control" id="department_edit">
                        <span  style="color:red;" class="message_error text-red block department_edit_error"></span>
                    </div>
                    <div class="col-2 mt-2">
                        <p>Attachment</p>
                    </div>
                    <div class="col-10">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="attachment_edit" required>
                            <label class="custom-file-label" style="font-size: 9px !important" for="attachment_edit">Choose file...</label>
                            <span  style="color:red;" class="message_error text-red block attachment_error"></span>
                        </div>
                    </div>
                </div>
             
                </div>
                <div class="modal-footer justify-content-end">
                    <button id="btn_update_book" type="submit" class="btn btn-success btn-sm">
                        <i class="fas fa-check"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>