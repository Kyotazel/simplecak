<?php
$btn_payment = '';
if ($data_credit->status == FALSE) {
    $btn_payment = '
                        <a href="' . base_url('admin/credit//add_payment?data=' . urlencode($this->encrypt->encode($data_credit->id))) . '" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Tambah Data Pembayaran</a>
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
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-10 mt-10">
                        <div class="card-footer text-center border bg-gray-100">
                            <h5>Keterangan Piutang</h5>
                        </div>

                        <div class="card border shadow-none">
                            <table class="table">
                                <tr>
                                    <td width="150px">Kode</td>
                                    <td width="5px">:</td>
                                    <td><b><?= $data_credit->code; ?></b></td>
                                </tr>
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
                                            <input type="text" class="form-control form-control-sm bg-white" readonly value="<?= number_format($data_credit->price, 0, '.', '.'); ?>">
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
                                            <input type="text" class="form-control form-control-sm bg-white" readonly value="<?= number_format($data_credit->rest_credit, 0, '.', '.'); ?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Customer</td>
                                    <td>:</td>
                                    <td><b><?= $data_credit->member_name ? $data_credit->member_name : '-'; ?></b></td>
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
                            <label>Deskripsi:</label>
                            <div class="border p-2">
                                <p>
                                    <?= $data_credit->description; ?>
                                </p>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <a href="<?= base_url('admin/credit/'); ?>" class="btn btn-primary btn_link"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
                            <!-- <a href="<?= base_url('admin/credit/'); ?>" class="btn btn-primary btn"><i class="fa fa-arrow-left"></i> Lihat Data Piutang</a> -->
                            <?= $btn_payment; ?>
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
                                                        <a href="' . base_url('admin/credit/') . '" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Lihat Data Piutang</a>
                                                    </div>
                                                ';
                            } else {
                            ?>
                                <div class="col-md-12 mt-10">
                                    <h5 class="text-green mb-10 card-footer">Detail Angsuran :</h5>
                                    <div class="table-responsive">
                                        <table class="table table_payment">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Kode Pembayaran</th>
                                                    <th>Tanggal Pembayaran</th>
                                                    <th>Jumlah Tagihan</th>
                                                    <th>Jumlah Dibayar</th>
                                                    <th>Sisa Tanggungan</th>
                                                    <th>Catatan</th>
                                                    <th>status</th>
                                                    <th>Petugas</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $counter = 0;
                                                foreach ($data_detail as $item_detail) {
                                                    $counter++;
                                                    $label_status = $item_detail->status ? '<label class="label label-success">Lunas</label>' : '<label class="label label-warning">Belum Lunas</label>';
                                                    echo '
                                                                    <tr>
                                                                        <td>' . $counter . '</td>
                                                                        <td>' . $item_detail->code . '</td>
                                                                        <td>' . $item_detail->date . '</td>
                                                                        <td>Rp.' . number_format($item_detail->credit_price, 0, '.', '.') . '</td>
                                                                        <td>Rp.' . number_format($item_detail->payment_price, 0, '.', '.') . '</td>
                                                                        <td>Rp.' . number_format($item_detail->rest_credit, 0, '.', '.') . '</td>
                                                                        <td>' . $item_detail->note . '</td>
                                                                        <td>' . $label_status . '</td>
                                                                        <td>' . $item_detail->user_name . '</td>
                                                                    </tr>
                                                                ';
                                                }
                                                if (empty($data_detail)) {
                                                    echo '
                                                                    <tr>
                                                                        <td colspan="10" class="text-center">
                                                                            <div class="bg-empty-data"></div>
                                                                            <h3 class="text-center text-muted">Tidak ada data pembayaran</h3>
                                                                        </td>
                                                                    </tr>
                                                                ';
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php } ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>