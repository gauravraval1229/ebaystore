  <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-body">

          <div>
            <?php if ($this->session->flashdata('error')) { ?>
              <div class="alert alert-danger" id="msg">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close" style="color:black">&times;</a>
                  <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
              </div>
            <?php }
            if ($this->session->flashdata('success')) { ?>
              <div class="alert alert-success" id="msg">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close" style="color:black">&times;</a>
                  <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
              </div>
            <?php } ?>
          </div>
          <?php //echo "<pre>";  print_r($shopifyProdutList); ?>
          <!-- DOM - jQuery events table -->
          <section id="dom">
            <div class="row">
              <div class="col-12">
                <div class="card">

                    <div class="row">
                      <div class="col-sm-7" style="margin-top: 15px;">
                        <h4 class="card-title" style="margin-left: 15px;"><?php echo $msgName; ?> List</h4>
                      </div>
                      <div class="col-sm-2" style="margin-top: 15px;margin-left: -10px;">
                        <a href="<?php echo base_url('shopify/ProductController/addNewProductShopify'); ?>" class="btn btn-info " style="float:right;">Add New Product</a>
                      </div>
                      <div class="col-sm-3" style="margin-top: 15px;margin-left: -10px;">
                        <a href="<?php echo base_url('shopify/ProductController/synchWithShopify'); ?>" class="btn btn-info " style="float:right;">Synchronize with Shopify</a>
                      </div>
                    </div>

                  <div class="card-content collapse show">
                    <div class="card-body card-dashboard">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration">
                          <thead>
                            <tr>
                              <th>Product Id</th>
                              <th>Product Name</th>
                              <th>Vendor</th>
                              <th>Product Type</th>
                              <th></th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php

                            if (count($shopifyProdutList->data)>=1) // if data found in array
                            {
                              for($i=0;$i<count($shopifyProdutList->data);$i++) { 

                                  $productId = $shopifyProdutList->data[$i]->shopify_id;
                                  $productName = $shopifyProdutList->data[$i]->title;
                                  $vendor = $shopifyProdutList->data[$i]->vendor;
                                  $productType = $shopifyProdutList->data[$i]->product_type;

                                  if($productId!="") { // if product id found then display data

                                ?>
                                <tr>
                                  <td><?php echo $productId; ?></td>
                                  <td><?php echo $productName; ?></td>
                                  <td><?php echo $vendor; ?></td>
                                  <td><?php echo $productType; ?></td>
                                  <td><a href="<?php echo base_url(); ?>shopify/ProductController/editProduct/<?php echo $productId; ?>">Edit</a></td>
                                  <td><a href="<?php echo base_url(); ?>shopify/ProductController/deleteProduct/<?php echo $productId; ?>">Delete</a></td>
                                </tr>
                              <?php } } } else { echo "<b> No Data Found <b>"; } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <!-- DOM - jQuery events table -->

        </div>
      </div>
    </div>
  <!-- END: Content-->

<script type="text/javascript">
  $(document).ready(function(){
    $('#msg').delay(4000).fadeOut(400);
  });
</script>