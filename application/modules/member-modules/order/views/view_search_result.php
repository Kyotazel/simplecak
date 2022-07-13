<div class="col-12 mb-3">
    <i class="fa fa-info-circle"></i> Daftar Jadwal tersedia :
</div>
<?php
foreach ($data_voyage as $item_voyage) {
    $file = base_url('upload/ship/' . $item_voyage->image_name);

    $get_teus_filled = $this->db->select('SUM(total_teus) AS total_teus')->where(['is_confirm' => 1, 'id_voyage' => $item_voyage->id])->get('tb_booking')->row();
    $total_teus_filled = $get_teus_filled->total_teus ? $get_teus_filled->total_teus : 0;
    $rest_teus = $item_voyage->container_slot - $total_teus_filled;
    $parcentage_fill = round(($rest_teus / $item_voyage->container_slot) * 100);
    echo '
            <div class="col-12 border p-3 rounded mb-3 shadow-2">
                <div class="row">
                    <h5 class="card-title col-4"><i class="fa fa-file"></i> No. Voyage : <b class="border-dashed p-2 text-primary" style="font-size: 20px;">' . $item_voyage->code . '</b></h5>
                    <div class="col-8 text-right">
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 row p-2">
                        <label class="col-12 m-0 p-0 font-weight-bold" for="" class="d-block">Rute Keberangkatan :</label>
                        <div class="col-6 border-dashed p-2">
                            <small class="d-block text-muted"><i class="fa fa-map"></i> Depo Awal :</small>
                            <label for="" class="d-block text-uppercase font-weight-bold">' . $item_voyage->depo_from . '</label>
                        </div>
                        <div class="col-6 border-dashed p-2">
                            <small class="d-block text-muted"><i class="fa fa-map"></i> Depo Awal :</small>
                            <label for="" class="d-block font-weight-bold text-uppercase">' . $item_voyage->depo_to . '</label>
                        </div>
                    </div>
                    <div class="col-4 row p-2">
                        <label class="col-12 m-0 p-0 font-weight-bold" for="" class="d-block">Tanggal Keberangkatan :</label>
                        <div class="col-6 border-dashed p-2">
                            <small class="d-block text-muted"><i class="fa fa-calendar"></i> Tanggal Berangkat :</small>
                            <label for="" class="d-block font-weight-bold">' . Modules::run('helper/date_indo', $item_voyage->date_from, '-') . '</label>
                        </div>
                        <div class="col-6 border-dashed p-2">
                            <small class="d-block text-muted"><i class="fa fa-calendar"></i> Tanggal sampai :</small>
                            <label for="" class="d-block font-weight-bold">' . Modules::run('helper/date_indo', $item_voyage->date_to, '-') . '</label>
                        </div>
                    </div>
                    <div class="col-4 row p-2">
                        <label class="col-12 m-0 p-0 font-weight-bold" for="" class="d-block">Tanggal Tiket :</label>
                        <div class="col-6 border-dashed p-2">
                            <small class="d-block text-muted"><i class="fa fa-calendar"></i> Tanggal Dibuka :</small>
                            <label for="" class="d-block font-weight-bold">' . Modules::run('helper/date_indo', $item_voyage->date_open, '-') . '</label>
                        </div>
                        <div class="col-6 border-dashed p-2">
                            <small class="d-block text-muted"><i class="fa fa-calendar"></i> Tanggal Ditutup :</small>
                            <label for="" class="d-block font-weight-bold">' . Modules::run('helper/date_indo', $item_voyage->date_close, '-') . '</label>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3 border-right">
                        <label class="col-12 m-0 p-0 font-weight-bold" for="" class="d-block">Keterangan Kapal :</label>
                        <div class="border-dashed p-2 row d-flex">
                            <img class="img-sm mr-1" src="' . $file . '" alt="">
                            <div class="ml-3 p-2">
                                <h5 class="text-uppercase">' . $item_voyage->ship_name . '</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 mt-3 border-right row">
                        <div class="col-8">
                            <div class="row">
                                <div class="col">
                                    <label>Tersedia :</label>
                                    <div class="h3 mt-2 mb-2"><b>' . $rest_teus . '</b><span class="text-success tx-13 ml-2">FEET</span></div>
                                </div>
                                <div class="col-auto align-self-center ">
                                    <div class="feature mt-0 mb-0">
                                        <i class="fe fe-box project bg-primary-transparent text-primary "></i>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div class="progress progress-sm h-1 mb-1">
                                    <div class="progress-bar bg-primary " style="width:' . $parcentage_fill . '%" role="progressbar"></div>
                                </div>
                                <small class="mb-0 text-muted">persentase teus tersedia<span class="float-right text-muted">' . $parcentage_fill . '%</span></small>
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="" class="d-block"><small>Total Teus kapal: </small><br><b> ' . number_format($item_voyage->container_slot, 0, '.', '.') . ' FEET</b></label>
                            <label for="" class="d-block"><small>Total Teus Terisi: </small><br> <b>' . number_format($total_teus_filled, 0, '.', '.') . ' FEET</b> </label>
                        </div>
                    </div>
                    <div class="col-md-3 mt-3 div_action">
                        <div class="row mb-1 countdown_ticket" data-date-now="' . date('Y-m-d') . '" data-date-to="' . $item_voyage->date_close . '">
                            <div class="col-3 p-1 border rounded text-center">
                                <h5 for="" class="p-0 m-0 text-danger text_day">--</h5>
                                <small for="" class="d-block font-weight-bold">Hari</small>
                            </div>
                            <div class="col-3 p-1 border rounded text-center">
                                <h5 for="" class="p-0 m-0 text-danger text_hour">--</h5>
                                <small for="" class="d-block font-weight-bold">Jam</small>
                            </div>
                            <div class="col-3 p-1 border rounded text-center">
                                <h5 for="" class="p-0 m-0 text-danger text_minute">--</h5>
                                <small for="" class="d-block font-weight-bold">Menit</small>
                            </div>
                            <div class="col-3 p-1 border rounded text-center">
                                <h5 for="" class="p-0 m-0 text-danger text_second">--</h5>
                                <small for="" class="d-block font-weight-bold">Detik</small>
                            </div>
                        </div>
                        <a href="' . Modules::run('helper/create_url', 'order/transaction?data=' . urlencode($this->encrypt->encode($item_voyage->id))) . '" class="btn btn-block btn-primary-gradient"><i class="fa fa-paper-plane"></i> Booking Sekarang</a>
                    </div>
                </div>
            </div>
        ';
}

if (empty($data_voyage)) {
    echo '
        <div class="col-12">
            <div class=" h-100 text-center">
                <img src="' . base_url('assets/themes/valex/') . 'img/svgicons/note_taking.svg" alt="" class="wd-35p">
                <h5 class="mg-b-10 mg-t-15 tx-18 text-muted">Tidak ada jadwal kapal ditemukan</h5>
            </div>
        </div>
    ';
}
