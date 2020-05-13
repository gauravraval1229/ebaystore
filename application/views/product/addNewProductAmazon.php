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

                              <form method="POST" enctype="multipart/form-data" action="<?php echo base_url('amazon/ProductController/addNewProduct'); ?>">

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Title : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="title" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Brand : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="brand">
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Price : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="text" class="form-control" name="price">
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Quantity : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="number" class="form-control" name="qty">
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Product Image : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <input type="file" class="form-control" name="prodcutImage" accept="image/x-png,image/gif,image/jpeg,image/jpg">
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <label>Description : </label>
                                  </div>
                                  <div class="col-md-9">
                                    <textarea class="form-control" name="description"></textarea>
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
                                    <button type="submit" name="btnAddNewProductSubmit" class="btn btn-info" style="margin-bottom: 12px;">Submit</button>
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