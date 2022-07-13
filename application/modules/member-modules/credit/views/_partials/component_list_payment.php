<?php
$label_status = $payment->status ? '<span class="badge badge-success tx-12">Lunas</span>' : '<span class="badge badge-light tx-12">Belum Lunas</span>';
?>
<div class="col-12 p-2 shadow-3 row mb-2">
    <div class="col-3 border-right">
        <small class="d-block"><i class="fa fa-calendar text-muted"></i> Tanggal Pembayaran :</small>
        <label for="" class="m-0 font-weight-bold tx-16 d-block"> <?= Modules::run('helper/date_indo', $payment->date, '-'); ?></label>
        <?= $label_status; ?>
    </div>
    <div class="col-5">
        <small class="d-block text-muted"><i class="fa fa-sticky-note text-muted"></i> Catatan Pembayaran :</small>
        <div class=""><?= nl2br($payment->note); ?></div>
    </div>
    <div class="col-4">
        <div class="row">
            <div class="col">
                <div class=""><small class="text-muted">Nominal Pembayaran :</small></div>
                <div class="h4 mt-1 mb-1"><b>Rp.<?= number_format($payment->payment_price, 0, '.', '.') ?></b><span class="text-success tx-13 ml-2"></span></div>
            </div>
            <div class="col-auto align-self-center ">
                <div class="feature mt-0 mb-0">
                    <i class="fe fe-monitor project bg-primary-transparent text-primary "></i>
                </div>
            </div>
        </div>
    </div>
</div>