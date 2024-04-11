<script>
    getCallback('getRoom',null,function(response){
        swal.close()
        mappingTable(response.data)
    })
    $('#btnRefresh').on('click', function(){
        getCallback('getRoom',null,function(response){
        swal.close()
        mappingTable(response.data)
    })
    })
    $('#btn_add_room').on('click', function(){
        getActiveItems('getLocation',null,'select_location','Location')
    })
    onChange('select_location','location_id')
    onChange('select_location_edit','location_id_edit')

    $('#btn_save_room').on('click', function(){
        var data ={
            'name' : $('#name').val(),
            'description' : $('#description').val(),
            'location_id' : $('#location_id').val(),
        }
        postCallback('addRoom',data, function(response){
            swal.close()
            $('.message_error').html('')
            $('#addMasterRoomModal').modal('hide')
            $('#name').val('')
            $('#description').val('')
            $('#location_id').val('')
            toastr['success'](response.meta.message);
            getCallbackNoSwal('getRoom', null, function(response){
                mappingTable(response.data)
            })
        })
    })
    $('#master_room_table').on('click','.edit', function(){
        var id = $(this).data('id')
        var data={
            'id':id
        }
        getActiveItems('getLocation',null,'select_location_edit','Location')
        getCallback('detailRoom',data,function(response){
            swal.close()
            $('#roomId').val(response.detail.id)
            $('#name_edit').val(response.detail.name)
            $('#description_edit').val(response.detail.description)
            $('#select_location_edit').val(response.detail.location)
            $('#select_location_edit').trigger('change')
            $('#location_id_edit').val(response.detail.location)
        })
    })
    $('#btn_update_room').on('click', function(){
        var data ={
            'id':$('#roomId').val(),
            'name_edit': $('#name_edit').val(),
            'description_edit': $('#description_edit').val(),
            'location_id_edit': $('#location_id_edit').val(),
        }
        postCallback('updateRoom',data, function(response){
            swal.close()
            $('.message_error').html('')
            $('#editMasterRoomModal').modal('hide')
            $('#name_edit').val('')
            $('#description_edit').val('')
            $('#location_id_edit').val('')
            toastr['success'](response.meta.message);
            getCallbackNoSwal('getRoom', null, function(response){
                mappingTable(response.data)
            })
        })
    })
    // Function
    function mappingTable(response){
            var data =''
            $('#master_room_table').DataTable().clear();
            $('#master_room_table').DataTable().destroy();
            for(i = 0; i < response.length; i++ )
                        {
                           
                            data += `<tr style="text-align: center;">
                                    <td style="text-align: center;width:10%;">${response[i]['status']==0?'<span class="badge badge-success">Available</span>':'<span class="badge badge-secondary">Used</span>'}</td>
                                    <td style="text-align: left;">${response[i]['name']==null?'':response[i]['name']}</td>
                                    <td style="text-align: left;width:10%;">${response[i]['location_relation']==null?'':response[i].location_relation.name}</td>
                                    <td style="width:5%;text-align:center">
                                            <button title="Detail" class="edit btn btn-sm btn-info rounded"data-id="${response[i]['id']}" data-toggle="modal" data-target="#editMasterRoomModal">
                                                <i class="fa-solid fa-edit"></i>
                                            </button>
                                            
                                    </td>
                                </tr>
                                `;
                        }
                            $('#master_room_table > tbody:first').html(data);
                            $('#master_room_table').DataTable({
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
    // Function
</script>