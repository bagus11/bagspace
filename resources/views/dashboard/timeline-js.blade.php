<script>
    getCallbackNoSwal('getTimelineHeaderUser',null,function(response){
        mappingTableTimeline(response.data)
        mappingTask(response.data[0])
        mappingDaily(response.daily)
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
    onChange('select_status','daily_status')
    $('#btn_save_daily').on('click', function(e){
        e.preventDefault();
        var data = new FormData();
        data.append('daily_name',$('#daily_name').val())
        data.append('daily_description',$('#daily_description').val())
        data.append('daily_status',$('#daily_status').val())
        data.append('daily_attachment',$('#daily_attachment')[0].files[0]);

        postAttachment('addDaily',data,false,function(response){
            swal.close()
            $('#addDailyModal').modal('hide')
            $('.message_error').html('')
            toastr['success'](response.meta.message);
            getCallbackNoSwal('getTimelineHeaderUser',null,function(response){
                mappingTableTimeline(response.data)
                mappingTask(response.data[0])
                mappingDaily(response.daily)
                $('#select_project').empty()
                $.each(response.data,function(i,data){
                    $('#select_project').append('<option style="margin-top:-5px; font-size:12px !Important" data-name="'+ data.name +'" value="'+data.request_code+'">' + data.name +'</option>');
                });
                
            })
        })
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
                var style =''
                const d = new Date();
                const date = d.toISOString().split('T')[0];
                const time = d.toTimeString().split(' ')[0];
                if(date > response.task_relation[i].end_date)
                {
                    style='style="color:#EE4E4E;"'
                }
                if(authId == pic && response.task_relation[i].status ==0 ){
                    task =`<li class="list-group-item mx-4 p-0" style="max-height:60px !important">
                                <div class="row p-0">
                               <div class="p-0 col-1 checkbox-container">
                                    <input type="checkbox" id="check" name="check" class="is_checked" value="${response.task_relation[i]['id']}" data-status="${response.task_relation[i]['status']}" data-id="${response.task_relation[i]['id']}" ${response.task_relation[i]['status'] == 1 ?'checked':'' } onchange="updateStatusTask('${response.task_relation[i].id}','${response.task_relation[i].status}','${select_project}')">
                                </div>
                                <div class="p-0 col-9 mt-2">
                                    <label ${style}>${response.task_relation[i].detail_relation.name}</label>
                                    <p ${style}>${response.task_relation[i].name}</p>
                                    </div>
                                    <div class="p-0 col-1 mt-3">
                                        <button class="btn btn-sm btn-info rounded" onclick="detail(${response.task_relation[i].id})" data-toggle="modal" data-target="#detailTimelineModal" title="Detail Information">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="p-0 col-1 mt-3">
                                        <button class="daily btn btn-sm btn-primary" title="Update Activity" data-id="${response.task_relation[i].id}" data-task="${response.task_relation[i].subdetail_code}" data-toggle="modal" data-target="#updateDailyModal">
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
        function detail(id){
            $('#log_task_table').DataTable().clear();
            $('#log_task_table').DataTable().destroy();
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
                            $('#start_date_sub_task_label').val(response.detail.start_date)
                            $('#end_date_task_label').val(response.detail.end_date)
                            $('#name_task_label').html(': ' + response.detail.name)
                            $('#select_pic_task').html(': ' + response.detail.user_relation.name)
                            var attachment_label ='-'
                            if(response.detail.attachment !==''){
                                attachment_label =`<a style="color:#76ABAE !important;font-size:10px !important" title="Click Here For Attachment" href="{{URL::asset('${response.detail.attachment}')}}" target="_blank">
                                    <i class="fa-solid fa-file-pdf"></i> Click Here
                                    </a>`
                            }
                            $('#attachment_label').html(': ' + attachment_label)
                            if(response.detail.amount > 0){
                                $('#actual_amount_label').html(': ' + convertToRupiah(response.detail.amount))
                            }else{
                                $('#actual_amount_label').html(': - ')
                            }
                            $('#description_task_label').html(': ' + response.detail.description)
                            
                            var mapping_data =''
                
                                    
                            for(i = 0; i < response.log_task.length; i++ )
                                {
                                    const d = new Date(response.log_task[i].created_at)
                                    const date = d.toISOString().split('T')[0];
                                    const time = d.toTimeString().split(' ')[0];
    
                                        mapping_data += `<tr style="text-align: center;">
                                                            <td style="text-align:center;width:10%">${convertDate(date)} ${time}</td>
                                                            <td style="text-align:left;width:15%">${response.log_task[i].creator_relation.name}</td>
                                                            <td style="text-align:left;width:10%">${response.log_task[i].name}</td>
                                                            <td style="text-align:left;width:15%">${response.log_task[i].user_relation.name}</td>
                                                            <td style="text-align:center;width:10%">${convertDate(response.log_task[i].start_date)}</td>
                                                            <td style="text-align:center;width:10%">${convertDate(response.log_task[i].end_date)}</td>
                                                            <td style="text-align:right;width:10%">${convertToRupiah(response.log_task[i].amount)}</td>
                                                            <td style="text-align:left;width:20%">${response.log_task[i].remark}</td>
                                                        </tr>
                                                `;
                                }
                            $('#log_task_table > tbody:first').html(mapping_data);
                            $('#log_task_table').DataTable({
                                // scrollX  : true,
                                language: {
                                                    'paginate': {
                                                            'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                                                            'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                                                    }
                                                },
                            }).columns.adjust()
                        },
                        error: function(xhr, status, error) {
                            swal.close();
                            toastr['warning']('Failed to get data, please contact ICT Developer');
                        }
                    });
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
        function mappingDaily(response){
            $('#daily_container').empty()
            var task =''
            for(i =0; i < response.length; i++){
                    task +=`<li class="list-group-item mx-4 p-0" style="max-height:60px !important">
                                <div class="row p-0">
                                <div class="p-0 col-10 mt-2">
                                    <label>${response[i].name}</label>
                                    <p>${response[i].remark}</p>
                                    </div>
                                    <div class="p-0 col-2 mt-3">
                                      <button class="btn btn-sm btn-info rounded" onclick="detailActivity('${response[i].id}')" title ="Detail" data-toggle="modal" data-target="#detailDailyModal">
                                        <i class="fa-solid fa-eye"></i>
                                      </button>
                                    </div>
                                </div>
                            </li>`
            }
            $('#daily_container').html(task)
           
        }
        function reportDaily(id){
            window.open(`print_daily/${id}`,'_blank');
        }
        function detailActivity(id){
            data={'id':id}
            getCallback('detailActivity',data,function(response){
                swal.close()
                var attachment ='-'
                
                if(response.detail.attachment !==''){
                   attachment =  `<a style="color:#76ABAE !important;font-size:10px !important" title="Click Here For Attachment" href="{{URL::asset('${response.detail.attachment}')}}" target="_blank">
                                    <i class="fa-solid fa-file-pdf"></i> Click Here
                                    </a>`
                }
                var status = response.detail.status == 1 ? 'On Progress' : 'Done'
                $('#daily_name_label').html(': ' +  response.detail.name)
                $('#daily_start_date_label').html(': ' +  convertDate(response.detail.start_date))
                $('#daily_description_label').html(': ' +  response.detail.description)
                $('#daily_status_label').html(': ' +  status)
                $('#daily_attachment_label').html(': ' +  attachment)

            })
        }
    // Function
</script>
