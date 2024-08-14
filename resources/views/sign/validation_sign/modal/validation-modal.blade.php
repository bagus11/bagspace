<div class="modal fade" id="validationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header p-0 ml-4 mx-2 my-2">
                <b>Validation Sign</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row my-0 d-flex justify-content-center">
                    <div class="col-12">
                        <p style="text-align:center">
                            <b style="font-size: 12px !important;text-align:center !important ">Are you sure about this signature?</b>
                        </p>
                    </div>
                    <div class="col-2 mt-2">
                        <p>PIN</p>
                    </div>
                    <div class="col-5">
                        <div class="pinBox">
                            <input type="text" name="mycode" id="pincode" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row my-0 d-flex justify-content-center">
                    <div class="col-5">
                        <span style="font-size:10px;color:white !important;text-transform: lowercase !important;" class="badge rounded-pill bg-danger message_error pincode_error"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-end p-0 my-0 mx-2">
                <button class="btn btn-sm btn-success mb-2 mx-2" id="btn_approve_sign">
                    <i class="fas fa-check"></i>
                </button>
            </div>
        </div>
    </div>
</div>
