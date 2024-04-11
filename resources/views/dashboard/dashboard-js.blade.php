<script>
    $('#approver_container').prop('hidden',true);
    $('#userMeetContainer').prop('hidden',true);
    $('#userListContainer').prop('hidden',true);
    $('#lastApproverContainer').prop('hidden',true);
    toastr['info']('Hello ' + nameAuth );

    var array_list_user = [];
    getCallbackNoSwal('getApprover',null,function(response){
        if(response.data.length > 0){
            $('#approver_container').prop('hidden',false);
            mappingTableApprover(response.data)
        }
    })
    $('#approver_table').on('click','.detail', function(){
        var id = $(this).data("id");
        array_list_user = []
        var data ={
            'id':id
        }
        getCallbackNoSwal('detailTicket',data, function(response){
            var typeLabel =response.detail.type == 1 ? 'Offline' :'Online'
            var status =''
            var color =''
            switch(response.detail.status){
                case 0:
                    status ='APPROVAL PROGRESS'
                    color ='info'
                    break;
                case 1:
                    status ='APPROVAL PROGRESS'
                    color ='warning'
                    break;
                default:
            }
            var lastApprover = response.approval.slice(-1).pop()
            $('#meetingIdLabel').html(': ' + response.detail.meeting_id)
            $('#typeLabel').html( ': ' + typeLabel)
            $('#meetingId').val(response.detail.meeting_id)
            $('#titleLabel').html(': ' + response.detail.title)
            $('#startDateLabel').html(': ' + response.detail.date_start)
            $('#startTimeLabel').html(': ' + response.detail.start_time)
            $('#endTimeLabel').html(': ' + response.detail.end_time)
            $('#descriptionLabel').html(': ' + response.detail.description)
            $('#userLabel').html(': ' + response.detail.user_relation.name)
            $('#roomLabel').html(': ' + response.detail.room_relation.name)
            $('#statusLabel').html(': ' +'<span class="badge badge-'+color+'">'+status+'</span>' )
            mappingTableUser(response.user)

            if(lastApprover.user_id == authId){
                $('#lastApproverContainer').prop('hidden',false);
            }else{
                $('#lastApproverContainer').prop('hidden',true);
            }

        })
    })
    onChange('selectApproval','approval_id')
    onChange('select_option_meet','option_meet_id')
    $("#btn_save_approval").on('click', function(){
        var data ={
            'meeting_id'        : $('#meetingId').val(),
            'approval_id'       : $('#approval_id').val(),
            'remark_approval'   : $('#remark_approval').val(),
            'option_meet_id'    : $('#option_meet_id').val(),
            'selectApproval'    : $('#selectApproval').val(),
            'array_list_user'   : array_list_user
        }

        postCallback('updateApprovalTicket',data, function(response){
            swal.close()
            $('.message_error').html('')
            $('#editBookingModal').modal('hide')
            $('#approval_id').val('')
            $('#remark_approval').val('')
            toastr['success'](response.meta.message);
            $('#approver_container').prop('hidden', true)
            getCallbackNoSwal('getApprover',null,function(response){
                if(response.data.length > 0){
                    $('#approver_container').prop('hidden',false);
                    mappingTableApprover(response.data)
                }
            })
        })
    })
    $('#select_option_type').on('change', function(){
        var select_option_type = $('#select_option_type').val()
        if(select_option_type == 2){
            $('#userMeetContainer').prop('hidden', false)
        }else{
            $('#userMeetContainer').prop('hidden', true)
        }
    })
    
    $('#userMeetTable').on('change','.is_checked', function(event){
        var {name,value, checked} =event.target
        var nik = $(this).data('nik')
        var name = $(this).data('name')
        if(checked){
            var post = {
                'nik'       : nik,
                'name'      : name,
                'value'     : value
            }
            array_list_user.push(post)
            mappingArrayMeet(array_list_user)
        }else{
            var index = findIndexByProperty(array_list_user,'nik', nik)
            if (index !== -1) {
                array_list_user.splice(index, 1); // Remove 1 element at index
            }
            console.log(array_list_user)
            // removeItemFromTable(value)
            mappingArrayMeet(array_list_user)
        }
        if(array_list_user.length == 0){
            $('#userListContainer').prop('hidden', true)
        }else{
            $('#userListContainer').prop('hidden', false)
        }
    })
    $('#userListTable').on('click','.delete', function(){
        var nik = $(this).data('nik')
        var index = findIndexByProperty(array_list_user,'nik', nik)
        deleteRow($(this).closest('tr'));
        if (index !== -1) {
                array_list_user.splice(index, 1); // Remove 1 element at index
            }
            console.log(array_list_user)
            // removeItemFromTable(value)
            mappingArrayMeet(array_list_user)
    })
    function deleteRow(row) {
        var name = row.find('td:first').text().trim();
        var nameA = []
        $('#userMeetTable tbody tr').each(function() {
            var nameA = $(this).find('td:nth-child(2)').text().trim();
            if (nameA == name) {
                $(this).find('input[type="checkbox"]').prop('checked', false);
                return false; // exit loop early
            }
        });

    }
    function mappingTableApprover(response){
        var data =''
            $('#approver_table').DataTable().clear();
            $('#approver_table').DataTable().destroy();
            var data=''
                    for(i = 0; i < response.length; i++ )
                    {
                        var status =''
                        switch(response[i].status){
                            case 0:
                                status ='APPROVAL PROGRESS'
                                break;
                            case 1:
                                status ='APPROVAL PROGRESS'
                                // code block
                                break;
                            default:
                        }
                        data += `<tr style="text-align: center;">
                                <td style="text-align:center;">${response[i].meeting_id}</td>
                                <td style="">
                                        <button title="Assign Approval Here" class="detail btn btn-sm btn-info rounded"   data-id="${response[i]['id']}" data-toggle="modal" data-target="#editBookingModal">
                                            <i class="fas fa-solid fa-edit"></i>
                                        </button>
                                </td>
                            </tr>
                            `;
                    }
            $('#approver_table > tbody:first').html(data);
            $('#approver_table').DataTable({
                scrollX  : true,
                searching   :false,
                info   :false,
                searching :false,
                pagingType: "simple",
                language: {
                                    'paginate': {
                                    'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                                    'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                                    }
                                },
            }).columns.adjust()
    }
    function mappingTableUser(response){
        var data =''
            $('#userMeetTable').DataTable().clear();
            $('#userMeetTable').DataTable().destroy();
            var data=''
                    for(i = 0; i < response.length; i++ )
                    {
                        data += `<tr style="text-align: center;">
                                <td style="text-align: center;width:10%">
                                    <div class="checkbox-wrapper-24">
                                        <input type="checkbox" id="check" name="check" data-nik ='${response[i].nik}' data-name='${response[i].name}' class="is_checked" style="border-radius: 100px !important;" value="${response[i]['id']}"  data-name="${response[i]['name']}">
                                    </div>
                                    </td>
                                <td style="text-align:left;width:90%">${response[i].name}</td>
                                
                            </tr>
                            `;
                    }
            $('#userMeetTable > tbody:first').html(data);
            var table = $('#userMeetTable').DataTable({
                scrollX     : true,
                searching   : true,
                pagingType  : "simple",
                pageLength  : 10,
                info        : false,
                lengthChange: false,
                language: {
                                    'paginate': {
                                    'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                                    'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                                    }
                                },
            }).columns.adjust()
            autoAdjustColumns(table)
    }
    function mappingArrayMeet(response){
        var data =''
            $('#userListTable').DataTable().clear();
            $('#userListTable').DataTable().destroy();
            var data=''
                    for(i = 0; i < response.length; i++ )
                    {
                        data += `<tr style="text-align: center;">
                                <td style="text-align: left;width:90%">
                                    ${response[i].name}
                                </td>
                                <td style="text-align:left;width:10%">
                                    <button class="btn btn-sm btn-danger delete" data-i ="${i}" data-nik="${response[i].nik}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            `;
                    }
            $('#userListTable > tbody:first').html(data);
            var table = $('#userListTable').DataTable({
                scrollX     : true,
                searching   : true,
                pagingType  : "simple",
                pageLength  : 10,
                info        : false,
                lengthChange: false,
                language: {
                                    'paginate': {
                                    'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                                    'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                                    }
                                },
            }).columns.adjust()
            autoAdjustColumns(table)
    }
 
</script>