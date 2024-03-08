<script>
    getCallback('getGroup', null, function(response){
        swal.close()
        mappingTable(response.data)
    })
    // Operation
        $('#btn_add_group').on('click', function(){
            
            $('#name').val('');
            $('#description').val('');
        })
        $('#btn_save_group').on('click', function(){
            var data ={
                'name'          : $('#name').val(),
                'description'   : $('#description').val()
            }
            postCallback('addGroup',data,function(response){
                swal.close();
                    $('.message_error').html('')
                    toastr['success'](response.meta.message);
                    $('#addGroupModal').modal('hide')
                    getCallback('getGroup',null,function(response){
                        swal.close()
                        mappingTable(response.data)
                    })
            })
        })
        $('#group_table').on('click','.edit', function(){
            $('#btnAddNewPIC').prop('hidden', true)
            $('#btnDeletePic').prop('hidden', true)
            var group = $(this).data('group')
            data ={
                'group_code'    : group
            }
            $('#groupCode').val(group)
            getCallback('getDetailGroup',data, function(response){
                swal.close()
                mappingActive(response.active)
                mappingInactive(response.inactive)
            })

        })

          // On change for button Add New PIC
            $('#user_inactive_table').on('change', 'input[type="checkbox"]', function() {
                let opts = $("#user_inactive_table input[type=checkbox]:checked").length;
                if (opts > 0) {
                    $('#btnDeletePic').prop('hidden', true)
                    $(".checkedActive").attr("disabled", true);
                    $('#btnAddNewPIC').prop('hidden', false)
                } else {
                    $('#btnDeletePic').prop('hidden', true)
                    $(".checkedActive").attr("disabled", false);
                    $('#btnAddNewPIC').prop('hidden', true)
                }
            });
        // On change for button Add New PIC
        
        // On change for button delete pic
            $('#user_active_table').on('change', 'input[type="checkbox"]', function() {
                    let opts = $("#user_active_table input[type=checkbox]:checked").length;
                    if (opts > 0) {
                        $('#btnDeletePic').prop('hidden', false)
                        $(".checkedInactive").attr("disabled", true);
                        $('#btnAddNewPIC').prop('hidden', true)
                    } else {
                        $('#btnDeletePic').prop('hidden', true)
                        $(".checkedInactive").attr("disabled", false);
                        $('#btnAddNewPIC').prop('hidden', true)
                    }
            });
        // On change for button delete pic

        // Delete PIC
            $('#btnDeletePic').on('click', function(){
                var picId                       = [];
                var lengthParsed                = 0;
                var group_code                  = $('#groupCode').val()
                var user_active_table           = $('#user_active_table').dataTable();
                var rowcollection               =  user_active_table.$("input[type=checkbox]:checked",{"page": "all"});
                rowcollection.each(function(){
                    picId.push($(this).val());
                });
                lengthParsed = picId.length;
                var data ={
                    'picId'         :picId,
                    'group_code'   :group_code,
                    'type'          : '1'
                }
                postCallbackNoSwal('updateDetailGroup',data, function(response) {
                    if(response.status == 200){
                        toastr['success'](response.message);
                        var data_test = {'group_code' : $('#groupCode').val()}
                        getCallbackNoSwal('getDetailGroup',data, function(response){
                            swal.close()
                            mappingActive(response.active)
                            mappingInactive(response.inactive)
                        }) 
                        $('#btnDeletePic').prop('hidden', true)
                    }else{
                        toastr['error'](response.message);
                    }
                })
            })
        // Delete PIC

        // Add New PIC
            $('#btnAddNewPIC').on('click', function(){
                var picId = [];
                var lengthParsed = 0;
                var group_code = $('#groupCode').val()
                var user_inactive_table = $('#user_inactive_table').dataTable();
                var rowcollection =  user_inactive_table.$("input[type=checkbox]:checked",{"page": "all"});
                rowcollection.each(function(){
                    picId.push($(this).val());
                });
                lengthParsed = picId.length;
                var data ={
                    'picId'         : picId,
                    'group_code'    : group_code,
                    'type'          : '2'
                }
                postCallbackNoSwal('updateDetailGroup',data, function(response) {
                   
                    if(response.status == 200){
                        var data_test = {'group_code' : $('#groupCode').val()}
                        getCallbackNoSwal('getDetailGroup',data, function(response){
                            swal.close()
                            mappingActive(response.active)
                            mappingInactive(response.inactive)
                        }) 
                        toastr['success'](response.message);
                        $('#btnAddNewPIC').prop('hidden', true)
                    }else{
                        toastr['error'](response.message);
                    }
                })
            })
        // Add New PIC

        // Update Group
            $('#group_table').on('click', '.update',function(){
                var group = $(this).data('group')
                var data ={
                    'group_code' : group
                }
                getCallback('detailGroup', data,function(response){
                    swal.close()
                    $('#name_edit').val(response.detail.group_name)
                    $('#description_edit').val(response.detail.description)
                    $('#groupCode').val(group)
                })
            })

            $('#btn_update_group').on('click', function(e){
                e.preventDefault();
                    var data = new FormData();
                    data.append('name_edit',$('#name_edit').val())
                    data.append('description_edit',$('#description_edit').val())
                    data.append('group_code',$('#groupCode').val())
                    data.append('attachment',$('#attachment')[0].files[0]);

                    postAttachment('updateGroup',data,false,function(response){
                        swal.close()
                        $('#updateGroupModal').modal('hide')
                        $('.message_error').html('')
                        toastr['success'](response.meta.message);
                        getCallbackNoSwal('getGroup', null, function(response){
                            mappingTable(response.data)
                        })
                    })
            })
        // Update Group
    // Operation
    // Function
        function mappingTable(response){
            var data =''
            $('#group_table').DataTable().clear();
            $('#group_table').DataTable().destroy();
            for(i = 0; i < response.length; i++ )
                        {
                            data += `<tr style="text-align: center;">
                                    <td style="text-align: left;">${response[i]['group_code']==null?'':response[i]['group_code']}</td>
                                    <td style="text-align: left;">${response[i]['group_name']==null?'':response[i]['group_name']}</td>
                                    <td style="width:25%;text-align:center">
                                            <button title="Detail" class="edit btn btn-sm btn-info rounded"data-group="${response[i]['group_code']}" data-toggle="modal" data-target="#editGroupModal">
                                                <i class="fa-solid fa-users"></i>
                                            </button>
                                            <button title="update" class="update btn btn-sm btn-primary rounded"data-group="${response[i]['group_code']}" data-toggle="modal" data-target="#updateGroupModal">
                                                <i class="fa-solid fa-user-pen"></i>
                                            </button>
                                            
                                    </td>
                                </tr>
                                `;
                        }
                            $('#group_table > tbody:first').html(data);
                            $('#group_table').DataTable({
                                scrollX  : true,
                                searching  :true,
                                language: {
                                    'paginate': {
                                    'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                                    'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                                    }
                                },
                                scrollY  :230
                            }).columns.adjust()
            
        }
        function mappingActive(response){
            var data =''
            $('#user_active_table').DataTable().clear();
            $('#user_active_table').DataTable().destroy();
            for(i = 0; i < response.length; i++ )
                        {
                            data += `<tr style="text-align: center;">
                                            <td style="text-align:center;"><input type="checkbox" class="checkedActive" value="${response[i].user_id}" data-user_id="${response[i].user_id}"></td>
                                            <td style="text-align: left;">${response[i].user_relation.nik ==null?'':response[i].user_relation.nik}</td>
                                            <td style="text-align: left;">${response[i].user_relation.name==null?'':response[i].user_relation.name}</td>
                                    </tr>
                                `;
                        }
                            $('#user_active_table > tbody:first').html(data);
                            $('#user_active_table').DataTable({
                                scrollX  : true,
                                searching  :true,
                                pagingType: 'simple_numbers',
                                language: {
                                    'paginate': {
                                    'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                                    'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                                    }
                                },
                                scrollY  :230
                            }).columns.adjust()
        }
        function mappingInactive(response){
            var data =''
            $('#user_inactive_table').DataTable().clear();
            $('#user_inactive_table').DataTable().destroy();
            for(i = 0; i < response.length; i++ )
                        {
                            data += `<tr style="text-align: center;">
                                            <td style="text-align:center;"><input type="checkbox" class="checkedInactive" value="${response[i].id}" data-user_id="${response[i].id}"></td>
                                            <td style="text-align: left;">${response[i].nik ==null?'':response[i].nik}</td>
                                            <td style="text-align: left;">${response[i].name==null?'':response[i].name}</td>
                                    </tr>
                                `;
                        }
                            $('#user_inactive_table > tbody:first').html(data);
                            $('#user_inactive_table').DataTable({
                                scrollX  : true,
                                searching  :true,
                                pagingType: 'simple_numbers',
                                language: {
                                    'paginate': {
                                    'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                                    'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                                    }
                                },
                                scrollY  :230
                            }).columns.adjust()
        }
    // Function
</script>