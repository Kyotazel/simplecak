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
                <td rowspan="2" style="vertical-align:midle" align="center">
                    <h2 style="margin-left:7px;margin-right:7px"><strong>Manifest</strong></h2>
                </td>
                <td rowspan="2" style="vertical-align:top">
                    <table style="font-size:14px">
                        <tbody>
                            <tr>
                                <td style="width: 40%;white-space: nowrap;">No. SPM</td>
                                <td>:</td>
                                <td><?= $data_voyage->manifest_number; ?></td>
                            </tr>
                            <tr>
                                <td>Tgl SPM</td>
                                <td>:</td>
                                <td><?= $data_voyage->manifest_date; ?></td>
                            </tr>
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
                                <td align="center">No</td>
                                <td align="center">No Container</td>
                                <td align="center">Size</td>
                                <td align="center">Segel|Merk</td>
                                <td align="center">Service</td>
                                <td align="center">Kode</td>
                                <td align="center">Muatan</td>
                                <td align="center">Jml</td>
                                <td align="center">Sat</td>
                            </tr>
                            <?php
                            $counter  = 0;

                            foreach ($get_data_countainer as $item_countainer) {
                                $countiner_type = isset($category_countainer[$item_countainer->category_countainer]) ? $category_countainer[$item_countainer->category_countainer] : '';
                                $countainer_teus = isset($category_teus[$item_countainer->category_teus]) ? $category_teus[$item_countainer->category_teus] : 0;
                                $service_type = isset($category_service[$item_countainer->category_service]) ? $category_service[$item_countainer->category_service] : '';
                                $stuffing_take = isset($category_stuffing[$item_countainer->stuffing_take]) ? $category_stuffing[$item_countainer->stuffing_take] : 0;
                                $stuffing_open = isset($category_stuffing[$item_countainer->stuffing_open]) ? $category_stuffing[$item_countainer->stuffing_open] : 0;

                                $counter++;
                                echo '
                                        <tr class="content">
                                            <td>' . $counter . '</td>
                                            <td align="center">' . $item_countainer->countainer_code . '</td>
                                            <td align="center">' . $countainer_teus . '</td>
                                            <td align="center">' . $item_countainer->seal_code . '</td>
                                            <td align="center">' . $service_type . '</td>
                                            <td colspan="4"></td>
                                        </tr>
                                        <tr class="content">
                                            <td></td>
                                            <td></td>
                                            <td colspan="3" align="left">' . strtoupper($item_countainer->customer_name) . '</td>
                                            <td align="left">' . $item_countainer->booking_code . '</td>
                                            <td align="left">' . $item_countainer->category_load_name . ' - ' . $item_countainer->category_stuff_name . '</td>
                                            <td align="left">1</td>
                                            <td align="left">CONT</td>
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
            <tr style="height:80px;vertical-align:top">
                <td colspan="3">
                    <table style="width:100%">
                        <tbody>
                            <tr>
                                <td></td>
                                <td align="center">Mengetahui</td>
                                <!-- <td align="center">Supir</td> -->
                                <td align="center">Pembuat</td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                            </tr>
                            <tr>
                                <td colspan="4">Halaman 1 dari 1 halaman</td>
                            </tr>
                            <tr>
                                <td>Dicetak : <?= Modules::run('helper/datetime_indo', date('Y-m-d H:i:s')); ?></td>
                                <td colspan="3"></td>
                            </tr>
                            <tr>
                                <td>Oleh : <?= $this->session->userdata('us_name'); ?></td>
                                <td align="center">(_________________)</td>
                                <!-- <td align="center">(_________________)</td> -->
                                <td align="center">(_________________)</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    <br>
    <br>
    <footer></footer>

</div>