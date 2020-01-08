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

                              <form method="POST" action="">
                                <?php //echo "<pre>"; print_r($productList); ?>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Quantity : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="number" class="form-control" name="quantity" value="<?php echo $quantity; ?>" required>
                                    <input type="hidden" name="skuName" value="<?php echo $skuName; ?>">
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Brand</label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="brand" value="<?php echo $productList->aspects->Brand[0]; ?>">
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Optical Zoom : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <select name="opticalZoom" class="form-control" required>
                                      <option value="<?php echo $productList->aspects->{'Optical Zoom'}[0]; ?>" selected><?php echo $productList->aspects->{'Optical Zoom'}[0]; ?></option>
                                      <option value="">Please Select Zoom Value</option>
                                      <option value="10x">10X</option>
                                      <option value="9x">9X</option>
                                      <option value="8x">8X</option>
                                    </select>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Type : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="type" value="<?php echo $productList->aspects->Type[0]; ?>">
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Recording Definition : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="recordingDefinition" value="<?php echo $productList->aspects->{'Recording Definition'}[0]; ?>" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Media Format : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="mediaFormat" value="<?php echo $productList->aspects->{'Media Format'}[0]; ?>" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Storage Type : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="storageType" value="<?php echo $productList->aspects->{'Storage Type'}[0]; ?>" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Description : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="description" value="<?php echo $productList->description; ?>">
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Title : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="title" value="<?php echo $productList->title; ?>">
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                  </div>
                                  <div class="col-md-9">
                                    <button type="submit" name="btnUpdate" class="btn btn-info" style="margin-bottom: 12px;">Submit</button>
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