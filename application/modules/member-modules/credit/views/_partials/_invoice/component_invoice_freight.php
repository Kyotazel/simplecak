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
        'id_booking' =>  $data_bs->id,
        'tb_booking_has_detail.type' => 1
    ],
    'join' => [
        'mst_category_load, tb_booking_has_detail.id_category_load = mst_category_load.id , left',
        'mst_category_stuff, tb_booking_has_detail.id_category_stuff = mst_category_stuff.id , left',
        'mst_transportation, tb_booking_has_detail.id_transportation = mst_transportation.id , left'
    ],
    'order_by' => 'tb_booking_has_detail.stuffing_take'
];
$data_detail_bs = Modules::run('database/get', $array_query_detail_bs)->result();
$array_detail_bs = [];
foreach ($data_detail_bs as $item_detail) {
    if (!isset($array_detail_bs[$item_detail->stuffing_take][$item_detail->category_teus][$item_detail->price])) {
        $array_detail_bs[$item_detail->stuffing_take][$item_detail->category_teus][$item_detail->price] = 0;
    }
    $array_detail_bs[$item_detail->stuffing_take][$item_detail->category_teus][$item_detail->price] += $item_detail->qty;
}

//invoice
$data_invoice  = [];
$discount_form = '';
$total_invoice = '';


$data_invoice = Modules::run('database/find', 'tb_invoice', ['id_booking' => $data_bs->id, 'type' => 1])->row();
$invoice_code['freight'] = $data_invoice->code;
$date_today = $data_invoice->invoice_date;
$due_date = $data_invoice->due_date;


?>
<div class="">
    <div class="invoice-header">
        <h1 class="invoice-title">Invoice FREIGHT</h1>
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
            <p class="invoice-info-row"><span>No. Invoice</span> <span><?= $invoice_code['freight']; ?></span></p>
            <p class="invoice-info-row"><span>No. Booking</span> <span><?= $data_bs->code; ?></span></p>
            <p class="invoice-info-row"><span>No. Voyage</span> <span><?= $data_bs->voyage_code; ?></span></p>
            <p class="invoice-info-row"><span>Tanggal Invoice :</span> <span><?= Modules::run('helper/date_indo', $date_today, '-'); ?></span></p>
            <p class="invoice-info-row"><span>Jatuh Tempo :</span> <span><?= Modules::run('helper/date_indo', $due_date, '-'); ?></span></p>
        </div>
    </div>
    <div class="table-responsive mg-t-40">
        <table class="table table-invoice">
            <thead>
                <tr>
                    <th class="wd-20p text-center">stuffing</th>
                    <th class="wd-40p text-center">H. Satuan</th>
                    <th class="text-center">qty</th>
                    <th class="text-center">SAT</th>
                    <th class="text-center">SIZE</th>
                    <th class="text-right" style="width: 200px;">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $grand_total = 0;
                foreach ($array_detail_bs as $cat_stuffing => $value_item) {
                    $row_value = count($value_item) + 1;
                    $stuffing_text = isset($category_stuffing[$cat_stuffing]) ? $category_stuffing[$cat_stuffing] : '';
                    echo '
                            <tr>
                                <td class="text-center" rowspan="' . $row_value . '">
                                    ' . strtoupper($stuffing_text) . '
                                </td>
                            </tr>

                        ';
                    foreach ($value_item as $cat_teus => $value_teus) {
                        $teus_text = isset($category_teus[$cat_teus]) ? $category_teus[$cat_teus] : '';
                        foreach ($value_teus as $price => $qty) {
                            $total = $price * $qty;
                            $grand_total += $total;
                            echo '
                                <tr>
                                    <td class="text-center">Rp.' . number_format($price, 0, '.', '.') . '</td>
                                    <td class="text-center">' . $qty . '</td>
                                    <td class="text-center">UNIT</td>
                                    <td class="text-center">' . $teus_text . '</td>
                                    <td class="text-right">Rp.' . number_format($total, 0, '.', '.') . '</td>
                                </tr>
                            ';
                        }
                    }
                }


                $ppn_price = $data_bs->ppn > 0 ? $grand_total * ($data_bs->ppn / 100) : 0;
                $grand_total += $data_bs->price_materai;
                $all_grand_total = $grand_total + $ppn_price;

                ?>
                <tr>
                    <td class="text-center">DOKUMEN & MATERAI</td>
                    <td colspan="4"></td>
                    <td class="tx-right">Rp.<?= number_format($data_bs->price_materai, 0, '.', '.'); ?></td>
                </tr>

                <tr>
                    <td class="valign-middle" colspan="2" rowspan="5">
                        <div class="invoice-notes">
                            <label class="main-content-label tx-13">Bank Transfer :</label>
                            <?php
                            $get_all_bank = Modules::run('database/find', 'mst_bank', ['isDeleted' => 'N'])->result();
                            foreach ($get_all_bank as $item_bank) {
                                echo '
                                <div class="row border-dashed justify-content-center align-items-center">
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
                    <td class="tx-right" colspan="2">Rp.<?= number_format($grand_total, 0, '.', '.'); ?></td>
                </tr>
                <tr>
                    <td class="tx-right" colspan="2">PPN (<?= $data_bs->ppn; ?>%)</td>
                    <td class="tx-right" colspan="2">Rp.<?= number_format($ppn_price, 0, '.', '.'); ?></td>
                </tr>
                <tr>
                    <td class="tx-right" colspan="2">Diskon </td>
                    <td class="tx-right" colspan="2">
                        <?php
                        if (!empty($data_invoice)) {
                            $discount_form = 'Rp' . number_format($data_invoice->discount_price, 0, '.', '.');
                        } else {
                            $discount_form = '
                                    <div class="input-group float-right" style="width: 200px;">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text font-weight-bold">
                                                Rp.
                                            </div>
                                        </div>
                                        <input value="0" class="form-control  font-weight-bold rupiah count_price_invoice bg-white" data-target="price_freight" data-ppn="' . $ppn_price . '" data-grandtotal="' . $grand_total . '" name="diskon_freight" type="text">
                                    </div>
                                ';
                        }

                        echo $discount_form;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="tx-right tx-uppercase tx-bold tx-inverse" colspan="2">Total Tagihan</td>
                    <td class="tx-right" colspan="2">
                        <?php
                        if (!empty($data_invoice)) {
                            $all_grand_total = $data_invoice->total_invoice;
                        }
                        ?>
                        <h4 class="tx-primary tx-bold price_freight" data-subtotal="<?= $grand_total; ?>" data-ppn="<?= $ppn_price; ?>" data-grandtotal="<?= $all_grand_total; ?>">Rp.<?= number_format($all_grand_total, 0, '.', '.'); ?></h4>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>