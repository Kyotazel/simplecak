<?php
$btn_payment = '';
if ($data_credit->status == FALSE) {
    $btn_payment = '
                        <a href="' . base_url('admin/credit/add_payment?data=' . urlencode($this->encrypt->encode($data_credit->id))) . '" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Tambah Data Pembayaran</a>
                    ';
}

if (strtotime($data_credit->deadline) < strtotime(date('Y-m-d'))) {
    //expired
    $label_expired = $data_credit->status ? '-' : '<label class="text-danger text-bold font-weight-bold">Telah Jatuh Tempo</label>';
} else {
    //expired
    $label_expired = $data_credit->status ? '-' : '<label class="text-success text-bold font-weight-bold">Belum Jatuh Tempo</label>';
}
?>
<div class="row">
    <div class="col-md-4 mb-10 mt-10">
        <div class="card">
            <div class="card-header text-white bg-primary-gradient">
                <h5><i class="fa fa-file"></i> Keterangan Invoice</h5>
            </div>
            <div class="card-body shadow-none">
                <table class="table">
                    <tr>
                        <td width="150px">Invoice</td>
                        <td width="5px">:</td>
                        <td><b><?= $data_credit->invoice_code; ?></b></td>
                    </tr>
                    <tr>
                        <td>Nominal</td>
                        <td>:</td>
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text" style="padding:0 10px;">Rp.</div>
                                </div>
                                <input type="text" class="form-control form-control-sm bg-white border-dashed font-weight-bold tx-14" readonly value="<?= number_format($data_credit->price, 0, '.', '.'); ?>">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Sisa Tanggungan</td>
                        <td>:</td>
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text" style="padding:0 10px;">Rp.</div>
                                </div>
                                <input type="text" class="form-control form-control-sm bg-white font-weight-bold tx-14 border-dashed" readonly value="<?= number_format($data_credit->rest_credit, 0, '.', '.'); ?>">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Tanggal Piutang</td>
                        <td>:</td>
                        <td><b><?= Modules::run('helper/date_indo', $data_credit->date, '-'); ?> s/d <?= Modules::run('helper/date_indo', $data_credit->deadline, '-'); ?></b></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>:</td>
                        <td><b><?= $data_credit->status ? '<label class="text-primary font-weight-bold">Telah Lunas</label>' : '<label class="text-danger font-weight-bold">Belum Lunas</label>'; ?></b></td>
                    </tr>
                    <tr>
                        <td>Status Jatuh Tempo</td>
                        <td>:</td>
                        <td><b><?= $label_expired; ?></b></td>
                    </tr>
                </table>
            </div>
        </div>


    </div>
    <div class="col-md-8">
        <!-- <h3 class="text-green mb-10">Form Pembayaran :</h3> -->
        <form class="form-horizontal form_payment">
            <?php
            if ($data_credit->status == 2) {
                echo '
                                <div class="col-md-12 mb-10">
                                    <hr>
                                    <h2 class="text-center text-muted" >PIUTANG <b>' . $data_credit->code . '</b> TELAH DIBATALKAN </h2>
                                    <hr>
                                </div>
                                <div class="col-md-4 mt-10">
                                    <label>Keterangan Pembatalan:</label>
                                    <table class="table">
                                        <tr>
                                            <td width="150px">Tanggal Dibatalkan </td>
                                            <td width="5px">:</td>
                                            <td><b>' . $data_credit->updated_date . '</b></td>
                                        </tr>
                                        <tr>
                                        <td>Dibatlakan Oleh</td>
                                        <td>:</td>
                                        <td><b>' . $data_credit->user_name . '</b></td>
                                    </tr>
                                    </table>
                                </div>
                                <div class="col-md-8 mt-10">
                                    <label>Catatan Pembatalan:</label>
                                    <div class="p-10 border border-radius-5">' . $data_credit->reject_note . '</div>
                                </div>
                                <div class="col-md-12 text-right">
                                    <a href="' . base_url('admin/credit') . '" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Lihat Data Piutang</a>
                                </div>
                            ';
            } else {
            ?>
                <div class="col-md-12">
                    <h5 class="text-green mb-3 col-12">Detail Angsuran :</h5>
                    <div class="row">
                        <?php
                        foreach ($data_detail as $item_detail) {
                            $data['payment'] = $item_detail;
                            $html_data = $this->load->view('_partials/component_list_payment', $data, TRUE);
                            echo $html_data;
                        }
                        if (empty($data_detail)) {
                            echo '
                            <div class="col-12 text-center py-5 shadow-3">
                                <div class="plan-card text-center">
                                    <i class="fas fa-file plan-icon text-primary"></i>
                                    <h6 class="text-drak text-uppercase mt-2">Data Kosong</h6>
                                    <small class="text-muted">Tidak ada pembayaran.</small>
                                </div>
                            </div>
                            ';
                        }
                        ?>
                    </div>
                </div>
            <?php } ?>
        </form>
    </div>
</div>