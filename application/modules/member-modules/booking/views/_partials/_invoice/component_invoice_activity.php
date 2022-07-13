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
        'tb_booking_has_countainer.id_booking' => $data_bs->id
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

<div class="">
    <div class="invoice-header">
        <h1 class="invoice-title">Invoice ACTIVITY</h1>
        <div class="billed-from">
            <img style="width: 150px;" src="<?= base_url('upload/' . $company_logo); ?>" alt="">
            <h6 class="mt-1"><?= strtoupper($company_name); ?></h6>
            <p><?= $company_address; ?><br>
                Tel No: <?= $company_number_phone; ?><br>
                Email: <?= $company_email; ?></p>
        </div><!-- billed-from -->
    </div><!-- invoice-header -->
    <div class="row mg-t-20">
        <div class="col-md">
            <label class="tx-gray-600">Ditagihkan Kepada :</label>
            <div class="billed-to">
                <h6><?= strtoupper($data_bs->customer_name); ?></h6>
                <p>
                    <?= $data_bs->customer_address; ?>
                </p>
            </div>
        </div>
        <div class="col-md">
            <label class="tx-gray-600">Informasi Tagihan :</label>
            <p class="invoice-info-row"><span>No. Invoice</span> <span><?= $data_invoice->code; ?></span></p>
            <p class="invoice-info-row"><span>No. Booking</span> <span><?= $data_bs->code; ?></span></p>
            <p class="invoice-info-row"><span>No. Voyage</span> <span><?= $data_bs->voyage_code; ?></span></p>
            <p class="invoice-info-row"><span>Tanggal Invoice :</span> <span><?= Modules::run('helper/date_indo', $data_invoice->invoice_date, '-'); ?></span></p>
            <p class="invoice-info-row"><span>Jatuh Tempo :</span> <span><?= Modules::run('helper/date_indo', $data_invoice->due_date, '-'); ?></span></p>
        </div>
    </div>
    <div class="table-responsive mg-t-40">
        <table class="table table-invoice border text-md-nowrap mb-0">
            <thead>
                <tr>
                    <th style="width: 20px;" class="text-center">No</th>
                    <th style="width: 200px;" class="text-center">No.Kontainer</th>
                    <th class="text-center">Ukuran</th>
                    <th class="text-center">Tipe</th>
                    <th class="text-center">sts</th>
                    <th class="text-center">Aktifitas</th>
                    <th style="width: 200px;" class="text-center">Tgl. Mulai</th>
                    <th style="width: 200px;" class="text-center">Tgl. Akhir</th>
                    <th class="text-center">Item</th>
                    <th class="text-center">Tarif</th>
                    <th class="text-right">Total Tagihan</th>
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
                            'tb_booking_has_countainer_activity.id_invoice' => $data_invoice->id
                        ]
                    ];
                    $get_data_activity = Modules::run('database/get', $array_query)->result();
                    if (empty($get_data_activity)) {
                        continue;
                    }

                    $rowspan_number = count($get_data_activity) > 0 ? (count($get_data_activity) + 1) : 2;

                    $html_tr .= '
                            <tr>
                                <td class="text-center" style="width:20px;" rowspan="' . $rowspan_number . '">' . $counter . '</td>
                                <td class="text-center" rowspan="' . $rowspan_number . '">
                                    <label for="" class="m-0 d-block text-center font-weight-bold">' . $item_countainer->countainer_code . '</label>
                                </td>
                                <td class="text-center" style="width:20px;" rowspan="' . $rowspan_number . '">
                                    <label class=" m-0">' . $countainer_teus . '</label>
                                </td>
                                <td class="text-center" style="width:20px;" rowspan="' . $rowspan_number . '"><label class=" m-0 ">' .  strtoupper($countiner_type) . '</label></td>
                            </tr>
                        ';

                    if (!empty($get_data_activity)) {
                        foreach ($get_data_activity as $item_activity) {
                            $grand_total += $item_activity->total_price;

                            $label_status = isset($status_activity_transaction[$item_activity->status]) ? $status_activity_transaction[$item_activity->status] : '-';
                            $html_tr .= '
                                <tr>
                                    <td class="text-center">' .  strtoupper($label_status) . '</td>
                                    <td class="text-center" style="width:200px;">' . strtoupper($item_activity->activity_name) . '</td>
                                    <td class="text-center">
                                        <span><i class="fa fa-calendar"></i> ' . Modules::run('helper/change_date', $item_activity->date_from, '-') . '</span>
                                    </td>
                                    <td class="text-center">
                                        <span><i class="fa fa-calendar"></i> ' . Modules::run('helper/change_date', $item_activity->date_to, '-') . '</span>
                                    </td>
                                    <td class="text-center">
                                        <span>' . $item_activity->qty . '</span>
                                    </td>
                                    <td style="width:200px;" class="text-center">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text font-weight-bold">
                                                    Rp.
                                                </div>
                                            </div>
                                            <input value="' . number_format($item_activity->price, 0, '.', '.') . '" readonly class="form-control bg-white border-dashed" type="text">
                                        </div>
                                    </td>
                                    <td style="width:200px;" class="text-center">
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
                    }
                }
                echo $html_tr;

                ?>

                <tr>
                    <td class="valign-middle" colspan="7" rowspan="5">
                        <div class="invoice-notes">
                            <label class="main-content-label tx-13">Bank Transfer :</label>
                            <?php
                            $get_all_bank = Modules::run('database/find', 'mst_bank', ['isDeleted' => 'N'])->result();
                            foreach ($get_all_bank as $item_bank) {
                                echo '
                                <div class="row border-dashed justify-content-center align-items-center" style="width:400px;">
                                    <div class="col-3">
                                        <img src="' . base_url('upload/bank/' . $item_bank->image) . '" alt="">
                                    </div>
                                    <div class="col-9 text-center">
                                        <h2 class="m-0 p-0 font-weight-bold text-orange">' . $item_bank->account_number . '</h2>
                                        <label class="m-0">AN : ' . strtoupper($item_bank->account_owner) . '</label>
                                    </div>
                                </div>
                                ';
                            }
                            ?>
                        </div><!-- invoice-notes -->
                    </td>
                </tr>
                <tr>
                    <td class="tx-right" colspan="2">Subtotal</td>
                    <td class="tx-right font-weight-bold" colspan="2">Rp.<?= number_format($data_invoice->total_price, 0, '.', '.'); ?></td>
                </tr>
                <tr>
                    <td class="tx-right" colspan="2">PPN (<?= $data_invoice->ppn_value; ?>%)</td>
                    <td class="tx-right font-weight-bold" colspan="2">Rp.<?= number_format($data_invoice->ppn_price, 0, '.', '.'); ?></td>
                </tr>
                <tr>
                    <td class="tx-right tx-uppercase tx-bold tx-inverse" colspan="2">Total Tagihan</td>
                    <td class="tx-right font-weight-bold" colspan="2">
                        <h4 class="tx-primary tx-bold price_lc font-weight-bold">Rp.<?= number_format($data_invoice->grand_total_price, 0, '.', '.'); ?></h4>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>