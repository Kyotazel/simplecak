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
        mst_countainer.barcode AS countainer_barcode,
        mst_customer.name AS customer_name
        
    ',
    'from' => 'tb_booking_has_countainer',
    'join' => [
        'mst_countainer , tb_booking_has_countainer.id_countainer = mst_countainer.id , left',
        'tb_booking , tb_booking_has_countainer.id_booking = tb_booking.id , left',
        'tb_booking_has_detail , tb_booking_has_countainer.id_booking_detail = tb_booking_has_detail.id , left',
        'mst_category_load, tb_booking_has_detail.id_category_load = mst_category_load.id , left',
        'mst_category_stuff, tb_booking_has_detail.id_category_stuff = mst_category_stuff.id , left',
        'mst_customer, tb_booking.id_customer = mst_customer.id , left'
    ],
    'where' => [
        'tb_booking.is_confirm' => 1,
        'tb_booking.id_voyage' => $data_voyage->id
    ]
];
$get_data_countainer = Modules::run('database/get', $array_query)->result();
?>


<div class="text-right mb-1">
    <a href="javascript:void(0)" class="btn btn-primary"><i class="fa fa-print"></i> Cetak Dokumen</a>
</div>
<div id="div_print">


    <style>
        p {
            margin-top: 2px;
            margin-bottom: 2px
        }

        @media print {
            footer {
                page-break-after: always;
            }
        }

        tr.border-bottom td {
            border-bottom: 1pt solid black;
        }

        tr.content td {
            font-size: 12px;
        }

        #table-content {
            border-collapse: separate;
            border-spacing: 0 0.3em;
        }
    </style>
    <table border="1" style="width:100%">
        <tbody>
            <tr>
                <td rowspan="2">
                    <table>
                        <tbody>
                            <tr>
                                <td style="vertical-align: top;">
                                    <img src="<?= base_url('upload/' . $company_logo); ?>" style="max-height:50px">
                                </td>
                                <td>
                                    <div style="margin-left:7px">
                                        <h3 style="margin-bottom:2px;margin-top:2px"><strong><?= strtoupper($company_name); ?></strong></h3>
                                        <p style="font-size:12px"><?= strtoupper($company_address); ?></p>
                                        <p style="font-size:12px">Telp. <?= $company_number_phone; ?> &nbsp;&nbsp;&nbsp;&nbsp;Fax <?= $company_fax; ?></p>
                                        <p style="font-size:12px"><?= $company_city; ?></p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td rowspan="2" style="vertical-align:middle" align="middle">
                    <h3 style="margin-left:7px;margin-right:7px"><strong>Loading List</strong></h3>
                </td>
                <td rowspan="2" style="vertical-align:top">
                    <table style="font-size:14px">
                        <tbody>
                            <tr>
                                <td>Kapal</td>
                                <td>:</td>
                                <td><?= strtoupper($data_voyage->ship_name); ?></td>
                            </tr>
                            <tr>
                                <td>Voy</td>
                                <td>:</td>
                                <td><?= strtoupper($data_voyage->code); ?></td>
                            </tr>
                            <tr>
                                <td>Rute</td>
                                <td>:</td>
                                <td><?= $data_voyage->depo_from . ' - ' . $data_voyage->depo_to; ?> </td>
                            </tr>
                            <tr>
                                <td style="width: 40%;white-space: nowrap;">Tanggal Etd</td>
                                <td>:</td>
                                <td><?= Modules::run('helper/date_indo', $data_voyage->date_from, '-'); ?></td>
                            </tr>
                            <tr>
                                <td>Tanggal Eta</td>
                                <td>:</td>
                                <td><?= Modules::run('helper/date_indo', $data_voyage->date_to, '-'); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>

            </tr>
            <tr>
                <td colspan="3">
                    <table style="width:100%" id="table-content">
                        <tbody>
                            <tr class="border-bottom">
                                <td align="center" style="width:5%">No</td>
                                <td align="center" style="width:15%">Container</td>
                                <td align="center" style="width:5%">Qty</td>
                                <td align="center">Barang</td>
                                <td align="center">Kepemilikan</td>
                                <td align="center" style="width:15%">Segel</td>
                                <td align="center" style="width:5%">40</td>
                                <td align="center" style="width:5%">20</td>
                                <td align="center" style="width:5%">Stuffing</td>
                            </tr>
                            <tr>
                            </tr>
                            <?php
                            $counter = 0;
                            foreach ($get_data_countainer as $item_countainer) {
                                $counter++;
                                $teus_20 = '';
                                $teus_40 = '';
                                if ($item_countainer->category_countainer == 1) {
                                    $teus_20 = ' <i class="fa fa-check"></i> ';
                                    $teus_40 = '-';
                                } else {
                                    $teus_20 = '-';
                                    $teus_40 = ' <i class="fa fa-check"></i>';
                                }
                                $stuffing = $item_countainer->stuffing_take == 1 ? 'SD' : 'SL';
                                echo '
                                        <tr class="content">
                                            <td align="center">' . $counter . '</td>
                                            <td>' . $item_countainer->countainer_code . '</td>
                                            <td align="center">1</td>
                                            <td>' . $item_countainer->category_load_name . ' - ' . $item_countainer->category_stuff_name . '</td>
                                            <td align="center">' . strtoupper($item_countainer->customer_name) . '</td>
                                            <td align="center">' . $item_countainer->seal_code . '</td>
                                            <td align="center">' . $teus_20 . '</td>
                                            <td align="center">' . $teus_40 . '</td>
                                            <td align="center">' . $stuffing . '</td>
                                        </tr>
                                    ';
                            }
                            ?>


                        </tbody>
                    </table>
                </td>
            </tr>
            <tr style="height:80px;vertical-align:top">
                <td colspan="3">
                    <p>Keterangan : </p>
                    <p></p>
                </td>
            </tr>
            <!-- <tr style="height:80px;vertical-align:top">
                <td colspan="3">
                    <table style="width:100%">
                        <tr>
                            <td></td>
                            <td align="center">Mengetahui</td>
                            <td align="center">Pembuat</td>
                        </tr>
                        <tr><td colspan="4"></td></tr>
                        <tr><td colspan="4"></td></tr>
                        <tr><td colspan="4"></td></tr>
                        <tr><td colspan="4"></td></tr>
                        <tr><td colspan="4">Halaman 1 dari 2 halaman</td></tr>
                        <tr>
                            <td>Dicetak : 02-23-2022 19:33:52</td>
                            <td colspan="3"></td>
                        </tr>
                        <tr>
                            <td>Oleh : badawi</td>
                            <td align="center">(_________________)</td>
                            <td align="center">(_________________)</td>
                        </tr>
                    </table>
                </td>
            </tr> -->
        </tbody>
    </table>

    <br>
    <br>
    <footer></footer>

</div>