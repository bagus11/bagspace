<div class="modal fade" id="editGroupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <b>Set User</b>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
   
        <div class="modal-body">
            <input type="hidden" id="groupCode">
            <div class="row m-0">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header pb-0">
                          <div class="row">
                            <div class="col-3">
                              <p class="title-head">Current User</p>
                            </div>
                            
                          </div>
                        </div>
                        <div class="card-body">
                            <table class="datatable-stepper" id="user_active_table">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="sort" data-sort="action"></th>
                                        <th scope="col" class="sort" data-sort="name">NIK</th>
                                        <th scope="col" class="sort" data-sort="name">Name</th>
                                    </tr>
                                </thead>
                              </table>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-sm btn-danger" id="btnDeletePic" style="float: right">
                                <i class="fa-solid fa-user-xmark"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-header pb-0">
                          <div class="row">
                            <div class="col-3">
                              <p class="title-head">List User</p>
                            </div>
                          </div>
                        </div>
                        <div class="card-body">
                            <table class="datatable-stepper" id="user_inactive_table">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="sort" data-sort="action"></th>
                                        <th scope="col" class="sort" data-sort="name">NIK</th>
                                        <th scope="col" class="sort" data-sort="name">Name</th>
                                    </tr>
                                </thead>
                              </table>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-sm btn-success" id="btnAddNewPIC" style="float: right">
                                <i class="fa-solid fa-user-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>