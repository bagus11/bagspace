<script>
     getCallbackNoSwal('getTimelineHeaderUser',null,function(response){
                            mappingTableTimeline(response.data)
                            $('#project_label').html(response.data.length)
                        })
    getCallbackNoSwal('getCalculation',null, function(response){
        $('#remaining_label').html(response.progress)
        $('#task_label').html(response.all)
       
    })
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