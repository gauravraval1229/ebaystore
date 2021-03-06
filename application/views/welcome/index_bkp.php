<style type="text/css">
.row {
    
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

                          <p style="margin-top: 20px; margin-left: 20px;">Welcome <?php echo ucfirst($this->session->userdata['logged_in']['firstName']).' '.ucfirst($this->session->userdata['logged_in']['lastName']); ?></p>

                        </div>
                      </div>
                    </div>
                </section>


                <!-- <div id="crypto-stats-3" class="row">
                    <div class="col-xl-4 col-12">
                        <div class="card crypto-card-3 pull-up">
                            <div class="card-content">
                                <div class="card-body pb-0">
                                    <div class="row">
                                        <div class="col-2">
                                            <i class="cc BTC warning font-large-2" title="BTC"></i>
                                        </div>
                                        <div class="col-5 pl-2">
                                            <h4>BTC</h4>
                                            <h6 class="text-muted">Bitcoin</h6>
                                        </div>
                                        <div class="col-5 text-right">
                                            <h4>$9,980</h4>
                                            <h6 class="success darken-4">31% <i class="la la-arrow-up"></i></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12"><canvas id="btc-chartjs" class="height-75"></canvas></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-12">
                        <div class="card crypto-card-3 pull-up">
                            <div class="card-content">
                                <div class="card-body pb-0">
                                    <div class="row">
                                        <div class="col-2">
                                            <i class="cc ETH blue-grey lighten-1 font-large-2" title="ETH"></i>
                                        </div>
                                        <div class="col-5 pl-2">
                                            <h4>ETH</h4>
                                            <h6 class="text-muted">Ethereum</h6>
                                        </div>
                                        <div class="col-5 text-right">
                                            <h4>$944</h4>
                                            <h6 class="success darken-4">12% <i class="la la-arrow-up"></i></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12"><canvas id="eth-chartjs" class="height-75"></canvas></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-12">
                        <div class="card crypto-card-3 pull-up">
                            <div class="card-content">
                                <div class="card-body pb-0">
                                    <div class="row">
                                        <div class="col-2">
                                            <i class="cc XRP info font-large-2" title="XRP"></i>
                                        </div>
                                        <div class="col-5 pl-2">
                                            <h4>XRP</h4>
                                            <h6 class="text-muted">Balance</h6>
                                        </div>
                                        <div class="col-5 text-right">
                                            <h4>$1.2</h4>
                                            <h6 class="danger">20% <i class="la la-arrow-down"></i></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12"><canvas id="xrp-chartjs" class="height-75"></canvas></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->

                <!-- Icon section start -->
                <section id="icon-section">
                    
                    <div class="row">
                        <div class="col-xl-4 col-md-6 col-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="media align-items-stretch">
                                        <div class="p-2 text-center bg-info rounded-left">
                                            <i class="icon-wallet font-large-2 text-white"></i>
                                        </div>
                                        <div class="p-2 media-body">
                                            <h5>Total Products</h5>
                                            <h5 class="text-bold-400 mb-0">
                                                <?php 
                                                    if(count($amazonProductList) == 0 || count($amazonProductList) == 1) {
                                                        echo 0;
                                                    }
                                                    else {
                                                        echo count($amazonProductList);
                                                    }
                                                ?>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 col-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="media align-items-stretch">
                                        <div class="p-2 text-center bg-success rounded-left">
                                            <i class="icon-wallet font-large-2 text-white"></i>
                                        </div>
                                        <div class="p-2 media-body">
                                            <h5>Ebay Products</h5>
                                            <h5 class="text-bold-400 mb-0">20,000</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 col-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="media align-items-stretch">
                                        <div class="p-2 text-center bg-warning rounded-left">
                                            <i class="icon-wallet font-large-2 text-white"></i>
                                        </div>
                                        <div class="p-2 media-body">
                                            <h5>Shopify Products</h5>
                                            <h5 class="text-bold-400 mb-0">30,000</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-4 col-md-6 col-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="media align-items-stretch">
                                        <div class="p-2 text-center bg-info rounded-left">
                                            <i class="icon-basket-loaded font-large-2 text-white"></i>
                                        </div>
                                        <div class="p-2 media-body">
                                            <h5>Total Orders</h5>
                                            <h5 class="text-bold-400 mb-0">4,000</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 col-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="media align-items-stretch">
                                        <div class="p-2 text-center bg-success rounded-left">
                                            <i class="icon-basket-loaded font-large-2 text-white"></i>
                                        </div>
                                        <div class="p-2 media-body">
                                            <h5>Total Sold Products</h5>
                                            <h5 class="text-bold-400 mb-0">2,000</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 col-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="media align-items-stretch">
                                        <div class="p-2 text-center bg-warning rounded-left">
                                            <i class="icon-basket-loaded font-large-2 text-white"></i>
                                        </div>
                                        <div class="p-2 media-body">
                                            <h5>Total Products in Stock</h5>
                                            <h5 class="text-bold-400 mb-0">2,000</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </section>
                <!-- // Icon section end -->

            </div>
        </div>
    </div>
  <!-- END: Content-->