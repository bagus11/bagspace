<script>
   var request_code = $('#request_code').val()
  var dataStart ={
    'request_code' : request_code
  }
  $(document).ready(function () {
        $('#addTaskModal').on('show.bs.modal', function () {
            $('#detailCardModal').css('z-index', 1039);
        });
        $('#addTaskModal').on('hidden.bs.modal', function () {
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
            'actual_amount'   : actual_amount,
        }
        $.ajax({
            url: "{{route('addTask')}}",
            type: "post",
            dataType: 'json',
            data:data,
            async: true,
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
                        Swal.fire({
                                    title: "<strong>"+response.detail.name+"</strong>",
                                    icon: false,
                                    html: `
                                    <div class="container" style="text-align:left !important;width 300px !important">
                                        <div class="row">
                                            <div class="col-3">
                                                <p styke="color:black !important">Start Date</p>
                                            </div>
                                            <div class="col-9">
                                                <p styke="color:black !important">: ${convertDate(response.detail.start_date)}</p>
                                            </div>
                                            <div class="col-3">
                                                <p styke="color:black !important">End Date</p>
                                            </div>
                                            <div class="col-9">
                                                <p styke="color:black !important"> : ${convertDate(response.detail.start_date)}</p>
                                            </div>
                                            <div class="col-3">
                                                <p styke="color:black !important">PIC</p>
                                            </div>
                                            <div class="col-9">
                                                <p styke="color:black !important"> : ${response.detail.user_relation.name}</p>
                                            </div>
                                            <div class="col-3">
                                                <p styke="color:black !important">Description</p>
                                            </div>
                                            <div class="col-9">
                                                <p styke="color:black !important"> : ${response.detail.description}</p>
                                            </div>
                                        </div>
                                    </div>
                                 
                                    `,
                                    showCloseButton: false,
                                    showCancelButton: false,
                                    focusConfirm: false,
                                });
                    },
                    error: function(xhr, status, error) {
                        swal.close();
                        toastr['warning']('Failed to get data, please contact ICT Developer');
                    }
                });
    })
//   Function 
        function getData(data){
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
                    data:data,
                    beforeSend: function() {
                        SwalLoading('Please wait ...');
                    },
                    success: function(response) {
                        swal.close();
                        var data_new =''
                        var data_progress =''
                        var data_pending =''
                        var data_done =''
                        for(i = 0; i < response.data.length ; i++ ){
                            var color = '';
                                if(response.data[i].percentage > 0 && response.data[i].percentage <= 25){
                                    color ='bg-danger'
                                }else if(response.data[i].percentage >= 26 && response.data[i].percentage <= 50){
                                    color ='bg-warning'
                                }else if(response.data[i].percentage >= 51 && response.data[i].percentage <= 75){
                                    color ='bg-primary'
                                }else if(response.data[i].percentage >= 76){
                                    color ='bg-success'
                                }
                            var card =`
                            <div class="card cursor-grab mb-2 card-child"  id="${response.data[i].detail_code}" onclick="show('${response.data[i].detail_code}','${response.data[i].name}')">
                                <div class="card-body detail_kanban p-2">
                                    <p class="mb-0" style="font-weight:bold;font-size:12px;">${response.data[i].name}</p>
                                    <div class="text-right p-0">
                                    <small class="text-muted mb-1 d-inline-block" style="font-size:9px;font-weight:bold;">${response.data[i].percentage}%</small>
                                    </div>
                                    <div class="progress" style="height: 5px;">
                                    <div class="progress-bar ${color}" role="progressbar" style="width: ${response.data[i].percentage}%;" aria-valuenow="${response.data[i].percentage}" aria-valuemin="0" aria-valuemax="100"></div>                            
                                    </div>
                                    <div class="mt-1 mx-4 pt-1 pb-1 justify-content-center" style="font-size:9px;text-align:center;background-color:#41B06E;border-radius:5px">
                                    <i class="fa-solid fa-clock mr-1"></i>  ${convertDate(response.data[i].start_date)} -  ${convertDate(response.data[i].end_date)}
                                    </div>
                                </div>
                                </div>
                            `
                            if(response.data[i].status == 0){
                            data_new += `
                            ${card}
                            `;
                            }
                            else if(response.data[i].status == 1){
                            data_progress += `
                                ${card}
                                `;
                            }else if(response.data[i].status == 2){
                                data_pending +=`
                                ${card}
                                `;
                            }else if(response.data[i].status == 3){
                                data_done +=`
                               ${card}
                                `; 
                            }
                        }
                        $('#kanban_new').append(data_new)
                        $('#kanban_progress').append(data_progress)
                        $('#kanban_pending').append(data_pending)
                        $('#kanban_done').append(data_done)

                    },
                    error: function(xhr, status, error) {
                        swal.close();
                        toastr['warning']('Failed to get data, please contact ICT Developer');
                    }
                });
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
                    data:data,
                    success: function(response) {
                        var data_new =''
                        var data_progress =''
                        var data_pending =''
                        var data_done =''
                        for(i = 0; i < response.data.length ; i++ ){
                            var card =`
                            <div class="card cursor-grab mb-2 card-child"  id="${response.data[i].detail_code}" onclick="show('${response.data[i].detail_code}','${response.data[i].name}')">
                                <div class="card-body detail_kanban p-2">
                                    <p class="mb-0" style="font-weight:bold;font-size:12px;">${response.data[i].name}</p>
                                    <div class="text-right p-0">
                                    <small class="text-muted mb-1 d-inline-block" style="font-size:9px;font-weight:bold;">${response.data[i].percentage}%</small>
                                    </div>
                                    <div class="progress" style="height: 5px;">
                                    <div class="progress-bar" role="progressbar" style="width: ${response.data[i].percentage}%;" aria-valuenow="${response.data[i].percentage}" aria-valuemin="0" aria-valuemax="100"></div>                            
                                    </div>
                                    <div class="mt-1 mx-4 pt-1 pb-1 justify-content-center" style="font-size:9px;text-align:center;background-color:#41B06E;border-radius:5px">
                                    <i class="fa-solid fa-clock mr-1"></i>  ${convertDate(response.data[i].start_date)} -  ${convertDate(response.data[i].end_date)}
                                    </div>
                                </div>
                                </div>
                            `
                            if(response.data[i].status == 0){
                            data_new += `
                               ${card}
                            `;
                            }
                            else if(response.data[i].status == 1){
                            data_progress += `
                                ${card}
                                `;
                            }else if(response.data[i].status == 2){
                                data_pending +=`
                                ${card}
                                `;
                            }else if(response.data[i].status == 3){
                                data_done +=`
                                ${card}
                                `; 
                            }
                        }
                        $('#kanban_new').append(data_new)
                        $('#kanban_progress').append(data_progress)
                        $('#kanban_pending').append(data_pending)
                        $('#kanban_done').append(data_done)

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
                        // Mapping Activity
                        $('#task_subdetail_table').DataTable().clear();
                        $('#task_subdetail_table').DataTable().destroy();
                        
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
                            data_percentage = `
                            <div class="single-chart" style="display: flex; justify-content: left; align-items: left;padding-left:15px !important">
                                <svg viewBox="0 0 36 36" class="circular-chart ${color}" style="min-height:100px;width:100%;min-width:150px !important">
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
                                    <text x="18" y="20.35" class="percentage">${response.detail.percentage}%</text>
                                </svg>
                            </div>
                            `;
                            $('#percentage_task_container').html(data_percentage)
                        for(i=0 ; i < response.data.length; i ++){
                           
                            var label = response.data[i].status == 1 ? `<s>${response.data[i].name}</s>` : `${response.data[i].name}`
                            var disabled = response.data[i].pic == auth_id ? 'test' : 'disabled'  
                            const d = new Date(response.data[i].update_done)
                            const date = d !='Thu Jan 01 1970 07:00:00 GMT+0700 (Western Indonesia Time)' ? convertDate(d.toISOString().split('T')[0]) : ''; 
                            const time = d != 'Thu Jan 01 1970 07:00:00 GMT+0700 (Western Indonesia Time)'? d.toTimeString().split(' ')[0]: '';   
                            var date_time =  date + ' ' + time                
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
                                    ${date_time}
                                </td>
                                <td style="width:5%;text-align:center">
                                    <button title="Detail" class="detail btn btn-sm btn-info"data-id="${response.data[i]['id']}" type="button">
                                                    <i class="fas fa-solid fa-eye"></i>
                                    </button>   
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
                                                                <span style="font-size:9px !important;color:#E2DFD0">${convertDate(date)}, ${time}</span>
                                                            </div>
                                                        </div>
                                        
                                                        `;
                                                    
                                                    }
                                                    chat += remark;
                        }
                        $('#chat_container').append(chat)
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
                            data_percentage = `
                            <div class="single-chart" style="display: flex; justify-content: left; align-items: left;padding-left:15px !important">
                                <svg viewBox="0 0 36 36" class="circular-chart ${color}" style="min-height:100px;width:100%;min-width:150px !important">
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
                                    <text x="18" y="20.35" class="percentage">${response.detail.percentage}%</text>
                                </svg>
                            </div>
                            `;
                            $('#percentage_task_container').html(data_percentage)
                        for(i=0 ; i < response.data.length; i ++){
                            var label = response.data[i].status == 1 ? `<s>${response.data[i].name}</s>` : `${response.data[i].name}`
                            var disabled = response.data[i].pic == auth_id ? 'test' : 'disabled'  
                            const d = new Date(response.data[i].update_done)
                            const date = d !='Thu Jan 01 1970 07:00:00 GMT+0700 (Western Indonesia Time)' ? convertDate(d.toISOString().split('T')[0]) : ''; 
                            const time = d != 'Thu Jan 01 1970 07:00:00 GMT+0700 (Western Indonesia Time)'? d.toTimeString().split(' ')[0]: '';   
                            var date_time =  date + ' ' + time                
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
                                    ${date_time}
                                </td>
                                <td style="width:5%;text-align:center">
                                  
                                    <button title="Detail" class="detail btn btn-sm btn-info"data-id="${response.data[i]['id']}" type="button">
                                                    <i class="fas fa-solid fa-eye"></i>
                                    </button>   
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
                                                                <span style="font-size:9px !important;color:#E2DFD0">${convertDate(date)}, ${time}</span>
                                                            </div>
                                                        </div>
                                        
                                                        `;
                                                    
                                                    }
                                                    chat += remark;
                        }
                        $('#chat_container').append(chat)
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
                                                                    <span style="font-size:9px !important;color:#E2DFD0">${convertDate(date)}, ${time}</span>
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
       


//   Function 
</script>