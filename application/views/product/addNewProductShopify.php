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

                              <form method="POST" action="<?php echo base_url('ProductController/addNewProductShopify'); ?>">

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Product Name : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="product_name" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Product Type : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="product_type" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Vendor : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="vendor" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Tags : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="tags" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Published : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="checkbox" name="publish" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Shopify : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="checkbox" name="shopify" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Variants : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="variant" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Price : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="number" class="form-control" name="price" required>
                                  </div>
                                </div>
                                
                                <div class="row">
                                  <div class="col-md-3">
                                  </div>
                                  <div class="col-md-9">
                                    <button type="submit" name="btnAddNewProductShopifySubmit" class="btn btn-info" style="margin-bottom: 12px;">Submit</button>
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