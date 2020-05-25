<style type="text/css">
.row {
  margin-top: 10px;
}
.customeBox {
    margin-bottom: 1.875rem;
    border: none;
    -webkit-box-shadow: 0 1px 15px 1px rgba(62, 57, 107, 0.07);
    box-shadow: 0 1px 15px 1px rgba(62, 57, 107, 0.07);
    position: relative;
    display: -webkit-box;
    display: -webkit-flex;
    display: -moz-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -moz-box-orient: vertical;
    -moz-box-direction: normal;
    min-width: 0;
    word-wrap: break-word;
    background-color: #FFFFFF;
    background-clip: border-box;
    border: 1px solid rgba(0, 0, 0, 0.06);
    border-radius: 0.35rem; 
}
</style>

  <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">

                <section class="validations" id="validation">
                    <div class="row customeBox">
                        <div class="col-md-10">
                            <p style="margin-top: 20px; margin-left: 20px;">Welcome <?php echo ucfirst($this->session->userdata['logged_in']['firstName']).' '.ucfirst($this->session->userdata['logged_in']['lastName']); ?></p>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control" id="storeType" style="margin-top: 8px;margin-bottom: 5px;">
                                <option value="amazon">Amazon</option>
                                <option value="ebay">Ebay</option>
                            </select>
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

                <!--- Display Processing Start -->
                    <div class="row processImg" style="display: none;">
                        <div class="col-md-12 text-center">
                            <img src="<?php echo base_url('assests/processingDashboard.gif') ?>" style="height: 50%;width: 50%;">
                        </div>
                    </div>
                <!--- Display Processing End -->

                <!-- Amazon Icon section start -->
                    <section id="icon-section" class="amazonSection">
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
                                                <h5 class="text-bold-400 mb-0" id="totalProductAmazon">0</h5>
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
                                                <h5>Total Sold Products</h5>
                                                <h5 class="text-bold-400 mb-0" id="totalProductSoldAmazon">0</h5>
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
                                                <h5>Total Remaining Products</h5>
                                                <h5 class="text-bold-400 mb-0" id="totalRemainingProductAmazon">0</h5>
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
                                                <h5 class="text-bold-400 mb-0" id="totalOrderAmazon">0</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                <!-- Amazon Icon section end -->

                <!-- Ebay Icon section start -->
                    <section id="icon-section" class="ebaySection" style="display: none;">
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
                                                <h5 class="text-bold-400 mb-0" id="totalProductEbay">0</h5>
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
                                                <h5>Total Sold Products</h5>
                                                <h5 class="text-bold-400 mb-0" id="totalProductSoldEbay">0</h5>
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
                                                <h5>Total Remaining Products</h5>
                                                <h5 class="text-bold-400 mb-0" id="totalRemainingProductEbay">0</h5>
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
                                                <h5 class="text-bold-400 mb-0" id="totalOrderEbay">0</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                <!-- Ebay Icon section end -->

            </div>
        </div>
    </div>
  <!-- END: Content-->

<script type="text/javascript">
    $(document).ready(function(){
        //var storeType = $("#storeType").val(); // Work pending
        var storeType = "amazon";
        if(storeType == "amazon") {
            $.ajax({
                data: {"storeType":storeType},
                url: "getDashboardAmazon",
                method: "POST",
                success : function(data){
                    var amazonArr = data.split(',');

                    if(amazonArr[0] == "success") { // data found

                        $("#totalProductAmazon").html('');
                        $("#totalProductSoldAmazon").html('');
                        $("#totalRemainingProductAmazon").html('');
                        $("#totalOrderAmazon").html('');

                        $("#totalProductAmazon").html(amazonArr[1]);
                        $("#totalProductSoldAmazon").html(amazonArr[2]);
                        $("#totalRemainingProductAmazon").html(amazonArr[3]);
                        $("#totalOrderAmazon").html(amazonArr[4]);
                    }
                    else { // user sessoin expired
                        window.location.href = '<?php echo base_url() ?>index.php/LoginController/index';
                    }
                }
            });
        }
    });

    $("#storeType").change(function(){
        var storeType = $("#storeType").val();

        if(storeType == "amazon") {

            document.getElementsByClassName('amazonSection')[0].style.display = "none";
            document.getElementsByClassName('ebaySection')[0].style.display = "none";
            document.getElementsByClassName("processImg")[0].style.display = "block";

            $.ajax({
                data: {"storeType":storeType},
                url: "getDashboardAmazon",
                method: "POST",
                success : function(data) {

                    document.getElementsByClassName("processImg")[0].style.display = "none";
                    document.getElementsByClassName('amazonSection')[0].style.display = "block";
                    document.getElementsByClassName('ebaySection')[0].style.display = "none";

                    var amazonArr = data.split(',');

                    if(amazonArr[0] == "success"){

                        $("#totalProductAmazon").html('');
                        $("#totalProductSoldAmazon").html('');
                        $("#totalRemainingProductAmazon").html('');
                        $("#totalOrderAmazon").html('');

                        $("#totalProductAmazon").html(amazonArr[1]);
                        $("#totalProductSoldAmazon").html(amazonArr[2]);
                        $("#totalRemainingProductAmazon").html(amazonArr[3]);
                        $("#totalOrderAmazon").html(amazonArr[4]);
                    }
                    else { // user sessoin expired
                        window.location.href = '<?php echo base_url() ?>index.php/LoginController/index';
                    }
                }
            });
        }
        else if(storeType == "ebay") {

            document.getElementsByClassName('amazonSection')[0].style.display = "none";
            document.getElementsByClassName('ebaySection')[0].style.display = "none";
            document.getElementsByClassName("processImg")[0].style.display = "block";

            $.ajax({
                data: {"storeType":storeType},
                url: "getDashboardEbay",
                method: "POST",
                success : function(data) {

                    var ebayArr = data.split(',');

                    if(ebayArr['0'] == "login") { // Token is expired. Need to login in ebay

                        window.location.href = ebayArr[1];
                    }
                    else if (ebayArr['0'] == "success"){ // token is refreshed and display data

                        document.getElementsByClassName("processImg")[0].style.display = "none";
                        document.getElementsByClassName('amazonSection')[0].style.display = "none";
                        document.getElementsByClassName('ebaySection')[0].style.display = "block";

                        $("#totalProductEbay").html('');
                        $("#totalProductSoldEbay").html('');
                        $("#totalRemainingProductEbay").html('');
                        $("#totalOrderEbay").html('');

                        $("#totalProductEbay").html(ebayArr[1]);
                        $("#totalProductSoldEbay").html(ebayArr[2]);
                        $("#totalRemainingProductEbay").html(ebayArr[3]);
                        $("#totalOrderEbay").html(ebayArr[4]);
                    }
                    else { // user sessoin expired
                        window.location.href = '<?php echo base_url() ?>index.php/LoginController/index';
                    }
                }
            });
        }
    });
</script>