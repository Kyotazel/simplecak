<?php
$get_invoice_activity = Modules::run('database/find', ' tb_invoice', ['id_booking' => $data_bs->id, 'type' => 4])->result();
?>
<div class="panel panel-primary tabs-style-2">
    <div class=" tab-menu-heading">
        <div class="tabs-menu1">
            <!-- Tabs -->
            <ul class="nav panel-tabs main-nav-line">

                <?php
                $counter = 0;
                foreach ($get_invoice_activity as $item_invoice) {
                    $counter++;
                    $active = $counter == 1 ? 'active' : '';
                    echo '
                        <li><a href="#tab' . $counter . '" class="nav-link ' . $active . '" data-toggle="tab">INVOICE : ( ' . $item_invoice->code . ' )</a></li>
                    ';
                }
                ?>
            </ul>
        </div>
    </div>
    <div class="panel-body tabs-menu-body main-content-body-right border">
        <?php
        if (empty($get_invoice_activity)) {
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

        <div class="tab-content">
            <?php
            $counter  = 0;
            foreach ($get_invoice_activity as $item_invoice) {
                $counter++;
                $active = $counter == 1 ? 'active' : '';
                $data['data_invoice'] = $item_invoice;
                $html_content = $this->load->view('_partials/_invoice/component_invoice_activity', $data, TRUE);
                echo '
                        <div class="tab-pane ' . $active . '" id="tab' . $counter . '">
                            ' . $html_content . '
                        </div>
                    ';
            }
            ?>
        </div>
    </div>
</div>