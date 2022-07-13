<?php
$html_item_icon = '';
$next_status = $data_detail->status + 1;
if ($data_detail->status == 9) {
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
        if ($key_status == $data_detail->status) {
            $active_status = ' <div class="dot-label bg-success mr-1"></div>';
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

$btn_close_ticket   = $data_detail->status == 1 ? Modules::run('security/edit_access', ' <a href="javascript:void(0)" data-id="' . $this->encrypt->encode($data_detail->id) . '" class="btn btn-warning-gradient btn-rounded btn_close_ticket"><i class="fa fa-door-closed"></i> Proses Ke pelayaran</a> ') : '';
$btn_cancel_voyage  = $data_detail->status == 1 ? Modules::run('security/edit_access', ' <a href="javascript:void(0)" data-id="' . $this->encrypt->encode($data_detail->id) . '" class="btn btn btn-light-gradient btn-rounded btn_cancel_voyage"><i class="fa fa-window-close"></i> Batalkan Voyage</a> ') : '';


$get_teus_filled = $this->db->select('SUM(total_teus) AS total_teus')->where(['is_confirm' => 1, 'id_voyage' => $data_detail->id])->get('tb_booking')->row();
$total_teus_filled = $get_teus_filled->total_teus ? $get_teus_filled->total_teus : 0;
$rest_teus = $data_detail->container_slot - $total_teus_filled;
$parcentage_fill = round(($rest_teus / $data_detail->container_slot) * 100);

$array_query_bs = [
    'select' => '
        tb_booking.*,
        mst_customer.name AS customer_name,
        mst_customer.address AS customer_address
    ',
    'from' => 'tb_booking',
    'where' => [
        'tb_booking.id_voyage' => $data_detail->id,
        'tb_booking.is_confirm' => 1
    ],
    'join' => [
        'mst_customer, tb_booking.id_customer = mst_customer.id , left'
    ]
];
$get_bs = Modules::run('database/get', $array_query_bs)->result();

$data['category_teus']   = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_teus'])->row()->value, TRUE);
$data['category_countainer']  = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'countainer_category'])->row()->value, TRUE);
$data['booking_status']  = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'booking_status'])->row()->value, TRUE);
$data['category_service']     = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_service'])->row()->value, TRUE);
$data['category_stuffing']    = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_stuffing'])->row()->value, TRUE);
?>
<div class="col-12">
    <div class="md-stepper-horizontal">
        <?= $html_item_icon; ?>
    </div>
</div>
<div class="row mt-2">
    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <h5 class="card-title col-4"><i class="fa fa-file"></i> No. Voyage : <b class="border-dashed p-2 text-primary"><?= $data_detail->code; ?></b></h5>
                        <div class="col-8 text-right">
                            <?php
                            echo $btn_cancel_voyage . '&nbsp;' . $btn_close_ticket;
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 row p-2">
                            <label class="col-12 m-0" for="" class="d-block">Rute Keberangkatan :</label>
                            <div class="col-6 border-dashed p-2">
                                <small class="d-block text-muted"><i class="fa fa-map"></i> Depo Awal :</small>
                                <label for="" class="d-block text-uppercase font-weight-bold"><?= $data_detail->depo_from; ?></label>
                            </div>
                            <div class="col-6 border-dashed p-2">
                                <small class="d-block text-muted"><i class="fa fa-map"></i> Depo Awal :</small>
                                <label for="" class="d-block font-weight-bold text-uppercase"><?= $data_detail->depo_to; ?></label>
                            </div>
                        </div>
                        <div class="col-4 row p-2">
                            <label class="col-12 m-0" for="" class="d-block">Tanggal Keberangkatan :</label>
                            <div class="col-6 border-dashed p-2">
                                <small class="d-block text-muted"><i class="fa fa-calendar"></i> Tanggal Berangkat :</small>
                                <label for="" class="d-block font-weight-bold"><?= Modules::run('helper/date_indo', $data_detail->date_from, '-'); ?></label>
                            </div>
                            <div class="col-6 border-dashed p-2">
                                <small class="d-block text-muted"><i class="fa fa-calendar"></i> Tanggal sampai :</small>
                                <label for="" class="d-block font-weight-bold"><?= Modules::run('helper/date_indo', $data_detail->date_to, '-'); ?></label>
                            </div>
                        </div>
                        <div class="col-4 row p-2">
                            <label class="col-12 m-0" for="" class="d-block">Tanggal Tiket :</label>
                            <div class="col-6 border-dashed p-2">
                                <small class="d-block text-muted"><i class="fa fa-calendar"></i> Tanggal Dibuka :</small>
                                <label for="" class="d-block font-weight-bold"><?= Modules::run('helper/date_indo', $data_detail->date_open, '-'); ?></label>
                            </div>
                            <div class="col-6 border-dashed p-2">
                                <small class="d-block text-muted"><i class="fa fa-calendar"></i> Tanggal Ditutup :</small>
                                <label for="" class="d-block font-weight-bold"><?= Modules::run('helper/date_indo', $data_detail->date_close, '-'); ?></label>
                            </div>
                        </div>
                        <div class="col-md-4 mt-3 border-right">
                            <div class="iconfont text-left">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title mb-3">Total BS (Booking Slot)</h4>
                                </div>
                                <div class="d-flex mb-0">
                                    <div class="">
                                        <h4 class="mb-1 font-weight-bold"><?= count($get_bs); ?><span class="text-success tx-13 ml-2">Nota</span></h4>
                                        <p class="mb-2 tx-12 text-muted">Total Tiket Booking Slot</p>
                                    </div>
                                    <div class="card-chart bg-primary-transparent brround ml-auto mt-0">
                                        <i class="typcn typcn-group-outline text-primary tx-24"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 mt-3 ">
                            <div class="iconfont text-left">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title mb-3">Total Pendapatan</h4>
                                </div>
                                <div class="d-flex mb-0">
                                    <div class="">
                                        <h4 class="mb-1 font-weight-bold">Rp. 150.000<span class="text-success tx-13 ml-2"></span></h4>
                                        <p class="mb-2 tx-12 text-muted">Kalkulasi total pendapatan dalam satu voyage</p>
                                    </div>
                                    <div class="card-chart bg-primary-transparent brround ml-auto mt-0">
                                        <i class="typcn typcn-plus-outline text-primary tx-24"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="col-4 d-flex">
            <div class="card  w-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa fa-ship"></i> Keterangan Kapal :</h5>
                    <div class="col-12">
                        <!-- <label class=" m-0" for="" class="d-block">Nama Kapal :</label> -->
                        <div class="border-dashed p-2 row d-flex">
                            <?php
                            $file = base_url('upload/ship/' . $data_detail->image_name);
                            ?>
                            <img class="img-sm mr-1" src="<?= $file; ?>" alt="">
                            <div class="ml-3 p-2">
                                <h5 class="text-uppercase"><?= $data_detail->ship_name; ?></h5>
                            </div>
                        </div>
                        <div class="mt-3 row">
                            <div class="col-8">
                                <div class="row">
                                    <div class="col">
                                        <label>Total Feet tersedia :</label>
                                        <div class="h3 mt-2 mb-2"><b><?= $rest_teus; ?></b><span class="text-success tx-13 ml-2">FEET</span></div>
                                    </div>
                                    <div class="col-auto align-self-center ">
                                        <div class="feature mt-0 mb-0">
                                            <i class="fe fe-box project bg-primary-transparent text-primary "></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="progress progress-sm h-1 mb-1">
                                        <div class="progress-bar bg-primary " style="width: <?= $parcentage_fill; ?>%;" role="progressbar"></div>
                                    </div>
                                    <small class="mb-0 text-muted">persentase Feet yang terdia<span class="float-right text-muted"><?= $parcentage_fill; ?>%</span></small>
                                </div>
                            </div>
                            <div class="col-4">
                                <label for="" class="d-block"><small>Kapasitas Feet Kapal: </small><br><b> <?= $data_detail->container_slot; ?> FEET</b></label>
                                <label for="" class="d-block"><small>Total Feet Terisi: </small><br> <b><?= $total_teus_filled; ?> FEET</b> </label>
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
                                    <li class=""><a href="#tab21" class="active" data-toggle="tab"><i class="fa fa-file"></i> Daftar Booking Slot</a></li>
                                    <!-- <li><a href="#tab22" data-toggle="tab"><i class="fa fa-cube"></i> Daftar Kontainer</a></li> -->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-9">
                    <div class="panel-body tabs-menu-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab21">
                                <?php
                                $data['data_voyage'] = $data_detail;

                                $data['data_bs'] = $get_bs;

                                $this->load->view('view_list_bs', $data);
                                ?>
                            </div>
                            <div class="tab-pane " id="tab22">
                                <?php
                                $this->load->view('view_list_countainer', $data);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" tabindex="-1" id="modal_form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Input Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </div>
            <div class="modal-body">
                <form id="form-data">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Catatan Pembatalan :</label>
                            <textarea name="note" class="form-control" id="" cols="30" rows="10"></textarea>
                            <span class="help-block notif_note"></span>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn_save_cancel"><i class="fa fa-paper-plane"></i> Simpan Data</button>
            </div>
        </div>
    </div>
</div>