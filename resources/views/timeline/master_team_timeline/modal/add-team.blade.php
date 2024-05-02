<div class="modal fade" id="addTeamModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-mainCore">
                <b style="font-size: 12px"> Form Add Team Header</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="row">
              <div class="col-md-3 mt-2">
                <p>Name</p>
              </div>
              <div class="col-md-9">
                <input type="text" class="form-control" id="team_name">
                <span  style="color:red;" class="message_error text-red block team_name_error"></span>
              </div>
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btn_save_team" type="button" class="btn btn-sm btn-success">
                    <i class="fa-solid fa-check"></i>
                </button>
            </div>
        </div>
    </div>
</div>