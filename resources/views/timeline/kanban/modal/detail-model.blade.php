<div class="modal fade" id="detailCardModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark">
            <div class="modal-header bg-mainCore p-2 ml-2">
                <b style="font-size: 12px;color:#EEEE" id="detail_label"></b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-1">
                <input type="hidden" id="detail_code_chat">
                <input type="hidden" id="request_code_chat">
               {{-- <fieldset class="legend1">
                            <legend style="text-align: left;" class="p-0">General Module</legend>
                              
              </fieldset> --}}
                
              <fieldset class="legend1">
                <legend>General Module</legend>
                <div class="row">
                    <div class="col-md-3">
                        <div class="flex-wrapper" id="percentage_task_container" style="margin: auto !important;margin-top:10px !important  "> 
                          
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row mx-2">
                            <div class="col-3 mt-2">
                                <p>Request Code</p>
                            </div>
                            <div class="col-3 mt-2">
                                <p id="module_request_code_label"></p>
                            </div>
                            <div class="col-3 mt-2">
                                <p>Detail Code</p>
                            </div>
                            <div class="col-3 mt-2">
                                <p id="module_detail_code_label"></p>
                            </div> 
                            <div class="col-3 mt-2">
                                <p>Module Name</p>
                            </div>
                            <div class="col-3 mt-2">
                                <p id="module_name_label"></p>
                            </div>
                            <div class="col-3 mt-2">
                                <p>Status</p>
                            </div>
                            <div class="col-3 mt-2">
                                <p id="module_status_label"></p>
                            </div>
                            <div class="col-3 mt-2">
                                <p>Start Date</p>
                            </div>
                            <div class="col-3 ">
                                <input type="date" class="form-control" id="module_start_date_label" >
                            </div>
                            <div class="col-3 mt-2">
                                <p>End Date</p>
                            </div>
                            <div class="col-3">
                                <input type="date" class="form-control" id="module_end_date_label" >
                            </div>
                        </div>
                        <div class="row mx-2">
                            <div class="col-3 mt-2">
                                <p>Description</p>
                            </div>
                            <div class="col-9 mt-2">
                                <p id="module_description_label"></p>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-md-12">
                        
                      <div class="row">
                        <div class="col-12">
                            <button class="btn btn-sm btn-dark rounded-circle" id="btn_add_task" style="float: right;margin-top:-12px;margin-bottom:5px" data-toggle="modal" data-target="#addTaskModal" title="Create Task Here">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12">
                            <table class="datatable-stepper" id="task_subdetail_table">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" style="text-align: center" class="sort" data-sort=""></th>
                                        <th scope="col" style="text-align: center" class="sort" data-sort="start_date">Start Date</th>
                                        <th scope="col" style="text-align: center" class="sort" data-sort="task">Task</th>
                                        <th scope="col" style="text-align: center" class="sort" data-sort="pic">PIC</th>
                                        <th scope="col" style="text-align: center" class="sort" data-sort="dateline">Dateline</th>
                                        <th scope="col" style="text-align: center" class="sort" data-sort="updated_at">Updated At</th>
                                        <th scope="col" style="text-align: center" class="sort" data-sort="action">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                      </div>
                    </div>
                </div>
              </fieldset>
              <fieldset class="legend1">
                <legend>Send Disscuss Here</legend>
                <div class="row">
                    <div class="col-1">
                        <span class="avatar avatar-sm rounded-circle mt-2 ml-2">
                            @php
                                $auth= auth()->user()->avatar;
                            @endphp
                             <img alt="Image placeholder" src="{{asset('storage/users-avatar/'.$auth)}}">
                        </span>
                    </div>
                    <div class="col-11">
                        <div class="input-group">
                            <div class="input-group-append">
                                <input type="file" class="form-control-file attach_btn" id="file_attach" style="display: none;">
                                <label for="file_attach" class="input-group-text attach_btn"><i class="fas fa-paperclip"></i></label>
                            </div>
                            <textarea name="" id="remark_chat" class="form-control type_msg" placeholder="Type your message..."></textarea>
                            <div class="input-group-append">
                                <button id="send_chat" class="input-group-text send_btn" style="background-color:#31363F;"><i class="fas fa-location-arrow"></i></button>
                            </div>
                        </div>
                         <span style="color:red;font-size:9px" class="message_error text-red block remark_chat_error"></span>
                    </div>
                </div>

              </fieldset>
              <fieldset class="legend1">
                <legend>Activity</legend>
                {{-- <fieldset class="legend1">
                    <legend>Log Activity</legend> --}}
                    <div class="box mx-2" id="chat_container">  
                    </div><!-- box -->
              </fieldset>

               
            </div>
        </div>
    </div>
</div>

<style>
    *{
  box-sizing:border-box;
}
.type_msg{
			background-color: rgba(0,0,0,0.3) !important;
			border:0 !important;
			color:white !important;
			height: 60px !important;
			overflow-y: auto;
		}
.type_msg:focus{
		     box-shadow:none !important;
           /* outline:0px !important; */
}
.send_btn{
	border-radius: 0 15px 15px 0 !important;
	background-color: rgba(0,0,0,0.3) !important;
    border:0 !important;
    color: white !important;
    cursor: pointer;
}
.attach_btn{
	border-radius: 15px 0 0 15px !important;
	background-color: rgba(0,0,0,0.3) !important;
			border:0 !important;
			color: white !important;
			cursor: pointer;
}
body{
  margin:0;
  font:.9em/1.5 'Roboto';
  cursor:default;
}
.box{
  width:100%;
  /* max-width:400px; */
  /* margin:2em auto; */
  
}
.message{
  width:100%;
  /* border-radius:15px; */
  font-size: 12px;

  padding-left:10px;
}
.person-a .message{
  /* background:#f8f8f8; */
  color: #eeee;
}
.person-a{
  display:flex;
  margin-bottom:10px;
  align-items:flex-end;
}
.message b{
    color: white; 
}
.icon{
  --size:40px;
  width:var(--size);
  height:var(--size);
  background-position:center;
  background-size:cover;
  border-radius:100%;
  margin-right:.8em;
  position:relative;
}
.circular-chart{
    width : 500px !important;
    height: 100% !important;
}
#percentage_task_container{
    width: 100% !important;
}
</style>