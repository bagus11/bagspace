<script>
    var url = $('#attachment').val();
    var pdfjsLib = window['pdfjs-dist/build/pdf'];
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.worker.min.js';
    var pdfDoc = null,
        pageNum = 1,
        canvas = document.getElementById('pdf-canvas'),
        ctx = canvas.getContext('2d');
        var canvasWidth = canvas.width;
        var canvasHeight = canvas.height;
    
    var rectangles = [];
    var array_user = [];
    $('#pincode').pincodeInput({inputs:4});
    $('#btn_approve_sign').on('click', function(){
        var data ={
            'signature_code'    :$('#signature_code').val(),
            'pincode'           :$('#pincode').val(),
            'step'              :$('#step').val(),
            'y'                 : canvasHeight,
            'x'                 : canvasWidth,
        }
        $.ajax({
            url: "{{route('postValidationSign')}}",
            type: "post",
            dataType: 'json',
            data:data,
            async: true,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success:function(response){
                swal.close()
                console.log(response);
            },
            error: function(response) {
                $('.message_error').html('')
                swal.close();
                if(response.status == 500){
                    console.log(response)
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
    function renderPage(num) {
        if (!pdfDoc) {
            console.error("PDF document not loaded yet.");
            return;
        }

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

                // Draw signature images for the current page
                array_user.forEach(function(item) {
                    if (item.page_number === num) {
                        drawSignatureImage(item.x, item.y, item.signature_image);
                    }
                });
            });
        }).catch(function(err) {
            console.error("Error rendering page: ", err);
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
        getData(); // Fetch data after the PDF document is loaded
    }).catch(function(err) {
        console.error("Error loading PDF document: ", err);
    });

    var data_test = {
        'signature_code': $('#signature_code').val(),
        'step': $('#step').val()
    };

    function getData() {
        $.ajax({
            url: "{{route('getValidationSign')}}",
            type: "get",
            dataType: 'json',
            data: data_test,
            success: function(response) {
                array_user = response.data.map(function(item) {
                    return {
                        x: item.x,
                        y: item.y,
                        page_number: item.page_number,
                        signature_image: item.signature_relation.signature // Assuming the signature image is part of the response
                    };
                });
                renderPage(pageNum); // Re-render the page to include the signature images
            },
            error: function(xhr, status, error) {
                swal.close();
                alert('error');
            }
        });
    }

    function drawSignatureImage(x, y, signature_image) {
        var img = new Image();
        img.onload = function() {
            ctx.drawImage(img, x, y, 150, 75); // Draw image with specified width and height
        };
        img.src = signature_image;
    }

    getData();
</script>
