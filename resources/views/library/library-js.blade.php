<script>
    getCallback('getLibrary', null, function(response){
        swal.close()
        mappingTable(response.data)
    })
    $('#btnRefresh').on('click', function(){
        getCallback('getLibrary', null, function(response){
            swal.close()
            mappingTable(response.data)
        })  
    })
    $('#btn_add_book').on('click', function(){
        getActiveItems('getLocation',null,'select_location', 'Location')
        getActiveItems('getDepartment',null,'select_department', 'Department')
        $('#name').val('')
        $('#description').val('')
        $('#location_id').val('')
        $('#department').val('')
    })
    onChange('select_location','location_id')
    onChange('select_department','department')

    $('#btn_save_book').on('click', function(e){
        e.preventDefault()
        var data        = new FormData();    
        var attachment      = $('#attachment')[0].files[0];
        data.append('attachment',attachment)
        data.append('name',$('#name').val())
        data.append('description',$('#description').val())
        data.append('location_id',$('#location_id').val())
        data.append('department',$('#department').val())
        postAttachment('addLibrary',data,false,function(response){
            swal.close()
            toastr['success'](response.meta.message);
                window.location = 'library';
        })
    })
    $('#btn_update_book').on('click', function(e){
        e.preventDefault()
        var data        = new FormData();    
        var attachment      = $('#attachment_edit')[0].files[0];
        data.append('attachment_edit',attachment)
        data.append('name_edit',$('#name_edit').val())
        data.append('id',$('#editId').val())
        data.append('description_edit',$('#description_edit').val())
        data.append('location_id_edit',$('#location_id_edit').val())
        data.append('department_edit',$('#department_edit').val())
        postAttachment('updateLibrary',data,false,function(response){
            swal.close()
            toastr['success'](response.meta.message);
                window.location = 'library';
        })
    })

    $('#library_table').on('click','.edit', function(){
        var id = $(this).data('id')
        getActiveItems('getLocation',null,'select_location_edit', 'Location')
        getActiveItems('getDepartment',null,'select_department_edit', 'Department')
        var data ={
            'id': id
        }
        getCallback('detailLibrary',data, function(response){
            swal.close()
            $('#name_edit').val(response.detail.name)
            $('#description_edit').val(response.detail.description)
            $('#department_edit').val(response.detail.department)
            $('#select_department_edit').val(response.detail.department)
            $('#select_department_edit').select2().trigger('change')
            $('#location_id_edit').val(response.detail.location)
            $('#select_location_edit').val(response.detail.location)
            $('#select_location_edit').select2().trigger('change')
            $('#editId').val(id)
        })
    })
    $('#library_table').on('click','.detail', function(){
        var id = $(this).data('id')
        var data ={
            'id': id
        }
        getCallback('detailLibrary',data, function(response){
            swal.close()
            $('#name_label').html(': ' +response.detail.name)
            $('#description_label').html(': ' +response.detail.description)
            $('#department_label').html(': ' +response.detail.department_relation.name)
            $('#location_label').html(': ' +response.detail.location_relation.name)
            $('#attachment_label').html(` :  <a target="_blank" href="{{URL::asset('${response.detail.attachment}')}}" class="ml-3" style="color:blue;">
                                            <i class="far fa-file" style="color: red;font-size: 12px;"></i>
                                            Click Here</a>  `)
            $('#editId').val(id)
            mappingLog(response.data)
        })
    })
    function mappingTable(response){
            var data =''
            $('#library_table').DataTable().clear();
            $('#library_table').DataTable().destroy();
            for(i = 0; i < response.length; i++ )
                        {
                            const d = new Date(response[i].created_at)
                            const date = d !='Thu Jan 01 1970 07:00:00 GMT+0700 (Western Indonesia Time)' ? convertDate(d.toISOString().split('T')[0]) : ''; 
                            const time = d != 'Thu Jan 01 1970 07:00:00 GMT+0700 (Western Indonesia Time)'? d.toTimeString().split(' ')[0]: '';   
                            data += `<tr style="text-align: center;">
                                   
                                    <td style="text-align: center;width:15%">${date} ${time}</td>
                                    <td style="text-align: left;width:10%">${response[i].request_code}</td>
                                    <td style="text-align: left;width:15%">${response[i].location_relation.name}</td>
                                    <td style="text-align: left;width:15%">${response[i].department_relation.name}</td>
                                    <td style="text-align: left;width:25%">${response[i].name}</td>
                                    <td style="width:5%;text-align:center;width:10%">
                                            <button title="Edit Documentation" class="edit btn btn-sm btn-warning rounded"data-id="${response[i]['id']}" data-toggle="modal" data-target="#editBookModal">
                                                <i class="fa-solid fa-edit"></i>
                                            </button>
                                            <button title="Detail" class="detail btn btn-sm btn-info rounded"data-id="${response[i]['id']}" data-toggle="modal" data-target="#detailBookModal">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                            
                                    </td>
                                </tr>
                                `;
                        }
                            $('#library_table > tbody:first').html(data);
                            $('#library_table').DataTable({
                                scrollX  : true,
                                searching  :true,
                                language: {
                                    'paginate': {
                                    'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                                    'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                                    }
                                },
                                scrollY  :360
                            }).columns.adjust()
            
        }
        function mappingLog(response){
            var data =''
            $('#log_attachment_table').DataTable().clear();
            $('#log_attachment_table').DataTable().destroy();
            for(i = 0; i < response.length; i++ )
                        {
                            const d = new Date(response[i].created_at)
                            const date = d !='Thu Jan 01 1970 07:00:00 GMT+0700 (Western Indonesia Time)' ? convertDate(d.toISOString().split('T')[0]) : ''; 
                            const time = d != 'Thu Jan 01 1970 07:00:00 GMT+0700 (Western Indonesia Time)'? d.toTimeString().split(' ')[0]: '';   
                            data += `<tr style="text-align: center;">
                                   
                                    <td style="text-align: center;width:15%">${date} ${time}</td>
                                    <td style="text-align: left;width:15%">${response[i].user_relation.name}</td>

                                    <td style="width:5%;text-align:center;width:10%">
                                        <a target="_blank" href="{{URL::asset('${response[i].attachment}')}}" class="ml-3" style="color:blue;">
                                            <i class="far fa-file" style="color: red;font-size: 12px;"></i>
                                            Click Here</a>           
                                    </td>
                                </tr>
                                `;
            }
        $('#log_attachment_table > tbody:first').html(data);
        $('#log_attachment_table').DataTable({
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
</script>