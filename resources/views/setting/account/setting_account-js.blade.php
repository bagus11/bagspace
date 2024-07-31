<script>
     getCallbackNoSwal('getTimelineHeaderUser',null,function(response){
                            mappingTableTimeline(response.data)
                            $('#project_label').html(response.data.length)
                        })
    getCallbackNoSwal('getCalculation',null, function(response){
        $('#remaining_label').html(response.progress)
        $('#task_label').html(response.all)
       
    })
    $('#btn_update_password').on('click', function(){
        var data ={
            'current_password': $('#current_password').val(),
            'new_password': $('#new_password').val(),
            'confirm_password': $('#confirm_password').val()
        }
        $('.message_error').html('')
        postCallback('update_password', data, function(response){
            swal.close()
            $('#changePasswordModal').modal('hide')
            $('#current_password').val('')
            $('#new_password').val('')
            $('#confirm_password').val('')
            toastr['success'](response.meta.message)
        })
    })

    // Change Image 
    $(document).ready(function() {
        var cropper;
        var image = document.getElementById('cropImage');
        var input = document.getElementById('profileImageInput');

        input.addEventListener('change', function(e) {
            var files = e.target.files;
            var done = function(url) {
                input.value = '';
                image.src = url;
                $('#cropContainer').show();

                if (cropper) {
                    cropper.destroy();
                }
                
                cropper = new Cropper(image, {
                    aspectRatio: 1,
                    viewMode: 3,
                });
            };
            var reader;
            var file;
            var url;

            if (files && files.length > 0) {
                file = files[0];

                if (URL) {
                    done(URL.createObjectURL(file));
                } else if (FileReader) {
                    reader = new FileReader();
                    reader.onload = function(e) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });

        $('#cropButton').click(function() {
            if (cropper) {
                var canvas = cropper.getCroppedCanvas({
                    width: 160,
                    height: 160,
                });

                if (canvas) {
                    canvas.toBlob(function(blob) {
                        var formData = new FormData();
                        formData.append('profile_image', blob);

                        $.ajax({
                            url: '{{ route("changeImage") }}',
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            beforeSend : function(){
                                SwalLoading('Please wait ...');
                            },
                            success: function(response) {
                                swal.close()
                                toastr['success'](response.meta.message)
                                $('#image_profile').empty()
                                console.log(response.data)
                                $('#image_profile').html(`
                                    <img src="{{URL::asset('storage/${response.data}')}}" class="rounded-circle">
                                `)
                                $('#changeImageModal').modal('hide');
                            },
                            error: function() {
                                console.log('Upload error');
                            }
                        });
                    });
                } else {
                    console.log('Canvas is null');
                }
            } else {
                console.log('Cropper instance is not initialized');
            }
        });

        $('#btn_update_profile').click(function() {
            $('#cropButton').click();
        });
    });
    // Change Image 
     function mappingTableTimeline(response){
            var data =''
            $('#progress_track_container').empty()
            for(i =0; i< response.length; i++){
                var color = ''
                            if(response[i].percentage >= 0 && response[i].percentage <= 25){
                                color ='danger'
                            }else if(response[i].percentage >= 26 && response[i].percentage <= 50){
                                color ='warning'
                            }else if(response[i].percentage >= 51 && response[i].percentage <= 75){
                                color ='info'
                            }else{
                                color ='success'
                            }
                data +=`
                <li class="list-group-item px-0">
                    <div class="row align-items-center">
                        <div class="col-auto">
                           <button class="btn btn-sm btn-dark go_project rounded" onclick="goProject('${response[i].request_code}','${response[i].link}')" data-request="${response[i].request_code}" data-link="${response[i].link}" title="Go To Project">
                            <i class="fa-solid fa-diagram-project"></i>
                           </button>
                        </div>
                      <div class="col">
                        <div class="progress-group">
                                                <div class="progress-group" style="font-size:10px !important;">
                                                    ${response[i].name}
                                                    <span class="float-right" style="font-size:10px">${response[i].percentage}%</span>
                                                    <div class="progress progress-md">
                                                        <div class="progress-bar bg-${color}" style="width: ${response[i].percentage}%;height:20px !important">
                                                    </div>
                                                </div>
                                            </div>
                        </div>
                    </div>
                  </li>
                `;
            }
            $('#progress_track_container').html(data)
        }
</script>