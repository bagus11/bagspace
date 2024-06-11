
<div class="modal fade" id="addSignModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <b>Add Signature</b>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <fieldset class="legend1 mt-2">
                <legend>General Transaction</legend>
                <div class="row mx-2">
                    <div class="col-2 mt-2">
                        <p>Signature</p>
                    </div>
                    <div class="col-10">
                        <div id="signature-pad" class="m-signature-pad">
                            <div class="m-signature-pad--body">
                                <canvas id="canvas" width="450" height="150"></canvas>
                                <span  style="color:red;" class="message_error text-red block signature_error"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mx-2">
                    <div class="col-2 mt-2">
                        <p>Paraf</p>
                    </div>
                    <div class="col-10">
                        <div id="signature-pad" class="m-signature-pad">
                            <div class="m-signature-pad--body">
                                <canvas id="canvas_paraf" width="450" height="150"></canvas>
                                <span  style="color:red;" class="message_error text-red block signature_error"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mx-2">
                    <div class="col-2 mt-2">
                        <p>PIN</p>
                    </div>
                    <div class="col-4">
                        <div class="pinBox">
                            <input type="text" name="mycode" id="pincode-input1">
                          </div>
                    </div>
                </div>
          </fieldset>
        </div>
        <div class="modal-footer">
            <button id="btn_add_signature" type="button" class="btn btn-sm btn-success">
                <i class="fas fa-check"></i>
            </button>
        </div>
      </div>
    </div>
  </div>

  <style>
    #canvas{
        border: 1px solid #1679AB !important;
        border-radius: 15px !important;
    }
    #canvas_paraf{
        border: 1px solid #1679AB !important;
        border-radius: 15px !important;
    }
  </style>