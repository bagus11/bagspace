<div class="modal fade" id="editTeamDetail">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-mainCore">
                <b style="font-size: 12px" > Form Edit Team</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="form-group row mx-4">
                    <div class="col-md-2 mt-2">
                        <p for="">Name</p>
                </div>
                    <div class="col-md-10">
                        <input type="hidden" class="form-control" id="teamHeadId">
                        <input type="text" class="form-control" id="teamNameUpdate">
                        <span  style="color:red;" class="message_error text-red block teamNameUpdate_error"></span>
                    </div>
                    <div class="col-md-2 mt-2">
                        <p for="">Leader</p>
                    </div>
                    <div class="col-md-10">
                        <select name="selectLeader" id="selectLeader" class="select2"></select>
                        <input type="hidden" name="leaderId" id="leaderId">
                        <span  style="color:red;" class="message_error text-red block leaderId_error"></span>
                    </div>
                </div>
             
                <div class="row">
                    <div class="col-12">
                        <table class="datatable-stepper" id="listTeamProject">
                            <thead>
                                <tr>
                                    <th style="text-align:center">No</th>
                                    <th style="text-align:center">Name</th>
                                    <th style="text-align:center">Role</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button id="btnUpdateName" type="button" class="btn btn-sm btn-success">
                    <i class="fa-solid fa-check"></i>
                </button>
            </div>
        </div>
    </div>
</div>