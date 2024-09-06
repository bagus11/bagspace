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

                  <fieldset id="detail_container">
                    <legend>Detail Sign</legend>
                    <table class="datatable-stepper" id="detail_sign_table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="sort" style="text-align: center" data-sort="name">Step</th>
                                <th scope="col" class="sort" style="text-align: center" data-sort="name">Name</th>
                                <th scope="col" class="sort" style="text-align: center" data-sort="name">Status</th>
                                <th scope="col" class="sort" style="text-align: center" data-sort="name">Finished At</th>
                            </tr>
                        </thead>
                    </table>
                  </fieldset>
                </div>
                <div class="modal-footer">
                  
                </div>
        </div>
    </div>
</div>
