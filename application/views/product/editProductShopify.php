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
                                    <label>Product Name: <span class="req">*</span></label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="product_name" value="<?php echo $shopifyProdutList->data->title; ?>" required>
                                    <input type="hidden" name="productId" value="<?php echo $shopifyProdutList->data->shopify_id; ?>">
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Product Type: <span class="req">*</span></label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="product_type" value="<?php echo $shopifyProdutList->data->product_type; ?>">
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Vendor: <span class="req">*</span></label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="vendor" value="<?php echo $shopifyProdutList->data->vendor; ?>" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Tags: <span class="req">*</span></label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="tags" value="<?php echo $shopifyProdutList->data->tags; ?>" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Published: <span class="req">*</span></label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="checkbox" name="publish" <?php if($shopifyProdutList->data->published == 1) { echo "checked='checked'"; } ?> required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Shopify: <span class="req">*</span></label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="checkbox" name="shopify" <?php if($shopifyProdutList->data->shopify == 1) { echo "checked='checked'"; } ?> required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Variants: <span class="req">*</span></label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="variant" value="<?php echo $shopifyProdutList->data->variants; ?>" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Price: <span class="req">*</span></label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="price" onkeypress="return isNumber(event)" value="<?php echo $shopifyProdutList->data->price; ?>" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Product Image : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="file" class="form-control" name="productImage" accept="image/x-png,image/jpg,image/jpeg">
                                  </div>
                                </div>

                                <?php
                                  $image = ROOT_PATH.'assests/productImageShopify/'.$shopifyProdutList->data->images;
                                  if ($shopifyProdutList->data->images == "" || !file_exists($image)) { // image not exist in folder or in database
                                    //$imageName = "assests/productImageShopify/defaultProduct.jpg";
                                    $imageName = defaultProductImage;
                                  }
                                  else {
                                    $imageName = base_url("assests/productImageShopify/".$shopifyProdutList->data->images);
                                  }
                                ?>

                                <div class="row" style="margin-top: 30px;">
                                  <div class="col-md-3"></div>
                                  <div class="col-md-9">
                                    <input type="hidden" name="old_image" value="<?php echo $shopifyProdutList->data->images; ?>">
                                    <input type="hidden" id="txtimage" value="<?php echo $imageName; ?>">
                                    <img src="<?php echo $imageName; ?>" height="55%" width="25%" style="cursor: pointer;" id="prodcutImage">
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

<!-- Modal Start -->
<div id="imageModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3><b>Product Image</b></h3>
        <button type="button" class="close" style="font-size: 2rem !important;" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body text-center">
        <img src="" id="modalImage" height="75%" width="75%">
      </div>
    </div>
  </div>
</div>
<!-- Modal End -->

<script type="text/javascript">
  function isNumber(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
    return false;
    return true;
  }

  $("#prodcutImage").click(function(){
    $("#modalImage").attr('src',$("#txtimage").val());
    $('#imageModal').modal('show');
  });
</script>