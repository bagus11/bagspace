<div class="modal fade" id="signModal">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header p-0 my-2 mx-2">
                <b style="font-size:13px;margin-top:5px;margin-left:5px">Approval Person</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              
                    <div class="row">
                        <div class="col-3 mt-2">
                            <p>X Coordinate</p>
                        </div>
                        <div class="col-3">
                            <input type="text" id="x_location" class="form-control" disabled>
                        </div>
                        <div class="col-3 mt-2">
                            <p>Y Coordinate</p>
                        </div>
                        <div class="col-3">
                            <input type="text" id="y_location" class="form-control" disabled>
                        </div>
                        
                        <div class="col-3 mt-2">
                            <p>Page Number</p>
                        </div>
                        <div class="col-3">
                            <input type="text" id="page_location" class="form-control" disabled>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-3 mt-2">
                            <p>User</p>
                        </div>
                        <div class="col-6">
                            <select name="select_user" class="select2" id="select_user"></select>
                            <input type="hidden" id="user_id">
                        </div>
                    </div>
               
            </div>
            <div class="modal-footer justify-content-end">
                <button class="btn btn-sm btn-success" id="btn_approve_user">
                    <i class="fas fa-check"></i>
                </button>
            </div>
        </div>
    </div>
</div>
