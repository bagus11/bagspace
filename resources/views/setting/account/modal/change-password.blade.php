<div class="modal fade" id="changePasswordModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header p-0 my-2 mx-2">
               <b style="font-size:13px;margin-top:5px;margin-left:5px">Change Password</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-3">
                            <p>Current Password</p>
                        </div>
                        <div class="col-9">
                            <input type="password" class="form-control" id="current_password">
                            <span  style="color:red;font-size:9px" class="current_password_error text-red block name_error"></span>
                        </div>
                        <div class="col-3">
                            <p>New Password</p>
                        </div>
                        <div class="col-9">
                            <input type="password" class="form-control" id="new_password">
                            <span  style="color:red;font-size:9px" class="new_password_error text-red block name_error"></span>
                        </div>
                        <div class="col-3">
                            <p>Confirm Password</p>
                        </div>
                        <div class="col-9">
                            <input type="password" class="form-control" id="confirm_password">
                            <span  style="color:red;font-size:9px" class="confirm_password_error text-red block name_error"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button id="btn_update_password" type="button" class="btn btn-success btn-sm">
                        <i class="fas fa-check"></i>
                    </button>
                </div>
        </div>
    </div>
</div>