<script>
    getCallback('getTimelineType',null,function(response){
        swal.close()
        mappingTable(response.data)
    })
    $('#btn_save_type').on('click', function(){
        var data ={
            'name' : $('#name').val()
        }
        postCallback('saveTimelineType',data, function(response){
            swal.close()
            $('#addTypeModal').modal('hide')
            toastr['success'](response.meta.message);
            getCallbackNoSwal('getTimelineType',null,function(response){
                mappingTable(response.data)
            })
        })
    })
    $('#type_table').on('click', '.edit', function(){
        var id = $(this).data('id')
        var name = $(this).data('name')
        $('#editId').val(id)
        $('#name_edit').val(name)
    })
    $('#btn_update_type').on('click', function(){
        var data ={
            'name_edit' : $('#name_edit').val(),
            'id' : $('#editId').val()
        }
        postCallback('updateTimelineType',data,function(response){
            swal.close()
            $('#editTypeModal').modal('hide')
            toastr['success'](response.meta.message);
            getCallbackNoSwal('getTimelineType',null,function(response){
                mappingTable(response.data)
            })
        })
    })
    $('#type_table').on('change','.is_checked', function(){
        var id = $(this).data('id')
        var data ={
            'id': id
        }
        postCallbackNoSwal('updateStatusType',data, function(response){
            toastr['success'](response.meta.message);
            getCallbackNoSwal('getTimelineType',null,function(response){
                mappingTable(response.data)
            })
        })
    })
    // Function
    function mappingTable(response){
            var data =''
            
            $('#type_table').DataTable().clear();
            $('#type_table').DataTable().destroy();
            for(i = 0; i < response.length; i++ )
                {
                            data += `<tr style="text-align: center;">
                                <td style="text-align: center;width:5%"> <input type="checkbox" id="check" name="check" class="is_checked" style="border-radius: 5px !important;" value="${response[i]['id']}"  data-status="${response[i]['status']}" data-id="${response[i]['id']}" ${response[i]['status'] == 1 ?'checked':'' }></td>
                                    <td style="text-align:center;width: 10%">${response[i].status == 1 ? 'active' : 'inactive'}</td>
                                    <td style="text-align:left;width:65%">${response[i].name}</td>
                                    <td style="width:15%">
                                            <button title="Detail" data-name="${response[i].name}" class="edit btn btn-sm btn-warning rounded"data-id="${response[i]['id']}" data-toggle="modal" data-target="#editTypeModal">
                                                <i class="fas fa-solid fa-edit"></i>
                                            </button>   
                                    </td>
                                </tr>
                                `;
                }
            $('#type_table > tbody:first').html(data);
            $('#type_table').DataTable({
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