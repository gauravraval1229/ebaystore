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
                              <th>Product Id</th>
                              <th>Product Name</th>
                              <th>Vendor</th>
                              <th>Product Type</th>
                              <th></th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                            
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