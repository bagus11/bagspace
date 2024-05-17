<script>
    getCallbackNoSwal('getTimelineCategory', null, function(response){
        swal.close()
        mappingTable(response.data)
    })
    getActiveItems('getActiveTimelineType',null,'select_type_edit','Type')
    $('#btn_add_category').on('click', function(){
        getActiveItems('getActiveTimelineType',null,'select_type','Type')
        
    })
    onChange('select_type','type_id')
    $('#btn_save_category').on('click', function(){
        var data ={
            'name'              : $('#name').val(),
            'description'       : $('#description').val(),
            'type_id'           : $('#type_id').val()
        }
        postCallback('saveTimelineCategory', data, function(response){
            swal.close()
            $('#addCategoryModal').modal('hide')
            toastr['success'](response.meta.message)
            getCallbackNoSwal('getTimelineCategory', null, function(response){
                swal.close()
                mappingTable(response.data)
            })
        })
    })
    $('#btn_update_category').on('click', function(){
        var data ={
            'name_edit'                 : $('#name_edit').val(),
            'description_edit'          : $('#description_edit').val(),
            'type_id_edit'              : $('#type_id_edit').val(),
            'id'                        : $('#editId').val()
        }
        postCallback('updateTimelineCategory', data, function(response){
            swal.close()
            $('#editCategoryModal').modal('hide')
            toastr['success'](response.meta.message)
            getCallbackNoSwal('getTimelineCategory', null, function(response){
                swal.close()
                mappingTable(response.data)
            })
        })
    })
    $('#category_table').on('change','.is_checked', function(){
        var id = $(this).data('id')
        var data ={
            'id': id
        }
        postCallbackNoSwal('updateStatusCategory',data, function(response){
            toastr['success'](response.meta.message);
            getCallbackNoSwal('getTimelineCategory',null,function(response){
                mappingTable(response.data)
            })
        })
    })
    $('#category_table').on('click', '.edit', function(){
        var id = $(this).data('id')
        var name = $(this).data('name')
        var type = $(this).data('type')
        var description = $(this).data('description')
        $('#editId').val(id)
        $('#name_edit').val(name)
        $('#type_id_edit').val(type)
        $('#select_type_edit').val(type)
        $('#select_type_edit').select2().trigger('change')
        $('#description_edit').val(description)
    })
    onChange('select_type_edit','type_id_edit')
    // Function
    function mappingTable(response){
            var data =''
            
            $('#category_table').DataTable().clear();
            $('#category_table').DataTable().destroy();
            for(i = 0; i < response.length; i++ )
                {
                            data += `<tr style="text-align: center;">
                                <td style="text-align: center;width:5%"> <input type="checkbox" id="check" name="check" class="is_checked" style="border-radius: 5px !important;" value="${response[i]['id']}"  data-status="${response[i]['status']}" data-id="${response[i]['id']}" ${response[i]['status'] == 1 ?'checked':'' }></td>
                                    <td style="text-align:center;width: 10%">${response[i].status == 1 ? 'active' : 'inactive'}</td>
                                    <td style="text-align:left;width:30%">${response[i].type_relation.name}</td>
                                    <td style="text-align:left;width:65%">${response[i].name}</td>
                                    <td style="width:15%">
                                            <button title="Detail" data-name="${response[i].name}" data-description="${response[i].description}" data-type="${response[i].type_id}" class="edit btn btn-sm btn-warning rounded"data-id="${response[i]['id']}" data-toggle="modal" data-target="#editCategoryModal">
                                                <i class="fas fa-solid fa-edit"></i>
                                            </button>   
                                    </td>
                                </tr>
                                `;
                }
            $('#category_table > tbody:first').html(data);
            $('#category_table').DataTable({
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
    // Function
</script>