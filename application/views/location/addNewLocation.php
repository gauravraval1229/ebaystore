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
                            <h4 class="text-uppercase">Add <?php echo $msgName; ?></h4>
                        </div>
                    </div>

                    <div class="row match-height">
                      <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="card">

                          <div class="row">
                            <div class="col-md-1"></div>
                            
                            <div class="col-md-10">

                              <form method="POST" action="<?php echo base_url('locationController/addNewLocation'); ?>">

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Address 1 : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="address1" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Address 2 : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="address2" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>City : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="city" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>State Or Province : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="state" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Country : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <select name="country" class="form-control" required>
                                      <option value="">Please Select Country</option>
                                      <option value="US">United Sates</option>
                                      <option value="DE">Germany</option>
                                    </select>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Postal Code : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="postalCode" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Location Instructions : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="locationInstruction" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Name : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="name" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Phone : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="phone" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Location Type : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <select class="form-control" name="locationType" required>
                                      <option value="">Please Select Location Type</option>
                                      <option value="WAREHOUSE">Warehouse</option>
                                      <option value="STORE">Store</option>
                                    </select>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                  </div>
                                  <div class="col-md-9">
                                    <button type="submit" name="btnAddNewLocationSubmit" class="btn btn-info">Submit</button>
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