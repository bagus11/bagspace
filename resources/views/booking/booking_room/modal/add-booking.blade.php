<div class="modal fade" id="addBookingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <b>Add Ticket</b>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row mt-2">
            <div class="col-2 mt-2">
              <p>Type</p>
            </div>
            <div class="col-4">
              <select name="select_type" class="select2" id="select_type">
                <option value="">Choose Type</option>
                <option value="1">Offline</option>
                <option value="2">Online</option>
              </select>
              <input type="hidden" class="form-control" id="type_id">
              <span  style="color:red;font-size:9px;" class="message_error text-red block type_id_error"></span>
            </div>
            <div class="col-2 mt-2">
              <p>Start Date</p>
            </div>
            <div class="col-4">
              <input type="date" id="start_date" class="form-control" value="{{date('Y-m-d')}}">
              <span  style="color:red;" class="message_error text-red block start_date_error"></span>
            </div>
            <div class="col-2 mt-2">
              <p>Start Time</p>
            </div>
            <div class="col-4">
              <input type="time" id="start_time" class="form-control" value="{{date('H:i')}}">
              <span  style="color:red;" class="message_error text-red block start_time_error"></span>
            </div>
            <div class="col-2 mt-2">
              <p>End Time</p>
            </div>
            <div class="col-4">
              <input type="time" id="end_time" class="form-control">
              <span  style="color:red;" class="message_error text-red block end_time_error"></span>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-2 mt-2">
              <p>Location</p>
            </div>
            <div class="col-10">
              <select name="select_location" class="select2" id="select_location">
              </select>
              <input type="hidden" class="form-control" id="location_id">
              <span  style="color:red;font-size:9px;" class="message_error text-red block location_id_error"></span>
            </div>
          </div>
          <div class="row" id="room_container">
            <div class="col-2 mt-2">
              <p>Room</p>
            </div>
            <div class="col-10">
              <select name="select_room" class="select2" id="select_room">
                <option value="">Choose Location First</option>
              </select>
              <input type="hidden" class="form-control" id="room_id">
              <span  style="color:red;font-size:9px;" class="message_error text-red block room_id_error"></span>
            </div>
          </div>
            <div class="row">
              
              <div class="col-2 mt-2">
                <p>Title</p>
              </div>
              <div class="col-10">
                <input type="text" class="form-control" id="title">
                <span  style="color:red;font-size:9px;" class="message_error text-red block title_error"></span>
              </div>
              <div class="col-2 mt-2">
                <p>Description</p>
              </div>
              <div class="col-10">
                <textarea class="form-control" id="description" rows="3"></textarea>
                <span  style="color:red;" class="message_error text-red block description_error"></span>
              </div>
            </div>
          
        </div>
        <div class="modal-footer">
            <button id="btn_save_ticket" type="button" class="btn btn-sm btn-success">
                <i class="fas fa-check"></i>
            </button>
        </div>
      </div>
    </div>
  </div>