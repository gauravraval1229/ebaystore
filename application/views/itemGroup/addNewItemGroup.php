<style type="text/css">
.row
{
  margin-top: 10px;
}
</style>

  <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">

                <!-- validations start -->
                <section class="validations" id="validation">
                    <div class="row">
                        <div class="col-12 mt-3 mb-1">
                            <h4 class="text-uppercase">Add New <?php echo $msgName; ?></h4>
                        </div>
                    </div>

                    <div class="row match-height">
                      <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="card">

                          <div class="row">
                            <div class="col-md-1"></div>
                            
                            <div class="col-md-10">

                              <form method="POST" action="">

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Title : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="title" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>description : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="description" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                  </div>
                                  <div class="col-md-9">
                                    <button type="submit" name="btnAddNewItemGroupSubmit" class="btn btn-info" style="margin-bottom: 12px;">Submit</button>
                                  </div>
                                </div>
                              </form>

                            </div>

                            <div class="col-md-1"></div>
                          </div>

                        </div>
                      </div>
                    </div>
                </section>
                <!-- validations end -->

            </div>
        </div>
    </div>
    <!-- END: Content-->