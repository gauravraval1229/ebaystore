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

                              <form method="POST" enctype="multipart/form-data" action="<?php echo base_url('ebay/ProductController/addNewProduct'); ?>">

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Quantity: <span class="req">*</span></label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="number" class="form-control" name="quantity" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Brand: <span class="req">*</span></label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="brand" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Optical Zoom: <span class="req">*</span></label>
                                  </div>
                                  <div class="col-md-9">
                                    <select name="opticalZoom" class="form-control" required>
                                      <option value="">Please Select Zoom Value</option>
                                      <option value="10x">10X</option>
                                      <option value="9x">9X</option>
                                      <option value="8x">8X</option>
                                    </select>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Type: <span class="req">*</span></label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="type" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Recording Definition: <span class="req">*</span></label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="recordingDefinition" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Media Format: <span class="req">*</span></label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="mediaFormat" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Storage Type: <span class="req">*</span></label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="storageType" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Description: <span class="req">*</span></label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="description" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Title: <span class="req">*</span></label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="title" required>
                                  </div>
                                </div>

                                <!-- <div class="row">
                                  <div class="col-md-3">
                                    <label>Product Image : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="file" class="form-control" name="productImage" required>
                                  </div>
                                </div> -->

                                <div class="row">
                                  <div class="col-md-3">
                                  </div>
                                  <div class="col-md-9">
                                    <button type="submit" name="btnAddNewProductSubmit" class="btn btn-info" style="margin-bottom: 12px;">Submit</button>
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