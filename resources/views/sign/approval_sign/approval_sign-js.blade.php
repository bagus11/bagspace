<script>
        var url = $('#attachment').val();
        var pdfjsLib = window['pdfjs-dist/build/pdf'];
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.worker.min.js';
        var pdfDoc = null,
            pageNum = 1,
            canvas = document.getElementById('pdf-canvas'),
            ctx = canvas.getContext('2d');

        function renderPage(num) {
            pdfDoc.getPage(num).then(function(page) {
                var viewport = page.getViewport({ scale: 1.5 });
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                var renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };
                page.render(renderContext);
            });
        }

        function queueRenderPage(num) {
            pageNum = num;
            renderPage(pageNum);
        }

        function onPrevPage() {
            if (pageNum <= 1) {
                return;
            }
            queueRenderPage(pageNum - 1);
        }

        function onNextPage() {
            if (pageNum >= pdfDoc.numPages) {
                return;
            }
            queueRenderPage(pageNum + 1);
        }

        $('#prev-page').on('click', onPrevPage);
        $('#next-page').on('click', onNextPage);

        pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
            pdfDoc = pdfDoc_;
            renderPage(pageNum);
        });
        array_user=[];
        $('#pdf-canvas').click(function(event) {
            $('#signModal').modal('show')
            var rect = canvas.getBoundingClientRect();
            var x = event.clientX - rect.left;
            var y = event.clientY - rect.top;

            $('#x_location').val(x);
            $('#y_location').val(y);
            $('#page_location').val(pageNum);
            $.ajax({
                url: "{{route('getUser')}}",
                type: "get",
                dataType: 'json',
                success: function(response){
                    $('#select_user').empty()
                    $('#select_user').append('<option value ="">Choose User</option>');
                    $.each(response.data,function(i,data){
                        $('#select_user').append('<option data-name="'+ data.name +'" data-img="'+data.avatar+'" value="'+data.id+'">' + data.name +'</option>');
                    });
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                    }
                }); 
                onChange('select_user','user_id')
        });
        $('#btn_approve_user').on('click', function(){
            var img = [$("#select_user").select2().find(":selected").data("img")][0];
            var name = [$("#select_user").select2().find(":selected").data("name")][0];
            var id   = $('#select_user').val()
            var post_user ={
                'id' :id,
                'name' :name,
                'img' :img,
                'page_location' :$('#page_location').val(),
                'x_location' :$('#x_location').val(),
                'y_location' :$('#y_location').val(),
            }
            $('#signModal').modal('hide')
            array_user.push(post_user)
            mappingUser(array_user)
            console.log(array_user)
        })

        function mappingUser(response){
            $('#user_container').empty()
            var data =''
            for(i =0; i < response.length; i++){
                  data +=`
                                <li class="list-group-item mx-4 p-0 mx-2" style="max-height:60px !important">
                                    <div class="row ">
                                   <div class="col-1 mt-3 ml-2">
                                      <span class="avatar avatar-sm rounded-circle">
                                           <img alt="Image placeholder" src="{{asset('storage/users-avatar/${response[i].img}')}}">
                                        </span>
                                    </div>
                                    <div class="col-9 mt-2">
                                        <label>${response[i].name}</label>
                                        <p>Page Number : ${response[i].page_location}</p>
                                        </div>
                                        <div class="p-0 col-1 mt-3">
                                            <button class="btn btn-sm btn-danger rounded" data-id="${i}" data-toggle="modal" data-target="#detailTimelineModal" title="Detail Information">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </li>
                  `
                }
                $('#user_container').html(data)
             
        }

</script>