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
                            <h4 class="text-uppercase">Edit <?php echo $msgName; ?></h4>
                        </div>
                    </div>

                    <div class="row match-height">
                      <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="card">

                          <div class="row">
                            <div class="col-md-1"></div>
                            
                            <div class="col-md-10">

                              <form method="POST" action="" enctype='multipart/form-data'>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Product Name :</label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="product_name" value="<?php echo $shopifyProdutList->data->title; ?>" required>
                                    <input type="hidden" name="productId" value="<?php echo $shopifyProdutList->data->shopify_id; ?>">
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Product Type : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="product_type" value="<?php echo $shopifyProdutList->data->product_type; ?>">
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Vendor : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="vendor" value="<?php echo $shopifyProdutList->data->vendor; ?>" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Tags : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="tags" value="<?php echo $shopifyProdutList->data->tags; ?>">
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Published : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="checkbox" name="publish" <?php if($shopifyProdutList->data->published == 1) { echo "checked='checked'"; } ?> >
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Shopify : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="checkbox" name="shopify" <?php if($shopifyProdutList->data->shopify == 1) { echo "checked='checked'"; } ?> >
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Variants : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="variant" value="<?php echo $shopifyProdutList->data->variants; ?>" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Price : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="number" class="form-control" name="price" value="<?php echo $shopifyProdutList->data->price; ?>">
                                  </div>
                                </div>

                                <?php
                                    $image = ROOT_PATH . '/assests/productImageShopify/'.$shopifyProdutList->data->images;
                                    if ($shopifyProdutList->data->images=="" || !file_exists($image)) // image not exist in folder or exist not in database
                                    {
                                        $imageName = "assests/productImageShopify/defaultProduct.jpg";
                                    }
                                    else
                                    {
                                      $imageName = "assests/productImageShopify/".$shopifyProdutList->data->images;
                                    }
                                ?>
                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Product Image : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="file" class="form-control" name="productImage">
                                  </div>
                                </div>

                                <div class="row" style="margin-top: 30px;">
                                  <div class="col-md-3"></div>
                                  <div class="col-md-9">
                                    <img height="55%" width="25%" src="<?php echo base_url($imageName); ?>">
                                    <input type="hidden" class="form-control" name="old_image" value="<?php echo $shopifyProdutList->data->images; ?>">
                                  </div>
                                </div>

                                <div class="row" style="margin-top: 0px;">
                                  <div class="col-md-3">
                                  </div>
                                  <div class="col-md-9">
                                    <button type="submit" name="btnUpdateShopify" class="btn btn-info" style="margin-bottom: 12px;">Submit</button>
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