<div class="modal fade" id="addBookModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-mainCore">
               Add Book
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" id="form_serialize" enctype="multipart/form-data">
                <div class="modal-body">
                <div class="row">
                        <div class="col-4 mt-2">
                            <p>TItle</p>
                        </div>
                        <div class="col-8">
                            <input type="text" class="form-control" id="name">
                            <span  style="color:red;" class="message_error text-red block name_error"></span>
                        </div>
                        <div class="col-4 mt-2">
                            <p>Description</p>
                        </div>
                        <div class="col-8">
                            <textarea class="form-control" id="description" rows="3"></textarea>
                            <span  style="color:red;" class="message_error text-red block description_error"></span>  
                        </div>
                </div>
                <div class="row mt-2">
                    <div class="col-4 mt-2">
                        <p>Location</p>
                    </div>
                    <div class="col-8">
                        <select name="select_location" class="select2" id="select_location"></select>
                        <input type="hidden" class="form-control" id="location_id">
                        <span  style="color:red;" class="message_error text-red block location_id_error"></span>
                    </div>
                    <div class="col-4 mt-2">
                        <p>Department</p>
                    </div>
                    <div class="col-8">
                        <select name="select_department" class="select2" id="select_department">
                            <option value="">Choose Location First</option>
                        </select>
                        <input type="hidden" class="form-control" id="department">
                        <span  style="color:red;" class="message_error text-red block department_error"></span>
                    </div>
                    <div class="col-4 mt-2">
                        <p>Attachment</p>
                    </div>
                    <div class="col-8">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="attachment" required>
                            <label class="custom-file-label" style="font-size: 9px !important" for="attachment">Choose file...</label>
                            <span  style="color:red;" class="message_error text-red block attachment_error"></span>
                        </div>
                    </div>
                </div>
                
                </div>
                <div class="modal-footer justify-content-end">
                    <button id="btn_save_book" type="submit" class="btn btn-success btn-sm">
                        <i class="fas fa-check"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>