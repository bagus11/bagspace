<script>
   var request_code = $('#request_code').val()
   var leader_id = $('#leader_id').val()
  var dataStart ={
    'request_code' : request_code
  }
//   $(document).ready(function () {
 

//   })
  $(document).ready(function () {
        $('#addTaskModal').on('show.bs.modal', function () {
            $('#detailCardModal').css('z-index', 1039);
        });
        $('#addTaskModal').on('hidden.bs.modal', function () {
            $('#detailCardModal').css('z-index', 1041);
        });
        $('#updateTaskModal').on('show.bs.modal', function () {
            $('#detailCardModal').css('z-index', 1039);
        });
        $('#updateTaskModal').on('hidden.bs.modal', function () {
                $('#detailCardModal').css('z-index', 1041);
        });
        $('#addDailyModal').on('show.bs.modal', function () {
            $('#detailCardModal').css('z-index', 1039);
        });
        $('#addDailyModal').on('hidden.bs.modal', function () {
                $('#detailCardModal').css('z-index', 1041);
        });
  })


  var header_type = $('#header_type').val()
  getData(dataStart)
//   Update Status When Drag Kanban
    document.addEventListener('DOMContentLoaded', function () {
            // Set up Dragula for the kanban board
            const kanbanBoard = document.getElementById('kanban-board');
            const in_progress = document.getElementById('in-progress');
            const pending = document.getElementById('pending');
            const done = document.getElementById('done');
            const columns = Array.from(document.querySelectorAll('.kanban-cards'));
            const drake = dragula(columns);

            // Add event listeners for when a card is dropped
            drake.on('drop', async function (el, target, source, sibling) {
                    // Handle the card's new position and update status
                    const cardId = el.id;
                    const oldColumn = source.parentElement.id;
                    const newColumn = target.parentElement.id;
                    // Example: If moving from "To Do" to "In Progress," update status
                    await updateStatus(cardId, newColumn);

                    // Add more conditions for other column transitions as needed
                });

                // Simulate an asynchronous update function (replace with your actual logic)
                async function updateStatus(cardId, newStatus) {
                var status = 0
                if(newStatus =='parent1'){
                    status = 0
                }else if(newStatus =='parent2'){ 
                    status = 1
                }else if(newStatus =='parent3'){ 
                    status = 2
                }
                else if(newStatus =='parent4'){ 
                    status = 3
                }
                var data ={
                    'detail_code' : cardId,
                    'status' : status,
                }
                $.ajax({
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{route('updateTimelineDetailStatus')}}",
                        type: "post",
                        dataType: 'json',
                        async: true,
                        data: data,
                        success: function(response) {
                            $('.message_error').html('')
                            if(response.status == 200){
                                toastr['success'](response.message);
                            }else{
                                toastr['error'](response.message);
                                getDataNoSwal(dataStart)
                            }
                            // getDataNoSwal(dataStart)
                            
                        },
                        error: function(xhr, status, error) {
                            swal.close();
                            toastr['error']('Failed to get data, please contact ICT Developer');
                        }
                    });
                
                }
            });
            $(document).ready(function () {
            $('#detailCardModal').on('hidden.bs.modal', function () {
            // var detail_code = $('#detail_code_chat').val()
            clearInterval(chat);
            getDataNoSwal(dataStart)
            })
    })
    $('#send_chat').on('click', function(){
            $('.message_error').html('')
            $('#send_chat').prop('disabled',true)
            var formData        = new FormData();    
            var detail_code     = $('#detail_code_chat').val()
            var remark_chat     = $('#remark_chat').val()
            formData.append('detail_code', detail_code)
            formData.append('remark_chat',$('#remark_chat').val())
            formData.append('file_attach',$('#file_attach')[0].files[0]);
            formData.append('request_code_chat',$('#request_code_chat').val())
            if(remark_chat == ''){
                $('.remark_chat_error').html('remark is required')
                $('#send_chat').prop('disabled',false)
            }else{
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('sendChat')}}",
                    type: "post",
                    dataType: 'json',
                    async: true,
                    processData: false,
                    contentType: false,
                    data: formData,
                    beforeSend: function() {
                        // SwalLoading('Inserting progress, please wait .');
                        $('#send_chat').prop('disabled',true)
                    },
                    success: function(response) {
                            $('.message_error').html('')
                            $('#send_chat').prop('disabled',false)
                            showNoSwal(detail_code)
                            $('#remark_chat').val('')
                
                    },
                    error: function(xhr, status, error) {
                        // swal.close();
                        toastr['error']('Failed to get data, please contact ICT Developer');
                    }
                });
            }
        // uploadFile('save_wo',formData,'work_order_list')
    })
    $('.btn_module').on('click',function(){
        $('#name_module').val('')
        $('#description_module').val('')
      
        if(header_type != 1){
            $('#purchase_container').prop('hidden', false)
        }else{
            $('#purchase_container').prop('hidden', true)
        }
    })
    $("#plan_amount").on({
                    keyup: function() {
                    formatCurrency($(this));
                    },
                    blur: function() { 
                    formatCurrency($(this), "blur");
                    }
    });
    
    $("#plan_amount_edit").on({
                    keyup: function() {
                    formatCurrency($(this));
                    },
                    blur: function() { 
                    formatCurrency($(this), "blur");
                    }
    });

    $("#actual_amount").on({
                    keyup: function() {
                    formatCurrency($(this));
                    },
                    blur: function() { 
                    formatCurrency($(this), "blur");
                    }
    });
    $('#btn_save_ticket').on('click',function(){
        var plan_amount = $('#plan_amount').val()
        var plan_amount_convert = parseFloat(plan_amount.replace(/,/g, ''));
        var data ={
            'start_date_module' : $('#start_date_module').val(),
            'request_code' : $('#request_code').val(),
            'end_date_module' : $('#end_date_module').val(),
            'name_module' : $('#name_module').val(),
            'description_module' : $('#description_module').val(),
            'status_module' : $('#status_module').val(),
            'plan_amount' : plan_amount_convert,
        }
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('createModule')}}",
            type: "post",
            dataType: 'json',
            async: true,
            data: data,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                $('.message_error').html('')
                $('#addCardModal').modal('hide')
                getData(dataStart)
                
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
 
    })
    $('#btn_new_module').on('click', function(){
        $('#status_module').val(0)
    })
    $('#btn_on_progress_module').on('click', function(){
        $('#status_module').val(1)
    })
    $('#btn_pending_module').on('click', function(){
        $('#status_module').val(2)
    })
    $('#btn_done_module').on('click', function(){
        $('#status_module').val(3)
    })
    $('#btn_add_task').on('click', function(){
        var detail_code = $('#detail_code_chat').val()
        $('#name_sub_module').val('')
        $('#description_sub_module').val('')
        $('#pic_id').val('')
        $('#select_pic').val('')
        $('#select_pic').select2().trigger('change')
        $('#actual_amount').val('')
        if(header_type == 1){
            $('#actual_label').prop('hidden', true)
            $('#amount_container').prop('hidden', true)
        }else{
            $('#actual_label').prop('hidden', false)
            $('#amount_container').prop('hidden', false)
        }
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('getTeam')}}",
            type: "get",
            dataType: 'json',
            async: true,
            data:{
              'request_code' : $('#request_code').val(),
            },
            success: function(response) {
                $('#select_pic').empty()
                    $('#select_pic').append('<option value ="">Choose PIC</option>');
                    $.each(response.data,function(i,data){
                        $('#select_pic').append('<option data-name="'+ data.user_relation.name +'" value="'+data.user_id+'">' + data.user_relation.name +'</option>');
                    });
            },
            error: function(xhr, status, error) {
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });

    })
    onChange('select_pic','pic_id')
    $('#btn_save_task').on('click', function(){
        var detail_code = $('#detail_code_chat').val()
        var actual_amount = $('#actual_amount').val()
        var actual_amount_convert = parseFloat(actual_amount.replace(/,/g, ''));
        var data ={
            'request_code'      : $('#request_code').val(),
            'detail_code'       : $('#detail_code_chat').val(),
            'name_sub_module'   : $('#name_sub_module').val(),
            'start_date_sub_module'   : $('#start_date_sub_module').val(),
            'end_date_sub_module'   : $('#end_date_sub_module').val(),
            'description_sub_module'   : $('#description_sub_module').val(),
            'pic_id'   : $('#pic_id').val(),
            'actual_amount'   : actual_amount_convert,
        }
        var formData        = new FormData();    
            formData.append('request_code',$('#request_code').val())
            formData.append('detail_code',$('#detail_code_chat').val())
            formData.append('name_sub_module',$('#name_sub_module').val())
            formData.append('start_date_sub_module',$('#start_date_sub_module').val())
            formData.append('end_date_sub_module',$('#end_date_sub_module').val())
            formData.append('description_sub_module',$('#description_sub_module').val())
            formData.append('pic_id',$('#pic_id').val())
            formData.append('actual_amount',actual_amount_convert)
            formData.append('attachment_task',$('#attachment_task')[0].files[0]);
        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('addTask')}}",
            type: "post",
            dataType: 'json',
            async: true,
            processData: false,
            contentType: false,
            data: formData,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success:function(response){
                swal.close()
                $('#addTaskModal').modal('hide')
                toastr['success'](response.meta.message);
                showNoSwal(detail_code)
            },
            error: function(response) {
                $('.message_error').html('')
                swal.close();
                if(response.status == 500){
                    toastr['error'](response.responseJSON.meta.message);
                    return false
                }
                if(response.status === 422)
                {
                    $.each(response.responseJSON.errors, (key, val) => 
                        {
                            $('span.'+key+'_error').text(val)
                        });
                }else{
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            }
        });  
       
    })
    $('#btn_edit_module').on('click', function(){
        var data ={
            'detail_code' : $('#detail_code_chat').val()
        }
       
    })
//   Update Status When Drag Kanban
    $('#task_subdetail_table').on('change', '.is_checked', function(){
        var id      = $(this).data('id')
        var status  = $(this).data('status')
        var detail_code = $('#detail_code_chat').val()
        var data ={
            'id':id,
            'status':status
        }
        $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('updateStatusTask')}}",
                type: "post",
                dataType: 'json',
                async: true,
                data: data,
                success: function(response) {
                    if(response.status==500){
                        toastr['warning'](response.message);
                        showNoSwal(detail_code)
                       
                    }
                    else{
                        toastr['success'](response.message);
                        showNoSwal(detail_code)
                        postBot(response.bot)
                    }
                    
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    })
    $('#task_subdetail_table').on('click', '.detail', function(){
        var id = $(this).data('id')
        $('#log_task_table').DataTable().clear();
        $('#log_task_table').DataTable().destroy();
        $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('getSubDetailTimeline')}}",
                    type: "get",
                    dataType: 'json',
                    async: true,
                    data:{
                        'id' :id
                    },
                    success: function(response) {
                        $('#start_date_sub_task_label').val(response.detail.start_date)
                        $('#end_date_task_label').val(response.detail.end_date)
                        $('#name_task_label').html(': ' + response.detail.name)
                        $('#select_pic_task').html(': ' + response.detail.user_relation.name)
                        var attachment_label ='-'
                        if(response.detail.attachment !==''){
                            attachment_label =`<a style="color:#76ABAE !important;font-size:10px !important" title="Click Here For Attachment" href="{{URL::asset('${response.detail.attachment}')}}" target="_blank">
                                <i class="fa-solid fa-file-pdf"></i> Click Here
                                </a>`
                        }
                        $('#attachment_label').html(': ' + attachment_label)
                        if(header_type != 1){
                            $('#actual_amount_label').html(': ' + convertToRupiah(response.detail.amount))
                        }else{
                            $('#actual_amount_label').html(': - ')
                        }
                        $('#description_task_label').html(': ' + response.detail.description)
                        
                        var mapping_data =''
            
                                
                        for(i = 0; i < response.log_task.length; i++ )
                            {
                                const d = new Date(response.log_task[i].created_at)
                                const date = d.toISOString().split('T')[0];
                                const time = d.toTimeString().split(' ')[0];

                                    mapping_data += `<tr style="text-align: center;">
                                                        <td style="text-align:center;width:10%">${convertDate(date)} ${time}</td>
                                                        <td style="text-align:left;width:15%">${response.log_task[i].creator_relation.name}</td>
                                                        <td style="text-align:left;width:10%">${response.log_task[i].name}</td>
                                                        <td style="text-align:left;width:15%">${response.log_task[i].user_relation.name}</td>
                                                        <td style="text-align:center;width:10%">${convertDate(response.log_task[i].start_date)}</td>
                                                        <td style="text-align:center;width:10%">${convertDate(response.log_task[i].end_date)}</td>
                                                        <td style="text-align:right;width:10%">${convertToRupiah(response.log_task[i].amount)}</td>
                                                        <td style="text-align:left;width:20%">${response.log_task[i].remark}</td>
                                                    </tr>
                                            `;
                            }
                        $('#log_task_table > tbody:first').html(mapping_data);
                        $('#log_task_table').DataTable({
                            // scrollX  : true,
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
                        toastr['warning']('Failed to get data, please contact ICT Developer');
                    }
                });
    })
    $('#task_subdetail_table').on('click','.update', function(){
        $('#remark_edit').val('')
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('getTeam')}}",
            type: "get",
            dataType: 'json',
            async: true,
            data:{
              'request_code' : $('#request_code').val(),
            },
            success: function(response) {
                $('#select_pic_edit').empty()
                    $.each(response.data,function(i,data){
                        $('#select_pic_edit').append('<option data-name="'+ data.user_relation.name +'" value="'+data.user_id+'">' + data.user_relation.name +'</option>');
                    });
            },
            error: function(xhr, status, error) {
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });

        var id = $(this).data('id')
        
        var data ={
            'id': id
        }
      
        $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('getSubDetailTimeline')}}",
                    type: "get",
                    dataType: 'json',
                    async: true,
                    data:data,
                    beforeSend: function() {
                        SwalLoading('Please wait ...');
                    },
                    success: function(response) {
                        swal.close()
                        if(response.detail.amount == 0 || response.detail.amount == null){
                            $('#amount_container_edit').prop('hidden', true)
                            $('#actual_label_edit').prop('hidden', true)
                        }else{
                            $('#amount_container_edit').prop('hidden', false)
                            $('#actual_label_edit').prop('hidden', false)
                        }
                        $('#start_date_edit_sub_module').val(response.detail.start_date)
                        $('#end_date_edit_sub_module').val(response.detail.end_date)
                        $('#name_edit_sub_module').val(response.detail.name)
                        $('#actual_amount_edit').val(response.detail.amount)
                        $('#description_edit_sub_module').val(response.detail.description)
                        $('#select_pic_edit').val(response.detail.pic)
                        $('#select_pic_edit').select2().trigger('change')
                        $('#taskId').val(id)
                    },
                    
                    error: function(xhr, status, error) {
                        swal.close();
                        toastr['warning']('Failed to get data, please contact ICT Developer');
                    }
        });

    })
    $('#task_subdetail_table').on('click', '.daily', function(){
        var task = $(this).data('task')
        $('#daily_task').val(task)
    })
    onChange('select_pic_edit','pic_id_edit')
    $('#btn_edit_task').on('click', function(){
        var data = {
            'name_edit_sub_module' : $('#name_edit_sub_module').val(),
            'start_date_edit_sub_module' : $('#start_date_edit_sub_module').val(),
            'end_date_edit_sub_module' : $('#end_date_edit_sub_module').val(),
            'actual_amount_edit' : $('#actual_amount_edit').val(),
            'description_edit_sub_module' : $('#description_edit_sub_module').val(),
            'remark_edit' : $('#remark_edit').val(),
            'pic_id_edit' : $('#pic_id_edit').val(),
            'id'    :$('#taskId').val(),
        }
        $.ajax({
            url: "{{route('updateTask')}}",
            type: "post",
            dataType: 'json',
            data:data,
            async: true,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success:function(response){
                swal.close()
                $('#updateTaskModal').modal('hide')
                toastr['success'](response.meta.message);
                showNoSwal(response.data.detail_code)
            },
            error: function(response) {
                $('.message_error').html('')
                swal.close();
                if(response.status == 500){
                    toastr['error'](response.responseJSON.meta.message);
                    return false
                }
                if(response.status === 422)
                {
                    $.each(response.responseJSON.errors, (key, val) => 
                        {
                            $('span.'+key+'_error').text(val)
                        });
                }else{
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            }
        });  
    })
    $('#btn_update_module').on('click', function(){
        var detail_code =  $('#detail_code_chat').val()
        var plan        = $('#plan_amount_edit').val()
        var plan_convert = parseFloat(plan.replace(/,/g, ''));
        var data ={
            'start_date_module_edit'        : $('#start_date_module_edit').val(),
            'end_date_module_edit'          : $('#end_date_module_edit').val(),
            'name_module_edit'              : $('#name_module_edit').val(),
            'description_module_edit'       : $('#description_module_edit').val(),
            'plan_amount_edit'              : plan_convert,
            'reason_module_edit'            : $('#reason_module_edit').val(),
            'detail_code'                   : detail_code
        }
        $.ajax({
            url: "{{route('updateModule')}}",
            type: "post",
            dataType: 'json',
            data:data,
            async: true,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success:function(response){
                swal.close()
                $('#editModuleModal').modal('hide')
                toastr['success'](response.meta.message);
                showNoSwal(detail_code)
            },
            error: function(response) {
                $('.message_error').html('')
                swal.close();
                if(response.status == 500){
                    toastr['error'](response.responseJSON.meta.message);
                    return false
                }
                if(response.status === 422)
                {
                    $.each(response.responseJSON.errors, (key, val) => 
                        {
                            $('span.'+key+'_error').text(val)
                        });
                }else{
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            }
        });  

    })

    // Gantt Chart
            $('#gantt-tab').on('click', function(){
                $.ajax({
                    url: "{{route('getGanttChart')}}",
                    data : dataStart,
                    type: 'GET',
                    dataType: 'json',  // Assuming response will be JSON
                    success: function(data) {
                        updateGanttChart(data);
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        console.error('Error fetching data:', error);
                        // Example: Show error message to user
                        alert('Error fetching data. Please try again later.');
                    }
                });
            })
             
            function formatDate(dateStr) {
                var date = new Date(dateStr);
                return date.getFullYear() + '-' +
                    ('0' + (date.getMonth() + 1)).slice(-2) + '-' +
                    ('0' + date.getDate()).slice(-2);
            }

            function calculateDuration(startDateStr, endDateStr) {
                var startDate = new Date(startDateStr);
                var endDate = new Date(endDateStr);
                var duration = (endDate - startDate) / (1000 * 60 * 60 * 24);
                return Math.round(duration);
            }
            // Set custom task type for milestones
            gantt.templates.task_class = function (start, end, task) {
                if (task.type == 'milestone') {
                    return "milestone";
                } else if (task.overdue) {
                    return "overdue";
                }
                return "";
            };

            gantt.templates.tooltip_text = function(start, end, task) {
                var text = '<b>Task:</b> ' + task.text + '<br>';
                text += '<b>Start Date:</b> ' + gantt.templates.tooltip_date_format(start) + '<br>';
                text += '<b>End Date:</b> ' + gantt.templates.tooltip_date_format(end) + '<br>';
                text += '<b>Progress:</b> ' + (task.progress * 100).toFixed(2) + '%<br>';
                if (task.type === 'milestone') {
                    text += '<b>Type:</b> Milestone<br>';
                } else if (task.overdue) {
                    text += '<b>Status:</b> Overdue<br>';
                } else {
                    text += '<b>Status:</b> On Time<br>';
                }
                return text;
            };
            // Initialize Gantt chart
            gantt.config.xml_date = "%Y-%m-%d";
            gantt.config.readonly = true; // Set Gantt chart to read-only
            gantt.init("gantt_here");

            // Export Gantt Chart
            document.getElementById('export-btn').addEventListener('click', function() {
                exportGanttToExcel();
            });
            function exportGanttToExcel() {
                var data = gantt.serialize();
                var tasks = data.data;
                
                // Prepare Excel data
                var excelData = [];
                tasks.forEach(function(task) {
                    var row = {
                        // "ID": task.id,
                        "Title": task.text,
                        "Start Date": task.start_date,
                        "Duration": task.duration,
                        "Progress (%)": task.progress * 100,
                        // "Parent": task.parent || '',
                        // "Type": task.type || 'task',
                        "Overdue": task.overdue ? 'Yes' : 'No'
                    };
                    excelData.push(row);
                });

                // Create a worksheet
                var ws = XLSX.utils.json_to_sheet(excelData);
                var wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, "Gantt Chart");

                // Export to Excel
                XLSX.writeFile(wb, "gantt_chart.xlsx");
            }

            // Export Gantt Chart
    // Gantt Chart

    // Dauly Activity
        $('#btn_save_daily').on('click', function(e){
            e.preventDefault()
            var formData        = new FormData();    
            var subdetail_code     = $('#daily_task').val()
            formData.append('subdetail_code', subdetail_code)
            formData.append('daily_description',$('#daily_description').val())
            formData.append('daily_attachment',$('#daily_attachment')[0].files[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('updateDaily')}}",
                type: "post",
                dataType: 'json',
                async: true,
                processData: false,
                contentType: false,
                data: formData,
                beforeSend: function() {
                    SwalLoading('Inserting progress, please wait .');
                },
                success: function(response) {
                        swal.close()
                        $('.message_error').html('')
                        var detail_code = $('#detail_code_chat').val()
                        showNoSwal(detail_code)
                        $('#daily_description').val('')
                        $('#addDailyModal').modal('hide')
                        toastr['success'](response.meta.message);
            
                },
                error: function(xhr, status, error) {
                    // swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
        })
    // Dauly Activity
//   Function 
        function getData(data) {
            $('#kanban_new').empty();
            $('#kanban_progress').empty();
            $('#kanban_pending').empty();
            $('#kanban_done').empty();
            $('#moduleContainerLabel').empty();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('getTimelineDetail')}}",
                type: "get",
                dataType: 'json',
                async: true,
                data: data,
                beforeSend: function() {
                    SwalLoading('Please wait ...');
                },
                success: function(response) {
                    swal.close();
                    var data_new = '';
                    var data_progress = '';
                    var data_pending = '';
                    var data_done = '';
                    var module_container = ''
                    var cssModule =''
                    
                    for (i = 0; i < response.data.length; i++) {
                        var color = '';
                        if (response.data[i].percentage > 0 && response.data[i].percentage <= 25) {
                            color = 'rgba(255, 99, 132, 1)'; // Red
                        } else if (response.data[i].percentage >= 26 && response.data[i].percentage <= 50) {
                            color = 'rgba(255, 206, 86, 1)'; // Yellow
                        } else if (response.data[i].percentage >= 51 && response.data[i].percentage <= 75) {
                            color = 'rgba(54, 162, 235, 1)'; // Blue
                        } else if (response.data[i].percentage >= 76) {
                            color = 'rgba(75, 192, 192, 1)'; // Green
                        }
                      
                        if(header_type == 1){
                                        card =`
                                            <div class="card cursor-grab mb-2 card-child"  id="${response.data[i].detail_code}" onclick="show('${response.data[i].detail_code}','${response.data[i].name}')" >
                                                <div class="card-body detail_kanban p-2">
                                                    <p class="mb-0 hover" style="font-weight:bold;font-size:12px;color:black">${response.data[i].name}</p>
                                                    <div class="text-right p-0">
                                                    <small class="text-muted mb-1 d-inline-block hover" style="font-size:9px;font-weight:bold;color:black !important">${response.data[i].percentage}%</small>
                                                    </div>
                                                    <div class="progress" style="height: 5px;">
                                                    <div class="progress-bar ${color}" role="progressbar" style="width: ${response.data[i].percentage}%;" aria-valuenow="${response.data[i].percentage}" aria-valuemin="0" aria-valuemax="100"></div>                            
                                                    </div>
                                                    <div class="mt-1 mx-4 pt-1 pb-1 justify-content-center"style="font-size:9px;text-align:center;background-color:${isDateLate(response.data[i].end_date) == true && response.data[i] !=3 ? '#EE4E4E' : '#41B06E'};border-radius:5px;color:white !important">
                                                    <i class="fa-solid fa-clock mr-1"></i>  ${convertDate(response.data[i].start_date)} -  ${convertDate(response.data[i].end_date)}
                                                    </div>
                                                </div>
                                                </div>
                                            `
                        }else{         
                            var card = `
                                <div class="card cursor-grab mb-2 card-child" id="${response.data[i].detail_code}" onclick="show('${response.data[i].detail_code}','${response.data[i].name}')" >
                                    <div class="card-body detail_kanban p-2">
                                        <div class="row mb-4">
                                            <div class="col-12">
                                                <p class="mb-0 hover" style="font-weight:bold;font-size:12px; !important">${response.data[i].name}</p>
                                                <div class="text-right p-0">
                                                    <p class="mb-1 d-inline-block hover" style="font-size:9px !important;font-weight:bold;">${response.data[i].percentage}%</p>
                                                </div>
                                                <div class="progress" style="height: 5px;">
                                                    <div class="progress-bar ${color}" role="progressbar" style="width: ${response.data[i].percentage}%;" aria-valuenow="${response.data[i].percentage}" aria-valuemin="0" aria-valuemax="100"></div>                            
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <canvas id="chart-${response.data[i].detail_code}" style="width: 160px; height: 140px;"></canvas>
                                            </div>
                                        </div>
                                        <div class="mt-0 mx-2" style="margin-top:-15px !important">
                                            <div class="mt-1 mx-4 pt-1 pb-1 justify-content-center" style="font-size:9px;text-align:center;background-color:${isDateLate(response.data[i].end_date) == true && response.data[i] !=3 ? '#EE4E4E' : '#41B06E'};border-radius:5px;color:white !important">
                                                <i class="fa-solid fa-clock mr-1"></i> ${convertDate(response.data[i].start_date)} - ${convertDate(response.data[i].end_date)}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        }
                        if(response.data[i].sub_detail_relation){
                             var taskLabel =''
                            for(j =0 ; j < response.data[i].sub_detail_relation.length; j++ ){
                               
                                    taskLabel +=`
                                                    <li class="list-group-item" style="font-size:10px;font-family:Poppins" onclick="changeLabel('${response.data[i].sub_detail_relation[j].subdetail_code}')"> ${response.data[i].sub_detail_relation[j].name}</li>
                                              
                                                    
                                    `
                            }
                          var plan = response.data[i].plan > 0 ? formatRupiah(response.data[i].plan) : '-'
                        module_container +=`
                            <div class="card  mx-2 mb-1" style="box-shadow:none !important;border-radius:30px !important;${cssModule};">
                                <div class="card-header   collapsed p-0 mb-0 mt-2" id="heading${i}" data-toggle="collapse" data-target="#collapse${i}" aria-expanded="false" aria-controls="collapse${i}" style="border-radius:30px !important">
                                    <b class="p-0 ml-3 mb-0" style="font-size:12px">${response.data[i].name}</b>
                                </div>
                                <div id="collapse${i}" class="collapse" aria-labelledby="heading${i}" data-parent="#accordionExample">
                                    <div class="card-body p-0">
                                            <fieldset class="legend1 mt-4">
                                                <legend>General Information</legend>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <span style ="font-size:11px">${response.data[i].description}</span>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                        <div class="col-12">
                                                            <span style ="font-size:11px" >Start Date : ${convertDate(response.data[i].start_date)}</span>
                                                        </div>
                                                        <div class="col-12">
                                                            <span style ="font-size:11px" >Dateline: ${convertDate(response.data[i].end_date)}</span>
                                                        </div>
                                                        <div class="col-12">
                                                            <span style ="font-size:11px" >Plan : ${plan}</span>
                                                        </div>
                                                </div>
                                            </fieldset>
                                              <fieldset class="legend1">
                                                <legend>Task List</legend>
                                                <ul class="list-group ">
                                                    ${taskLabel}
                                                </ul>
                                                </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `
                        }
                     
                        if (response.data[i].status == 0) {
                            data_new += card;
                        } else if (response.data[i].status == 1) {
                            data_progress += card;
                        } else if (response.data[i].status == 2) {
                            data_pending += card;
                        } else if (response.data[i].status == 3) {
                            data_done += card;
                        }
                       
                        if(response.data[0].name == response.data[i].name){
                            cssModule = 'margin-top=-35px !important'
                        }else{
                            cssModule = 'margin-top=5px !important'
                        }
                       
                    }

                    $('#kanban_new').append(data_new);
                    $('#kanban_progress').append(data_progress);
                    $('#kanban_pending').append(data_pending);
                    $('#kanban_done').append(data_done);
                    $('#moduleContainerLabel').html(module_container);
                    

                    // Initialize the charts
                    if(header_type ==2){
                        response.array.forEach(function(item) {
                            var ctx = document.getElementById('chart-' + item.detail_code).getContext('2d');
                            new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: ['Plan', 'Actual'],
                                    datasets: [{
                                        label: 'Plan',
                                        data: [item.plan],
                                        backgroundColor: '#E88D67',
                                        borderColor: 'white',
                                        borderWidth: 1
                                    },
                                    {
                                        label: 'Actual',
                                        data: [item.actual],
                                        backgroundColor: '#F3F7EC',
                                        borderColor: 'white',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    maintainAspectRatio: false,
                                    aspectRatio: 3, // Adjust aspect ratio
                                    scales: {
                                        x: {
                                            display: false // Hide x-axis labels
                                        },
                                        y: {
                                            display: true // Hide y-axis labels
                                        }
                                    },
                                    plugins: {
                                        tooltip: {
                                            enabled: true // Enable tooltips on hover
                                        },
                                        legend: {
                                            display: false // Hide legend
                                        }
                                    }
                                }
                            });
                        });

                    }

                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['warning']('Failed to get data, please contact ICT Developer');
                }
            });
        }

        function isDateLate(inputDate) {
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            const dateToCheck = new Date(inputDate);
            dateToCheck.setHours(0, 0, 0, 0);

            return dateToCheck < today; // Returns true if the date is in the past
        }
        function getDataNoSwal(data){
           
            $('#kanban_new').empty()
            $('#kanban_progress').empty()
            $('#kanban_pending').empty()
            $('#kanban_done').empty()
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('getTimelineDetail')}}",
                type: "get",
                dataType: 'json',
                async: true,
                data: data,
                beforeSend: function() {
                    // SwalLoading('Please wait ...');
                },
                success: function(response) {
                    // swal.close();
                    var data_new = '';
                    var data_progress = '';
                    var data_pending = '';
                    var data_done = '';

                    for (i = 0; i < response.data.length; i++) {
                        var color = '';
                        if (response.data[i].percentage > 0 && response.data[i].percentage <= 25) {
                            color = 'rgba(255, 99, 132, 1)'; // Red
                        } else if (response.data[i].percentage >= 26 && response.data[i].percentage <= 50) {
                            color = 'rgba(255, 206, 86, 1)'; // Yellow
                        } else if (response.data[i].percentage >= 51 && response.data[i].percentage <= 75) {
                            color = 'rgba(54, 162, 235, 1)'; // Blue
                        } else if (response.data[i].percentage >= 76) {
                            color = 'rgba(75, 192, 192, 1)'; // Green
                        }
                        if(header_type == 1){
                                        card =`
                                    <div class="card cursor-grab mb-2 card-child"  id="${response.data[i].detail_code}" onclick="show('${response.data[i].detail_code}','${response.data[i].name}')">
                                        <div class="card-body detail_kanban p-2">
                                            <p class="mb-0" style="font-weight:bold;font-size:12px;">${response.data[i].name}</p>
                                            <div class="text-right p-0">
                                            <small class="text-muted mb-1 d-inline-block" style="font-size:9px;font-weight:bold;">${response.data[i].percentage}%</small>
                                            </div>
                                            <div class="progress" style="height: 5px;">
                                            <div class="progress-bar ${color}" role="progressbar" style="width: ${response.data[i].percentage}%;" aria-valuenow="${response.data[i].percentage}" aria-valuemin="0" aria-valuemax="100"></div>                            
                                            </div>
                                            <div class="mt-1 mx-4 pt-1 pb-1 justify-content-center" style="font-size:9px;text-align:center;background-color:${isDateLate(response.data[i].end_date) == true && response.data[i] !=3 ? '#EE4E4E' : '#41B06E'};border-radius:5px">
                                            <i class="fa-solid fa-clock mr-1"></i>  ${convertDate(response.data[i].start_date)} -  ${convertDate(response.data[i].end_date)}
                                            </div>
                                        </div>
                                        </div>
                                    `
                        }else{

                                    
                        var card = `
                          <div class="card cursor-grab mb-2 card-child" id="${response.data[i].detail_code}" onclick="show('${response.data[i].detail_code}','${response.data[i].name}')" >
                                    <div class="card-body detail_kanban p-2">
                                        <div class="row mb-4">
                                            <div class="col-12">
                                                <p class="mb-0 hover" style="font-weight:bold;font-size:12px; !important">${response.data[i].name}</p>
                                                <div class="text-right p-0">
                                                    <p class="mb-1 d-inline-block hover" style="font-size:9px !important;font-weight:bold;">${response.data[i].percentage}%</p>
                                                </div>
                                                <div class="progress" style="height: 5px;">
                                                    <div class="progress-bar ${color}" role="progressbar" style="width: ${response.data[i].percentage}%;" aria-valuenow="${response.data[i].percentage}" aria-valuemin="0" aria-valuemax="100"></div>                            
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <canvas id="chart-${response.data[i].detail_code}" style="width: 160px; height: 140px;"></canvas>
                                            </div>
                                        </div>
                                        <div class="mt-0 mx-2" style="margin-top:-15px !important">
                                            <div class="mt-1 mx-4 pt-1 pb-1 justify-content-center" style="font-size:9px;text-align:center;background-color:${isDateLate(response.data[i].end_date) == true && response.data[i] !=3 ? '#EE4E4E' : '#41B06E'};border-radius:5px;color:white !important">
                                                <i class="fa-solid fa-clock mr-1"></i> ${convertDate(response.data[i].start_date)} - ${convertDate(response.data[i].end_date)}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        `;
                        }
                        if (response.data[i].status == 0) {
                            data_new += card;
                        } else if (response.data[i].status == 1) {
                            data_progress += card;
                        } else if (response.data[i].status == 2) {
                            data_pending += card;
                        } else if (response.data[i].status == 3) {
                            data_done += card;
                        }
                    }

                    $('#kanban_new').append(data_new);
                    $('#kanban_progress').append(data_progress);
                    $('#kanban_pending').append(data_pending);
                    $('#kanban_done').append(data_done);
                    if(header_type == 2){

                        // Initialize the charts
                        response.array.forEach(function(item) {
                            var ctx = document.getElementById('chart-' + item.detail_code).getContext('2d');
                            new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: ['Plan', 'Actual'],
                                    datasets: [{
                                        label: 'Plan',
                                        data: [item.plan],
                                        backgroundColor: '#E88D67',
                                        borderColor: 'white',
                                        borderWidth: 1
                                    },
                                    {
                                        label: 'Actual',
                                        data: [item.actual],
                                        backgroundColor: '#F3F7EC',
                                        borderColor: 'white',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    maintainAspectRatio: false,
                                    aspectRatio: 3, // Adjust aspect ratio
                                    scales: {
                                        x: {
                                            display: false // Hide x-axis labels
                                        },
                                        y: {
                                            display: true // Hide y-axis labels
                                        }
                                    },
                                    plugins: {
                                        tooltip: {
                                            enabled: true // Enable tooltips on hover
                                        },
                                        legend: {
                                            display: false // Hide legend
                                        }
                                    }
                                }
                            });
                        });
                    }
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['warning']('Failed to get data, please contact ICT Developer');
                }
            });
        }

        function show(id,title){
            // 10000 milliseconds = 10 seconds
            $('#detailCardModal').modal('show')
            $('#detail_label').html(title)
            $('#detail_code_chat').val(id)
            chat = setInterval(function() {
                showNoSwal(id);
            }, 10000);
            $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('getSubDetailKanban')}}",
                    type: "get",
                    dataType: 'json',
                    async: true,
                    data:{
                    'detail_code' :id
                    },
                    beforeSend: function() {
                        SwalLoading('Please wait ...');
                    },
                    success: function(response) {
                       
                        swal.close();
                        chat
                        $('#start_date_module_edit').val(response.detail.start_date)
                        $('#end_date_module_edit').val(response.detail.end_date)
                        $('#name_module_edit').val(response.detail.name)
                        $('#description_module_edit').val(response.detail.description)
                        if(header_type == 1){
                            $('#purchase_container_edit').prop('hidden', true)
                        }else{
                            $('#purchase_container_edit').prop('hidden', false)
                            $('#plan_amount_edit').val(convertToRupiah(response.detail.plan))
                        }
                        // Mapping Activity
                        $('#task_subdetail_table').DataTable().clear();
                        $('#task_subdetail_table').DataTable().destroy();
                        $('#log_module_table').DataTable().destroy();
                        
                        $('#chat_container').empty()
                        $('#percentage_task_container').empty()
                        var chat = ''
                        var data_table = ''
                        var auth_id = $('#authId').val()
                       
                        var data_percentage =''
                       
                        var plan_label =response.detail.plan == 0 ? ': -' : `: ${convertToRupiah(response.detail.plan)}`
                        $('#plan_label').html(plan_label)
                        var color = ''
                            if(response.detail.percentage >= 0 && response.detail.percentage <= 25){
                                color ='red'
                            }else if(response.detail.percentage >= 26 && response.detail.percentage <= 50){
                                color ='orange'
                            }else if(response.detail.percentage >= 51 && response.detail.percentage <= 75){
                                color ='blue'
                            }else{
                                color ='green'
                            }
                            if ($('#percentage_task_container .circular-chart').length > 0) {
                                // Update existing chart
                                $('#percentage_task_container .circular-chart').attr('class', 'circular-chart ' + color);
                                $('#percentage_task_container .circle').attr('stroke-dasharray', `${response.detail.percentage}, 100`);
                                $('#percentage_task_container .percentage').text(`${response.detail.percentage}%`);
                            } else {
                                // Create new chart
                                var data_percentage = `
                                    <div class="single-chart" style="display: flex; justify-content: left; align-items: left; padding-left: 15px !important">
                                        <svg viewBox="0 0 36 36" class="circular-chart ${color}" style="min-height: 100px; width: 100%; min-width: 150px !important">
                                            <path class="circle-bg"
                                                d="M18 2.0845
                                                    a 15.9155 15.9155 0 0 1 0 31.831
                                                    a 15.9155 15.9155 0 0 1 0 -31.831"
                                            />
                                            <path class="circle"
                                                stroke-dasharray="${response.detail.percentage}, 100"
                                                d="M18 2.0845
                                                    a 15.9155 15.9155 0 0 1 0 31.831
                                                    a 15.9155 15.9155 0 0 1 0 -31.831"
                                            />
                                            <text x="18" y="20.35" class="percentage" style="color : black !important">${response.detail.percentage}%</text>
                                        </svg>
                                    </div>
                                `;
                            }
                                $('#percentage_task_container').html(data_percentage);
                        for(i=0 ; i < response.data.length; i ++){
                           
                          
                            const task = response.data[i];
                            var disabled = 'disabled';
                            if(task.pic == auth_id){
                                disabled = ''
                            }
                            if(leader_id == auth_id && response.data[i]['status'] == 1){  
                                disabled = ''
                            }
                            const d = new Date(task.update_done);
                            const date = d != 'Thu Jan 01 1970 07:00:00 GMT+0700 (Western Indonesia Time)' ? convertDate(d.toISOString().split('T')[0]) : '';
                            const datevalidate = d != 'Thu Jan 01 1970 07:00:00 GMT+0700 (Western Indonesia Time)' ? d.toISOString().split('T')[0] : '';
                            const time = d != 'Thu Jan 01 1970 07:00:00 GMT+0700 (Western Indonesia Time)' ? d.toTimeString().split(' ')[0] : '';
                            const date_time = date + ' ' + time;

                            let label = '';
                            if (task.status == 1) {
                                label = `<s>${task.name}</s>`;
                            } else if (isDateLate(task.end_date) && date_time != '') {
                                label = `<strong style="color:red">${task.name}</strong>`;
                            } else {
                                label = `${task.name}`;
                            }

                            const updatedDate = new Date(task.updated_at);
                            const isEndDateSameAsUpdated = response.data[i].end_date === datevalidate;
                            const isEndDateLateComparedToUpdated = new Date(task.end_date) < updatedDate && !isEndDateSameAsUpdated;
                            const formattedDateTime = isEndDateLateComparedToUpdated ? `<strong style="color:red">${date_time}</strong>` : date_time;
                            var btn_update =''
                            var log_activity =''
                            if(task.status == 0){
                                if(auth_id == task.pic){
                                    btn_update =`
                                    <button class="update btn btn-sm btn-warning" title="Update Task" data-id="${response.data[i]['id']}" data-toggle="modal" data-target="#updateTaskModal">
                                                <i class="fas fa-edit"></i>
                                        </button>
                                    `
                                }
                            }
                            if(auth_id == task.pic){
                                if(task.status == 0){
                                    log_activity =`
                                        <button class="daily btn btn-sm btn-primary" title="Update Activity" data-id="${response.data[i]['id']}" data-task="${response.data[i].subdetail_code}" data-toggle="modal" data-target="#addDailyModal">
                                                    <i class="fa-solid fa-book"></i>
                                            </button>
                                        `
                                }
                            }
                            
                            
                            data_table +=`
                            <tr>
                                <td style="width:5%;text-align:center">
                                    <input type="checkbox" id="check" name="check" class="is_checked" style="border-radius: 5px !important;" value="${response.data[i]['id']}"  data-status="${response.data[i]['status']}" data-id="${response.data[i]['id']}" ${response.data[i]['status'] == 1 ?'checked':'' } ${disabled}>
                                </td>
                                <td style="width:10%;text-align:left">
                                    ${convertDate(response.data[i].start_date)}
                                </td>
                                <td>
                                    ${label}
                                </td>
                                <td style="width:25%;">
                                    ${response.data[i].user_relation.name}
                                </td>
                                <td style="width:10%;text-align:left">
                                    ${convertDate(response.data[i].end_date)}
                                </td>
                                <td style="width:15%;text-align:left">
                                    ${formattedDateTime}
                                </td>
                                <td style="width:20%;text-align:center">
                                    <button title="Detail" class="detail btn btn-sm btn-info" data-id="${response.data[i]['id']}" data-toggle="modal" data-target="#detailTaskModal" >
                                                    <i class="fas fa-solid fa-eye"></i>
                                    </button>   
                                   ${log_activity}
                                   ${btn_update}

                                </td>
                            </tr>
                            `;
                        }
                        $('#task_subdetail_table > tbody:first').html(data_table);
                        $('#task_subdetail_table').DataTable({
                            // scrollX  : true,
                            language: {
                                        'paginate': {
                                                'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                                                'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                                        }
                                    },
                        }).columns.adjust()                    
                        // Mapping Activity

                        // Mapping Chat
                            for (j = 0; j < response.chat.length; j++) {
                                const d = new Date(response.chat[j].created_at);
                                const date = d.toISOString().split('T')[0];
                                const time = d.toTimeString().split(' ')[0];
                                var auth = $('#authId').val();
                                var name_img = response.chat[j].user_relation.gender == 1 ? 'profile.png' : 'female_final.png';
                                var attachment = response.chat[j].attachment ? `<a style="color:#76ABAE !important;font-size:10px !important" title="Click Here For Attachment" href="{{URL::asset('${response.chat[j].attachment}')}}" target="_blank">
                                    <i class="fa-solid fa-file-pdf"></i> Click Here
                                    </a>` : '';

                                if (response.chat[j].user_relation.id == 999) {
                                    remark = `
                                        <div class="direct-chat-msg">
                                            <div class="direct-chat-infos clearfix">
                                                <span style='font-size:9px;' class="direct-chat-timestamp">${formatDate(date)} ${time}</span>
                                            </div>
                                            <div class="desk" style="width=100px !important">
                                                ${attachment}
                                                <span style="font-size:9px !important;color:black;font-weight:normal !important; margin-left:auto;margin-right:auto;text-align:center !important;background-color:#d2d6de" class="badge badge-secondary p-2">${response.chat[j].remark}</span>
                                            </div>
                                        
                                        </div>
                                    `;
                                } else {
                                    remark = `
                                        <div class="person-a">
                                            <div class="icon" style=" background-image:url('{{ asset('storage/users-avatar/${response.chat[j].user_relation.avatar}')}}');"></div>
                                            <div class="message">
                                                <span><b>${response.chat[j].user_relation.name}</b>  ${attachment} ${response.chat[j].remark}</span>
                                                <br>
                                                <span style="font-size:9px !important;color:#31363F">${convertDate(date)}, ${time}</span>
                                            </div>
                                        
                                        </div>
                                    `;
                                }
                                chat += remark;
                            }
                            $('#chat_container').append(chat);
                        // Mapping Chat

                        // Mapping Detail
                            var status_detail = ''
                            switch(response.detail.status){
                                case 0:
                                    status_detail ='New'
                                
                                    break;
                                case 1:
                                    status_detail ='In Progress'
                                    break;
                                case 2:
                                    status_detail ='Pending'
                                    break;
                                case 3:
                                    status_detail ='DONE'
                                    break;
                                default:

                            }
                        // Mapping Detail
                        $('#module_request_code_label').html(': ' + response.detail.request_code)
                        $('#module_detail_code_label').html(': ' + response.detail.detail_code)
                        $('#module_name_label').html(': ' + response.detail.name)
                        $('#module_description_label').html(': ' + response.detail.description)
                        $('#module_status_label').html(': '+ status_detail)
                        $('#module_start_date_label').val(response.detail.start_date)
                        $('#module_end_date_label').val(response.detail.end_date)
                        $('#request_code_chat').val(response.detail.request_code)
                        $('#detail_code_chat').val(id)
                        // Mapping Detail
                       
                        // Mapping Log Module
                            var data_log_module =''
                           
                            for(k=0 ; k < response.log.length; k ++){
                             
                                var dateConvert = new Date(response.log[k].created_at);
                                var dateLog = dateConvert != 'Thu Jan 01 1970 07:00:00 GMT+0700 (Western Indonesia Time)' ? convertDate(dateConvert.toISOString().split('T')[0]) : '';
                                var timeLog = dateConvert != 'Thu Jan 01 1970 07:00:00 GMT+0700 (Western Indonesia Time)' ? dateConvert.toTimeString().split(' ')[0] : '';
                                data_log_module +=`
                                <tr>
                                    <td style="width:13%;text-align:center"> ${dateLog} ${timeLog}</td>
                                    <td style="width:17%;text-align:left"> ${response.log[k].user_relation.name}</td>
                                    <td style="width:10%;"> ${response.log[k].name}</td>
                                    <td style="width:10%;">${convertDate(response.log[k].start_date)}</td>
                                    <td style="width:10%;text-align:left">${convertDate(response.log[k].end_date)}</td>
                                    <td style="width:5%;text-align:right">${convertToRupiah(response.log[k].plan)}</td>
                                    <td style="text-align:left">${response.log[k].remark}</td>
                                </tr>
                                `;
                            }
                            $('#log_module_table > tbody:first').html(data_log_module);
                      
                            $('#log_module_table').DataTable({
                                // scrollX  : true,
                                language: {
                                            'paginate': {
                                                    'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                                                    'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                                            }
                                        },
                            }).columns.adjust()   
                        // Mapping Log Module
                        },
                    error: function(xhr, status, error) {
                        swal.close();
                        toastr['error']('Failed to get data, please contact ICT Developer');
                    }
            });

        }

        function showNoSwal(id){
            $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('getSubDetailKanban')}}",
                    type: "get",
                    dataType: 'json',
                    async: true,
                    data:{
                    'detail_code' :id
                    },
                    beforeSend: function() {
                       
                    },
                    success: function(response) {
                      
                        chat
                        // Mapping Activity
                        $('#task_subdetail_table').DataTable().clear();
                        $('#task_subdetail_table').DataTable().destroy();
                        $('#log_module_table').DataTable().destroy();
                        
                        $('#chat_container').empty()
                        $('#percentage_task_container').empty()
                        var chat = ''
                        var data_table = ''
                        var auth_id = $('#authId').val()
                        var data_percentage =''
                        var color = ''
                            if(response.detail.percentage >= 0 && response.detail.percentage <= 25){
                                color ='red'
                            }else if(response.detail.percentage >= 26 && response.detail.percentage <= 50){
                                color ='orange'
                            }else if(response.detail.percentage >= 51 && response.detail.percentage <= 75){
                                color ='blue'
                            }else{
                                color ='green'
                            }
                            if ($('#percentage_task_container .circular-chart').length > 0) {
                                // Update existing chart
                                $('#percentage_task_container .circular-chart').attr('class', 'circular-chart ' + color);
                                $('#percentage_task_container .circle').attr('stroke-dasharray', `${response.detail.percentage}, 100`);
                                $('#percentage_task_container .percentage').text(`${response.detail.percentage}%`);
                            } else {
                                // Create new chart
                                var data_percentage = `
                                    <div class="single-chart" style="display: flex; justify-content: left; align-items: left; padding-left: 15px !important">
                                        <svg viewBox="0 0 36 36" class="circular-chart ${color}" style="min-height: 100px; width: 100%; min-width: 150px !important">
                                            <path class="circle-bg"
                                                d="M18 2.0845
                                                    a 15.9155 15.9155 0 0 1 0 31.831
                                                    a 15.9155 15.9155 0 0 1 0 -31.831"
                                            />
                                            <path class="circle"
                                                stroke-dasharray="${response.detail.percentage}, 100"
                                                d="M18 2.0845
                                                    a 15.9155 15.9155 0 0 1 0 31.831
                                                    a 15.9155 15.9155 0 0 1 0 -31.831"
                                            />
                                            <text x="18" y="20.35" class="percentage" style="color : black !important">${response.detail.percentage}%</text>
                                        </svg>
                                    </div>
                                `;
                            }
                                $('#percentage_task_container').html(data_percentage);
                                for(i=0 ; i < response.data.length; i ++){
                           
                           
                                    const task = response.data[i];

                                    var disabled = 'disabled';
                                    if(task.pic == auth_id){
                                      
                                        disabled = ''
                                    }else if(leader_id == auth_id && response.data[i]['status'] == 1){
                                        
                                    disabled = ''
                                    }
                                    const d = new Date(task.update_done);
                                    const date = d != 'Thu Jan 01 1970 07:00:00 GMT+0700 (Western Indonesia Time)' ? convertDate(d.toISOString().split('T')[0]) : '';
                                    const datevalidate = d != 'Thu Jan 01 1970 07:00:00 GMT+0700 (Western Indonesia Time)' ? d.toISOString().split('T')[0] : '';
                                    const time = d != 'Thu Jan 01 1970 07:00:00 GMT+0700 (Western Indonesia Time)' ? d.toTimeString().split(' ')[0] : '';
                                    const date_time = date + ' ' + time;

                                    let label = '';
                                    if (task.status == 1) {
                                        label = `<s>${task.name}</s>`;
                                    } else if (isDateLate(task.end_date) && date_time != '') {
                                        label = `<strong style="color:red">${task.name}</strong>`;
                                    } else {
                                        label = `${task.name}`;
                                    }

                                    const updatedDate = new Date(task.updated_at);
                                    const isEndDateSameAsUpdated = response.data[i].end_date === datevalidate;
                                    const isEndDateLateComparedToUpdated = new Date(task.end_date) < updatedDate && !isEndDateSameAsUpdated;
                                    const formattedDateTime = isEndDateLateComparedToUpdated ? `<strong style="color:red">${date_time}</strong>` : date_time;
                                    var btn_update =''
                                    var log_activity =''
                                    if(task.status == 0){
                                        if(auth_id == task.pic){
                                            btn_update =`
                                                <button class="update btn btn-sm btn-warning" title="Update Task" data-id="${response.data[i]['id']}" data-toggle="modal" data-target="#updateTaskModal">
                                                        <i class="fas fa-edit"></i>
                                                </button>
                                            `
                                        }
                                    }
                                    if(auth_id == task.pic){
                                        if(task.status == 0){
                                            log_activity =`
                                                    <button class="daily btn btn-sm btn-primary" title="Update Activity" data-id="${response.data[i]['id']}" data-task="${response.data[i].subdetail_code}" data-toggle="modal" data-target="#addDailyModal">
                                                            <i class="fa-solid fa-book"></i>
                                                    </button>
                                                `
                                        }
                                    }
                                    
                                    
                                    data_table +=`
                                    <tr>
                                        <td style="width:5%;text-align:center">
                                            <input type="checkbox" id="check" name="check" class="is_checked" style="border-radius: 5px !important;" value="${response.data[i]['id']}"  data-status="${response.data[i]['status']}" data-id="${response.data[i]['id']}" ${response.data[i]['status'] == 1 ?'checked':'' } ${disabled}>
                                        </td>
                                        <td style="width:10%;text-align:left">
                                            ${convertDate(response.data[i].start_date)}
                                        </td>
                                        <td>
                                            ${label}
                                        </td>
                                        <td style="width:25%;">
                                            ${response.data[i].user_relation.name}
                                        </td>
                                        <td style="width:10%;text-align:left">
                                            ${convertDate(response.data[i].end_date)}
                                        </td>
                                        <td style="width:15%;text-align:left">
                                            ${formattedDateTime}
                                        </td>
                                        <td style="width:20%;text-align:center">
                                            <button title="Detail" class="detail btn btn-sm btn-info" data-id="${response.data[i]['id']}" data-toggle="modal" data-target="#detailTaskModal" >
                                                            <i class="fas fa-solid fa-eye"></i>
                                            </button>   
                                        ${log_activity}
                                        ${btn_update}

                                        </td>
                                    </tr>
                                    `;
                       }
                        $('#task_subdetail_table > tbody:first').html(data_table);
                        $('#task_subdetail_table').DataTable({
                            // scrollX  : true,
                            language: {
                                        'paginate': {
                                                'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                                                'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                                        }
                                    },
                        }).columns.adjust()                    
                        // Mapping Activity

                        // Mapping Chat
                        for (j = 0; j < response.chat.length; j++) {
                            const d = new Date(response.chat[j].created_at);
                            const date = d.toISOString().split('T')[0];
                            const time = d.toTimeString().split(' ')[0];
                            var auth = $('#authId').val();
                            var name_img = response.chat[j].user_relation.gender == 1 ? 'profile.png' : 'female_final.png';
                            var attachment = response.chat[j].attachment ? `<a style="color:#76ABAE !important;font-size:10px !important" title="Click Here For Attachment" href="{{URL::asset('${response.chat[j].attachment}')}}" target="_blank">
                                <i class="fa-solid fa-file-pdf"></i> Click Here
                                </a>` : '';
                            if (response.chat[j].user_relation.id == 999) {
                                remark = `
                                    <div class="direct-chat-msg">
                                        <div class="direct-chat-infos clearfix">
                                            <span style='font-size:9px;' class="direct-chat-timestamp">${formatDate(date)} ${time}</span>
                                        </div>
                                        <div class="desk" style="width=100px !important">
                                            <span style="font-size:9px !important;color:black;font-weight:normal !important; margin-left:auto;margin-right:auto;text-align:center !important;background-color:#d2d6de" class="badge badge-secondary p-2">${response.chat[j].remark}</span>
                                        </div>
                                        ${attachment}
                                    </div>
                                `;
                            } else {
                                remark = `
                                    <div class="person-a">
                                        <div class="icon" style=" background-image:url('{{ asset('storage/users-avatar/${response.chat[j].user_relation.avatar}')}}');"></div>
                                        <div class="message">
                                            <span><b>${response.chat[j].user_relation.name}</b>  ${attachment} ${response.chat[j].remark}</span>
                                            <br>
                                            <span style="font-size:9px !important;color:#31363F">${convertDate(date)}, ${time}</span>
                                        </div>
                                       
                                    </div>
                                `;
                            }
                            chat += remark;
                        }
                        $('#chat_container').append(chat);
                        // Mapping Chat
                        var status_detail = ''
                        switch(response.detail.status){
                            case 0:
                                status_detail ='New'
                              
                                break;
                            case 1:
                                status_detail ='In Progress'
                                break;
                            case 2:
                                status_detail ='Pending'
                                break;
                            case 3:
                                status_detail ='DONE'
                                break;
                            default:

                        }
                        // Mapping Detail
                        $('#module_request_code_label').html(': ' + response.detail.request_code)
                        $('#module_detail_code_label').html(': ' + response.detail.detail_code)
                        $('#module_name_label').html(': ' + response.detail.name)
                        $('#module_description_label').html(': ' + response.detail.description)
                        $('#module_status_label').html( ': ' + status_detail)
                        $('#module_start_date_label').val(response.detail.start_date)
                        $('#module_end_date_label').val(response.detail.end_date)
                        $('#request_code_chat').val(response.detail.request_code)
                        $('#detail_code_chat').val(id)
                        // Mapping Detail
                          // Mapping Log Module
                          var data_log_module =''
                            for(k=0 ; k < response.log.length; k ++){
                                
                                var dateConvert = new Date(response.log[k].created_at);
                                var date = dateConvert != 'Thu Jan 01 1970 07:00:00 GMT+0700 (Western Indonesia Time)' ? convertDate(dateConvert.toISOString().split('T')[0]) : '';
                                var time = dateConvert != 'Thu Jan 01 1970 07:00:00 GMT+0700 (Western Indonesia Time)' ? dateConvert.toTimeString().split(' ')[0] : '';
                                data_log_module +=`
                                <tr>
                                    <td style="width:13%;text-align:center"> ${date} ${time}</td>
                                    <td style="width:17%;text-align:left"> ${response.log[k].user_relation.name}</td>
                                    <td style="width:10%;"> ${response.log[k].name}</td>
                                    <td style="width:10%;">${convertDate(response.log[k].start_date)}</td>
                                    <td style="width:10%;text-align:left">${convertDate(response.log[k].end_date)}</td>
                                    <td style="width:5%;text-align:right">${convertToRupiah(response.log[k].plan)}</td>
                                    <td style="text-align:left">${response.log[k].remark}</td>
                                </tr>
                                `;
                            }
                            $('#log_module_table > tbody:first').html(data_log_module);
                            $('#log_module_table').DataTable({
                                // scrollX  : true,
                                language: {
                                            'paginate': {
                                                    'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                                                    'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                                            }
                                        },
                            }).columns.adjust()   
                        // Mapping Log Module
                        },
                    error: function(xhr, status, error) {
                        swal.close();
                        toastr['error']('Failed to get data, please contact ICT Developer');
                    }
            });
        }

        function getChat(detail_code){
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('getChat')}}",
                type: "get",
                dataType: 'json',
                async: true,
                data:{
                'detail_code' : detail_code
                },
                success: function(response) {
                
                    var chat = ''
                    $('#chat_container').empty()
                    for(j = 0; j < response.chat.length; j++){
                                        const d = new Date(response.chat[j].created_at)
                                        const date = d.toISOString().split('T')[0];
                                        const time = d.toTimeString().split(' ')[0];
                                        var auth = $('#authId').val()
                                        var name_img = response.chat[j].user_relation.gender == 1 ? 'profile.png' : 'female_final.png';
                                                if(response.chat[j].user_relation.id == 999){
                                            
                                                remark = `
                                                    <div class="direct-chat-msg">
                                                            <div class="direct-chat-infos clearfix">
                                                                <span style='font-size:9px;' class="direct-chat-timestamp">${formatDate(date)} ${time}</span>
                                                            </div>
                                                        <div class="desk" style="width=100px !important">
                                                            <span style="font-size:9px !important;color:black;font-weight:normal !important; margin-left:auto;margin-right:auto;text-align:center !important;background-color:#d2d6de" class="badge badge-secondary p-2">${response.chat[j].remark}</span>
                                                            </div>
                                                            
                                                        </div>

                                                `
                                                }else{
                                                    remark =`
                                                    <div class="person-a">
                                                                <div class="icon" style=" background-image:url('{{ asset('storage/users-avatar/${response.chat[j].user_relation.avatar}')}}');">
                                                                </div> 
                                                                <div class="message">
                                                                
                                                                    <span>
                                                                        <b>${response.chat[j].user_relation.name}</b> ${response.chat[j].remark}
                                                                    </span>
                                                                    <br>
                                                                    <span style="font-size:9px !important;color:#31363F">${convertDate(date)}, ${time}</span>
                                                                </div>
                                                            </div>     
                                                    `;
                                                }
                                                chat += remark;
                    }
                    $('#chat_container').append(chat)

                },
                error: function(xhr, status, error) {
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
        }
        
        function updateGanttChart(data) {
            var tasks = {
                data: [],
                links: []
            };

            data.forEach(function(header) {
                var headerTask = {
                    id: 'header_' + header.id,
                    text: header.name,
                    start_date: formatDate(header.start_date),
                    duration: calculateDuration(header.start_date, header.end_date),
                    progress: header.percentage / 100,
                    open: true // Open by default
                };
                tasks.data.push(headerTask);

                if (header.detail_relation) {
                    header.detail_relation.forEach(function(detail) {
                        var detailTask = {
                            id: 'detail_' + detail.id,
                            text: detail.name,
                            start_date: formatDate(detail.start_date),
                            duration: calculateDuration(detail.start_date, detail.end_date),
                            progress: detail.percentage / 100,
                            parent: headerTask.id
                        };
                        tasks.data.push(detailTask);

                        if (detail.sub_detail_relation) {
                            detail.sub_detail_relation.forEach(function(subdetail) {
                                var updateDoneDate = new Date(subdetail.update_done);
                                var is_done = updateDoneDate.toISOString().split('T')[0]
                                var endDate;
                                var duration;
                                var isOverdue = false;

                                if (updateDoneDate.getFullYear() === 1970) {
                                    endDate = subdetail.end_date;
                                    duration = 0; // Set as milestone
                                } else {
                                    endDate = updateDoneDate.toISOString().split('T')[0];
                                    duration = calculateDuration(subdetail.start_date, endDate);

                                    if (is_done > new Date(subdetail.end_date).toISOString().split('T')[0]) {
                                        isOverdue = true;
                                    } else {
                                        isOverdue = false;
                                    }
                                }

                                var subdetailTask = {
                                    id: 'subdetail_' + subdetail.id,
                                    text: subdetail.name,
                                    start_date: formatDate(subdetail.start_date),
                                    duration: duration,
                                    progress: subdetail.percentage / 100,
                                    parent: detailTask.id,
                                    type: (duration === 0) ? 'milestone' : 'task',
                                    overdue: isOverdue // Custom attribute to indicate overdue status
                                };
                                tasks.data.push(subdetailTask);
                            });
                        }
                    });
                }
            });

            gantt.clearAll();
            gantt.parse(tasks);
        }

        $('#detail_content').prop('hidden', true)

        function changeLabel(response){
            $('#detail_content').prop('hidden', false)
            $('#result_container').empty()
            $('#activity_container').empty()
            var data ={
                'subdetail_code' : response
            }
            $.ajax({
            url: "{{route('getLogTask')}}",
            type: "get",
            dataType: 'json',
            data:data,
            success: function(response){
                var actual = response.detail.amount > 0 ? formatRupiah(response.detail.amount) : '-'
                var chat = ''
               var detail =`
                        <fieldset class="legend1">
                                <legend style="width:100% !important">${response.detail.name}</legend>

                                <div class="row">
                                        <div class="col-12">
                                        <span style ="font-size:11px" >${response.detail.description}</span>
                                        </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <span style ="font-size:11px" >Start Date : ${convertDate(response.detail.start_date)}</span>
                                    </div>
                                    <div class="col-12">
                                        <span style ="font-size:11px" >Dateline: ${convertDate(response.detail.end_date)}</span>
                                    </div>
                                    <div class="col-12">
                                        <span style ="font-size:11px" >Actual: ${actual}</span>
                                    </div>
                                    <div class="col-12">
                                        <span style ="font-size:11px" >PIC : ${response.detail.user_relation.name}</span>
                                    </div>
                                </div>
                        </fieldset>
            `;
                $('#result_container').html(detail)

                for(i = 0; i < response.data.length ; i ++){
                    const d = new Date(response.data[i].created_at)
                    const date = d.toISOString().split('T')[0];
                    const time = d.toTimeString().split(' ')[0];
                    var attachment = response.data[i].attachment ? `<a style="color:#76ABAE !important;font-size:10px !important" title="Click Here For Attachment" href="{{URL::asset('${response.data[i].attachment}')}}" target="_blank">
                                    <i class="fa-solid fa-file-pdf"></i> Click Here
                                    </a>` : '';
                    chat += `
                    <div class="person-a">
                        <div class="icon" style=" background-image:url('{{ asset('storage/users-avatar/${response.data[i].creator_relation.avatar}')}}');">
                        </div> 
                        <div class="message">
                            <span>
                                <b>${response.data[i].creator_relation.name}</b> 
                                 ${attachment}
                                ${response.data[i].remark}
                            </span>
                            <br>
                            <span style="font-size:9px !important;color:#31363F">${convertDate(date)}, ${time}</span>
                        </div>
                    </div>     
                    `   
                }
                $('#activity_container').html(chat)
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
                }
            }); 
        }

//   Function 
</script>