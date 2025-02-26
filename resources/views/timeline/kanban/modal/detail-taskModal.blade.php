
<div class="modal fade" id="detailTaskModal">
    <div class="modal-dialog modal-xl modal-dialog-centered" >
        <div class="modal-content">
            <div class="modal-header p-0 mx-2 my-2 ">
                <b style="font-size: 12px;">Form Detail Task</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
              <fieldset class="legend1 mx-2" style="border-radius: 15px !important;">
                <legend>Detail Task </legend>
                <div class="row">
                    <div class="col-8">
                        <div class="row mx-2">
                            <div class="col-2 mt-2">
                                <p style="font-size: 10px !important">Start Date</p>
                            </div>
                            <div class="col-4 mt-2">
                                <input type="date" id="start_date_sub_task_label" class="form-control" value="{{date('Y-m-d')}}">
                            </div>
                            <div class="col-2 mt-2">
                                <p style="font-size: 10px !important">End Date</p>
                            </div>
                            <div class="col-4">
                                <input type="date" id="end_date_task_label" class="form-control" value="{{date('Y-m-d')}}">
                              
                            </div>
                        </div>
                        <div class="row mx-2">
                            <div class="col-2 mt-2">
                                <p style="font-size: 10px !important">Title</p>
                            </div>
                            <div class="col-4 mt-2">
                              <p style="font-size: 10px !important" id="name_task_label"></p>
                               
                            </div>
                            <div class="col-2 mt-2">
                                <p style="font-size: 10px !important">Plan</p>
                            </div>
                            <div class="col-4 mt-2">
                              <p style="font-size: 10px !important" id="plan_task_label"></p>
                            </div>
                            <div class="col-2 mt-2">
                                <p style="font-size: 10px !important">Actual</p>
                            </div>
                            <div class="col-4 mt-2">
                              <p style="font-size: 10px !important" id="actual_amount_label"></p>
                            </div>
                            <div class="col-2 mt-2">
                                <p style="font-size: 10px !important">PIC</p>
                            </div>
                            <div class="col-4 mt-2">
                               <p style="font-size: 10px !important" id="select_pic_task"></p>
                            </div>
                            <div class="col-2 mt-2">
                                <p style="font-size: 10px !important">Attachment</p>
                            </div>
                            <div class="col-4 mt-2">
                               <p style="font-size: 10px !important" id="attachment_label"></p>
                            </div>
                        </div>
                        <div class="row mx-2">
                            <div class="col-2 mt-2">
                                <p style="font-size: 10px !important">Description</p>
                            </div>
                            <div class="col-10 mt-2">
                               <p style="font-size: 10px !important" id="description_task_label"></p>
                               
                            </div>
                        </div>
                    </div>
                </div>
              </fieldset>
              <fieldset class="legend1 mx-2 my-0 mt-2 px-0 mb-2" style="border-radius: 15px !important;">
                <legend>Log Transaction</legend>
                <div class="row">
                    <div class="col-12">
                        <table class="datatable-stepper" id="log_task_table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" style="text-align: center" class="sort" data-sort="created_at">Created at</th>
                                    <th scope="col" style="text-align: center" class="sort" data-sort="updated_by">Updated By</th>
                                    <th scope="col" style="text-align: center" class="sort" data-sort="pic">PIC</th>
                                    <th scope="col" style="text-align: center" class="sort" data-sort="start_date">Start Date</th>
                                    <th scope="col" style="text-align: center" class="sort" data-sort="end_date">End Date</th>
                                    <th scope="col" style="text-align: center" class="sort" data-sort="plan">Plan</th>
                                    <th scope="col" style="text-align: center" class="sort" data-sort="actual">Actual</th>
                                    <th scope="col" style="text-align: center" class="sort" data-sort="remark">Remark</th>
                                    <th scope="col" style="text-align: center" class="sort" data-sort="status">Status</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </fieldset>
               
            </div>
        </div>
    </div>
</div>
