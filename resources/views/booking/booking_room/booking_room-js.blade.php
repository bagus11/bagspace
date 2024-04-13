<script>
    // Call Function
    getCallback('getTicket', null,function(response){
        swal.close()
        mappingTable(response.data)
    })
    $('#btnRefresh').on('click', function(){
        getCallback('getTicket', null,function(response){
            swal.close()
            mappingTable(response.data)
        }) 
    })
    // Call Function

    // Operation
        $('#btn_add_room').on('click', function(){
            $('#room_container').prop('hidden', true)
            getActiveItems('getLocation',null,'select_location','Location')  
        })
        onChange('select_type','type_id')
        onChange('select_room','room_id')
        onChange('select_location','location_id')
        $('#select_type').on('change', function(){
            var type = $('#select_type').val()
            if(type === 1 || type === '1'){
                $('#room_container').prop('hidden', false)
            }else{
                $('#room_container').prop('hidden', true)
                $('#room_id').val('')
                $('#select_room').val('')
                $('#select_room').select2().trigger('change')
            }
        })
        $('#select_location').on('change', function(){
            var location = $('#select_location').val()
            var data ={
                'location_id' : location
            }
            getActiveItems('getActiveRoom',data,'select_room','Room')
        })

        $("#btn_save_ticket").on('click', function(){
            var data ={
                'description'   : $('#description').val(),
                'type_id'   : $('#type_id').val(),
                'location_id'   : $('#location_id').val(),
                'room_id'   : $('#room_id').val(),
                'title'   : $('#title').val(),
                'start_date'   : $('#start_date').val(),
                'start_time'   : $('#start_time').val(),
                'end_time'   : $('#end_time').val(),
            }
            postCallback('createTicket',data,function(response){
                swal.close()
                $('.message_error').html('')
                $('#addBookingModal').modal('hide')
                toastr['success'](response.meta.message);
                getCallbackNoSwal('getTicket', null,function(response){
                    mappingTable(response.data)
                })
            })
        })
        $('#booking_table').on('click', '.detail', function(){
            $('#last_booking_container').prop('hidden','true')
            var id = $(this).data('id')
            var data ={
                'id' : id
            }
            getCallback('detailTicket',data,function(response){
                swal.close()
                var status =''
                        var color =''
                        switch(response.detail.status){
                            case 0:
                                status ='NEW'
                                color ='primary'
                                break;
                            case 1:
                                status ='APPROVAL PROGRESS'
                                color ='default'
                                break;
                            case 2 :
                                status  = 'ON GOING'
                                color   = 'info'
                                break;
                            case 3 :
                                status  = 'DONE'
                                color   = 'success'
                                break;
                            default:
                        }
                if(response.detail.approval_id == 0){
                    $('#last_booking_container').prop('hidden',false)
                }
                $('#meeting_id_label').html(': ' + response.detail.meeting_id)
                $('#type_label').html(response.detail.type == 1 ? ': OFFLINE' : ': ONLINE')
                $('#start_date_label').val(response.detail.date_start)
                $('#start_time_label').val(response.detail.start_time)
                $('#end_time_label').val(response.detail.end_time)
                $('#pic_label').html(': ' + response.detail.user_relation.name)
                $('#status_label').html(`:  <span class="badge badge-${color}" style="font-weight:bold !important;dont-size:14px!important">${status}</span>`)
                $('#location_label').html(': '+ response.detail.location_relation.name)
                $('#room_label').html(response.detail.room_relation == null ? ': -' : ': '+response.detail.room_relation.name)
                $('#meeting_link_label').html(response.detail.meeting_code == 2 ?': -': ': <a target="_blank" href="'+response.detail.meeting_link+'" class="ml-3" style="color:blue;"> Click here</a>')
                $('#meeting_link_type_label').html(response.detail.meeting_code == 1 ?': Yes' : ': No')
                $('#meeting_type_label').html(response.private.length > 0 ?': Private' : ': Public')
                mappingTableActivity(response.data)
                mappingPIC(response.approval)
            })
        })

    
    // Operation


    // Function
    function mappingTable(response){
            var data =''
            $('#booking_table').DataTable().clear();
            $('#booking_table').DataTable().destroy();
            var data=''
                    for(i = 0; i < response.length; i++ )
                    {
                        var status =''
                        var color =''
                        switch(response[i].status){
                            case 0:
                                status ='NEW'
                                color ='primary'
                                break;
                            case 1:
                                status ='APPROVAL PROGRESS'
                                color ='default'
                                break;
                            case 2 :
                                status  = 'ON GOING'
                                color   = 'info'
                                break;
                            case 3 :
                                status  = 'DONE'
                                color   = 'success'
                                break;
                            default:
                        }
                        data += `<tr style="text-align: center;">
                                <td style="text-align:center;">${response[i].meeting_id}</td>
                                <td style="text-align:left;">${response[i].title}</td>
                                <td style="text-align:center;">${response[i].date_start}</td>
                                <td style="text-align:center;"><span class="badge badge-${color}" style="font-weight:bold !important;dont-size:14px!important">${status}</span></td>
                                <td style="">
                                        <button title="Detail Ticket" class="detail btn btn-sm btn-info rounded"   data-id="${response[i]['id']}" data-toggle="modal" data-target="#detailBookingModal">
                                            <i class="fas fa-solid fa-eye"></i>
                                        </button>
                                </td>
                            </tr>
                            `;
                    }
            $('#booking_table > tbody:first').html(data);
            $('#booking_table').DataTable({
                scrollX  : true,
                language: {
                                    'paginate': {
                                            'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                                            'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                                    }
                                },
            }).columns.adjust()
    }
    function mappingTableActivity(response){
            var data =''
            $('#detail_booking_table').DataTable().clear();
            $('#detail_booking_table').DataTable().destroy();
            var data=''
                    for(i = 0; i < response.length; i++ )
                    {
                        var status =''
                        var color =''
                        switch(response[i].status){
                            case 0:
                                status ='NEW'
                                color ='primary'
                                break;
                            case 1:
                                status ='APPROVAL PROGRESS'
                                color ='default'
                                break;
                            case 2 :
                                status  = 'ON GOING'
                                color   = 'info'
                                break;
                            case 3 :
                                status  = 'DONE'
                                color   = 'success'
                                break;
                            default:
                        }
                        const d = new Date(response[i].created_at)
                        const date = d.toISOString().split('T')[0];
                        const time = d.toTimeString().split(' ')[0];
                        data += `
                                    <tr style="text-align: center;">
                                            <td style="text-align:center; width:25% !important">${date} ${time}</td>
                                            <td style="text-align:left;width:25% !important">${response[i].user_relation.name}</td>
                                            <td style="text-align:left;width:50% !important">${response[i].remark}</td>
                                    </tr>
                                `;
                    }
            $('#detail_booking_table > tbody:first').html(data);
            $('#detail_booking_table').DataTable({
                scrollX     : true,
                searching   : false,
                paging      : false,
                ordering    : false,
                info        : false
            }).columns.adjust()
    }
    function mappingPIC(response){
            var data =''
            $('#approver_list_table').DataTable().clear();
            $('#approver_list_table').DataTable().destroy();
            var data=''
                    for(i = 0; i < response.length; i++ )
                    {
                        var status =''
                        var color =''
                        switch(response[i].status){
                            case 0:
                                status ='NEW'
                                color ='primary'
                                break;
                            case 1:
                                status ='APPROVAL PROGRESS'
                                color ='default'
                                break;
                            case 2 :
                                status  = 'ON GOING'
                                color   = 'info'
                                break;
                            case 3 :
                                status  = 'DONE'
                                color   = 'success'
                                break;
                            default:
                        }
                        const d = new Date(response[i].created_at)
                        const date = d.toISOString().split('T')[0];
                        const time = d.toTimeString().split(' ')[0];
                        var avatar = 'storage/users-avatar/' + response[i].approval_relation.avatar
                        data += `
                                    <tr style="text-align: center;">
                                            <td style="text-align:center; width:10% !important">${response[i].step}</td>
                                            <td style="text-align:left;width:10% !important"> 
                                                <span class="avatar avatar-sm rounded-circle" style="width:30px;height:30px">
                                                    <img src="{{URL::asset('${avatar}')}}" class="navbar-brand-img" alt="..."> 
                                                </span> 
                                            </td>
                                            <td style="text-align:left;width : 80%">
                                                ${response[i].approval_relation.name}
                                            </td>
                                                
                                                
                                    </tr>
                                `;
                    }
            $('#approver_list_table > tbody:first').html(data);
            var table = $('#approver_list_table').DataTable({
                scrollX     : true,
                searching   : false,
                paging      : false,
                ordering    : false,
                info        : false
            }).columns.adjust()
            autoAdjustColumns(table)
    }
    // Function
</script>