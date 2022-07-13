<?php
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
        'tb_booking_has_countainer.id_booking' => $id_booking
    ]
];
$get_data_countainer = Modules::run('database/get', $array_query)->result();

$category_teus        = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_teus'])->row()->value, TRUE);
$category_countainer  = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'countainer_category'])->row()->value, TRUE);
$booking_status       = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'booking_status'])->row()->value, TRUE);
$category_service     = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_service'])->row()->value, TRUE);
$category_unit_lc     = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_unit_lc'])->row()->value, TRUE);
$status_activity_transaction     = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'status_activity_transaction'])->row()->value, TRUE);

?>
<div class="col-12">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="bg-primary-gradient text-white">
                <tr>
                    <th class="text-white" style="background: transparent;">No</th>
                    <th class="text-white" style="background: transparent;">No.Kontainer</th>
                    <th class="text-white" style="background: transparent;">Ukuran</th>
                    <th class="text-white" style="background: transparent;">Tipe</th>
                    <th class="text-white" style="background: transparent;">sts</th>
                    <th class="text-white" style="background: transparent;">Aktifitas</th>
                    <th class="text-white" style="background: transparent;">Tgl. Mulai</th>
                    <th class="text-white" style="background: transparent;">Tgl. Akhir</th>
                    <th class="text-white" style="background: transparent;">Item</th>
                    <th class="text-white" style="background: transparent;">Tarif</th>
                    <th class="text-white" style="background: transparent;">Total Tagihan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $html_tr  = '';
                $counter = 0;
                $grand_total = 0;
                foreach ($get_data_countainer as $item_countainer) {
                    $countiner_type = isset($category_countainer[$item_countainer->category_countainer]) ? $category_countainer[$item_countainer->category_countainer] : '';
                    $countainer_teus = isset($category_teus[$item_countainer->category_teus]) ? $category_teus[$item_countainer->category_teus] : 0;
                    $counter++;

                    //get activity
                    $array_query = [
                        'select' => '
                            tb_booking_has_countainer_activity.*,
                            tb_category_activity.name AS activity_name
                        ',
                        'from' => 'tb_booking_has_countainer_activity',
                        'join' => [
                            'tb_category_activity, tb_booking_has_countainer_activity.id_activity_booking = tb_category_activity.id , left'
                        ],
                        'where' => [
                            'tb_booking_has_countainer_activity.id_booking_countainer' => $item_countainer->id,
                            'tb_booking_has_countainer_activity.id_invoice' => 0
                        ]
                    ];
                    $get_data_activity = Modules::run('database/get', $array_query)->result();

                    $rowspan_number = count($get_data_activity) > 0 ? (count($get_data_activity) + 1) : 2;

                    $html_tr .= '
                            <tr>
                                <td style="width:20px;" rowspan="' . $rowspan_number . '">' . $counter . '</td>
                                <td rowspan="' . $rowspan_number . '">
                                    <label for="" class="m-0 d-block text-center font-weight-bold">' . $item_countainer->countainer_code . '</label>
                                    <div class="border-dashed text-center p-1">
                                        <img style="width:40px;" src="' . base_url('upload/barcode/' . $item_countainer->countainer_code . '.png') . '" alt="">
                                        <small class="text-mdi-tab-unselected d-block"><i class="fa fa-info-circle"></i> ID kontainer</small>
                                    </div>
                                </td>
                                <td style="width:20px;" rowspan="' . $rowspan_number . '">
                                    <label class="badge badge-light m-0 tx-16">' . $countainer_teus . '</label>
                                </td>
                                <td style="width:20px;" rowspan="' . $rowspan_number . '"><label class="badge badge-light m-0 tx-16">' .  strtoupper($countiner_type) . '</label></td>
                            </tr>
                        ';

                    if (!empty($get_data_activity)) {
                        foreach ($get_data_activity as $item_activity) {
                            $grand_total += $item_activity->total_price;

                            $label_status = isset($status_activity_transaction[$item_activity->status]) ? $status_activity_transaction[$item_activity->status] : '-';
                            $html_tr .= '
                                <tr>
                                    <td>' .  strtoupper($label_status) . '</td>
                                    <td style="width:200px;">' . strtoupper($item_activity->activity_name) . '</td>
                                    <td>
                                        <span><i class="fa fa-calendar"></i> ' . Modules::run('helper/change_date', $item_activity->date_from, '-') . '</span>
                                    </td>
                                    <td>
                                        <span><i class="fa fa-calendar"></i> ' . Modules::run('helper/change_date', $item_activity->date_to, '-') . '</span>
                                    </td>
                                    <td>
                                        <span>' . $item_activity->qty . '</span>
                                    </td>
                                    <td style="width:200px;">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text font-weight-bold">
                                                    Rp.
                                                </div>
                                            </div>
                                            <input value="' . number_format($item_activity->price, 0, '.', '.') . '" readonly class="form-control bg-white border-dashed" type="text">
                                        </div>
                                    </td>
                                    <td style="width:200px;">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text font-weight-bold">
                                                    Rp.
                                                </div>
                                            </div>
                                            <input value="' . number_format($item_activity->total_price, 0, '.', '.') . '" readonly class="form-control bg-white border-dashed" type="text">
                                        </div>
                                    </td>
                                </tr>
                            ';
                        }
                    } else {
                        $html_tr .= '
                                <tr>
                                    <td colspan="7">
                                        <div class="p-2 text-center d-flex justify-content-center align-items-center">
                                            <div class="feature widget-2 text-center mt-0">
                                                <i class="ti-files project bg-primary-transparent mx-auto text-primary "></i>
                                            </div>
                                            <div class="plan-card text-center pl-3">
                                                <small class="text-muted text-uppercase mt-2">Tidak Ada Data</small>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            ';
                    }
                }
                echo $html_tr;


                ?>
                <tr>
                    <td colspan="10" class="text-right">
                        <label for="">Total</label>
                    </td>
                    <td>
                        <h4 class="font-weight-fold">Rp.<?= number_format($grand_total, 0, '.', '.'); ?></h4>
                    </td>
                </tr>
                <tr>
                    <td colspan="10" class="text-right">
                        <label for="">PPN / Tax</label>
                    </td>
                    <td>
                        <select class="form-control tax-price-activity">
                            <option value="0">Tidak ada</option>
                            <option value="1">1 %</option>
                            <option value="10">10 %</option>
                        </select>
                        <label for="" class="tax-value mt-1 d-block m-0">Rp.0</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="10" class="text-right">
                        <label for="">Grand Total</label>
                    </td>
                    <td class="">
                        <h4 class="text-primary font-weight-bold text-grandtotal-price" data-price="<?= $grand_total; ?>">Rp.<?= number_format($grand_total, 0, '.', '.'); ?></h4>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="mt-2 text-center p-4">
    <div class="d-flex flex-wrap justify-content-center mb-3">

        <div class="col-8 p-2 border-dashed d-block">
            <h4 class="text-center"><i class="fa fa-bullhorn"></i> Pemberitahuan</h4>
            <p class="text-left tx-12">
                Jika anda melakukan penyimpanan invoice , maka data invoice akan disimpan kedalam data piutang dan menjadi invoice yang harus dibayar oleh Customer. <br>
                proses penyimpanan ini tidak dapat Dibatalkan, maka pastikan data sudah benar sebelum melakukan penyimpanan data.
            </p>
        </div>
    </div>
    <div class="text-center">
        <label class=""><input type="checkbox" value="1" name="agreement"><span> Saya telah mengerti dan setuju untuk melanjutkan pembuatan invoice </span> <span class="text-danger notif_aggreement"></span></label>
    </div>
    <a href="javascript:void(0)" data-id="<?= $id_booking; ?>" class="btn btn-warning-gradient btn_save_invoice_activity btn-lg  btn-rounded font-weight-bold"><i class="fa fa-paper-plane"></i> Buat Invoice Sekarang</a>
    <small class="text-muted d-block mt-2">( <i class="fa fa-info-circle"></i> Invoice akan disimpan ke data piutang )</small>
</div>