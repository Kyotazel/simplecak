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

$html_item_icon = '';
$next_status = $data_bs->status + 1;
if ($data_bs->status == 9) {
    foreach ($get_list_status as $key_status => $value_status) {
        $icon           = isset($list_status_icon[$key_status]) ? $list_status_icon[$key_status] : '';
        $text_status    = isset($list_status[$key_status]) ? $list_status[$key_status] : '';
        $time = Modules::run('helper/datetime_indo', $value_status['date']);
        $html_item_icon .= '
        <div class="md-step active">
            <div class="md-step-circle bg-primary-gradient">
                <span><i class="fa-lg ' . $icon . '"></i></span>
            </div>
            <div class="md-step-title">
                <b>' . strtoupper($text_status) . '</b>
                <div class="col-12">
                    <small class="my-auto  d-block">' . $value_status['description'] . '</small>
                </div>
                <div class="col-12">
                    <small class="my-auto  d-block">' . $time . '</small>
                </div>
            </div>
            <div class="md-step-bar-left"></div>
            <div class="md-step-bar-right"></div>
        </div>
    ';
    }
} else {
    foreach ($list_status as $key_status => $value_status) {
        if ($key_status == 9) {
            continue;
        }
        $icon = isset($list_status_icon[$key_status]) ? $list_status_icon[$key_status] : '';
        $class_text = 'text-muted';
        $class_bg = '';
        $finish_class = '';
        $description = '-';
        $date_time = '-';
        $text_muted = 'text-muted';
        $active_status = '';
        if (isset($get_list_status[$key_status])) {
            $class_text = 'text-primary font-weight-bold ';
            $class_bg = 'bg-primary-gradient';
            $finish_class = 'finish';
            $description = $get_list_status[$key_status]['description'];
            $date_time = Modules::run('helper/datetime_indo', $get_list_status[$key_status]['date']);
            $text_muted = '';
            $active_status = '
                <i class="fa fa-check text-success position-absolute" style="right:0;"></i>
            ';
        }
        if ($key_status == $data_bs->status) {
            $active_status = ' <div class="dot-label bg-success mr-1"></div>';
        }

        if ($key_status == $next_status) {
            $date_time = '';
        }

        $html_item_icon .= '
            <div class="md-step ">
                <div class="md-step-circle ' . $class_bg . '">
                    <span><i class="fa-lg ' . $icon . '"></i></span>
                </div>
                <div class="md-step-title ' . $text_muted . '">
                    <b>' . strtoupper($value_status) . '</b>
                    <div class="col-12">
                    <small class="my-auto ' . $text_muted . ' d-block"> ' . $description . '</small>
                    </div>
                    <div class="col-12">
                        <small class="my-auto font-weight-bold ' . $text_muted . ' d-block"> ' . $date_time . '</small>
                    </div>
                </div>
                <div class="md-step-bar-left ' . $finish_class . '"></div>
                <div class="md-step-bar-right ' . $finish_class . '"></div>
            </div>
        ';
    }
}


$category_teus   = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_teus'])->row()->value, TRUE);
$category_countainer  = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'countainer_category'])->row()->value, TRUE);
$booking_status  = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'booking_status'])->row()->value, TRUE);
$category_service     = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_service'])->row()->value, TRUE);
$category_unit_lc     = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_unit_lc'])->row()->value, TRUE);
$act = $this->input->get('act');

$data['category_teus'] = $category_teus;
$data['category_countainer'] = $category_countainer;
$data['booking_status'] = $booking_status;
$data['category_service'] = $category_service;
$data['category_unit_lc'] = $category_unit_lc;


$array_query_detail_bs = [
    'select' => '
        tb_booking_has_detail.*,
        mst_category_load.name AS category_load_name,
        mst_category_stuff.name AS category_stuff_name,
        mst_transportation.name AS transport_name
    ',
    'from' => 'tb_booking_has_detail',
    'where' => [
        'id_booking' =>  $data_bs->id
    ],
    'join' => [
        'mst_category_load, tb_booking_has_detail.id_category_load = mst_category_load.id , left',
        'mst_category_stuff, tb_booking_has_detail.id_category_stuff = mst_category_stuff.id , left',
        'mst_transportation, tb_booking_has_detail.id_transportation = mst_transportation.id , left'
    ]
];
$data_bs_bs = Modules::run('database/get', $array_query_detail_bs)->result();

$status_voyage = isset($status_voyage[$data_bs->status_voyage]) ? $status_voyage[$data_bs->status_voyage] : '';
if ($data_bs->status_voyage == 1) {
    $status_voyage = 'Sedang diproses ke pelayaran';
}
if ($data_bs->is_confirm == 0) {
    $status_voyage = 'Menunggu Konfirmasi';
}

if ($data_bs->is_confirm == 2) {
    $status_voyage = 'Dibatalkan';
}
$html_item_countainer = '';
$html_item_lc = '';
foreach ($data_bs_bs as $item_detail_bs) {
    if ($item_detail_bs->type == 1) {
        $countiner_type = isset($category_countainer[$item_detail_bs->category_countainer]) ? $category_countainer[$item_detail_bs->category_countainer] : '';
        $countainer_teus = isset($category_teus[$item_detail_bs->category_teus]) ? $category_teus[$item_detail_bs->category_teus] : 0;
        $service_type = isset($category_service[$item_detail_bs->category_service]) ? $category_service[$item_detail_bs->category_service] : '';
        $html_item_countainer .= '
            <div class="col-12 ">
                <div class="border-dashed rounded-3 p-2 row align-items-center">
                    <label for="" class=" m-0 font-weight-bold col-4 border-right">
                        ' . strtoupper($countiner_type) . ' (' . strtoupper($countainer_teus) . ' FEET) x ' . $item_detail_bs->qty . '
                    </label>
                    <small class="d-block col-5 border-right">
                        <span class="text-muted"><i class="fa fa-check-circle"></i> Barang : </span> ' . strtoupper($item_detail_bs->category_load_name) . ' - ' . strtoupper($item_detail_bs->category_stuff_name) . '
                    </small>
                    <small class="d-block col-3">
                        <span class="text-muted"><i class="fa fa-check-circle"></i> Service : </span> ' . strtoupper($service_type) . '
                    </small>
                </div>
            </div>
        ';
    } else {
        $html_item_lc .= '
            <div class="col-12">
                <div class="border-dashed rounded-5 p-2 row align-items-center">
                    <label for="" class="col-4 m-0 font-weight-bold border-right ">
                        ' . strtoupper($item_detail_bs->transport_name) . ' x ' . $item_detail_bs->qty . '
                    </label>
                    <small class="d-block col-5 border-right">
                        <span class="text-muted"><i class="fa fa-check-circle"></i> Barang : </span> ' . strtoupper($item_detail_bs->category_load_name) . ' - ' . strtoupper($item_detail_bs->category_stuff_name) . '
                    </small>
                    <small class="d-block col-3">
                        <span class="text-muted"><i class="fa fa-check-circle"></i> Keterangan : </span> ' . nl2br(strtoupper($item_detail_bs->transport_description)) . '
                    </small>
                </div>
            </div>
        ';
    }
}


?>
<div class="col-12">
    <div class="md-stepper-horizontal">
        <?= $html_item_icon; ?>
    </div>
</div>
<div class="row mt-2">
    <div class="row">
        <div class="col-8">
            <div class="shadow-3 rounded-5 mb-2" style="border:none;">
                <div class="card-header bg-primary-gradient text-white row p-2">
                    <div class="col-12 tx-16 d-flex align-items-center">
                        <span class="font-weight-bold"><i class="fa fa-shopping-bag  tx-20"></i> Transaksi </span>
                        <span class="mx-2"> <?= Modules::run('helper/date_indo', $data_bs->date, '-'); ?></span>
                        <span class="badge badge-light text-capitalize px-4 py-1"><?= $status_voyage; ?></span>
                        <span class="ml-3"><?= $data_bs->code; ?></span>
                    </div>
                </div>
                <div class="card-body bg-white">
                    <div class="row">
                        <div class=" col-8 border-right p-0  row">
                            <div class="col-12">
                                <label for="" class="font-weight-bold m-0 mr-2 d-block">Alamat Tujuan :</label>
                                <div class="row col-12 border-dashed m-0">
                                    <div class="col">
                                        <div class=" mt-2 mb-2 text-primary text-capitalize tx-16"><b><?= $data_bs->receiver; ?></b></div>
                                        <p class="tx-12"><?= $data_bs->receiver_address; ?></p>
                                    </div>
                                    <div class="col-auto align-self-center ">
                                        <div class="feature mt-0 mb-0">
                                            <i class="fe fe-user project bg-primary-transparent text-primary "></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?= $html_item_countainer . $html_item_lc; ?>
                        </div>
                        <div class="col-md-4 col-12 d-flex align-items-center">
                            <div>
                                <div class="align-items-center mb-3">
                                    <?php
                                    $html_price = '
                                        <label for="" class="font-weight-bold m-0 mr-2 d-block">Total Transaksi :</label>
                                        <h2 class="mb-1 font-weight-bold text-primary">Rp.' . number_format($data_bs->grand_total, 0, '.', '.') . '</h2>
                                        <small class="d-block">Jumlah yang ditagihkan kepada customer include pajak & dokumen.</small>
                                    ';
                                    if ($data_bs->status == 1 && $data_bs->is_confirm == 0) {
                                        $html_price = '
                                            <label for="" class="m-o px-4 py-1 bg-primary font-weight-bold text-white rounded-30"><i class="fa fa-clock"></i> Menunggu Konfirmasi Admin</label>
                                            <div class="row col-12 mb-1 countup_unloading" data-date-now="2022-04-13" data-date-to="2022-03-31">
                                                <div class="col-3 p-1 border rounded text-center">
                                                    <h5 for="" class="p-0 m-0 text-danger text_day">13</h5>
                                                    <small for="" class="d-block font-weight-bold">Hari</small>
                                                </div>
                                                <div class="col-3 p-1 border rounded text-center">
                                                    <h5 for="" class="p-0 m-0 text-danger text_hour">7</h5>
                                                    <small for="" class="d-block font-weight-bold">Jam</small>
                                                </div>
                                                <div class="col-3 p-1 border rounded text-center">
                                                    <h5 for="" class="p-0 m-0 text-danger text_minute">13</h5>
                                                    <small for="" class="d-block font-weight-bold">Menit</small>
                                                </div>
                                                <div class="col-3 p-1 border rounded text-center">
                                                    <h5 for="" class="p-0 m-0 text-danger text_second">34</h5>
                                                    <small for="" class="d-block font-weight-bold">Detik</small>
                                                </div>
                                            </div>
                                            <small class="d-block">Jumlah yang akan ditagihkan kepada customer sedang menunggu konfirmasi dari admin.</small>
                                            <div class=" mt-3">
                                                <a href="javascript:void(0)" class="btn btn-round btn-light-gradient btn-rounded font-weight-bold">Batalkan <i class="fa fa-paper-plane"></i></a>
                                            </div>
                                        ';
                                    }
                                    echo $html_price;
                                    ?>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="w-100">
                <div class="card-header bg-primary-gradient text-white row p-2">
                    <div class="col-12 tx-16 d-flex align-items-center">
                        <span class="font-weight-bold"><i class="fa fa-ship  tx-20"></i> Keterangan Kapal : </span>
                        <span class="mx-2"> <?= $data_bs->voyage_code; ?></span>
                    </div>
                </div>
                <div class="card-body bg-white">
                    <div class="col-12">
                        <!-- <label class=" m-0" for="" class="d-block">Nama Kapal :</label> -->
                        <div class="border-dashed p-2 row d-flex">
                            <img class="img-sm mr-1" src="<?= base_url('upload/ship/' . $data_bs->ship_image); ?>" alt="">
                            <div class="ml-3 p-2">
                                <h5 class="text-uppercase"><?= $data_bs->ship_name; ?></h5>
                            </div>
                        </div>
                        <div class="col-12 d-flex align-items-center tx-14">
                            <label class="m-0 font-weight-bold mr-2" for="">Rute : </label>
                            <label class="my-0 px-2 badge badge-pill badge-light tx-14 mx-3" for=""><i class="fa fa-map-marker"></i> <?= $data_bs->depo_from; ?> </label>
                            <hr class="mx-1" style="width: 100px;border-top: 5px dotted ;">
                            <i class="fa fa-arrow-circle-right"></i>
                            <label class="my-0 px-2 badge badge-pill badge-light tx-14 mx-3" for=""><i class="fa fa-map-marker"></i> <?= $data_bs->depo_to; ?> </label>
                        </div>
                        <div class="col-12 row">
                            <div class="col-6 border-dashed p-2">
                                <small class="d-block text-muted"><i class="fa fa-calendar"></i> Tanggal Berangkat :</small>
                                <label for="" class="d-block font-weight-bold m-0"><?= Modules::run('helper/date_indo', $data_bs->voyage_date_from, '-'); ?></label>
                            </div>
                            <div class="col-6 border-dashed p-2">
                                <small class="d-block text-muted"><i class="fa fa-calendar"></i> Tanggal sampai :</small>
                                <label for="" class="d-block font-weight-bold m-0"><?= Modules::run('helper/date_indo', $data_bs->voyage_date_to, '-'); ?></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="col-12">
    <div class="card">
        <div class="card-body ">
            <div class="panel panel-primary tabs-style-3" style="border: none;">
                <div class="tab-menu-heading">
                    <div class="tabs-menu ">
                        <!-- Tabs -->
                        <ul class="nav panel-tabs">
                            <li class="">
                                <a href="<?= Modules::run('helper/create_url', 'booking/detail?data=' . urlencode($this->encrypt->encode($data_bs->id)) . '&act=booking-list'); ?>" class="<?= ($act == 'booking-list' || $act == '') ? 'active' : ''; ?> text-left">
                                    <i class="fa fa-file"></i> Detail Booking Slot
                                </a>
                            </li>

                            <li>
                                <a href="<?= Modules::run('helper/create_url', 'booking/detail?data=' . urlencode($this->encrypt->encode($data_bs->id)) . '&act=countainer-list') ?>" class="<?= ($act == 'countainer-list') ? 'active' : ''; ?> text-left">
                                    <i class="fa fa-cube"></i> Daftar Kontainer & LC
                                </a>
                            </li>
                            <li>
                                <a href="<?= Modules::run('helper/create_url', 'booking/detail?data=' . urlencode($this->encrypt->encode($data_bs->id)) . '&act=rilis-order') ?>" class="<?= ($act == 'rilis-order') ? 'active' : ''; ?> text-left">
                                    <i class="fa fa-file"></i> Rilis Order (RO)
                                </a>
                            </li>

                            <li>
                                <a href="<?= Modules::run('helper/create_url', 'booking/detail?data=' . urlencode($this->encrypt->encode($data_bs->id)) . '&act=bol') ?>" class="<?= ($act == 'bol') ? 'active' : ''; ?> text-left">
                                    <i class="fa fa-cube"></i> Bill Of Lading (BOL)
                                </a>
                            </li>
                            <li>
                                <a href="<?= Modules::run('helper/create_url', 'booking/detail?data=' . urlencode($this->encrypt->encode($data_bs->id)) . '&act=freight') ?>" class="<?= ($act == 'freight') ? 'active' : ''; ?> text-left">
                                    <i class="fa fa-file"></i> Daftar Invoice <b>( Freight, THC, & LC )</b>
                                </a>
                            </li>
                            <li>
                                <a href="<?= Modules::run('helper/create_url', 'booking/detail?data=' . urlencode($this->encrypt->encode($data_bs->id)) . '&act=activity') ?>" class="<?= ($act == 'activity') ? 'active' : ''; ?> text-left">
                                    <i class="fa fa-file"></i> Daftar Invoice <b>( Activity )</b>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <?php
                $act = $this->input->get('act');
                // $data['category_countainer']  = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'countainer_category'])->row()->value, TRUE);
                $data['category_stuffing']    = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_stuffing'])->row()->value, TRUE);
                // $data['category_teus']        = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_teus'])->row()->value, TRUE);

                if ($act == 'booking-list' || $act == '') {
                    $this->load->view('view_list_bs', $data);
                }
                if ($act == 'countainer-list') {
                    $this->load->view('view_list_countainer', $data);
                }

                if ($act == 'rilis-order') {
                    $get_ro = Modules::run('database/find', 'tb_booking_has_ro', ['id_booking' => $data_bs->id, 'status' => 1])->row();
                    if (!empty($get_ro)) {
                        $this->load->view('_partials/document_rilis_order', $data);
                    } else {
                        echo '
                        <div class="col-12 text-center border p-4">
                            <div class="plan-card text-center">
                                <i class="fas fa-file plan-icon text-primary"></i>
                                <h6 class="text-drak text-uppercase mt-2">Data Kosong</h6>
                                <small class="text-muted">Dokumen belum dibuat oleh admin.</small>
                            </div>
                        </div>
                    ';
                    }
                }
                if ($act == 'bol') {

                    $array_query  = [
                        'select' => '
                            tb_booking_has_countainer.*,
                            tb_booking.code AS booking_code,
                            tb_booking.date AS booking_date,
                            tb_booking_has_detail.id_category_load,
                            tb_booking_has_detail.id_category_stuff,
                            tb_booking_has_detail.category_countainer,
                            tb_booking_has_detail.category_teus,
                            tb_booking_has_detail.category_service,
                            tb_booking_has_detail.stuffing_take,
                            tb_booking_has_detail.stuffing_open,
                            tb_booking_has_detail.stuffing_take_address,
                            tb_booking_has_detail.stuffing_open_address,
                            mst_category_load.name AS category_load_name,
                            mst_category_stuff.name AS category_stuff_name,
                            mst_countainer.code AS countainer_code,
                            mst_countainer.barcode AS countainer_barcode
                            
                        ',
                        'from' => 'tb_booking_has_countainer',
                        'join' => [
                            'mst_countainer , tb_booking_has_countainer.id_countainer = mst_countainer.id , left',
                            'tb_booking , tb_booking_has_countainer.id_booking = tb_booking.id , left',
                            'tb_booking_has_detail , tb_booking_has_countainer.id_booking_detail = tb_booking_has_detail.id , left',
                            'mst_category_load, tb_booking_has_detail.id_category_load = mst_category_load.id , left',
                            'mst_category_stuff, tb_booking_has_detail.id_category_stuff = mst_category_stuff.id , left'
                        ],
                        'where' => [
                            'tb_booking_has_countainer.id_booking' => $data_bs->id
                        ]
                    ];
                    $get_data_countainer = Modules::run('database/get', $array_query)->result();
                    $data['data_countainer_bs'] = $get_data_countainer;

                    $array_query  = [
                        'select' => '
                            tb_booking_has_lc.*,
                            tb_booking.code AS booking_code,
                            tb_booking.date AS booking_date,
                            tb_booking_has_detail.id_category_load,
                            tb_booking_has_detail.id_category_stuff,
                            tb_booking_has_detail.category_countainer,
                            tb_booking_has_detail.category_teus,
                            tb_booking_has_detail.category_service,
                            tb_booking_has_detail.stuffing_take,
                            tb_booking_has_detail.stuffing_open,
                            tb_booking_has_detail.stuffing_take_address,
                            tb_booking_has_detail.stuffing_open_address,
                            tb_booking_has_detail.transport_description,
                            mst_category_stuff.name AS category_stuff_name,
                            mst_transportation.name AS transport_type_name
                            
                        ',
                        'from' => 'tb_booking_has_lc',
                        'join' => [
                            'tb_booking , tb_booking_has_lc.id_booking = tb_booking.id , left',
                            'tb_booking_has_detail , tb_booking_has_lc.id_booking_detail = tb_booking_has_detail.id , left',
                            'mst_category_stuff, tb_booking_has_detail.id_category_stuff = mst_category_stuff.id , left',
                            'mst_transportation, tb_booking_has_detail.id_transportation = mst_transportation.id , left'
                        ],
                        'where' => [
                            'tb_booking.id' => $data_bs->id
                        ]
                    ];
                    $get_data_lc = Modules::run('database/get', $array_query)->result();
                    $data['data_lc'] = $get_data_lc;

                    $this->load->view('_partials/document_bol', $data);
                }
                if ($act == 'freight') {
                    $this->load->view('_partials/component_preview_invoice', $data);
                }
                if ($act == 'activity') {
                    $this->load->view('_partials/list_invoice_activity', $data);
                }
                ?>
            </div>
        </div>
    </div>
</div>