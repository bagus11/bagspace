<script>
    var url = $('#attachment').val();
    var pdfjsLib = window['pdfjs-dist/build/pdf'];
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.worker.min.js';
    var pdfDoc = null,
        pageNum = 1,
        canvas = document.getElementById('pdf-canvas'),
        ctx = canvas.getContext('2d');

    var rectangles = [];
    var array_user = [];

    function renderPage(num) {
        pdfDoc.getPage(num).then(function(page) {
            var viewport = page.getViewport({ scale: 1.5 });
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            var renderContext = {
                canvasContext: ctx,
                viewport: viewport
            };
            page.render(renderContext).promise.then(function() {
                // Redraw rectangles for the current page
                rectangles.forEach(function(rect) {
                    if (rect.pageNum === num) {
                        drawRectangle(rect.x, rect.y, rect.width, rect.height, rect.name);
                    }
                });
            });
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

    $('#pdf-canvas').click(function(event) {
        $('#signModal').modal('show');
        var rect = canvas.getBoundingClientRect();
        var scaleX = canvas.width / rect.width;
        var scaleY = canvas.height / rect.height;
        var x = (event.clientX - rect.left) * scaleX;
        var y = (event.clientY - rect.top) * scaleY;

        $('#x_location').val(x);
        $('#y_location').val(y);
        $('#page_location').val(pageNum);

        $.ajax({
            url: "{{route('getUserSign')}}",
            type: "get",
            data: { 'signature_code': $('#signature_code').val() },
            dataType: 'json',
            success: function(response) {
                $('#select_user').empty();
                $('#select_user').append('<option value="">Choose User</option>');
                $.each(response.data, function(i, data) {
                    $('#select_user').append(`<option data-name="${data.user_relation.name}" data-img="${data.user_relation.avatar}" value="${data.user_id}">${data.user_relation.name}</option>`);
                });
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    });

    $('#btn_approve_user').on('click', function() {
        var img = $("#select_user").select2().find(":selected").data("img");
        var name = $("#select_user").select2().find(":selected").data("name");
        var id = $('#select_user').val();
        var x = parseFloat($('#x_location').val());
        var y = parseFloat($('#y_location').val());
        var width = 100; // Default width
        var height = 50; // Default height

        var post_user = {
            'id': id,
            'name': name,
            'img': img,
            'page_location': $('#page_location').val(),
            'x_location': x,
            'y_location': y,
            'type_id': $('#select_type').val(),
        };

        // Store the rectangle
        rectangles.push({
            pageNum: pageNum,
            x: x,
            y: y,
            width: width,
            height: height,
            name: name
        });

        // Draw the rectangle with the name centered
        drawRectangle(x, y, width, height, name);

        $('#signModal').modal('hide');
        array_user.push(post_user);
        mappingUser(array_user);
        $('#send_container').prop('hidden', false);
    });


    $('#send_container').prop('hidden', true);

    $(document).on("click", ".delete_array", function() {
        var id = $(this).data("id");
        var user = array_user[id];

        // Find and remove the rectangle associated with the user
        rectangles = rectangles.filter(rect => {
            return !(rect.pageNum === parseInt(user.page_location) && 
                     rect.x === parseFloat(user.x_location) && 
                     rect.y === parseFloat(user.y_location) &&
                     rect.name === user.name); // Ensure name matches
        });

        array_user.splice(id, 1);
        mappingUser(array_user);

        // Re-render the current page to update the rectangles
        renderPage(pageNum);

        $('#send_container').prop('hidden', array_user.length === 0);
    });

    $('#select_type').on('change', function(){
        var id = $('#select_type').val();
        $('#type_id').val(id);
    });

    $('#select_user').on('change', function(){
        var id = $('#select_user').val();
        $('#user_id').val(id);
    });

    $('#btn_send').on('click', function(e){
        e.preventDefault();
        var data = { 'array': array_user };
        console.log(data);
    });

    function mappingUser(response) {
        $('#user_container').empty();
        var data = '';
        for (var i = 0; i < response.length; i++) {
            data += `
                <li class="list-group-item mx-4 p-0 mx-2" style="max-height:60px !important">
                    <div class="row">
                        <div class="col-1 mt-3 ml-2">
                            <span class="avatar avatar-sm rounded-circle">
                                <img alt="Image placeholder" src="{{asset('storage/users-avatar/${response[i].img}')}}">
                            </span>
                        </div>
                        <div class="col-9 mt-2">
                            <label>${response[i].name}</label>
                            <p>Page Number: ${response[i].page_location} || Sign Type: ${response[i].type_id == 1 ? 'Sign' : 'Paraf'}</p>
                        </div>
                        <div class="p-0 col-1 mt-3">
                            <button class="btn btn-sm btn-danger delete_array rounded" data-id="${i}" title="Detail Information">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </li>
            `;
        }
        $('#user_container').html(data);
    }

    function drawRectangle(x, y, width = 100, height = 50, name = '') {
        var rect = canvas.getBoundingClientRect();
        var scaleX = canvas.width / rect.width;
        var scaleY = canvas.height / rect.height;
        var scaledWidth = width * scaleX;
        var scaledHeight = height * scaleY;

        var context = canvas.getContext('2d');
        context.strokeStyle = 'red'; // Rectangle border color
        context.lineWidth = 2; // Rectangle border width
        context.strokeRect(x, y, scaledWidth, scaledHeight);

        // Draw the name inside the rectangle, centered
        context.font = '16px Poppins';
        context.fillStyle = 'black';
        context.textAlign = 'center';
        context.textBaseline = 'middle';
        var textX = x + scaledWidth / 2;
        var textY = y + scaledHeight / 2;
        context.fillText(name, textX, textY);
    }
</script>
