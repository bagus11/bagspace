<script>
    getCallbackNoSwal('getTimelineHeaderUser',null,function(response){
        mappingTableTimeline(response.data)
        mappingTask(response.data[0])
        $('#select_project').empty()
        $.each(response.data,function(i,data){
            $('#select_project').append('<option style="margin-top:-5px; font-size:12px !Important" data-name="'+ data.name +'" value="'+data.request_code+'">' + data.name +'</option>');
        });
        
    })
    $('#pincode-input1').pincodeInput({inputs:4});
    $('#select_project').on('change',function(){
        var select_project = $('#select_project').val()
        var data ={
            'request_code' : select_project
        }
        getCallbackNoSwal('getTimelineHeaderDetail',data,function(response){
            mappingTask(response.data[0])
        })
    })
    getCallbackNoSwal('getValidationSign', null,function(response){
        if(response.count == 0){
            toastr['info']('Please set your digital signature and set PIN code for validation, thank you ');
            $('#addSignModal').modal('show')
        }
    })
    // Function
        function mappingTableTimeline(response){
            var data =''
            $('#progress_track_container').empty()
            for(i =0; i< response.length; i++){
                var color = ''
                            if(response[i].percentage >= 0 && response[i].percentage <= 25){
                                color ='danger'
                            }else if(response[i].percentage >= 26 && response[i].percentage <= 50){
                                color ='warning'
                            }else if(response[i].percentage >= 51 && response[i].percentage <= 75){
                                color ='info'
                            }else{
                                color ='success'
                            }
                data +=`
                <li class="list-group-item px-0">
                    <div class="row align-items-center">
                        <div class="col-auto">
                           <button class="btn btn-sm btn-dark go_project rounded" onclick="goProject('${response[i].request_code}','${response[i].link}')" data-request="${response[i].request_code}" data-link="${response[i].link}" title="Go To Project">
                            <i class="fa-solid fa-diagram-project"></i>
                           </button>
                        </div>
                      <div class="col">
                        <div class="progress-group">
                                                <div class="progress-group" style="font-size:10px !important;">
                                                    ${response[i].name}
                                                    <span class="float-right" style="font-size:10px">${response[i].percentage}%</span>
                                                    <div class="progress progress-md">
                                                        <div class="progress-bar bg-${color}" style="width: ${response[i].percentage}%;height:20px !important">
                                                    </div>
                                                
                                                </div>
                                            </div>
                        </div>
                    </div>
                  </li>
                `;
            }
            $('#progress_track_container').html(data)
        }

        function goProject(request_code,link){
                replace = request_code.replaceAll('/','_');
                if(link != ''){
                    window.open(`project/${replace}`,'_blank');
                }else{
                    toastr['warning']('BOT is not already, please contact ICT Dev to create this BOT :), Thank you');
                }
        }

        function mappingTask(response){
            var data_1 =''
            $('#task_container').empty()
            var select_project = $('#select_project').val()
            for(i =0; i < response.task_relation.length; i++){
                var task =''
                var pic = response.task_relation[i].pic 
                if(authId == pic && response.task_relation[i].status ==0 ){
                    task =`<li class="list-group-item mx-4 p-0">
                                <div class="row p-0">
                                <div class="col-1 mt-3">
                                    <input type="checkbox" id="check" name="check" class="is_checked" style="border-radius: 5px !important;" value="${response.task_relation[i]['id']}"  data-status="${response.task_relation[i]['status']}" data-id="${response.task_relation[i]['id']}" ${response.task_relation[i]['status'] == 1 ?'checked':'' } onchange="updateStatusTask('${response.task_relation[i].id}','${response.task_relation[i].status}','${select_project}')">
                                </div>
                                <div class="col-9">
                                    <label>${response.task_relation[i].detail_relation.name}</label>
                                    <p>${response.task_relation[i].name}</p>
                                    </div>
                                    <div class="col-1 mt-2">
                                        <button class="btn btn-sm btn-info  rounded" onclick="showDetail('${response.task_relation[i].id}')" title="Detail Information">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="col-1 mt-2">
                                        <button class="daily btn btn-sm btn-primary" title="Update Activity" data-id="${response.task_relation[i].id}" data-task="${response.task_relation[i].subdetail_code}" data-toggle="modal" data-target="#addDailyModal">
                                            <i class="fa-solid fa-book"></i>
                                        </button>
                                    </div>
                                </div>
                            </li>`
                }
                data_1 +=`
                    ${task}
                `;
            }
            $('#task_container').html(data_1)
        }

        function updateStatusTask(id, status,detail_code){
            var data ={
                'id' : id,
                'status' : status
            }
            postCallbackNoSwal('updateStatusTask',data, function(response){
                if(response.status==500){
                        toastr['warning'](response.message);
                    }
                    else{
                        toastr['success'](response.message);
                        var select_project = $('#select_project').val()
                        var data_test ={
                            'request_code' : select_project
                        }
                        getCallbackNoSwal('getTimelineHeaderDetail',data_test,function(response){
                            mappingTask(response.data[0])
                        })
                        getCallbackNoSwal('getTimelineHeaderUser',null,function(response){
                            mappingTableTimeline(response.data)
                        })
                        postBot(response.bot)
                        
                    }
            })
        }
        function showDetail(id){
            $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('getSubDetailTimeline')}}",
                    type: "get",
                    dataType: 'json',
                    async: true,
                    data:{
                        'id' :id
                    },
                    success: function(response) {
                        Swal.fire({
                                    title: "<strong>"+response.detail.name+"</strong>",
                                    icon: false,
                                    html: `
                                    <div class="container" style="text-align:left !important;width 300px !important">
                                        <div class="row">
                                            <div class="col-3">
                                                <p styke="color:black !important">Start Date</p>
                                            </div>
                                            <div class="col-9">
                                                <p styke="color:black !important">: ${convertDate(response.detail.start_date)}</p>
                                            </div>
                                            <div class="col-3">
                                                <p styke="color:black !important">End Date</p>
                                            </div>
                                            <div class="col-9">
                                                <p styke="color:black !important"> : ${convertDate(response.detail.start_date)}</p>
                                            </div>
                                            <div class="col-3">
                                                <p styke="color:black !important">PIC</p>
                                            </div>
                                            <div class="col-9">
                                                <p styke="color:black !important"> : ${response.detail.user_relation.name}</p>
                                            </div>
                                            <div class="col-3">
                                                <p styke="color:black !important">Description</p>
                                            </div>
                                            <div class="col-9">
                                                <p styke="color:black !important"> : ${response.detail.description}</p>
                                            </div>
                                        </div>
                                    </div>
                                 
                                    `,
                                    showCloseButton: false,
                                    showCancelButton: false,
                                    focusConfirm: false,
                                });
                    },
                    error: function(xhr, status, error) {
                        swal.close();
                        toastr['warning']('Failed to get data, please contact ICT Developer');
                    }
                });
        }

    // Function
</script>
