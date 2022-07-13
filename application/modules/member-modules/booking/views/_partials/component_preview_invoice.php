<div class="row">
    <div class="col-12">

        <div class="panel panel-primary tabs-style-2">
            <div class=" tab-menu-heading">
                <div class="tabs-menu1">
                    <!-- Tabs -->
                    <ul class="nav panel-tabs main-nav-line">

                        <?php
                        $status_freight = '';
                        $status_thc = '';
                        $status_lc = '';
                        if ($data_bs->total_price_freight > 0) {
                            $status_freight = 'active';
                            echo '
                                    <li><a href="#tab4" class="nav-link active" data-toggle="tab">INVOICE FREIGHT</a></li>
                                ';
                        }
                        if ($data_bs->total_price_thc > 0) {
                            $active = $data_bs->total_price_freight == 0 ? 'active' : '';
                            $status_thc = $active;
                            echo '
                                    <li><a href="#tab5" class="nav-link ' . $active . '" data-toggle="tab">INVOICE THC</a></li>
                                ';
                        }
                        if ($data_bs->total_price_lc > 0) {
                            $active = $data_bs->total_price_thc == 0 && $data_bs->total_price_freight == 0 ? 'active' : '';
                            $status_lc = $active;
                            echo '
                                <li><a href="#tab6" class="nav-link ' . $active . '" data-toggle="tab">INVOICE LOSS CARGO</a></li>
                            ';
                        }

                        ?>
                    </ul>
                </div>
            </div>
            <div class="panel-body tabs-menu-body main-content-body-right border">
                <div class="tab-content">
                    <div class="tab-pane <?= $status_freight; ?>" id="tab4">
                        <?php
                        $data['status_preview'] = TRUE;
                        $data_invoice = Modules::run('database/find', 'tb_invoice', ['id_booking' => $data_bs->id, 'type' => 1])->row();
                        if (!empty($data_invoice)) {
                            $this->load->view('_partials/_invoice/component_invoice_freight', $data);
                        } else {
                            echo '
                                <div class="col-12 text-center">
                                    <div class="plan-card text-center">
                                        <i class="fas fa-file plan-icon text-primary"></i>
                                        <h6 class="text-drak text-uppercase mt-2">Data Kosong</h6>
                                        <small class="text-muted">Data tagihan belum dibuat oleh admin.</small>
                                    </div>
                                </div>

                            ';
                        }
                        ?>

                    </div>
                    <div class="tab-pane <?= $status_thc; ?>" id="tab5">
                        <?php
                        $data['status_preview'] = TRUE;
                        $data_invoice = Modules::run('database/find', 'tb_invoice', ['id_booking' => $data_bs->id, 'type' => 2])->row();
                        if (!empty($data_invoice)) {
                            $this->load->view('_partials/_invoice/component_invoice_thc', $data);
                        } else {
                            echo '
                                <div class="col-12 text-center">
                                    <div class="plan-card text-center">
                                        <i class="fas fa-file plan-icon text-primary"></i>
                                        <h6 class="text-drak text-uppercase mt-2">Data Kosong</h6>
                                        <small class="text-muted">Data tagihan belum dibuat oleh admin.</small>
                                    </div>
                                </div>

                            ';
                        }
                        ?>
                    </div>
                    <div class="tab-pane <?= $status_lc; ?>" id="tab6">
                        <?php
                        $data['status_preview'] = TRUE;
                        $data_invoice = Modules::run('database/find', 'tb_invoice', ['id_booking' => $data_bs->id, 'type' => 3])->row();
                        if (!empty($data_invoice)) {
                            $this->load->view('_partials/_invoice/component_invoice_lc', $data);
                        } else {
                            echo '
                                <div class="col-12 text-center">
                                    <div class="plan-card text-center">
                                        <i class="fas fa-file plan-icon text-primary"></i>
                                        <h6 class="text-drak text-uppercase mt-2">Data Kosong</h6>
                                        <small class="text-muted">Data tagihan belum dibuat oleh admin.</small>
                                    </div>
                                </div>

                            ';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>