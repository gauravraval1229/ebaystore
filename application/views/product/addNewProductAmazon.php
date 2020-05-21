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
                            <h4 class="text-uppercase">Add <?php echo $msgName; ?></h4>
                        </div>
                    </div>

                    <div class="row match-height">
                      <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="card">

                          <div class="row">
                            <div class="col-md-1"></div>
                            
                            <div class="col-md-10">

                              <form method="POST" enctype="multipart/form-data" action="<?php echo base_url('amazon/ProductController/addNewProduct'); ?>">

                                <!-- <div class="row">
                                  <div class="col-md-3">
                                    <label>Select Product Type : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <select class="form-control" name="productType" id="productType" required>
                                      <option value="">Please Select Product Type</option>
                                      <option value="ASIN">ASIN</option>
                                      <option value="EAN">EAN</option>
                                      <option value="GCID">GCID</option>
                                      <option value="GTIN">GTIN</option>
                                      <option value="UPC">UPC</option>
                                    </select>
                                  </div>
                                </div>

                                <div class="row" id="rowProductId" style="display: none;">
                                  <div class="col-md-3">
                                    <label>Product Id : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="productId" id="productId" required>
                                  </div>
                                </div> -->

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Title: <span class="req">*</span></label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="title" required>
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
                                    <label>Price: <span class="req">*</span></label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="price" onkeypress="return isNumber(event)" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Quantity: <span class="req">*</span></label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="number" class="form-control" name="qty" min="0" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Description: <span class="req">*</span></label>
                                  </div>
                                  <div class="col-md-9">
                                    <textarea class="form-control" name="description" required></textarea>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Manufacturer: <span class="req">*</span></label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="manufacturer" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Product Image: <span class="req">*</span></label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="file" class="form-control" name="prodcutImage" accept="image/x-png,image/gif,image/jpeg,image/jpg">
                                  </div>
                                </div>

                                <!-- <div class="row">
                                  <div class="col-md-3">
                                    <label>Bullet Point : </label>
                                  </div>
                                  <div class="col-md-8">
                                    <input type="text" class="form-control txtBox" name="bulletPoints[]" id='bulletPoints1' required>
                                  </div>
                                  <div class="col-md-1">
                                    <input type="button" class="btn btn-info" id="addTextBox" value="+">
                                  </div>
                                </div>

                                <div id="bulletTextbox"></div> -->

                                <div class="row">
                                  <div class="col-md-3"></div>
                                  <div class="col-md-9">
                                    <button type="submit" name="btnAddNewProductSubmit" id="btnSubmit" class="btn btn-info" style="margin-bottom: 12px;">Submit</button>
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

<script type="text/javascript">
  function isNumber(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
    return false;
    return true;
  }

  $("form").submit(function() {
    document.getElementById('btnMsg').style.display = "block";
    document.getElementById('btnSubmit').style.display = "none";
  });

 /* $("#productType").change(function(){
    $("#productId").val('');
    document.getElementById("rowProductId").style.display = "flex";
  });*/

 /* $("form").submit(function(event) {

    var productType = $("#productType").val();
    var productId = $("#productId").val().trim();

    if(productType == ""){
      alert("Please select product type");
      return false;
    }
    else if(productId == ""){
      alert("Please enter product id");
      return false;
    }
    else if(productType == "ASIN" && productId.length != 10) {
      alert("Product id must be 10 digit");
      return false;
    }
    else if(productType == "EAN" && productId.length != 13) {
      alert("Product id must be 13 digit");
      return false;
    }
    else if(productType == "GCID" && productId.length != 16) {
      alert("Product id must be 16 digit");
      return false;
    }
    else if(productType == "GTIN" && (productId.length != 8 || productId.length !=12 || productId.length !=13 || productId.length != 14)) {
      alert("Product id must be 8,12,13,14 digit");
      return false;
    }
    else if(productType == "UPC" && productId.length != 12) {
      alert("Product id must be 12 digit");
      return false;
    }
    else{
      return true;
    }
  });*/
</script>

<script type="text/javascript">
  /*var i=2;
  
  $("#addTextBox").click(function(){
    var cnt = document.querySelectorAll('#bulletTextbox .txtBox').length;

    if(cnt>3){
      alert("You can add only 5 textbox");
      return false;
    }
    else{
      $("#bulletTextbox").append("<div class='row' id='bulletRow"+i+"'><div class='col-md-3'></div><div class='col-md-8'><input type='text' class='form-control txtBox' name='bulletPoints[]' id='bulletPoints"+i+"'></div><div class='col-md-1'><input type='button' class='btn btn-danger' value='-' onclick='removeTextbox("+i+")'></div></div>");
     i++;
    }
  });

  function removeTextbox(id){
    $('#bulletRow'+id).remove();
  }*/
</script>