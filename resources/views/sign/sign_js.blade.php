{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.3.4/signature_pad.js" integrity="sha512-j36pYCzm3upwGd6JGq6xpdthtxcUtSf5yQJSsgnqjAsXtFT84WH8NQy9vqkv4qTV9hK782TwuHUTSwo2hRF+/A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
<script>
    $(document).ready(function() {
        $('#approval_type').select2({
            dropdownParent: $('#addSignModal')
        })
        $('.approval_list_data').select2({
            dropdownParent: $('#addSignModal')
        })
        $('#detail_approval_type').select2({
            dropdownParent: $('#detailSignModal')
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
                    'data': null,
                    // title: 'Action',
                    wrap: true,
                    "render": function(item) {
                        return '<button type="button" data-sign_transaction_id="'+ item.id +'" class="btn btn-outline-info btn-sm mt-2 detail_sign_transaction" data-toggle="modal" data-target="#detailSignModal">View</button>'

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

        $(document).on('click', '#btn_add_sign', function(e) {
            e.preventDefault()
            $('#form_create_sign_transaction')[0].reset()
            $('#table_approver_data').hide()
            // $.ajax({
            //     url: "{{ route('list-user-approval') }}",
            //     type: "get",
            //     dataType: 'json',
            //     // data:data,
            //     success: function(res) {
            //         // mappingDetail(res.data)
                    
            //     },
            //     error: function(xhr, status, error) {
            //         swal.close();
            //         toastr['error']('Failed to get data, please contact ICT Developer');
            //     }
            // });
            // $('#list_sign_approval').DataTable().clear();
            // $('#list_sign_approval').DataTable().destroy();
        })

        $(document).on('change', '#total_approval_sign', function() {
            let total_approval = $('#total_approval_sign').val()
            $('#form_list_approval').empty()
            $('#table_list_approval').empty()
            if (total_approval <= 0) {
                $('#form_list_approval').empty()
                $('#table_list_approval').empty()
                $('#table_approver_data').hide()
            } else {
                $.ajax({
                    url: "{{ route('list-user-approval') }}",
                    type: "get",
                    dataType: 'json',
                    success: function(res) {
                        $('#table_approver_data').show()
                        $('#table_list_approval').empty()
                        let number_user = 1
                        for (let i = 0; i < total_approval; i++) {
                            $('#table_list_approval').append(`
                                <tr>
                                    <td>${number_user++}</td>
                                    <td>
                                        <div class="mb-3">
                                            <select class="form-control approval_list_data" name="approval_list_data[]" id="approval_list_data_${i}">
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                            `)
                            // $('#form_list_approval').append(`
                            //     <div class="mb-3">
                            //         <select class="form-control approval_list_data" name="approval_list_data[]" id="approval_list_data_${i}">
                            //             <option value="0">Hirarki</option>
                            //             <option value="1">Non Hirarki</option>
                            //         </select>
                            //     </div>
                            // `)
                        }
                        $('.approval_list_data').empty()
                        $('.approval_list_data').append(`<option value="">Choose Approver</option>`)
                        $.each(res.data, function(i, user) {
                            $('.approval_list_data').append(`
                                <option value="${user.id}">${user.name}</option>
                            `)
                        })
                        $('.approval_list_data').select2({
                            dropdownParent: $('#addSignModal')
                        })
                    }
                })
            }
        })

        $(document).on('click', '#btn_save_sign_transaction', function(e) {
            e.preventDefault()
            let form_data = new FormData()
            let approval_type = $('#approval_type').val()
            let title_sign = $('#title_sign').val()
            let description_sign = $('#description_sign').val()
            let total_approval_sign = $('#total_approval_sign').val()
            let attachment_sign = $('input[name="attachment_sign"]')[0].files[0]
            var approval_list_data = document.getElementsByClassName('approval_list_data');

            form_data.append('approval_type', approval_type)
            form_data.append('title_sign', title_sign)
            form_data.append('description_sign', description_sign)
            form_data.append('total_approval_sign', total_approval_sign)
            form_data.append('attachment_sign', attachment_sign)

            for (let i = 0; i < approval_list_data.length; i++) {
                form_data.append('step_approval[]', i+1)
                form_data.append('approval_list_data[]', approval_list_data[i].value)
                
            }

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
                error: function(xhr) {
                    // console.log(xhr.responseText);
                    swal.close();
                    let response_error = JSON.parse(xhr.responseText)
                    $.each(response_error.meta.message.errors, function(i, value) {
                        Swal.fire({
                            icon: "error",
                            title: 'Error!',
                            text: value
                        })
                    })
                }
            })
        })

        setTimeout(function() {
            $('#sign_table').DataTable().ajax.reload();
        }, 60000)

        $(document).on('click', '.detail_sign_transaction', function(e) {
            e.preventDefault()
            let sign_id = $(this).data('sign_transaction_id')
            // alert(sign_id)
            $('#form_detail_sign_transaction')[0].reset()
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
                    let approve_type_data = ['Hirarki', 'Non Hirarki']
                    $('#detail_approval_type').empty()
                    for (let i = 0; i < approve_type_data.length; i++) {
                        $('#detail_approval_type').append(`
                            <option value="${i}" ${res.data[0].approval_type == i ? 'selected' : ''}>${approve_type_data[i]}</option>
                        `)
                    }
                    $('#detail_approval_type').val()
                    $('#detail_title_sign').val(res.data[0].title)
                    $('#detail_description_sign').val(res.data[0].description)
                    $('#detail_total_approval_sign').val(res.data[0].step_approval)
                    $('#detail_total_approval_sign').val(res.data[0].step_approval)
                    console.log(res.data[0].signature_detail[0].user_id);
                    $('#table_list_detail_approval').empty()
                    let number_user = 1
                    $.each(res.data[0].signature_detail, function(i, user) {
                        $('#table_list_detail_approval').append(`
                            <tr>
                                <td>${number_user++}</td>
                                <td>${user.user.name}</td>
                                <td>${user.status}</td>
                            </tr>
                        `)
                    })
                    // for (let i = 0; i < res.data[0].signature_detail.length; i++) {
                    //     $('#form_detail_list_approval').append(`
                    //         <div class="mb-3">
                    //             <label for="detail_approval_list_data_${i}" class="form-label">User Approval</label>
                    //             <select class="form-control detail_approval_list_data" name="detail_approval_list_data[]" id="detail_approval_list_data_${i}">
                    //             </select>
                    //         </div>
                    //     `)
                    // }
                    
                    // $('.detail_approval_list_data').empty()
                    // for (let i = 0; i < res.data[0].signature_detail.length; i++) {
                    //     $('.detail_approval_list_data').append(`
                    //         <option value="${res.data[0].signature_detail[i].user_id}">${res.data[0].signature_detail[i].user.name}</option>
                    //     `)
                    // }
                    // for (let i = 0; i < res.data['user'].length; i++) {
                    //     $('.detail_approval_list_data').append(`
                    //     `)
                        
                    // }
                    // $('.detail_approval_list_data').select2({
                    //     dropdownParent: $('#detailSignModal')
                    // })
                }
            })
        })
    })

    function mappingDetail(x) {
        var data = ''
        for (i = 0; i < x.length; i++) {
            
            data += `
                    <tr>
                        <td style="text-align: center;width:10%"> <input type="checkbox" id="checkAll" name="check" class="is_checked" style="border-radius: 5px !important;" value="${x[i].id}"  data-name="${x[i].name}"></td>
                        <td style="width:90%">${x[i].name}</td>
                    </tr>
            `;

        }
        $('#list_sign_approval > tbody:first').html(data);
        $('#list_sign_approval').DataTable({
            scrollX: true,
            language: {
                'paginate': {
                    'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                    'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                }
            },
            scrollY: 220
        }).columns.adjust()
    }

    // $(document).on('click', '#checkAll', function(){
    $('#checkAll').on('click', function(){
     // Get all rows with search applied
        var table = $('#list_sign_approval').DataTable();
        var rows = table.rows({ 'search': 'applied' }).nodes();
     // Check/uncheck checkboxes for all rows in the table
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
    });


</script>
