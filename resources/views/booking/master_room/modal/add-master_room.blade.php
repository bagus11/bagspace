<div class="modal fade" id="addMasterRoomModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <b>Add Room</b>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
           
            <div class="row">
                <div class="col-3 mt-2">
                    <p>Name</p>
                </div>
                <div class="col-9">
                    <input type="text" class="form-control" id="name">
                    <span  style="color:red;" class="message_error text-red block name_error"></span>
                </div>
                <div class="col-3 mt-2">
                    <p>Location</p>
                </div>
                <div class="col-9">
                    <select name="select_location" class="select2" id="select_location"></select>
                    <input type="hidden" class="form-control" id="location_id">
                    <span  style="color:red;" class="message_error text-red block location_id_error"></span>
                </div>
                <div class="col-3 mt-2">
                    <p>Description</p>
                </div>
                <div class="col-9">
                    <textarea class="form-control" id="description" rows="3"></textarea>
                    <span  style="color:red;" class="message_error text-red block description_error"></span>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button id="btn_save_room" type="button" class="btn btn-sm btn-success">
                <i class="fas fa-check"></i>
            </button>
        </div>
      </div>
    </div>
  </div>