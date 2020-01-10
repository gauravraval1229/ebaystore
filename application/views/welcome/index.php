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

                <section class="validations" id="validation">
                    
                    <div class="row match-height">
                      <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="card">

                          <p style="margin-top: 20px; margin-left: 20px;">Welcome <?php echo $this->session->userdata['logged_in']['firstName'].' '.$this->session->userdata['logged_in']['lastName']; ?></p>

                        </div>
                      </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
  <!-- END: Content-->