<script>
    getCallback('getTeamTimeline', null, function(response){
        swal.close()
        mappingTable(response.data)
    })
    $('#team_table').on('click', '.is_checked', function(){
        var status = $(this).data('status')
        var data={
            'id' :$(this).data('id'),
            'status':status
        }
        postCallback('updateStatusMasterTeamTimeline',data, function(response){
            swal.close()
            toastr['success'](response.meta.message);
            getCallbackNoSwal('getTeamTimeline', null, function(response){
                mappingTable(response.data)
            })
        })
    })

    $('#team_table').on('click', '.detail', function() {
        $('#titleDetail').html('User List')
        $('#btnEditDetail').prop('hidden', false)
        $('#btnSaveDetail').prop('hidden', true)
        var id = $(this).data('id');
        var data ={
            'id':id
        }
        getCallback('getDetailTeam',data, function(response){
                swal.close();
                $('#masterIdDetail').val(id)
                mappingDetail(response.active)
        })
            $('#detailTeamTable').DataTable().clear();
            $('#detailTeamTable').DataTable().destroy();
    });
    $('#team_table').on('click', '.add', function() {
        $('#titleDetail').html('Add User Team')
        $('#btnEditDetail').prop('hidden', true)
        $('#btnSaveDetail').prop('hidden', false)
        var id = $(this).data('id');
        var data ={
            'id':id
        }
        getCallback('getDetailTeam',data, function(response){
                swal.close();
                $('#masterIdDetail').val(id)
                mappingDetail(response.innactive)
        })
            $('#detailTeamTable').DataTable().clear();
            $('#detailTeamTable').DataTable().destroy();
    });
    $('#team_table').on('click','.edit', function(){
        $('#listTeamProject').DataTable().clear();
        $('#listTeamProject').DataTable().destroy();
       var id = $(this).data('id');
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('getMasterTeamDetail')}}",
                type: "get",
                dataType: 'json',
                async: true,
                data:{
                    'id':id
                },
                beforeSend: function() {
                    SwalLoading('Please wait ...');
                },
                success: function(response) {
                    swal.close();
                    $('#teamNameUpdate').val(response.detail.name)
                    $('#teamHeadId').val(id)
                    $('#selectLeader').empty()
                    $('#leaderId').val(response.leader == null? '': response.leader.id)
                    response.leader == null ? $('#selectLeader').append('<option value ="">Choose PIC</option>') : $('#selectLeader').append('<option value ="'+response.leader.user_id+'">'+response.leader.username+'</option>')
                    $.each(response.table,function(i,data){
                    $('#selectLeader').append('<option value="'+data.user_id+'">' + data.username +'</option>');
                    });
                    var data =''
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
                    $('#listTeamProject > tbody:first').html(data);
                    $('#listTeamProject').DataTable({
                        scrollX  : true,
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
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    
    })
    $('#checkAll').on('click', function(){
     // Get all rows with search applied
        var table = $('#detailTeamTable').DataTable();
        var rows = table.rows({ 'search': 'applied' }).nodes();
     // Check/uncheck checkboxes for all rows in the table
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
    });
  onChange('selectLeader','leaderId')
  $('#btnUpdateName').on('click', function(){
        var data = {
            'teamNameUpdate':$('#teamNameUpdate').val(),
            'leaderId':$('#leaderId').val(),
            'id':$('#teamHeadId').val()
        }
        saveHelper('updateMasterTeam',data,'master_team_timeline')
   })
    $('#btnEditDetail').on('click', function(){
        var checkArray = [];
        var lengthParsed = 0;
        var detailTeamTable = $('#detailTeamTable').DataTable();
        var rowcollection =  detailTeamTable.$("input:checkbox[name=check]:checked",{"page": "all"});
        rowcollection.each(function(){
            checkArray.push($(this).val());
        });
        lengthParsed = checkArray.length;
        if(lengthParsed == 0)
        {
            toastr['error']('Please select 1 or more user');
            return false;
        }

        var data ={
            'checkArray':checkArray,
            'id':$('#masterIdDetail').val(),
        }
    
        saveRepo('updateDetailTeam',data,'master_team_timeline')
    })
    $('#btnSaveDetail').on('click', function(){
        var checkArray = [];
        var lengthParsed = 0;
        var detailTeamTable = $('#detailTeamTable').DataTable();
        var rowcollection =  detailTeamTable.$("input:checkbox[name=check]:checked",{"page": "all"});
        rowcollection.each(function(){
            checkArray.push($(this).val());
        });
        lengthParsed = checkArray.length;
        if(lengthParsed == 0)
        {
            toastr['error']('Please select 1 or more user');
            return false;
        }

        var data ={
            'checkArray':checkArray,
            'id':$('#masterIdDetail').val(),
        }
    
        saveRepo('addDetailTeam',data,'master_team_timeline')
    })
    $('#btn_save_team').on('click', function(){
        var data={
            'team_name':$('#team_name').val()
        }
        postCallback('saveTeam',data,function(response){
                swal.close()
                $('.message_error').html('')
                $('#addTeamModal').modal('hide')
                toastr['success'](response.meta.message);
                getCallbackNoSwal('getTeamTimeline', null,function(response){
                    mappingTable(response.data)
                })
            })
    })
    function mappingTable(response){
            var data =''
            
            $('#team_table').DataTable().clear();
            $('#team_table').DataTable().destroy();
            for(i = 0; i < response.length; i++ )
                {
                            data += `<tr style="text-align: center;">
                                <td style="text-align: center;width:5%"> <input type="checkbox" id="check" name="check" class="is_checked" style="border-radius: 5px !important;" value="${response[i]['id']}"  data-status="${response[i]['status']}" data-id="${response[i]['id']}" ${response[i]['status'] == 1 ?'checked':'' }></td>
                                    <td style="text-align:center;width: 10%">${response[i].status == 1 ? 'active' : 'inactive'}</td>
                                    <td style="text-align:left;width:65%">${response[i].name}</td>
                                    <td style="width:15%">
                                            <button title="Add Detail Team" class="add btn btn-sm btn-success rounded"data-id="${response[i]['id']}" data-toggle="modal" data-target="#addTeamDetail">
                                                <i class="fas fa-solid fa-plus"></i>
                                            </button>
                                            <button title="List Team" class="detail btn btn-sm btn-danger rounded"data-id="${response[i]['id']}" data-toggle="modal" data-target="#addTeamDetail">
                                                <i class="fas fa-solid fa-list"></i>
                                            </button>
                                            <button title="Detail" class="edit btn btn-sm btn-info rounded"data-id="${response[i]['id']}" data-toggle="modal" data-target="#editTeamDetail">
                                                <i class="fas fa-solid fa-users"></i>
                                            </button>   
                                    </td>
                                </tr>
                                `;
                }
            $('#team_table > tbody:first').html(data);
            $('#team_table').DataTable({
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
    function mappingDetail(x){
        var data =''
        for(i = 0; i < x.length ; i++){
            data +=`
                    <tr>
                        <td style="text-align: center;width:10%"> <input type="checkbox" id="checkAll" name="check" class="is_checked" style="border-radius: 5px !important;" value="${x[i]['id']}"  data-name="${x[i]['name']}"></td>
                        <td style="width:90%">${x[i].name}</td>
                    </tr>
            `;

        }
        $('#detailTeamTable > tbody:first').html(data);
        $('#detailTeamTable').DataTable({
            scrollX  : true,
                language: {
                                    'paginate': {
                                            'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                                            'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                                    }
                                },
            scrollY  :220
        }).columns.adjust()
    }
   
</script>