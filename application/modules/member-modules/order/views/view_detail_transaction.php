<?php
// $array = [
//     1 => 'menunggu konfirmasi',
//     2 => 'dikonfirmasi admin',
//     3 => 'Kontainer telah telah dipilih',
//     4 => 'kontainer telah ditimbang',
//     5 => 'kapal berangkat',
//     6 => 'kapal telah telah sampai',
//     7 => 'kontainer telah di pelabuhan tujuan',
//     8 => 'kontainer siap diambil',
//     9 => 'selesai',
//     10 => 'booking dibatalkan'
// ];
// print_r(json_encode($array));

$html_item_countainer = '';
$total_teus = 0;
$total_qty_countainer = 0;
foreach ($data_detail_bs as $item_bs) {
    $countiner_type = isset($category_countainer[$item_bs->category_countainer]) ? $category_countainer[$item_bs->category_countainer] : '';
    $countainer_teus = isset($category_teus[$item_bs->category_teus]) ? $category_teus[$item_bs->category_teus] : 0;
    $total_teus += ($countainer_teus * $item_bs->qty);
    $total_qty_countainer += $item_bs->qty;
    if ($item_bs->type == 1) {
        $html_item_countainer .= '
            <div class="p-1 border-dashed rounded row">
                <label for="" class="col-9 m-0 font-weight-bold">
                    ' . strtoupper($countiner_type) . ' (' . strtoupper($countainer_teus) . ' TEUS)
                </label>
                <label for="" class="col-3 m-0 h4">x ' . $item_bs->qty . '</label>
                <small class="d-block col-12">
                    <span class="text-muted"><i class="fa fa-circle"></i> Jenis : </span> KONTAINER
                </small>
                <small class="d-block col-12">
                    <span class="text-muted"><i class="fa fa-circle"></i> Barang : </span> ' . strtoupper($item_bs->category_load_name) . ' - ' . strtoupper($item_bs->category_stuff_name) . '
                </small>
            </div>
        ';
    } else {
        $html_item_countainer .= '
        <div class="p-1 border-dashed rounded row">
            <label for="" class="col-9 m-0 font-weight-bold">
                ' . strtoupper($item_bs->transport_name) . '
            </label>
            <label for="" class="col-3 m-0 h4">x ' . $item_bs->qty . '</label>
            <small class="d-block col-12">
                <span class="text-muted"><i class="fa fa-circle"></i> Jenis : </span> LOSS CARGO
            </small>
            <small class="d-block col-12">
                <span class="text-muted"><i class="fa fa-circle"></i> Barang : </span> ' . strtoupper($item_bs->category_load_name) . ' - ' . strtoupper($item_bs->category_stuff_name) . '
            </small>
        </div>
    ';
    }
}


$html_item_icon = '';

if ($data_voyage->status == 9) {
    foreach ($get_list_status as $key_status => $value_status) {
        $icon           = isset($list_status_icon[$key_status]) ? $list_status_icon[$key_status] : '';
        $text_status    = isset($list_status[$key_status]) ? $list_status[$key_status] : '';
        $time = Modules::run('helper/datetime_indo', $value_status['date']);
        $html_item_icon .= '
        <div class="align-items-center item d-flex row border-bottom p-0">
            <div class="col-12">
                <div class="">
                    <h6 class="text-uppercase text-primary">
                        <i class="fa-lg ' . $icon . ' project bg-primary-transparent  mx-auto "></i> ' . $text_status . '
                    </h6>
                    
                </div>
            </div>
            <div class="col-12">
                <small class="my-auto  d-block">' . $value_status['description'] . '</small>
            </div>
            <div class="col-12">
                <b><small class="my-auto  d-block">' . $time . '</small></b>
            </div>
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
        $description = '-';
        $date_time = '-';
        $text_muted = 'text-muted';
        $active_status = '';
        if (isset($get_list_status[$key_status])) {
            $class_text = 'text-primary font-weight-bold ';
            $class_bg = 'bg-primary-transparent';
            $description = $get_list_status[$key_status]['description'];
            $date_time = Modules::run('helper/datetime_indo', $get_list_status[$key_status]['date']);
            $text_muted = '';
            $active_status = '
                <i class="fa fa-check text-success position-absolute" style="right:0;"></i>
            ';
        }
        if ($key_status == $data_voyage->status) {
            $active_status = ' <div class="dot-label bg-success mr-1"></div>';
        }
        $html_item_icon .= '
            <div class="align-items-center item d-flex row border-bottom p-2">
                <div class="col-12 position-relative">
                    <div class="">
                    ' . $active_status . '
                        <h6 class="text-uppercase ' . $class_text . '">
                        <i class="fa-lg ' . $icon . ' project ' . $class_bg . ' mx-auto "></i> ' . $value_status . '
                        </h6>
                        
                    </div>
                </div>
                <div class="col-12">
                    <small class="my-auto ' . $text_muted . ' d-block">KET : ' . $description . '</small>
                </div>
                <div class="col-12">
                    <small class="my-auto font-weight-bold ' . $text_muted . ' d-block">TGL : ' . $date_time . '</small>
                </div>
            </div>
        ';
    }
}
$html_status = '';
if ($data_bs->is_confirm == 0) {
    $html_status = '
    <div class="alert alert-warning bg-warning-gradient text-white text-center p-2 rounded-30 mt-3 font-weight-bold" role="alert">
        <i class="fa fa-clock"></i> Menunggu Konfirmasi Admin
    </div>
    ';
}

if ($data_bs->is_confirm == 1) {
    $html_status = '
    <div class="alert alert-success mt-3 font-weight-bold" role="alert">
        <i class="fa fa-check"></i> Telah Dikonfirmasi admin
    </div>
    ';
}
if ($data_bs->is_confirm == 2) {
    $html_status = '
        <div class="alert alert-danger mt-3 text-center font-weight-bold m-0" role="alert">
            <i class="fa fa-window-close"></i> Ditolak oleh admin
        </div>
        <small class="text-muted">Catatan pembatalan :</small>
        <div class="p-2 border-dashed tx-12">' . $data_bs->reject_note . '</div>
    ';
}

?>
<div class="row mt-2">
    <div class="row">
        <div class="col-5 d-flex">
            <div class="card">
                <div class="row">
                    <div class="col-12 card-header bg-primary-gradient text-white">
                        <h5 class="card-title col-12 text-white"><i class="fa fa-file"></i> No. Voyage : <b class="border-dashed p-2 "><?= $data_voyage->code; ?></b></h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 row p-2">
                            <label class="col-12 m-0" for="" class="d-block">Rute Keberangkatan :</label>
                            <div class="col-6 border-dashed p-2">
                                <small class="d-block text-muted"><i class="fa fa-map"></i> Depo Awal :</small>
                                <label for="" class="d-block text-uppercase font-weight-bold m-0"><?= $data_voyage->depo_from; ?></label>
                            </div>
                            <div class="col-6 border-dashed p-2">
                                <small class="d-block text-muted"><i class="fa fa-map"></i> Depo Awal :</small>
                                <label for="" class="d-block font-weight-bold text-uppercase m-0"><?= $data_voyage->depo_to; ?></label>
                            </div>
                        </div>
                        <div class="col-6 row p-2">
                            <label class="col-12 m-0" for="" class="d-block">Tanggal Keberangkatan :</label>
                            <div class="col-6 border-dashed p-2">
                                <small class="d-block text-muted"><i class="fa fa-calendar"></i> Tanggal Berangkat :</small>
                                <label for="" class="d-block font-weight-bold m-0"><?= Modules::run('helper/date_indo', $data_voyage->date_from, '-'); ?></label>
                            </div>
                            <div class="col-6 border-dashed p-2">
                                <small class="d-block text-muted"><i class="fa fa-calendar"></i> Tanggal sampai :</small>
                                <label for="" class="d-block font-weight-bold m-0"><?= Modules::run('helper/date_indo', $data_voyage->date_to, '-'); ?></label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="border-dashed p-2 row d-flex">
                                <?php
                                $file = base_url('upload/ship/' . $data_voyage->image_name);
                                ?>
                                <img class="img-sm mr-1" src="<?= $file; ?>" alt="">
                                <div class="ml-3 p-2">
                                    <h5 class="text-uppercase"><?= $data_voyage->ship_name; ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="panel panel-default  mt-2 position-relative">
                                <div class="accor bg-primary ">
                                    <h5 class="panel-title1">
                                        <a style="font-size:13px;" class="accordion-toggle collapsed p-2" data-toggle="collapse" data-parent="#detail_tracking" href="#detail_tracking" aria-expanded="false">
                                            <i class="fas fa-angle-down mr-2"></i> Tracking Status Voyage
                                        </a>
                                    </h5>
                                </div>
                                <div id="detail_tracking" class="panel-collapse collapse in  bg-white" style="z-index:1000;" role="tabpanel" aria-expanded="false">
                                    <div class="panel-body border">
                                        <div class="browser-stats">
                                            <?= $html_item_icon; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-7">
            <div class="card">
                <div class="card-header bg-primary-gradient">
                    <div class="row">
                        <h5 class="card-title col-8 text-white"><i class="fa fa-file"></i> No. Booking : <b class="border-dashed p-2 "><?= $data_bs->code; ?></b></h5>
                        <div class="col-4">
                        </div>
                    </div>

                </div>

                <div class="card-body">
                    <div class="col-12">
                        <!-- <label class=" m-0" for="" class="d-block">Nama Kapal :</label> -->
                        <div class="mt-1 row">
                            <div class="col-md-7 row p-1">
                                <label class="font-weight-bold"><i class="fa fa-user"></i> Data Customer :</label>
                                <div class="row col-12 border-dashed">
                                    <div class="col">
                                        <div class="h3 mt-2 mb-2 text-primary"><b><?= $data_bs->customer_name; ?></b></div>
                                        <p class="tx-12"><?= $data_bs->customer_address; ?></p>
                                    </div>
                                    <div class="col-auto align-self-center ">
                                        <div class="feature mt-0 mb-0">
                                            <i class="fe fe-user project bg-primary-transparent text-primary "></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-7 border-dashed p-2">
                                    <small class="text-muted"><i class="fa fa-calendar"></i> Tanggal Booking: </small>
                                    <label for="" class="d-block font-weight-bold m-0"><b> <?= Modules::run('helper/date_indo', $data_bs->date, '-'); ?></b></label>
                                </div>
                                <div class="col-3 border-dashed p-2">
                                    <small class="text-muted"><i class="fa fa-box"></i> Total Qty: </small>
                                    <label for="" class="d-block font-weight-bold m-0 h4"><b><?= $total_qty_countainer; ?></b> </label>
                                </div>
                                <div class="col-2 border-dashed p-2">
                                    <small class="text-muted"><i class="fa fa-box"></i> Teus: </small>
                                    <label for="" class="d-block font-weight-bold m-0 h4"><b><?= $total_teus; ?></b> </label>
                                </div>
                                <div class="row col-md-12 border-dashed d-block p-2">
                                    <small class="text-muted d-block"><i class="fa fa-message-alt"></i> Pesan: </small>
                                    <p class="d-block"><?= $data_bs->note; ?></p>
                                </div>
                            </div>
                            <div class="col-md-5 p-1">
                                <label class="font-weight-bold"><i class="fa fa-box"></i> Data Detail BS :</label>
                                <?= $html_item_countainer; ?>
                                <?= $html_status; ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-12 mb-4">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-3">
                    <div class="panel panel-primary tabs-style-4" style="margin-bottom: 100px;">
                        <div class="tab-menu-heading w-100">
                            <label for="">Resume Transaksi Pelayaran : </label>
                            <div class="tabs-menu ">
                                <ul class="nav panel-tabs mr-3">
                                    <li class="text-left"><a href="#tab21" class="active text-left" data-toggle="tab"><i class="fa fa-file"></i> Harga Detail (BS)</a></li>
                                    <li><a href="#tab22" class="text-left" data-toggle="tab"><i class="fa fa-cube"></i> Daftar Kontainer</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-9  html_respon_detail">
                    <div class="panel-body tabs-menu-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab21">
                                <?php
                                $data['id_depo_from'] = $data_voyage->id_depo_from;
                                $data['data_bs'] = $data_bs;
                                $data['data_detail_bs'] = $data_detail_bs;
                                $data['category_countainer'] = $category_countainer;
                                $data['category_teus'] = $category_teus;
                                $data['category_stuffing'] = $category_stuffing;
                                $data['category_service'] = $category_service;
                                $this->load->view('view_detail_booking', $data);
                                ?>
                            </div>
                            <div class="tab-pane " id="tab22">
                                <?php
                                $this->load->view('view_detail_countainer', $data);
                                ?>
                            </div>
                            <div class="tab-pane" id="tab23">
                                <?php
                                $this->load->view('view_invoice');
                                ?>
                            </div>
                            <div class="tab-pane" id="tab24">
                                <p>On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.</p>
                                <p>On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.</p>
                                <p class="mb-0">Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>