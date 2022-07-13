<?php
$data['category_teus']   = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_teus'])->row()->value, TRUE);
$data['category_countainer']  = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'countainer_category'])->row()->value, TRUE);
$data['booking_status']  = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'booking_status'])->row()->value, TRUE);
$data['category_service']     = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_service'])->row()->value, TRUE);
$data['company_name'] = Modules::run('database/find', 'app_setting', ['field' => 'company_name'])->row()->value;
$data['company_tagline'] = Modules::run('database/find', 'app_setting', ['field' => 'company_tagline'])->row()->value;
$data['company_email'] = Modules::run('database/find', 'app_setting', ['field' => 'company_email'])->row()->value;
$data['company_number_phone'] = Modules::run('database/find', 'app_setting', ['field' => 'company_number_phone'])->row()->value;
$data['company_fax'] = Modules::run('database/find', 'app_setting', ['field' => 'company_fax'])->row()->value;
$data['company_city'] = Modules::run('database/find', 'app_setting', ['field' => 'company_city'])->row()->value;
$data['company_address'] = Modules::run('database/find', 'app_setting', ['field' => 'company_address'])->row()->value;
$data['company_logo'] = Modules::run('database/find', 'app_setting', ['field' => 'company_logo'])->row()->value;
$array_query = [
    'select' => '
        tb_booking.*,
        mst_customer.name AS customer_name,
        mst_customer.address AS customer_address,
        depo_from.name AS depo_from,
        depo_to.name AS depo_to,
        mst_ship.name AS ship_name,
        mst_ship.name AS ship_name,
        mst_ship.image AS ship_image,
        tb_voyage.status AS status_voyage,
        tb_voyage.code AS voyage_code,
        tb_voyage.date_from AS voyage_date_from,
        tb_voyage.date_to AS voyage_date_to
    ',
    'from' => 'tb_booking',
    'where' => [
        'tb_booking.id' => $data_credit->id_booking
    ],
    'join' => [
        'mst_customer, tb_booking.id_customer = mst_customer.id , left',
        'tb_voyage, tb_booking.id_voyage = tb_voyage.id, left',
        'mst_depo AS depo_from, tb_voyage.id_depo_from = depo_from.id, left',
        'mst_depo AS depo_to, tb_voyage.id_depo_to = depo_to.id, left',
        'mst_ship, tb_voyage.id_ship = mst_ship.id, left'
    ],
    'order_by' => 'tb_booking.id , DESC'
];
$get_data = Modules::run('database/get', $array_query)->row();
$data['data_bs'] = $get_data;
$data['data_invoice'] = Modules::run('database/find', 'tb_invoice', ['id' => $data_credit->id_invoice])->row();


$html_description = '';
$html_detail_invoice = '';
if ($data_credit->invoice_type == 1) {
    $html_description = 'Invoice FREIGHT untuk kode BS : ' . $data_credit->booking_code;
    $html_detail_invoice = $this->load->view('_partials/_invoice/component_invoice_freight', $data, TRUE);
}
if ($data_credit->invoice_type == 2) {
    $html_description = 'Invoice THC untuk kode BS : ' . $data_credit->booking_code;
    $html_detail_invoice = $this->load->view('_partials/_invoice/component_invoice_thc', $data, TRUE);
}
if ($data_credit->invoice_type == 3) {
    $html_description = 'Invoice Loss Cargo untuk kode BS : ' . $data_credit->booking_code;
    $html_detail_invoice = $this->load->view('_partials/_invoice/component_invoice_lc', $data, TRUE);
}
if ($data_credit->invoice_type == 4) {

    $html_description = 'Invoice Activity untuk kode BS : ' . $data_credit->booking_code;
    $html_detail_invoice = $this->load->view('_partials/_invoice/component_invoice_activity', $data, TRUE);
}

$percentage = round(($data_credit->total_payment / $data_credit->price) * 100);
$html_tag_expired = '';
if ($data_credit->status == 0 && strtotime(date('Y-m-d')) > strtotime($data_credit->deadline)) {
    $html_tag_expired = '
        <span for="" class="badge badge-pill badge-danger text-12">Telah Jatuh Tempo</span>
    ';
}



?>
<div class="col-12 row p-2 shadow-3  mb-2">
    <div class="col-3 ">
        <small class="text-muted d-block mb-2">No.Invoice :</small>
        <label for="" class="font-weight-bold tx-16 m-0">#<?= $data_credit->invoice_code;   ?></label>
        <p class="text-muted tx-12">
            <?= $html_description; ?>
        </p>
    </div>
    <div class="col-2">
        <small class="text-muted d-block"><i class="fa fa-calendar"></i> Tanggal Invoice :</small>
        <label for="" class="m-0"><?= Modules::run('helper/date_indo', $data_credit->date, '-'); ?></label>
        <small class="text-muted d-block mt-2"><i class="fa fa-calendar"></i> Jatuh Tempo :</small>
        <label for="" class="m-0"><?= Modules::run('helper/date_indo', $data_credit->deadline, '-'); ?></label>
    </div>
    <div class="col-2 row">
        <div class="col">
            <div class=""><small class="text-muted">Nominal Tagihan</small></div>
            <div class="h4 mt-1 mb-1"><b>Rp.<?= number_format($data_credit->price, 0, '.', '.'); ?></b><span class="text-success tx-13 ml-2"></span></div>
            <div class=""><small class="text-muted">Jumlah nominal yang ditagihkan.</small></div>
            <?= $html_tag_expired; ?>
        </div>
    </div>
    <div class="col-3 border-right">
        <div class="row">
            <div class="col">
                <div class=""><small class="text-muted">Sisa Tagihan</small></div>
                <div class="h4 mt-1 mb-1"><b>Rp.<?= number_format($data_credit->rest_credit, 0, '.', '.'); ?></b><span class="text-success tx-13 ml-2"></span></div>
                <div class="">
                    <p class="mb-1">Telah Dibayar : Rp.<?= number_format($data_credit->total_payment, 0, '.', '.'); ?></p>
                    <div class="progress progress-sm h-1 mb-1">
                        <div class="progress-bar bg-primary " style="width: <?= $percentage; ?>%;" role="progressbar"></div>
                    </div>
                    <small class="mb-0 text-muted">Persentase Bayar<span class="float-right text-muted"><?= $percentage; ?>%</span></small>
                </div>
            </div>
            <div class="col-auto align-self-center ">
                <div class="feature mt-0 mb-0">
                    <i class="fe fe-monitor project bg-primary-transparent text-primary "></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 text-center align-items-center d-flex flex-wrap align-content-center " style="justify-content: flex-start;">
        <a href="javascript:void(0)" data-id="<?= $data_credit->id; ?>" class="preview-payment btn btn-rounded btn-warning-gradient font-weight-bold btn-block ">Informasi Pembayaran <i class="fa fa-paper-plane"></i></a>
        <a data-toggle="collapse" href="#view_<?= $data_credit->id; ?>" role="button" aria-expanded="false" aria-controls="collapseExample" class="mt-2 col-12">Lihat Detail Tagihan <i class="fas fa-angle-down"></i></a>
    </div>
    <div class="col-12 mt-2 collapse  border-top pt-2" id="view_<?= $data_credit->id; ?>">
        <?= $html_detail_invoice; ?>
    </div>
</div>