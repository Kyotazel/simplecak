<?php
$id_bs = $data_bs->id;
$get_ro = Modules::run('database/find', 'tb_booking_has_ro', ['id_booking' => $id_bs, 'status' => 1])->row();
$array_query_detail_bs = [
    'select' => '
        tb_booking_has_detail.*,
        mst_category_load.name AS category_load_name,
        mst_category_stuff.name AS category_stuff_name
    ',
    'from' => 'tb_booking_has_detail',
    'where' => [
        'id_booking' =>  $id_bs,
        'tb_booking_has_detail.type' => 1
    ],
    'join' => [
        'mst_category_load, tb_booking_has_detail.id_category_load = mst_category_load.id , left',
        'mst_category_stuff, tb_booking_has_detail.id_category_stuff = mst_category_stuff.id , left'
    ]
];

$data_detail_bs = Modules::run('database/get', $array_query_detail_bs)->result();
$category_teus   = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_teus'])->row()->value, TRUE);
$category_countainer  = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'countainer_category'])->row()->value, TRUE);

?>
<div class="text-right mt-2 container">
    <a href="javascript:void(0)" data-type="4" data-voyage="10" data-so="1" data-bs="32" class="btn btn-primary-gradient"><i class="fa fa-print"></i> Cetak Dokumen</a>
</div>
<div id="printarea">

    <style>
        @media print {
            footer {
                page-break-after: always;
            }
        }

        #background {
            position: absolute;
            z-index: 900;
            background: white;
            display: block;
            min-height: 50%;
            min-width: 50%;
            width: 100%;
            padding: 10px;
            color: white;
            top: 15%;
            left: 0;
        }

        #content {
            /* position: absolute; */
            z-index: 950;
        }

        #bg-text {
            position: absolute;
            min-height: 50%;
            min-width: 50%;
            width: 100%;
            padding: 10px;
            /* color: white; */
            top: 45%;
            left: 35%;
            color: #2fa97c;
            font-size: 80px;
            transform: rotate(340deg);
            -webkit-transform: rotate(340deg);
            opacity: 0.2;
        }
    </style>

    <div id="content" class="shadow-3 container" style="padding-left:25px;padding-right:25px;padding-top:50px;min-height:700px;">
        <table width="100%">
            <tbody>
                <tr>
                    <td rowspan="8" style="vertical-align: top;width:150px;" align="center">
                        <img src="<?= base_url('upload/' . $company_logo); ?>" style="width:150px;">
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="vertical-align: top;vertical-align: top;">
                        <div style="margin-left:0px">
                            <h2 style="margin-bottom: 0rem;text-align:center;"><strong>RELEASE ORDER</h2>
                        </div>
                    </td>
                    <td colspan="3"></td>
                </tr>
                <tr>
                    <td colspan="2" style="vertical-align: top;vertical-align: top;">
                        <div style="margin-left:0px">
                            <h5 style="margin-bottom: 0rem;text-align:center;"><strong>PERMINTAAN CONTAINER KOSONG</strong></h5>
                            <!-- <p style="font-size:12px;padding-top:0px;margin-bottom: 0rem;">Komplek Ruko Harbour Citi-Nine F9 Jl. Gresik no 10-16 Perak Surabaya, Telp. 031-3503555</p> -->
                        </div>
                    </td>
                    <td colspan="3"></td>
                </tr>

                <tr>
                    <td rowspan="5" colspan="2" style="text-align: center;">
                        <h2 style="margin-bottom: 0rem;text-align:center;"><strong><?= strtoupper($data_bs->depo_from); ?></h2>
                    </td>
                </tr>
                <tr>
                    <td style="width: 150px;">TANGGAL </td>
                    <td style="width: 10px;">:</td>
                    <td><?= Modules::run('helper/date_indo', $get_ro->date, '-'); ?></td>
                </tr>
                <tr>
                    <td style="width: 150px;">DEPO/LAP </td>
                    <td style="width: 10px;">:</td>
                    <td><?= $data_bs->depo_from; ?></td>
                </tr>
                <tr>
                    <td style="width: 150px;">TUJUAN </td>
                    <td style="width: 10px;">:</td>
                    <td><?= $data_bs->depo_to; ?></td>
                </tr>
                <tr>
                    <td style="width: 150px;">TANGGAL AKHIR </td>
                    <td style="width: 10px;">:</td>
                    <td><?= Modules::run('helper/date_indo', $get_ro->due_date, '-'); ?></td>
                </tr>
                <tr>
                    <td>KEPADA YTH.</td>
                    <td colspan="5"></td>
                </tr>
                <tr>
                    <td colspan="6">Harap dilayani permintaan Container Kosong (EMPTY) untuk EMKL / Forwarding Sebanyak :</td>
                </tr>

            </tbody>
        </table>

        <table width="100%" style="border:none">
            <tbody>
                <tr>
                    <td style="font-weight:bold;border:1px solid #000;padding:3px;">Kontainer</td>
                    <td style="font-weight:bold;border:1px solid #000;width:150px;padding:3px;">Qty</td>
                </tr>
                <?php
                $status_sd = 0;
                $status_sl = 0;
                $html_tr  = '';
                foreach ($data_detail_bs as $item_countainer) {
                    $countiner_type = isset($category_countainer[$item_countainer->category_countainer]) ? $category_countainer[$item_countainer->category_countainer] : '';
                    $countainer_teus = isset($category_teus[$item_countainer->category_teus]) ? $category_teus[$item_countainer->category_teus] : 0;
                    $html_tr .= '
                            <tr>
                                <td style="border:1px solid #000;padding:3px;">' . $countainer_teus . ' Feet - ' . strtoupper($countiner_type) . '</td>
                                <td style="border:1px solid #000;padding:3px;">' . $item_countainer->qty . '</td>
                            </tr>
                        ';
                    if ($item_countainer->stuffing_take == 1) {
                        $status_sl++;
                    }
                    if ($item_countainer->stuffing_take == 2) {
                        $status_sd++;
                    }
                }
                echo $html_tr;
                ?>

            </tbody>
        </table>
        <table width="100%" style="border:none;margin-top:10px;">
            <tbody>
                <tr>
                    <td>
                        <b for="">Stuffing</b>
                    </td>
                    <td colspan="3">
                        <label for="">Dalam Depo <input type="checkbox" disabled <?= $status_sd > 0 ? 'checked' : ''; ?> style="width:20px;height:20px"></label>
                        <label for="">Luar Depo <input type="checkbox" disabled <?= $status_sl > 0 ? 'checked' : ''; ?> style="width:20px;height:20px"></label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b for="">Catatan/Keterangan</b>
                    </td>
                    <td colspan="3">
                        <p style="color: red;">
                            STUFFING BARANG BERBAHAYA (DG) HARUS ADA SURAT IJIN.<br>
                            RO HANYA BERLAKU 3 (TIGA) HARI DARI TANGGAL RELEASE.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: center;">
                        <b>TANDA TANGAN : </b>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <label style="display: block;margin-bottom:30px;" for=""><b>MARKETING :</b></label>
                        <label for="">(________________)</label>
                    </td>
                    <td style="text-align: center;">
                        <label style="display: block;margin-bottom:30px;" for=""><b>KEPALA DEPO :</b></label>
                        <label for="">(________________)</label>
                    </td>
                    <td style="text-align: center;">
                        <label style="display: block;margin-bottom:30px;" for=""><b>PETUGAS CONTAINER LSL :</b></label>
                        <label for="">(________________)</label>
                    </td>
                    <td style="text-align: center;">
                        <label style="display: block;margin-bottom:30px;" for=""><b>SECURITY :</b></label>
                        <label for="">(________________)</label>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>


</div>