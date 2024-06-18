<div class="modal fade" id="detailTaskModal">
    <div class="modal-dialog modal-xl modal-dialog-centered" >
        <div class="modal-content" style="background-color: #31363F">
            <div class="modal-header bg-mainCore">
                <b style="font-size: 12px;color:white">Form Detail Task</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
              <fieldset class="legend1 mx-2" style="color: white">
                <legend>Detail Task </legend>
                <div class="row mx-2">
                    <div class="col-2 mt-2">
                        <p>Start Date</p>
                    </div>
                    <div class="col-4 mt-2">
                        <input type="date" id="start_date_sub_task_label" class="form-control" value="{{date('Y-m-d')}}">
                    </div>
                    <div class="col-2 mt-2">
                        <p>End Date</p>
                    </div>
                    <div class="col-4">
                        <input type="date" id="end_date_task_label" class="form-control" value="{{date('Y-m-d')}}">
                      
                    </div>
                </div>
                <div class="row mx-2">
                    <div class="col-2 mt-2">
                        <p>Title</p>
                    </div>
                    <div class="col-4 mt-2">
                      <p id="name_task_label"></p>
                       
                    </div>
                    <div class="col-2 mt-2">
                        <p>Actual</p>
                    </div>
                    <div class="col-4 mt-2">
                      <p id="actual_amount_label"></p>
                    </div>
                    <div class="col-2 mt-2">
                        <p>PIC</p>
                    </div>
                    <div class="col-4 mt-2">
                       <p id="select_pic_task"></p>
                    </div>
                    <div class="col-2 mt-2">
                        <p>Attachment</p>
                    </div>
                    <div class="col-4 mt-2">
                       <p id="attachment_label"></p>
                    </div>
                </div>
                <div class="row mx-2">
                    <div class="col-2 mt-2">
                        <p>Description</p>
                    </div>
                    <div class="col-10 mt-2">
                       <p id="description_task_label"></p>
                       
                    </div>
                </div>
              </fieldset>
              <fieldset class="legend1  mx-0 my-0 mt-2 px-0">
                <legend class="ml-2">Log Transaction</legend>
                <div class="row">
                    <div class="col-12">
                        <table class="datatable-stepper" id="log_task_table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" style="text-align: center" class="sort" data-sort="start_date">Created at</th>
                                    <th scope="col" style="text-align: center" class="sort" data-sort="start_date">Updated By</th>
                                    <th scope="col" style="text-align: center" class="sort" data-sort="start_date">Title</th>
                                    <th scope="col" style="text-align: center" class="sort" data-sort="start_date">PIC</th>
                                    <th scope="col" style="text-align: center" class="sort" data-sort="start_date">Start Date</th>
                                    <th scope="col" style="text-align: center" class="sort" data-sort="start_date">End Date</th>
                                    <th scope="col" style="text-align: center" class="sort" data-sort="start_date">Actual</th>
                                    <th scope="col" style="text-align: center" class="sort" data-sort="start_date">Remark</th>
                                   
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </fieldset>
               
            </div>
        </div>
    </div>
</div>
