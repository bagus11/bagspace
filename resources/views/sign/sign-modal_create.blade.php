<div class="modal fade" id="addSignModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b>Create Sign Transaction</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_create_sign_transaction">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-3 mt-2">
                            <p>Approval Type</p>
                        </div>
                        <div class="col-9">
                            <select class="form-control" name="approval_type" id="approval_type">
                                <option value="0">Hirarki</option>
                                <option value="1">Non Hirarki</option>
                            </select>
                            <span style="color:red;" class="message_error text-red block approval_type_error"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3 mt-2">
                            <p>Title</p>
                        </div>
                        <div class="col-9">
                            <input type="text" class="form-control" name="title_sign" id="title_sign">
                            <span style="color:red;" class="message_error text-red block title_sign_error"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3 mt-2">
                            <p>Description</p>
                        </div>
                        <div class="col-9">
                            <input type="text" class="form-control" name="description_sign" id="description_sign">
                            <span style="color:red;" class="message_error text-red block description_sign_error"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3 mt-2">
                            <p>Step Approval</p>
                        </div>
                        <div class="col-9">
                            <input type="number" class="form-control" name="total_approval_sign" id="total_approval_sign" min="0">
                            <span style="color:red;" class="message_error text-red block total_approval_sign_error"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3 mt-2">
                            <p>Attachment</p>
                        </div>
                        <div class="col-9">
                            <input type="file" class="form-control" name="attachment_sign" id="attachment_sign"
                                style="height: 40px !important;">
                            <span style="color:red;" class="message_error text-red block attachment_sign_error"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12" id="form_list_approval">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btn_save_sign_transaction" type="button" class="btn btn-sm btn-success">
                        <i class="fas fa-check"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
