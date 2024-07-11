<div class="modal fade" id="addDailyModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <b style="font-size: 12px;">Update Activity</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" id="form_serialize" enctype="multipart/form-data">
                <div class="modal-body">
                <div class="row" id="title_label">
                    <div class="col-2 mt-2">
                        <p>Title</p>
                    </div>
                    <div class="col-10"> 
                        <input type="hidden" class="form-control" id="subdetail_code">  
                        <input type="text" class="form-control" id="daily_name">  
                        <span  style="color:red;" class="message_error text-red block daily_name_error"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2 mt-2">
                        <p>Description</p>
                    </div>
                    <div class="col-10">
                        <textarea class="form-control" id="daily_description" rows="3"></textarea>
                        <span  style="color:red;" class="message_error text-red block daily_description_error"></span>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-2 mt-2">
                        <p>Attachment</p>
                    </div>
                    <div class="col-4">
                        <input type="file" class="form-control" id="daily_attachment">
                    </div>
                </div>
                <div class="row mt-2" id="status_label">
                    <div class="col-2 mt-2">
                        <p>Status</p>
                    </div>
                    <div class="col-4">
                        <select name="select_status" class="select2" id="select_status">
                            <option value="">Choose Status</option>
                            <option value="1">On Progress</option>
                            <option value="2">DONE</option>
                        </select>
                        <input type="hidden" class="form-control" id="daily_status">  
                        <span  style="color:red;" class="message_error text-red block daily_status_error"></span>
                    </div>
                </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button id="btn_save_daily" type="submit" class="btn btn-sm btn-success">
                        <i class="fa-solid fa-check"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
