<div class="modal fade" id="detailSignModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b>Detail Sign Transaction</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_detail_sign_transaction">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-3 mt-2">
                            <p>Approval Type</p>
                        </div>
                        <div class="col-9">
                            <select class="form-control" name="detail_approval_type" id="detail_approval_type">
                                
                            </select>
                            <span style="color:red;" class="message_error text-red block detail_approval_type_error"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3 mt-2">
                            <p>Title</p>
                        </div>
                        <div class="col-9">
                            <input type="text" class="form-control" name="detail_title_sign" id="detail_title_sign">
                            <span style="color:red;" class="message_error text-red block detail_title_sign_error"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3 mt-2">
                            <p>Description</p>
                        </div>
                        <div class="col-9">
                            <input type="text" class="form-control" name="detail_description_sign" id="detail_description_sign">
                            <span style="color:red;" class="message_error text-red block detail_description_sign_error"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3 mt-2">
                            <p>Step Approval</p>
                        </div>
                        <div class="col-9">
                            <input type="number" class="form-control" name="detail_total_approval_sign" id="detail_total_approval_sign" min="0">
                            <span style="color:red;" class="message_error text-red block detail_total_approval_sign_error"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3 mt-2">
                            <p>Attachment</p>
                        </div>
                        <div class="col-9">
                            <p>
                                <a href="" id="detail_attachment_sign" target="_blank"><i class="fas fa-file"></i> Link Attachment</a>
                            </p>
                            {{-- <input type="file" class="form-control" name="detail_attachment_sign" id="detail_attachment_sign" style="height: 40px !important;"> --}}
                            <span style="color:red;" class="message_error text-red block detail_attachment_sign_error"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="datatable-stepper">
                                <thead>
                                    <tr>
                                        <th scope="col" class="sort" data-sort="no">No</th>
                                        <th scope="col" class="sort" data-sort="user_approval">Approver</th>
                                        <th scope="col" class="sort" data-sort="status">Status</th>

                                    </tr>
                                </thead>
                                <tbody id="table_list_detail_approval">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                    <button id="btn_update_sign_transaction" type="button" class="btn btn-sm btn-danger" data-dismiss="modal">
                        <i class="fas fa-xmark"></i>
                        {{-- <i class="fa-solid fa-x"></i> --}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
