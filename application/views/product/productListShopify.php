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
                        <a href="<?php echo base_url('ProductController/addNewProductShopify'); ?>" class="btn btn-info " style="float:right;">Add New <?php echo $msgName; ?></a>
                      </div>
                      <div class="col-sm-3" style="margin-top: 15px;margin-left: -10px;">
                        <a href="<?php echo base_url('ProductController/tt'); ?>" class="btn btn-info " style="float:right;">Synchronize with Shopify</a>
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
                              <th>Produtc Type</th>
                              <!-- <th></th>
                              <th></th> -->
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            for($i=0;$i<count($shopifyProdutList->data);$i++) { 

                                $productId = $shopifyProdutList->data[$i]->shopify_id;
                                $productName = $shopifyProdutList->data[$i]->title;
                                $vendor = $shopifyProdutList->data[$i]->vendor;
                                $productType = $shopifyProdutList->data[$i]->product_type;

                              ?>
                              <tr>
                                <td><?php echo $productId; ?></td>
                                <td><?php echo $productName; ?></td>
                                <td><?php echo $vendor; ?></td>
                                <td><?php echo $productType; ?></td>
                                <!-- <td><a href="<?php echo base_url(); ?>ProductController/editInventory/<?php echo $sku; ?>/<?php echo $totalQuantity; ?>">Edit</a></td>
                                <td><a href="<?php echo base_url(); ?>ProductController/deleteInventory/<?php echo $sku; ?>">Delete</a></td> -->
                              </tr>
                            <?php } ?>
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