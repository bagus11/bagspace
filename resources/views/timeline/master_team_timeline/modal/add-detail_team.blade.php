<div class="modal fade" id="addTeamDetail">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-mainCore">
                <b style="font-size: 12px" id="titleDetail"></b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
               <div class="row">
              <div class="col-md-12">
                <input type="hidden" id="masterIdDetail">
                <table class="datatable-stepper" id="detailTeamTable">
                    <thead>
                        <tr>
                            <th style="text-align: center"><input type="checkbox" id="checkAll" name="checkAll" class="checkAll" style="border-radius: 5px !important;"></th>
                            <th style="text-align: center">Name</th>
                        </tr>
                    </thead>
                </table>
              </div>
               </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btnSaveDetail" type="button" class="btn btn-sm btn-success">
                    <i class="fa-solid fa-user-plus"></i>
                </button>
                <button id="btnEditDetail" type="button" class="btn btn-sm btn-danger">
                    <i class="fa-solid fa-user-minus"></i>
                </button>
            </div>
        </div>
    </div>
</div>