<div class="modal fade" id="updateGroupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <b>Edit Group</b>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form class="form" id="form_serialize" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="row">
                <div class="col-3 mt-2">
                    <p>Name</p>
                </div>
                <div class="col-9">
                    <input type="text" class="form-control" id="name_edit">
                    <span  style="color:red;" class="message_error text-red block name_edit_error"></span>
                </div>
                <div class="col-3 mt-2">
                    <p>Description</p>
                </div>
                <div class="col-9">
                    <textarea class="form-control" id="description_edit" rows="3"></textarea>
                    <span  style="color:red;" class="message_error text-red block description_edit_error"></span>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-3 mt-2">
                    <p>Attachment</p>
                </div>
                <div class="col-9">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" style="font-size: 9px" id="attachment" lang="en">
                        <p class="custom-file-label" for="attachment" style="font-size: 9px">Select file</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button id="btn_update_group" type="button" class="btn btn-sm btn-success">
                <i class="fas fa-check"></i>
            </button>
        </div>
        </form>
      </div>
    </div>
  </div>