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
                <div class="modal-body p-0 mt-2 mx-2 my-1">
                  <fieldset>
                    <legend>General Information</legend>
                    <div class="row">
                        <div class="col-2">
                            <p>Approval Type</p>
                        </div>
                        <div class="col-4">
                           <p id="detail_approval_type"></p>
                        </div>
                        <div class="col-2">
                            <p>Step Approval</p>
                        </div>
                        <div class="col-4">
                            <p id="detail_total_approval_sign"></p>
                        </div>
                        <div class="col-2">
                            <p>Title</p>
                        </div>
                        <div class="col-4">
                          <p id="detail_title_sign"></p>
                        </div>
                        <div class="col-2">
                            <p>Attachment</p>
                        </div>
                        <div class="col-4">
                            <p>
                                <a href="" id="detail_attachment_sign" target="_blank"><i class="fas fa-file"></i> Click Here</a>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <p>Description</p>
                        </div>
                        <div class="col-10">
                          <p id="detail_description_sign"></p>
                        </div>
                  </fieldset>
           
                  <fieldset class="mt-2">
                    <legend>Step Approval</legend>
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
                  </fieldset>
                </div>
                <div class="modal-footer">
                  
                </div>
            </form>
        </div>
    </div>
</div>
