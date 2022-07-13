<?php

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
$data_detail_bs = Modules::run('database/get', $array_query_detail_bs)->result();

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
foreach ($data_detail_bs as $item_detail_bs) {
    if ($item_detail_bs->type == 1) {
        $countiner_type = isset($category_countainer[$item_detail_bs->category_countainer]) ? $category_countainer[$item_detail_bs->category_countainer] : '';
        $countainer_teus = isset($category_teus[$item_detail_bs->category_teus]) ? $category_teus[$item_detail_bs->category_teus] : 0;
        $service_type = isset($category_service[$item_detail_bs->category_service]) ? $category_service[$item_detail_bs->category_service] : '';
        $html_item_countainer .= '
            <div class="col-12 ">
                <div class="border-dashed rounded-3 p-2 row">
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
                <div class="border-dashed rounded-5 p-2 row">
                    <label for="" class="col-4 m-0 font-weight-bold border-right">
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
<div class="shadow-3 rounded-5 mb-2" style="border:none;">
    <div class="card-header bg-primary-gradient text-white row p-2">
        <div class="col-8 tx-16 d-flex align-items-center">
            <span class="font-weight-bold"><i class="fa fa-shopping-bag  tx-20"></i> Transaksi </span>
            <span class="mx-2"> <?= Modules::run('helper/date_indo', $data_bs->date, '-'); ?></span>
            <span class="badge badge-light text-capitalize px-4 py-1"><?= $status_voyage; ?></span>
            <span class="ml-3"><?= $data_bs->code; ?></span>
        </div>
        <div class="col-4 d-flex align-items-center tx-14">
            <label class="m-0 font-weight-bold mr-2" for="">Rute : </label>
            <label class="my-0 px-2 badge badge-pill badge-light tx-14 mx-3" for=""><i class="fa fa-map-marker"></i> <?= $data_bs->depo_from; ?> </label>
            <hr class="mx-1" style="width: 100px;border-top: 5px dotted ;">
            <i class="fa fa-arrow-circle-right"></i>
            <label class="my-0 px-2 badge badge-pill badge-light tx-14 mx-3" for=""><i class="fa fa-map-marker"></i> <?= $data_bs->depo_to; ?> </label>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class=" col-8 border-right p-0 ">
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
                            <h3 class="mb-1 font-weight-bold text-primary">Rp.' . number_format($data_bs->grand_total, 0, '.', '.') . '</h3>
                            <small class="d-block">Jumlah yang ditagihkan kepada customer include pajak & dokumen.</small>
                            <div class="d-flex mt-3">
                                <a href="' . Modules::run('helper/create_url', 'booking/detail?data=' . urlencode($this->encrypt->encode($data_bs->id))) . '" class="btn btn-round btn-warning-gradient btn-rounded font-weight-bold">Lihat Detail Transaksi <i class="fa fa-paper-plane"></i></a>
                            </div>
                            ';

                        if ($data_bs->status == 1 && $data_bs->is_confirm == 0) {
                            $time_reject =  json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'time_auto_reject_booking'])->row()->value, TRUE);
                            $date_expired = date('Y-m-d H:i:s', strtotime($data_bs->created_date . "+" . $time_reject . " days"));
                            $html_price = '
                                <label for="" class="m-o px-4 py-1 bg-primary font-weight-bold text-white rounded-30"><i class="fa fa-clock"></i> Menunggu Konfirmasi Admin</label>
                                <small class="d-block">Dibatalkan otomatis dalam waktu :</small>
                                <div class="row col-12 mb-1 countdown_ticket" data-date-now="" data-type="datetime" data-date-to="' . $date_expired . '">
                                    <div class="col-3 p-1 border rounded text-center">
                                        <h5 for="" class="p-0 m-0 text-danger text_day">-</h5>
                                        <small for="" class="d-block font-weight-bold">Hari</small>
                                    </div>
                                    <div class="col-3 p-1 border rounded text-center">
                                        <h5 for="" class="p-0 m-0 text-danger text_hour">-</h5>
                                        <small for="" class="d-block font-weight-bold">Jam</small>
                                    </div>
                                    <div class="col-3 p-1 border rounded text-center">
                                        <h5 for="" class="p-0 m-0 text-danger text_minute">-</h5>
                                        <small for="" class="d-block font-weight-bold">Menit</small>
                                    </div>
                                    <div class="col-3 p-1 border rounded text-center">
                                        <h5 for="" class="p-0 m-0 text-danger text_second">-</h5>
                                        <small for="" class="d-block font-weight-bold">Detik</small>
                                    </div>
                                </div>
                                <small class="d-block">Jumlah yang akan ditagihkan kepada customer sedang menunggu konfirmasi dari admin.</small>
                                <div class=" mt-3">
                                    <a href="javascript:void(0)" data-id="' . $data_bs->id . '" class="btn btn-round btn_cancel_order btn-light-gradient btn-rounded font-weight-bold">Batalkan Transaksi <i class="fa fa-paper-plane"></i></a>
                                </div>
                            ';
                        }

                        if ($data_bs->is_confirm == 2) {
                            $html_price = '
                                <div class="text-left">
                                    <h3 class="text-muted">PEMESANAN DIBATALKAN</h3>
                                    <label for="" class="d-block m-0 font-weight-bold"><i class="fa fa-envelope"></i> Catatan Pembatalan :</label>
                                    <div class="p-2 border-dashed col-12 rounded">
                                        ' . $data_bs->reject_note . '
                                    </div>
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