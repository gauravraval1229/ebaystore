<style type="text/css">
.row {
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
                          <h4 class="text-uppercase">Edit Amazon Product</h4>
                      </div>
                  </div>

                  <div class="row match-height">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                      <div class="card">

                        <div class="row">
                          <div class="col-md-1"></div>
                          
                          <div class="col-md-10">

                            <form method="POST" enctype="multipart/form-data" action="<?php echo base_url('amazon/ProductController/editProduct'); ?>">

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Title: <span class="req">*</span></label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="title" id="title" required>
                                    <input type="hidden" class="form-control" name="sku" id="sku">
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Price: <span class="req">*</span></label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="price" id="price" onkeypress="return isNumber(event)" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Quantity: <span class="req">*</span></label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="number" class="form-control" name="qty" id="qty" min="0" required>
                                    <input type="hidden" class="form-control" name="old_qty" id="old_qty">
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Description: <span class="req">*</span></label>
                                  </div>
                                  <div class="col-md-9">
                                    <textarea class="form-control" name="description" id="description" required></textarea>
                                  </div>
                                </div>

                                 <div class="row">
                                  <div class="col-md-3">
                                    <label>Product Image :</label>
                                  </div>
                                  <div class="col-md-9">
                                    <img src="" id="prodcutImage" height="150px" width="150px">
                                    <input type="hidden" id="txtimage" value="">
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Change Image :</label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="file" class="form-control" name="prodcutImageNew" accept="image/x-png,image/gif,image/jpeg,image/jpg">
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3"></div>
                                  <div class="col-md-9">
                                    <button type="submit" name="btnUpdate" id="btnSubmit" class="btn btn-info" style="margin-bottom: 12px;">Submit</button>
                                    <p id="btnMsg" style="color:red;display: none;">It will take several minutes to get this product added in your seller store.</p>
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
        <img src="" id="modalImage">
      </div>
    </div>
  </div>
</div>
<!-- Modal End -->

<script type="text/javascript">
  $(document).ready(function(){
    var productArray = sessionStorage.getItem("productArray");
    productArray = JSON.parse(productArray);

      $("#sku").val(productArray.sku);
      $("#title").val(productArray.title);
      $("#description").val(productArray.description);
      $("#price").val(productArray.price)
      $("#qty").val(productArray.qty);
      $("#old_qty").val(productArray.qty); // used in controller for sum of new+old qty

      var defaultProductImage = '<?php echo defaultProductImage; ?>';
      console.log(defaultProductImage);

      if(productArray.imageUrl == "" || productArray.imageUrl == "undefined") {
        $("#prodcutImage").attr('src',defaultProductImage);
        $("#txtimage").val('');
        $("#txtimage").val(defaultProductImage);
      }
      else{
        $("#prodcutImage").attr('src',productArray.imageUrl);
        $("#txtimage").val('');
        $("#txtimage").val(productArray.imageUrl);
      }
      
  });

  function isNumber(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
    return false;
    return true;
  }
/*
  function viewProductImage(){
    $("#modalImage").attr('src',$("#txtimage").val());
    $('#imageModal').modal('show');
  }*/
  $("#prodcutImage").click(function(){
    $("#modalImage").attr('src',$("#txtimage").val());
    $('#imageModal').modal('show');
  });

  $("form").submit(function() {
    document.getElementById('btnMsg').style.display = "block";
    document.getElementById('btnSubmit').style.display = "none";
  });
</script>