<script>
     $('#btnSignatureModal').on('click', function(){
        $('#signatureContainer').empty()
        $('#signatureContainer').prop('hidden', true)
        var signature = $('#signaturePad').val()
      
        if(signature == null || signature ==''){
           
            $('#signatureContainer').empty()
            $('#signatureContainer').prop('hidden', true)
        }else if(signature !=''){
         
            $('#signatureContainer').prop('hidden', false)   
            $('#signatureContainer').prepend(
                `
                <fieldset class="scheduler-border">
                        <legend class="scheduler-border">Current Signature</legend>
                        <img src="${signature}" id="" alt="">
                    </fieldset>
                `
            )
           
        }
    })
    document.addEventListener('DOMContentLoaded', function() {
        var canvas = document.getElementById('canvas');
        var signaturePad = new SignaturePad(canvas);
        var canva_paraf = document.getElementById('canvas_paraf');
        var signaturePadParaf = new SignaturePad(canva_paraf);
        
        $("#clear").on("click", function () {
            signaturePad.clear();
            signaturePadParaf.clear();
        });
        $('#btn_add_signature').on('click', function(){
            // Convert to 
            var canvas = signaturePad._canvas;
            var dataURL = canvas.toDataURL(); 
            var imageElement = document.createElement('img');
            imageElement.src = dataURL;
            document.body.appendChild(imageElement);

            var canvasParaf = signaturePadParaf._canvas;
            var dataURLParaf = canvasParaf.toDataURL(); 
            var imageElementParaf = document.createElement('img');
            imageElementParaf.src = dataURLParaf;
            document.body.appendChild(imageElementParaf);

            var data ={
                'signature'  : dataURL,
                'paraf'        : dataURLParaf,
                'pincode'       : $('#pincode-input1').val()
            }
            postCallback('saveSignature',data, function(response){
                swal.close()
                $('#addSignModal').modal('hide')
                toastr['success'](response.meta.message);
            })
          
        })
    });
</script>