<script>
    getCallback('getTimelineHeader',null, function(response){
        swal.close()
        mappingTable(response.data)
    })
    $('#btnRefresh').on('click',function(){
        getCallback('getTimelineHeader',null, function(response){
        swal.close()
        mappingTable(response.data)
    })
    })
    $('#btn_add_ticket').on("click", function(){
        $('#detail_team_container').prop('hidden', true)
        getActiveItems('getLocation',null,'select_office','Location')
        getActiveItems('getActiveTimelineType',null,'select_type','Type')
        getActiveItems('getActiveTeam',null,'select_team','Team')
        $('#name').val('')
        $('#office_id').val('')
        $('#description').val('')
        $('#team_id').val('')
        $('.message_error').html('')
    })
    onChange('select_office','office_id')
    onChange('select_team','team_id')
    onChange('select_type','type_id')
    $('#select_team').on('change',function(){
        var id = $('#select_team').val()
        var data ={
            'id':id
        }
        getCallback('getMasterTeamDetail',data,function(response){
            swal.close()
            $('#detail_team_container').prop('hidden', false)
           mappingTableTeam('table_detail_team',response)
        })
    })
    $('#btn_save_ticket').on('click', function(){
        var data ={
            'team_id':$('#team_id').val(),
            'name':$('#name').val(),
            'description':$('#description').val(),
            'office_id':$('#office_id').val(),
            'start_date':$('#start_date').val(),
            'end_date':$('#end_date').val(),
            'type_id':$('#type_id').val(),
        }
       
        postCallback('saveTimelineHeader', data, function(response){
            swal.close()
            $('#select_team').val('')
            $('#select_team').select2().trigger('change');
            $('#select_office').val('')
            $('#select_office').select2().trigger('change');
            $('.message_error').html('')
                $('#addTimelineHeader').modal('hide')
                toastr['success'](response.meta.message);
                getCallbackNoSwal('getTimelineHeader', null,function(response){
                    mappingTable(response.data)
                })
        })
    })
    $('#timeline_header_table').on('click','.detail', function(){
        var id = $(this).data('id')
        var data ={
            'id':id
        }
        getCallback('detailTimeline', data, function(response){
            swal.close()
            var status =''
            var color =''
            switch(response.detail.status){
                case 0:
                    status ='NEW'
                    color ='secondary'
                    break;
                case 1:
                    status ='On Progress'
                    color ='info'
                    break;
                case 2:
                    status ='PENDING'
                    color ='warning'
                    break;
                case 3:
                    status ='DONE'
                    color ='success'
                    break;
                case 3:
                    status ='TOO LATE'
                    color ='danger'
                    break;
                default:
            }
            $('#request_code_label').html(': ' + response.detail.request_code)
            $('#name_label').html(': ' + response.detail.name)
            $('#description_label').html(': ' + response.detail.description)
            $('#team_name_label').html(': ' + response.detail.team_relation.name)
            $('#pic_label').html(': ' + response.detail.pic_relation.name)
            $('#location_label').html(': ' + response.detail.office_relation.name)
            $('#link_label').html(': <a target=”_blank” href="' + response.detail.link + '"> Click here </a>')
            $('#start_date_label').val(response.detail.start_date)
            $('#end_date_label').val(response.detail.end_date)
            $('#status_label').html(`:  <span class="badge badge-${color}" style="font-weight:bold !important;dont-size:14px!important">${status}</span>`)
            mappingTableTeam('detail_team_table_project',response)
        })
    })
    
    $('#timeline_header_table').on('click','.edit', function(){
        var id = $(this).data('id')
        var data ={
            'id':id
        }
        getCallback('detailTimeline', data, function(response){
            swal.close()
            $('#project_name_edit').html(': ' + response.detail.name)
            $('#request_code_label_edit').html(': ' + response.detail.request_code)
            $('#start_date_edit').val(response.detail.start_date)
            $('#end_date_edit').val(response.detail.end_date)
            $('#request_code_edit').val(response.detail.request_code)
            $('#team_id_edit').val(response.detail.team_id)
            $('#editId').val(id)
            mappingLogTimelineDate(response.log)
        })
    })
    $('#timeline_header_table').on('click','.project', function(){
        var id = $(this).data('id')
        var link = $(this).data('link')
        var request = $(this).data('request')
            replace = request.replaceAll('/','_');
            if(link != ''){
                window.open(`project/${replace}`,'_blank');
            }else{
                toastr['warning']('BOT is not already, please contact ICT Dev to create this BOT :), Thank you');
            }
    })
    $('#timeline_header_table').on('click','.bot', function(){
        var id = $(this).data('id')
        $('.message_error').html('')
        $('#editId').val(id)
        $('#channel').val('')
        $('#link').val('')
    })
    $('#btn_summon_bot').on('click', function(){
        var data ={
            'channel' : $("#channel").val(),
            'link' : $("#link").val(),
            'id' : $("#editId").val(),
        }
        postCallback('summonBot', data, function(response){
            swal.close()
            $('#botTimelineModal').modal('hide')
            toastr['success'](response.meta.message);
            getCallbackNoSwal('getTimelineHeader',null, function(response){
                mappingTable(response.data)
            })
        })
    })
    $('#btn_update_timeline_header').on('click',function(){
        var data ={
            'start_date_edit' :$('#start_date_edit').val(),
            'end_date_edit' :$('#end_date_edit').val(),
            'request_code_edit' :$('#request_code_edit').val(),
            'team_id_edit' :$('#team_id_edit').val(),
            'description_edit' :$('#description_edit').val(),
        }
        postCallbackNoSwal('updateLogTimelineHeaderDate',data,function(response){
            toastr['success'](response.meta.message);
            var dataTest ={
                    'id':  $('#editId').val()
            }
            getCallbackNoSwal('detailTimeline', dataTest, function(response){
                    $('#project_name_edit').html(': ' + response.detail.name)
                    $('#request_code_label_edit').html(': ' + response.detail.request_code)
                    $('#start_date_edit').val(response.detail.start_date)
                    $('#end_date_edit').val(response.detail.end_date)
                    $('#request_code_edit').val(response.detail.request_code)
                    $('#team_id_edit').val(response.detail.team_id)
                    mappingLogTimelineDate(response.log)
                })
        })
    })
    $('#timeline_header_table').on('click', '.export', function(){
        var request_code = $(this).data('request')
        var id = $(this).data('id')
        var data ={
            'id':id,
            'request_code': request_code
        }

    })
    function mappingTable(response){
        var data =''
            
            $('#timeline_header_table').DataTable().clear();
            $('#timeline_header_table').DataTable().destroy();
            for(i = 0; i < response.length; i++ )
                {
                    var status =''
                    var color =''
                    switch(response[i].status){
                        case 0:
                            status ='NEW'
                            color ='secondary'
                            break;
                        case 1:
                            status ='On Progress'
                            color ='info'
                            break;
                        case 2:
                            status ='PENDING'
                            color ='warning'
                            break;
                        case 3:
                            status ='DONE'
                            color ='success'
                            break;
                        case 3:
                            status ='TOO LATE'
                            color ='danger'
                            break;
                        default:

                        }
                            data += `<tr style="text-align: center;">
                                        <td style="text-align: center;width:15%">${response[i].request_code}</td>
                                        <td style="text-align: left;width:10%">${response[i].type_relation.name}</td>
                                        <td style="text-align: left;width:15%">${response[i].team_relation.name}</td>
                                        <td style="text-align: center;width:30%">
                                            <div class="progress-group">
                                                <div class="progress-group">
                                                    ${response[i].name}
                                                    <span class="float-right" style="font-size:10px">${response[i].percentage}%</span>
                                                    <div class="progress progress-md">
                                                        <div class="progress-bar bg-success" style="width: ${response[i].percentage}%;height:20px !important">
                                                    </div>
                                                </div>
                                            </div>
                                            </td>
                                        <td style="text-align: center;width:5%;margin:auto">
                                            <span class="badge badge-${color}" style="font-weight:bold !important;dont-size:14px!important">${status}</span>    
                                        </td>
                                        
                                        <td style="width:25%">
                                                <button title="Detail" class="detail btn btn-sm btn-info rounded"data-id="${response[i]['id']}" data-toggle="modal" data-target="#detailTimelineHeader">
                                                    <i class="fas fa-solid fa-eye"></i>
                                                </button>   
                                                  
                                                @can('update-monitoring_timeline')
                                                <button title="Update Dateline" class="edit btn btn-sm btn-warning rounded"data-id="${response[i]['id']}" data-toggle="modal" data-target="#editTimelineHeader">
                                                    <i class="fas fa-solid fa-edit"></i>
                                                </button>  
                                                <button title="Create Telegram BOT" class="bot btn btn-sm btn-primary rounded"data-id="${response[i]['id']}" data-toggle="modal" data-target="#botTimelineModal" ${response[i].status_bot != 0 ? 'hidden' : ''}>
                                                    <i class="fa-solid fa-robot"></i>
                                                </button> 
                                                @endcan
                                             
                                                <button title="Go To Project" class="project btn btn-sm btn-dark rounded"data-id="${response[i]['id']}" data-toggle="modal" data-request="${response[i]['request_code']}" data-target="#addTeamDetail" ${response[i].link =='' ? 'disabled' :''} data-link ="${response[i].link}">
                                                    <i class="fa-solid fa-diagram-project"></i>
                                                </button>
                                        </td>
                                </tr>
                                `;
                }
            $('#timeline_header_table > tbody:first').html(data);
            $('#timeline_header_table').DataTable({
                scrollX  : true,
                language: {
                                    'paginate': {
                                            'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                                            'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                                    }
                                },
                scrollY  :265
            }).columns.adjust()
    }
    function mappingTableTeam(name,response){
        var data =''
        
        $('#'+name).DataTable().clear();
        $('#'+name).DataTable().destroy();
        for(i =0 ; i < response.table.length; i++){
                        var position =''
                        switch(response.table[i].position){
                            case 1:
                                position ='Staff'
                                color ='primary'
                                break;
                            case 2:
                                position ='Leader'
                                color ='default'
                                break;
                            default:

                        }
                        data +=`
                            <tr>

                                <td style="width:5%;text-align:center">${i +1}</td>
                                <td style="width:85%">${response.table[i].username}</td>
                                <td style="width:10%;text-align:center">
                                    <span class="badge badge-${color}" style="font-weight:bold !important;dont-size:14px!important">${position}</span>
                                </td>
                            </tr>
                        `
                    }
                    $(`#${name} > tbody:first`).html(data);
                    $('#'+name).DataTable({
                        scrollX  : true,
                        language: {
                                    'paginate': {
                                            'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                                            'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                                    }
                                },
                    }).columns.adjust()
    }
    function mappingLogTimelineDate(response){
        var data =''
        $('#log_history_update').DataTable().clear();
        $('#log_history_update').DataTable().destroy();
        for(i = 0; i < response.length; i++ )
            {
                const d = new Date(response[i].created_at)
                const date = d.toISOString().split('T')[0];
                const time = d.toTimeString().split(' ')[0];
                        data += `<tr style="text-align: center;">
                                    <td style="text-align: center;width:15%">${date} ${time}</td>
                                    <td style="text-align: left;width:25%">${response[i].pic_relation.name}</td>
                                    <td style="text-align: center;width:15%">${response[i].start_date}</td>
                                    <td style="text-align: center;width:15%">${response[i].end_date}</td>
                                    <td style="text-align: left;width:30%">${response[i].remark}</td>
                                    
                            </tr>
                            `;
            }
        $('#log_history_update > tbody:first').html(data);
        $('#log_history_update').DataTable({
            scrollX  : true,
            searching :false,
            order: [[0, 'desc']],
            language: {
                                'paginate': {
                                        'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                                        'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                                }
                            },
            scrollY  :180
        }).columns.adjust()
    }
    
</script>