<div class="modal fade" id="detailBookModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-mainCore">
               Edit Book
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <fieldset class="legend1 mt-2">
                        <legend>General Transaction</legend>
                        <div class="row">
                            <div class="col-2">
                                <p>TItle</p>
                            </div>
                            <div class="col-4">
                                <p id="name_label"></p>
                            </div>
                            <div class="col-2">
                                <p>Attachment</p>
                            </div>
                            <div class="col-4">
                                <p id="attachment_label"></p>
                            </div>
                            <div class="col-2">
                                <p>Location</p>
                            </div>
                            <div class="col-4">
                                <p id="location_label"></p>
                            </div>
                            <div class="col-2">
                                <p>Department</p>
                            </div>
                            <div class="col-4">
                                <p id="department_label"></p>
                            </div>
                            <div class="col-2">
                                <p>Description</p>
                            </div>
                            <div class="col-10">
                                <p id="description_label"></p>
                            </div>
                            
                        </div>
                    </fieldset>
                   
                        <fieldset class="legend1 mt-2">
                            <legend>Log Attachment</legend>
                           
                                    <table class="datatable-stepper" id="log_attachment_table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col" class="sort" style="text-align: center" data-sort="name">Created At</th>
                                                <th scope="col" class="sort" style="text-align: center" data-sort="name">PIC</th>
                                                <th scope="col" class="sort" style="text-align: center" data-sort="action">Attachment</th>
                                            </tr>
                                        </thead>
                                    </table>
                    </div>
                
                </div>
              
        </div>
    </div>
</div>