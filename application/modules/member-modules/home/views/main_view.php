<div class=" row rounded-20 bg-primary align-items-center" style="background: url(<?= base_url('assets/themes/valex/img/svgicons/cargo.svg'); ?>) no-repeat;height:100px;">
    <div class="col-3 border-right d-flex align-items-center">
        <img style="width:100px;" src="" alt="">
        <h3 class="ml-3 text-white mb-0">Order Kontainer</h3>
    </div>
    <div class="col-6">
        <p class="text-white tx-16 p-0 m-0">Yuk order kontainermu sekarang juga.</p>
    </div>
    <div class="col-3 text-right">
        <a href="<?= Modules::run('helper/create_url', '/order'); ?>" class="btn btn-rounded btn-warning-gradient font-weight-bold">Pesan kontainer Sekarang <i class="fa fa-paper-plane"></i></i></a>
    </div>
</div>
<div class="row mt-4">
    <?php
    if ($resume_invoice->total_credit > 0) {
        echo '
                <div class="col-12 col-lg-5">
                    <h3 class="card-title">Tagihan Anda</h3>
                    <div class="card bg-primary rounded-20">
                        <div class="card-body px-5">
                            <p class="text-white">
                                Hai <b>' . $this->session->userdata('member_name') . '</b> ! Anda masih memiliki tagihan yang belum dibayar dengan rincian:
                            </p>
                            <div class="row align-items-center">
                                <div class="col-md-8 p-0">
                                    <div class="new-table-cell-bottom text-white">
                                        <div class="block-container-notification__bill-panel-body-product-title">
                                            Total Semua tagihan :
                                        </div>
                                        <div class="block-container-notification__bill-panel-body-product-price">
                                            <h3>Rp ' . number_format($resume_invoice->total_credit, 0, '.', '.') . '</h3>
                                        </div>
                                        <div class="block-container-notification__bill-panel-body-product-invoice">
                                            Total Invoice : <strong>' . $resume_invoice->count_credit . ' Nota</strong></div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-center">
                                    <a href="' . Modules::run('helper/create_url', 'credit') . '" class="btn btn-warning-gradient btn-rounded btn-block font-weight-bold">Lihat Invoice <i class="fa fa-paper-plane"></i></a>
                                </div>
                            </div>
            
                        </div>
                    </div>
                </div>
            ';
    }
    ?>

    <div class="col row">
        <h3 class="card-title">Resume Transaksi</h3>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h1><?= $count_booking; ?></h1>
                        Order Aktif
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h1><?= $unloading_countainer; ?></h1>
                        Kontainer Siap Dibongkar
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h1><?= $count_return; ?></h1>
                        Kontainer Sedang Dibongkar
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mb-4">
    <h3 class="card-title col-12">Transaksi Sedang Berlangsung</h3>
    <div class="col-12">
        <div class="panel panel-primary tabs-style-2">
            <div class=" tab-menu-heading">
                <div class="tabs-menu1">
                    <!-- Tabs -->
                    <ul class="nav panel-tabs main-nav-line">
                        <li class="bg-white"><a href="#tab4" class="nav-link active font-weight-bold" data-toggle="tab">Order Aktif</a></li>
                        <li class="bg-white"><a href="#tab5" class="nav-link font-weight-bold" data-toggle="tab">Kontainer Siap Dibongkar</a></li>
                        <li class="bg-white"><a href="#tab6" class="nav-link font-weight-bold" data-toggle="tab">Kontainer Sedang Dibongkar</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body tabs-menu-body main-content-body-right bg-white">
                <div class="tab-content">
                    <div class="tab-pane active p-2" id="tab4">
                        <div class="html_respon_order"></div>
                    </div>
                    <div class="tab-pane" id="tab5">
                        <div class="p-2">
                            <table id="table_unloading" class="table table-bordered dt-responsive nowrap t-shadow" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <th style="width: 5%;">No</th>
                                    <th>BOOKING SLOT</th>
                                    <th>VOYAGE</th>
                                    <th>JENIS KONTAINER</th>
                                    <th style="width: 15%;">MUATAN</th>
                                    <th style="width: 15%;">KONTAINER & SEGEL</th>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab6">
                        <table id="table_return" class="table table-bordered dt-responsive nowrap t-shadow" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <th style="width: 5%;">No</th>
                                <th>BOOKING SLOT</th>
                                <th>VOYAGE</th>
                                <th>JENIS KONTAINER</th>
                                <th style="width: 15%;">MUATAN</th>
                                <th style="width: 15%;">KONTAINER & SEGEL</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>