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
          <!-- DOM - jQuery events table -->
          <section id="dom">
            <div class="row">
              <div class="col-12">
                <div class="card">

                    <div class="row">
                      <div class="col-sm-10" style="margin-top: 15px;">
                        <h4 class="card-title" style="margin-left: 15px;"><?php echo $msgName; ?> List</h4>
                      </div>
                      <div class="col-sm-2" style="margin-top: 15px;margin-left: -10px;">
                        <a href="<?php echo base_url('amazon/ProductController/addNewProduct'); ?>" class="btn btn-info" style="float:left;">Add New Product</a>
                      </div>
                    </div>

                  <div class="card-content collapse show">
                    <div class="card-body card-dashboard">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration">
                          <thead>
                            <tr>
                              <th>SKU</th>
                              <th>Product Name</th>
                              <th>Product Price</th>
                              <th>Product Quantity</th>
                              <th>Status</th>
                              <th></th>
                              <th></th> 
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              if (count($amazonProductList)>=1) { // if data found in array

                                for($i=0;$i<count($amazonProductList);$i++) { 

                                    if($i>=1){ // skip 0 key of array and start from 1 key

                                    $sku = $amazonProductList[$i][3];
                                    $title = $amazonProductList[$i][0];
                                    $price = $amazonProductList[$i][4];
                                      if($price == "") {
                                        $price = 0;
                                      }
                                    $qty = $amazonProductList[$i][5];
                                      if($qty == ""){
                                        $qty = 0;
                                      }
                                    $status = $amazonProductList[$i][28];

                                    $imageUrl = $amazonProductList[$i][7];
                                    $description = $amazonProductList[$i][1];

                                    if($sku!="") { // if sku is no empty then display data

                                    $productArray = array();
                                    $productArray1 = "";
                                    $productArray = array("sku"=>$sku,"title"=>$title,"price"=>$price,"qty"=>$qty,"description"=>$description,"imageUrl"=>$imageUrl);
                                    $productArray1 = htmlspecialchars(json_encode($productArray));
                                    //print_r($productArray);
                                  ?>
                                  <tr>
                                    <td><?php echo $sku; ?></td>
                                    <td><?php echo $title; ?></td>
                                    <td><?php echo $price; ?></td>
                                    <td><?php echo $qty; ?></td>
                                    <td><?php echo ucfirst($status); ?></td>
                                    <!-- <td><a href="<?php echo base_url(); ?>amazon/ProductController/editProduct/<?php echo $sku; ?>">Edit</a></td> -->
                                    <td><input type="hidden" id="hiddenProduct<?php echo $sku;?>" value="<?php echo $productArray1; ?>"><a href="#" onclick="editProduct('<?php echo $sku; ?>');">Edit</a></td>
                                    <!-- <td><a href="<?php echo base_url(); ?>amazon/ProductController/deleteProduct/<?php echo $sku; ?>">Delete</a></td>  -->
                                    <td><?=anchor(base_url()."amazon/ProductController/deleteProduct/".$sku,"Delete",array('onclick' => "return confirm('Are you sure want to delete this record ?To reflect in list it may take 25-30 minutes.')"))?></td>
                                  </tr>
                            <?php } } } } ?>
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
    localStorage.removeItem('productArray');
    localStorage.clear();
  });

  function editProduct(sku){
    var productArray = $("#hiddenProduct"+sku).val();
    sessionStorage.setItem("productArray",productArray);
    window.location.href = '<?php echo base_url() ?>index.php/amazon/ProductController/editProduct';
  }
</script>