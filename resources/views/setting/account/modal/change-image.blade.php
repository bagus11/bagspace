<div class="modal fade" id="changeImageModal">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header p-0 my-2 mx-2">
                <b style="font-size:13px;margin-top:5px;margin-left:5px">Change Image</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-3 mt-2">
                        <p>Current Image</p>
                    </div>
                    <div class="col-9">
                        <input type="file" class="form-control" id="profileImageInput" name="profile_image">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="container">
                        <div class="col-12" id="cropContainer" style="display:none;">
                            <img id="cropImage" style="max-width: 100%;">
                            <button id="cropButton" class="btn btn-primary mt-2">

                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
            </div>
        </div>
    </div>
</div>
<style>
    #cropContainer {
        text-align: center;
    }
    #cropImage {
        max-width: 100%;
        margin-top: 10px;
    }
    #cropButton {
        margin-top: 10px;
    }
</style>