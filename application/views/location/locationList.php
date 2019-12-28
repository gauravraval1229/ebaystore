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
        <?php echo "<pre>"; print_r ($locationList); ?>
        <!-- DOM - jQuery events table -->
        <section id="dom">
          <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title"><?php echo $msgName; ?> List</h4>
                    <a href="<?php echo base_url(); ?>LocationController/addNewLocation" class="btn btn-info heading-elements" style="float:right;">Add New <?php echo $msgName; ?></a>
                  </div>
                  <div class="card-content collapse show">
                    <div class="card-body card-dashboard">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration">
                            <thead>
                              <tr>
                                <th>Sr. No</th>
                                <th>Merchant Key</th>
                                <th><?php echo $msgName; ?> Status</th>
                                <th><?php echo $msgName; ?> Name</th>
                                <th>Phone</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                for($i=0;$i<count($locationList->locations);$i++) { 
                                  $merchantLocationKey=$locationList->locations[$i]->merchantLocationKey;
                                  ?>
                                <tr>
                                  <td><?php echo $i+1; ?></td>
                                  <td><?php echo $merchantLocationKey; ?></td>

                                    <?php
                                      if($locationList->locations[$i]->merchantLocationStatus=="ENABLED")
                                      {
                                        echo "<td><a href='".base_url('LocationController/enableDisableLocation/disable/'.$merchantLocationKey)."'>Enable</a></td>";
                                      }
                                      else
                                      {
                                        echo "<td><a style='color:red;' href='".base_url('LocationController/enableDisableLocation/enable/'.$merchantLocationKey)."'>Disable</a></td>";
                                      }
                                    ?>
                                  <td><?php echo $locationList->locations[$i]->locationInstructions; ?></td>
                                  <td><?php echo $locationList->locations[$i]->phone; ?></td>
                                  <td><a href="<?php echo base_url(); ?>LocationController/deleteLocation/<?php echo $locationList->locations[$i]->merchantLocationKey; ?>">Delete</a></td>
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