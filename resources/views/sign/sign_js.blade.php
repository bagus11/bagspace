<script>
    $(document).ready(function() {
        $('#btnRefresh').on('click', function(){
            $('#sign_table').DataTable().ajax.reload();
        })
        $('#approval_type').select2({
            dropdownParent: $('#addSignModal')
        })
        $('.approval_list_data').select2({
            dropdownParent: $('#addSignModal')
        })
        $('#sign_table').DataTable({
            processing: true,
            ajax: {
                url: '{{ route('fetch-sign') }}',
                type: 'GET',
            },
            columns: [{
                    "data": null,
                    "render": function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    "data": "signature_code",
                    "defaultContent": "<i>Not set</i>"
                },
                {
                    "data": "title",
                    "defaultContent": "<i>Not set</i>"
                },
                {
                    'data': null,
                    // title: 'Action',
                    wrap: true,
                    "render": function(item) {
                        var status = '';
                        switch(item.status) {
                            case 0:
                                status ='New'
                                break;
                            case 1:
                                status ='On Progress'
                                break;
                            default:
                                status ='DONE'
                            }
                        return `
                        ${status}
                        `

                    }
                },
                {
                    'data': null,
                    // title: 'Action',
                    wrap: true,
                    "render": function(item) {
                        var button_custom =''
                        var button_approval =''
                        if(item.status == 0){
                            button_custom =`   
                            <button type="button" style="background-color:#76ABAE !important;color:white" class="btn btn-sm mt-2 sign" title="Click Here For Attachment" data-id ="${item.signature_code}"><i class="fa-solid fa-file-pdf"></i>
                                </button>
                            `
                            button_approval =`
                             <button type="button" data-sign="${item.signature_code}" data-id="${item.id}" data-step="${item.step_approval}" class="btn btn-warning btn-sm mt-2 approval" data-toggle="modal" data-target="#approvalModal">
                                <i class="fa-solid fa-users"></i>
                            </button>
                            `
                        }
                        return `
                        <button type="button" data-sign_transaction_id="${item.id}" class="btn btn-info btn-sm mt-2 detail_sign_transaction" data-toggle="modal" data-target="#detailSignModal"><i class="fas fa-eye"></i></button>
                        ${button_approval}
                        ${button_custom}
                        
                        `

                    }
                },
            ],
            language: {
                'paginate': {
                'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                }
            },
        })
        $('#btn_set_approver').on('click', function(){
               var select_approver =document.getElementsByClassName('select_approver');
               var array_approver =[]
                for(i =0; i< select_approver.length; i++){
                    var post ={
                        'step' : i+1,
                        'user_id' :select_approver[i].value ,
                    }
                    array_approver.push(post)
                }
                var data ={
                    'signature_code' : $('#signature_code_approval').val(),
                    'user_array'  : array_approver
                }
                if(array_approver.length == 0)
                {
                    toastr['warning']('approver cannot be null');  
                }else{
                    postCallback('updateApprovalSign',data, function(response){
                    swal.close()
                    $('.message_error').html('')
                    toastr['success'](response.meta.message);
                    $('#approvalModal').modal('hide')
                    $('#sign_table').DataTable().ajax.reload();
                })
                }

            })

        $(document).on('click', '.sign', function(e) {
                var id = $(this).data('id')
                replace = id.replaceAll('/','_');
                window.open(`view-pdf/${replace}`,'_blank');
        })

        $(document).on('click', '#btn_add_sign', function(e) {
            e.preventDefault()
            $('#form_create_sign_transaction')[0].reset()
            $('#table_approver_data').hide()
        })

        $(document).on('click', '#btn_save_sign_transaction', function(e) {
            e.preventDefault()
            let form_data = new FormData()
            let approval_type = $('#approval_type').val()
            let title_sign = $('#title_sign').val()
            let description_sign = $('#description_sign').val()
            let total_approval_sign = $('#total_approval_sign').val()
            let attachment_sign = $('input[name="attachment_sign"]')[0].files[0]
        
            form_data.append('approval_type', approval_type)
            form_data.append('title_sign', title_sign)
            form_data.append('description_sign', description_sign)
            form_data.append('total_approval_sign', total_approval_sign)
            form_data.append('attachment_sign', attachment_sign)
            $.ajax({
                url: '{{ route("create-sign") }}',
                method: 'POST',
                processData: false,
                contentType: false,
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: form_data,
                // dataType: 'json',
                // async: true,
                enctype: 'multipart/form-data',
                beforeSend: function() {
                    SwalLoading('Please wait ...');
                },
                success: function(res) {
                    swal.close();
                    $('#sign_table').DataTable().ajax.reload();
                    $('#addSignModal').modal('hide')
                    toastr['success'](res.meta.message);
                },
                error: function(response) {
                    // console.log(xhr.responseText);
                    $('.message_error').html('')
                    swal.close();
                    // console.log(response.status)
                    if(response.status == 500){
                        toastr['error'](response.responseJSON.meta.message);
                        return false
                    }
                    else if(response.status === 422)
                    {
                        $.each(response.responseJSON.meta.message.errors, (key, val) => 
                            {
                                $('span.'+key+'_error').text(val)
                            });
                    }else{
                        toastr['error']('Failed to get data, please contact ICT Developer');
                    }
                }
            })
        })
        $(document).on('click', '.approval', function(){
            var step = $(this).data('step')
            var id = $(this).data('id')
            var signature_code = $(this).data('sign')
            var data ={
                'id':id,
                'signature_code':signature_code,
            }
            console.log(step)
            $('#signature_code_approval').val(signature_code)
            getCallbackNoSwal('getApprovalSign',data,function(response){
                    swal.close()
                    mappingStepApprover(step,response.data)
            })
        })
        setTimeout(function() {
            $('#sign_table').DataTable().ajax.reload();
        }, 60000)

        $(document).on('click', '.detail_sign_transaction', function(e) {
            e.preventDefault()
            let sign_id = $(this).data('sign_transaction_id')
            $('#detail_container').prop('hidden',true)
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route("detail-sign") }}',
                type: 'GET',
                data: {
                    sign_id: sign_id
                },
                dataType: 'json',
                async: true,
                success: function(res) {
                    $('#detail_approval_type').html( res.detail.approval_type == 1 ?': Hirarki' :': Non Hirarki')
                    $('#detail_title_sign').html(': ' + res.detail.title)
                    $('#detail_description_sign').html(': ' + res.detail.description)
                    $('#detail_total_approval_sign').html(': ' + res.detail.step_approval)
                    let data_attachment = res.detail.attachment
                    let link_attachment = "{{ asset('') }}"+data_attachment
                    $('#detail_attachment_sign').attr('href', link_attachment)
                    $('#table_list_detail_approval').empty()
                    let number_user = 1

                    if(res.data.length > 0){
                        $('#detail_container').prop('hidden',false)
                        var data=''
                        $('#detail_sign_table').DataTable().clear();
                        $('#detail_sign_table').DataTable().destroy();
                        for(i = 0; i < res.data.length ; i++){
                            var status = res.data[i].status == 0 ? 'Not yet' : 'Finished'
                            const d = new Date(res.data[i].updated_at)
                            const date = d != 'Thu Jan 01 1970 07:00:00 GMT+0700 (Western Indonesia Time)' ? convertDate(d.toISOString().split('T')[0]) : '';
                            const datevalidate = d != 'Thu Jan 01 1970 07:00:00 GMT+0700 (Western Indonesia Time)' ? d.toISOString().split('T')[0] : '';
                            const time = d != 'Thu Jan 01 1970 07:00:00 GMT+0700 (Western Indonesia Time)' ? d.toTimeString().split(' ')[0] : '';
                            const date_time = date + ' ' + time;
                            data +=`
                                <tr>
                                    <td style="width: 5%; text-align:center">${res.data[i].step}</td>
                                    <td>${res.data[i].user_relation.name}</td>
                                    <td style="width: 10%; text-align:center">${status}</td>
                                    <td style="width: 20%; text-align:left">${res.data[i].updated_at == null ?'-' : date_time}</td>
                                </tr>
                            `
                        }
                        $('#detail_sign_table > tbody:first').html(data);
                            $('#detail_sign_table').DataTable({
                                scrollX  : false,
                                searching  :true,
                                language: {
                                    'paginate': {
                                    'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                                    'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                                    }
                                },
                            }).columns.adjust()
                    }
                  
                }
            })
        })
    })

    
        function mappingStepApprover(step,response){
            var data = ''
           
            $('#approver_step_table').DataTable().clear();
            $('#approver_step_table').DataTable().destroy();
            for(i = 0; i < step ; i++){
                var user =''
                var selectTitle = 'select_approver_' + i
                data += `
                    <tr>
                        <td style="width:10%; text-align:center;">${i + 1}</td>
                        <td style="width:90%">
                            <select name="${selectTitle}" class="select2 select_approver" style="font-size:9px;" id="${selectTitle}">
                                <option >
                                </option>
                            </select>
                        </td>
                    </tr>
                
                `;
                getApproval(response[i] == null ? '' : response[i].user_id,selectTitle)
            }
         
            $('#approver_step_table > tbody:first').html(data);
            $('#approver_step_table').DataTable({
                scrollX  : false,
                language: {
                                    'paginate': {
                                    'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                                    'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                                    }
                                },
            }).columns.adjust()
            $('.select2').select2()
            $(".select2").select2({ dropdownCssClass: "myFont" });
        }
        function getApproval(response,title){
            // getActiveItems('getUser',null,title,'Approver')
            getCallbackNoSwal('getUser',null, function(res){
                $('#'+title).empty()
                $('#'+title).append('<option value ="">Choose Approver </option>');
                $.each(res.data,function(i,data){
                    $('#'+title).append('<option data-name="'+ data.name +'" value="'+data.id+'">' + data.name +'</option>');
                });
                if(response){
                    $('#'+title).val(response)
                    var test = $('#'+title).val(response)
                    $('#'+title).trigger('change')
                }

            })
           
        }


</script>
