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
          <?php //echo base_url(); echo "<pre>";  print_r($productList->inventoryItems); ?>
          <!-- DOM - jQuery events table -->
          <section id="dom">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                      <h4 class="card-title"><?php echo $msgName; ?> List</h4>
                      <a href="<?php echo base_url('ebay/ProductController/addNewProduct'); ?>" class="btn btn-info heading-elements" style="float:right;">Add New <?php echo $msgName; ?></a>
                  </div>

                  <div class="card-content collapse show">
                    <div class="card-body card-dashboard">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration">
                          <thead>
                            <tr>
                              <th>SKU</th>
                              <th>Quantity</th>
                              <th>Title</th>
                              <th>Brand</th>
                              <th>Description</th>
                              <th></th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            for($i=0;$i<count($productList->inventoryItems);$i++) { 

                                $sku = $productList->inventoryItems[$i]->sku;
                                $totalQuantity = $productList->inventoryItems[$i]->availability->shipToLocationAvailability->quantity;

                              ?>
                              <tr>
                                <td><?php echo $sku; ?></td>
                                <td><?php echo $totalQuantity; ?></td>
                                <td><?php echo $productList->inventoryItems[$i]->product->title; ?></td>
                                <td><?php echo $productList->inventoryItems[$i]->product->aspects->Brand[0]; ?></td>
                                <td><?php echo $productList->inventoryItems[$i]->product->description; ?></td>
                                <td><a href="<?php echo base_url(); ?>ebay/ProductController/editInventory/<?php echo $sku; ?>/<?php echo $totalQuantity; ?>">Edit</a></td>
                                <!-- <td><a href="<?php echo base_url(); ?>ebay/ProductController/deleteInventory/<?php echo $sku; ?>">Delete</a></td> -->
                                <td><?=anchor(base_url()."ebay/ProductController/deleteInventory/".$sku,"Delete",array('onclick' => "return confirm('Are you sure want to delete this record ?')"))?></td>
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