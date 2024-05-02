<div class="modal fade" id="addCardModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark">
            <div class="modal-header bg-mainCore">
                <b style="font-size: 12px;color:white"> Form Add Module</b>
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
                        <input type="date" id="start_date_module" class="form-control" value="{{date('Y-m-d')}}">
                        <span  style="color:red;" class="message_error text-red block start_date_module_error"></span>
                      </div>
                      <div class="col-2 mt-2">
                        <p>End Date</p>
                      </div>
                      <div class="col-4">
                        <input type="date" id="end_date_module" class="form-control"  value="{{date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "3 month" ) )}}">
                        <span  style="color:red;" class="message_error text-red block end_date_module_error"></span>
                      </div>
                </div>
                <div class="row">
                    <div class="col-2 mt-2">
                        <p>Title</p>
                    </div>
                    <div class="col-4">
                        <input type="text" class="form-control" id="name_module">
                        <span  style="color:red;" class="message_error text-red block name_module_error"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2 mt-2">
                        <p>Description</p>
                    </div>
                    <div class="col-10">
                        <textarea class="form-control" id="description_module" rows="3"></textarea>
                        <span  style="color:red;" class="message_error text-red block description_module_error"></span>
                    </div>
                </div>
              
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_save_ticket" type="button" class="btn btn-sm btn-success">
                    <i class="fa-solid fa-check"></i>
                </button>
            </div>
        </div>
    </div>
</div>