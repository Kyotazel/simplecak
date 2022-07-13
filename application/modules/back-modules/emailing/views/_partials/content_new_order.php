<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    .table-bordered thead th,
    .table-bordered thead td {
        border-top-width: 1px;
        padding-top: 7px;
        padding-bottom: 7px;
        background-color: rgba(255, 255, 255, 0.5);
    }

    .table th,
    .table td {
        padding: 0.75rem;
        vertical-align: top;
        border-top: 1px solid #dde2ef;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #dde2ef;
    }

    .bg-primary-gradient {
        background-image: linear-gradient(to left, #0db2de 0%, #005bea 100%) !important;
    }

    .text-white {
        color: #fff !important;
    }
</style>


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
$category_teus        = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_teus'])->row()->value, TRUE);
$category_service     = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_service'])->row()->value, TRUE);
$category_countainer  = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'countainer_category'])->row()->value, TRUE);
$category_stuffing    = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_stuffing'])->row()->value, TRUE);

$btn_save = Modules::run('security/edit_access', '<button type="submit" class="btn btn-primary-gradient  btn-rounded btn_save-countainer"><i class="fa fa-paper-plane"></i> Simpan Harga Kontainer</button>');
$readonly = Modules::run('security/edit_access', '1') ? '' : 'readonly disabled';


?>
<div class="col-12 p-2">
    <h3 style="margin: 0px;">KONTAINER</h3>
    <div class="table-responsive">
        <table style=" border-collapse: collapse;width: 100%;">
            <thead style=" background-image: linear-gradient(to left, #0db2de 0%, #005bea 100%);color:#fff; ">
                <tr>
                    <th style="
                            background-color:transparent; 
                            border-top-width: 1px;
                            padding: 7px;
                            border: 1px solid #dde2ef;
                        ">
                        Jenis Kontainer
                    </th>
                    <th style="
                            background-color:transparent; 
                            border-top-width: 1px;
                            padding: 7px;
                            border: 1px solid #dde2ef;
                        ">
                        STUFFING
                    </th>
                    <th style="
                            background-color:transparent; 
                            border-top-width: 1px;
                            padding-top: 7px;
                            border: 1px solid #dde2ef;
                        ">
                        MUATAN
                    </th>
                    <th style="
                            background-color:transparent; 
                            border-top-width: 1px;
                            padding: 7px;
                            border: 1px solid #dde2ef;
                        ">
                        QTY
                    </th>
                    <th style="
                            background-color:transparent; 
                            border-top-width: 1px;
                            padding: 7px;
                            border: 1px solid #dde2ef;  
                        ">
                        TOTAL
                    </th>
                </tr>
            </thead>
            <tbody class="tbody_item_booking">
                <?php
                $grand_total_price = 0;
                $total_price_freight = 0;
                $total_price_thc = 0;
                foreach ($data_detail_bs as $item_bs) {
                    $service_type = isset($category_service[$item_bs->category_service]) ? $category_service[$item_bs->category_service] : '';
                    $countiner_type = isset($category_countainer[$item_bs->category_countainer]) ? $category_countainer[$item_bs->category_countainer] : '';
                    $countainer_teus = isset($category_teus[$item_bs->category_teus]) ? $category_teus[$item_bs->category_teus] : 0;
                    $stuffing_take = isset($category_stuffing[$item_bs->stuffing_take]) ? $category_stuffing[$item_bs->stuffing_take] : 0;
                    $stuffing_open = isset($category_stuffing[$item_bs->stuffing_open]) ? $category_stuffing[$item_bs->stuffing_open] : 0;

                    if ($item_bs->type == 1) {
                        $total_price_freight +=  $item_bs->qty * $item_bs->price;
                        $total_price_thc +=  $item_bs->qty * $item_bs->price_thc;

                        $total_price = $item_bs->qty * ($item_bs->price + $item_bs->price_thc);
                        $grand_total_price += $total_price;

                        $btn_update_freight = '';
                        $btn_update_thc  = '';

                        echo '
                                <tr class="item_detail item_container countainer_2124">
                                    <td rowspan="2"
                                    style="
                                        background-color:transparent; 
                                        border-top-width: 1px;
                                        padding: 7px;
                                        border: 1px solid #dde2ef;
                                        vertical-align:top;
                                    "
                                    >
                                        <div style="margin-bottom:5px;">
                                            <small for="" class="d-block text-muted">Kategori Kontainer :</small><br>
                                            <label for=""> ' . strtoupper($countiner_type) . '</label>
                                        </div>
                                        <div style="margin-bottom:5px;">
                                            <small for="" class="d-block text-muted">Feet :</small><br>
                                            <label for=""> ' . strtoupper($countainer_teus) . ' FEET</label>
                                        </div>
                                        <div>
                                            <small for="" class="d-block text-muted">Service :</small><bar>
                                            <label for=""> ' . strtoupper($service_type) . ' </label>
                                        </div>
                                        
                                    </td>
                                    <td rowspan="2"
                                    style="
                                        background-color:transparent; 
                                        border-top-width: 1px;
                                        padding: 7px;
                                        border: 1px solid #dde2ef;  
                                        vertical-align:top;
                                    "
                                    >
                                        <small for="" class="d-block text-muted">Stuffing :</small>
                                        <label for="" class="m-0"> ' . strtoupper($stuffing_take) . '</label>
                                        <p class="border-dashed tx-13 p-1 mb-1">
                                            Alamat :<br>
                                            ' . $item_bs->stuffing_take_address . '
                                        </p>
                                        <small for="" class="d-block text-muted">Stripping :</small>
                                        <label for="" class="m-0"> ' . strtoupper($stuffing_open) . '</label>
                                        <p class="border-dashed tx-13 p-1 m-0">
                                            Alamat :<br>
                                            ' . $item_bs->stuffing_open_address . '
                                        </p>
                                    </td>
                                    <td rowspan="2"
                                    style="
                                        background-color:transparent; 
                                        border-top-width: 1px;
                                        padding: 7px;
                                        border: 1px solid #dde2ef;  
                                        vertical-align:top;
                                    "
                                    >
                                        <div style="margin-bottom:5px;">
                                            <small class="d-block text-muted">Kategori Barang Muatan :</small><br>
                                            <label for="" class="d-block p-2 border-dashed">' . strtoupper($item_bs->category_load_name) . '</label>
                                        </div>
                                        <div style="margin-bottom:5px;">
                                            <small class="d-block text-muted">Barang Muatan:</small><br>
                                            <label for="" class="d-block p-2 border-dashed">' . strtoupper($item_bs->category_stuff_name) . '</label>
                                        </div>
                                    </td>
                                    <td
                                    style="
                                        background-color:transparent; 
                                        border-top-width: 1px;
                                        padding: 7px;
                                        border: 1px solid #dde2ef;  
                                        vertical-align:top;
                                    "
                                    >
                                        <small class="d-block text-muted">Jumlah :</small>
                                        <h3 style="margin:0;">' . $item_bs->qty . '</h3>
                                    </td>
                                    <td
                                    style="
                                        background-color:transparent; 
                                        border-top-width: 1px;
                                        padding: 7px;
                                        border: 1px solid #dde2ef; 
                                        width:500px; 
                                    "   
                                    >
                                        <div class="row">
                                            <div class="col-6 border-right">
                                                <small class="d-block text-muted">
                                                    Harga Freight : 
                                                </small>
                                                <h3 style="margin:0px">Rp.' . number_format($item_bs->price, 0, '.', '.') . '</h3>
                                                <span class="help-block notif text-red text_' . $item_bs->id . '"></span>
                                                <label class="m-0 mt-1 tx-10">(' . $item_bs->qty . ' x <span class="span_price_freight_' . $item_bs->id . '">' . number_format($item_bs->price, 0, '.', '.') . '</span> ) = <span class="font-weight-bold span_total_price_freight_' . $item_bs->id . '">Rp. ' . number_format(($item_bs->qty * $item_bs->price), 0, '.', '.') . '</span></label>
                                            </div>
                                            <br>
                                            <div class="col-6">
                                                <small class="d-block text-muted">
                                                    Harga THC : 
                                                </small>
                                                <h3 style="margin:0px">Rp.' . number_format($item_bs->price_thc, 0, '.', '.') . '</h3>
                                                <span class="help-block notif text-red text_' . $item_bs->id . '"></span>
                                                <label class="m-0 mt-1 tx-10">(' . $item_bs->qty . ' x <span class="span_price_thc_' . $item_bs->id . '">' . number_format($item_bs->price_thc, 0, '.', '.') . '</span> ) = <span class="font-weight-bold span_total_price_thc_' . $item_bs->id . '">Rp. ' . number_format(($item_bs->qty * $item_bs->price_thc), 0, '.', '.') . '</span></label>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="2" 
                                    style="
                                        background-color:transparent; 
                                        border-top-width: 1px;
                                        padding: 7px;
                                        border: 1px solid #dde2ef; 
                                        width:500px; 
                                    "
                                    >
                                        <small class="d-block text-muted">Total Harga :</small>
                                        <label style="margin:0px;font-size:17px"><b>' . number_format($total_price, 0, '.', '.') . '</b></label>
                                        <small class="text-muted d-block"><i class="fa fa-info-circle"></i> total biaya kontainer.</small>
                                    </td>
                                </tr>
                            ';
                    }
                }

                $tax_text   = $data_bs->ppn > 0 ? 'Include' : 'Exclude';
                $tax_value  = $data_bs->ppn;
                $tax_price  = $tax_value > 0 ? $grand_total_price * ($tax_value / 100) : 0;
                $all_grand_total = $grand_total_price + $tax_price + $data_bs->price_materai;

                $tax_price_freight = $tax_value > 0 ? $total_price_freight * ($tax_value / 100) : 0;
                $tax_price_thc = $tax_value > 0 ? $total_price_thc * ($tax_value / 100) : 0;

                ?>
                <tr class="tr_add">
                    <td colspan="4" rowspan="5" style="
                            background-color:transparent; 
                            border-top-width: 1px;
                            padding: 7px;
                            border: 1px solid #dde2ef; 
                            width:500px; 
                        ">
                        <div class="alert alert-default alert-dismissible fade show" role="alert">
                            <span class="alert-inner--icon"><i class="ti-bell"></i></span>
                            <span class="alert-inner--text"><strong>Info!</strong> Berikut adalah nilai yang ditagihkan ke customer :</span>
                        </div>
                    </td>
                </tr>
                <tr class="">
                    <td style="
                                background-color:transparent; 
                                border-top-width: 1px;
                                padding: 7px;
                                border: 1px solid #dde2ef; 
                                width:500px; 
                            ">
                        <small class="tag mb-2 text-decoration-underline">Total Tagihan Freight</small>
                        <div class="row ">
                            <div class="col-4 border-right">
                                <small class="text-muted d-block"><i class="fa fa-info-circle"></i> Total Harga :</small>
                                <label style="font-size: 15px;font-weight:800;" class=" text-total-price-freight m-0 tx-14 font-weight-bold">Rp.<?= number_format($total_price_freight, 0, '.', '.'); ?></label>
                            </div>
                            <div class="col-4 border-right ">
                                <small class="text-muted d-block"><i class="fa fa-info-circle"></i> Pajak PPN :</small>
                                <label style="font-size: 15px;font-weight:800;" class=" text-total-tax-freight m-0 tx-14 font-weight-bold">Rp.<?= number_format($tax_price_freight, 0, '.', '.'); ?></label>
                                <small class="d-block text-right font-weight-bold text-primary"> <i class="fa fa-check-circle"></i> ( <?= $tax_text . ' ' . $tax_value . '%' ?> )</small>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block"><i class="fa fa-info-circle"></i> Total Invoice :</small>
                                <label style="font-size: 15px;font-weight:800;" class=" text-grand-total-freight font-weight-bold m-0 tx-14">Rp.<?= number_format(($total_price_freight + $tax_price_freight), 0, '.', '.'); ?></label>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="
                                        background-color:transparent; 
                                        border-top-width: 1px;
                                        padding: 7px;
                                        border: 1px solid #dde2ef; 
                                        width:500px; 
                                    ">
                        <small class="tag mb-2 text-decoration-underline">Total Tagihan THC</small>
                        <div class="row ">
                            <div class="col-4 border-right">
                                <small class="text-muted d-block" style="width: 200px;"><i class="fa fa-info-circle"></i> Total Harga :</small>
                                <label class=" text-grand-total-price-thc font-weight-bold m-0 tx-14" style="font-size: 15px;font-weight:800;">Rp.<?= number_format($total_price_thc, 0, '.', '.'); ?></label>
                            </div>
                            <div class="col-4 border-right ">
                                <small class="text-muted d-block" style="width: 200px;"><i class="fa fa-info-circle"></i> Pajak PPN :</small>
                                <label style="font-size: 15px;font-weight:800;" class=" text-total-tax-thc font-weight-bold m-0 tx-14">Rp.<?= number_format($tax_price_thc, 0, '.', '.'); ?></label>
                                <small class="d-block text-right  font-weight-bold text-primary"> <i class="fa fa-check-circle"></i> ( <?= $tax_text . ' ' . $tax_value . '%' ?> )</small>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block" style="width: 200px;"><i class="fa fa-info-circle"></i> Total Invoice :</small>
                                <label style="font-size: 15px;font-weight:800;" class="text-grand-total-tnc m-0 font-weight-bold tx-14">Rp.<?= number_format(($total_price_thc + $tax_price_thc), 0, '.', '.'); ?></label>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="
                                        background-color:transparent; 
                                        border-top-width: 1px;
                                        padding: 7px;
                                        border: 1px solid #dde2ef; 
                                        width:500px; 
                                    ">
                        <small class="text-muted"><i class="fa fa-info-circle"></i> Dokumen & Materai : &nbsp;&nbsp;</small>
                        <label style="font-size: 15px;font-weight:800;" class="m-0 font-weight-bold text-materai" data-price="<?= $data_bs->price_materai; ?>">Rp.<?= number_format($data_bs->price_materai, 0, '.', '.'); ?></label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="
                                        background-color:transparent; 
                                        border-top-width: 1px;
                                        padding: 7px;
                                        border: 1px solid #dde2ef; 
                                        width:500px; 
                                    ">
                        <small class="text-muted"><i class="fa fa-info-circle"></i> Grand Total Harga : &nbsp;&nbsp;</small>
                        <label style="font-size: 15px;font-weight:800;" class="text-primary font-weight-bold all-grand-total-price tx-30">Rp.<?= number_format($all_grand_total, 0, '.', '.'); ?></label>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <br>
    <h3 style="margin: 0px;">LOSS CARGO</h3>
    <div class="table-responsive">
        <table style=" border-collapse: collapse;width: 100%;">
            <thead style=" background-image: linear-gradient(to left, #0db2de 0%, #005bea 100%);color:#fff; ">
                <tr>
                    <th style="
                            background-color:transparent; 
                            border-top-width: 1px;
                            padding: 7px;
                            border: 1px solid #dde2ef;
                        ">Jenis Loss cargo</th>
                    <th style="
                            background-color:transparent; 
                            border-top-width: 1px;
                            padding: 7px;
                            border: 1px solid #dde2ef;
                        ">STUFFING</th>
                    <th style="
                            background-color:transparent; 
                            border-top-width: 1px;
                            padding: 7px;
                            border: 1px solid #dde2ef;
                        ">MUATAN</th>
                    <th style="
                            background-color:transparent; 
                            border-top-width: 1px;
                            padding: 7px;
                            border: 1px solid #dde2ef;
                        ">QTY</th>
                    <th style="
                            background-color:transparent; 
                            border-top-width: 1px;
                            padding: 7px;
                            border: 1px solid #dde2ef;
                        ">TOTAL</th>
                </tr>
            </thead>
            <tbody class="tbody_item_booking">
                <?php
                $grand_total_price = 0;
                foreach ($data_detail_bs as $item_bs) {
                    $service_type = isset($category_service[$item_bs->category_service]) ? $category_service[$item_bs->category_service] : '';
                    $countiner_type = isset($category_countainer[$item_bs->category_countainer]) ? $category_countainer[$item_bs->category_countainer] : '';
                    $countainer_teus = isset($category_teus[$item_bs->category_teus]) ? $category_teus[$item_bs->category_teus] : 0;
                    $stuffing_take = isset($category_stuffing[$item_bs->stuffing_take]) ? $category_stuffing[$item_bs->stuffing_take] : 0;
                    $stuffing_open = isset($category_stuffing[$item_bs->stuffing_open]) ? $category_stuffing[$item_bs->stuffing_open] : 0;

                    //check price

                    if ($item_bs->type == 2) {
                        $total_price = $item_bs->price * $item_bs->qty;
                        $grand_total_price += $total_price;

                        $btn_update_lc = '';
                        $readonly_lc = 'readonly';


                        //get datail
                        $get_detail_transport = Modules::run('database/find', 'tb_booking_has_lc', ['id_booking_detail' => $item_bs->id])->result();
                        $html_detail_transport = '';
                        foreach ($get_detail_transport as $item_transport) {
                            $html_detail_transport .= '
                                    <label for="" style="display:block">' . $item_transport->transport_name . '</label>
                                ';
                        }

                        echo '
                                <tr class="item_detail ">
                                    <td rowspan="2" colspan="2" 
                                    style="
                                        background-color:transparent; 
                                        border-top-width: 1px;
                                        padding: 7px;
                                        border: 1px solid #dde2ef;
                                        vertical-align:top;
                                    "
                                    >
                                        <div style="margin-bottom:5px;">
                                            <small for="" class="d-block text-muted">Jenis Kendaraan :</small><br>
                                            <label for=""> ' . strtoupper($item_bs->transport_name) . '</label>
                                        </div>
                                        <div style="margin-bottom:5px;">
                                            <small for="" class="d-block text-muted">Detail Kendaraan :</small>
                                            ' . $html_detail_transport . '
                                        </div>
                                    </td>
                                    <td rowspan="2"
                                    style="
                                        background-color:transparent; 
                                        border-top-width: 1px;
                                        padding: 7px;
                                        border: 1px solid #dde2ef;
                                        vertical-align:top;
                                    "
                                    >
                                        <div style="margin-bottom:5px;">
                                            <small class="d-block text-muted">Barang Muatan:</small><br>
                                            <label for="" class="d-block p-2 border-dashed">' . strtoupper($item_bs->category_stuff_name) . '</label>
                                        </div>
                                        <div style="margin-bottom:5px;">
                                            <small class="d-block text-muted">Keterangan :</small>
                                            <p for="" class="d-block p-2 border-dashed">' . nl2br(strtoupper($item_bs->transport_description)) . '</p>
                                        </div>
                                    </td>
                                    <td
                                    style="
                                        background-color:transparent; 
                                        border-top-width: 1px;
                                        padding: 7px;
                                        border: 1px solid #dde2ef;
                                        vertical-align:top;
                                    "
                                    >
                                        <small class="d-block text-muted">Jumlah :</small>
                                        <h3 class="mb-1">' . $item_bs->qty . '</h3>
                                    </td>
                                    <td
                                    style="
                                        background-color:transparent; 
                                        border-top-width: 1px;
                                        padding: 7px;
                                        border: 1px solid #dde2ef;
                                        width:350px;
                                        vertical-align:top;
                                    "
                                    >
                                        <small class="d-block text-muted">Harga :</small>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text font-weight-bold">
                                                    <label for="" style="font-size: 15px;font-weight:800;">Rp.' . number_format($item_bs->price, 0, '.', '.') . '</label>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="2"
                                    style="
                                        background-color:transparent; 
                                        border-top-width: 1px;
                                        padding: 7px;
                                        border: 1px solid #dde2ef;
                                        width:350px;
                                        vertical-align:top;
                                    "
                                    >
                                        <small class="d-block text-muted">Total Harga :</small>
                                        <label for="" class="p-1 border-dashed d-block tx-20">
                                            <span class="text-price text-count-lc-' . $item_bs->id . '">' . number_format($total_price, 0, '.', '.') . '</span>
                                        </label>
                                        <small class="text-muted d-block "><i class="fa fa-info-circle"></i> total biaya Loss Cargo.</small>
                                    </td>
                                </tr>
                            ';
                    }
                }
                ?>
                <tr class="tr_add">
                    <td colspan="4" rowspan="4" style="
                                        background-color:transparent; 
                                        border-top-width: 1px;
                                        padding: 7px;
                                        border: 1px solid #dde2ef;
                                        width:350px;
                                    ">
                        <div class="alert alert-default alert-dismissible fade show" role="alert">
                            <span class="alert-inner--icon"><i class="ti-bell"></i></span>
                            <span class="alert-inner--text"><strong>Info!</strong> Berikut adalah nilai yang ditagihkan ke customer :</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="
                                        background-color:transparent; 
                                        border-top-width: 1px;
                                        padding: 7px;
                                        border: 1px solid #dde2ef;
                                        width:350px;
                                    ">
                        <small class="text-muted"><i class="fa fa-info-circle"></i> Total Harga :</small>
                        <label class=" text-grand-total-lc m-0 tx-20">Rp.<?= number_format($grand_total_price, 0, '.', '.'); ?></label>
                    </td>
                </tr>
                <tr>
                    <?php
                    $tax_text   = $data_bs->ppn > 0 ? 'Include' : 'Exclude';
                    $tax_value  = $data_bs->ppn;
                    $tax_price  = $tax_value > 0 ? $grand_total_price * ($tax_value / 100) : 0;
                    $all_grand_total = $grand_total_price + $tax_price;
                    ?>
                    <td colspan="2" style="
                                        background-color:transparent; 
                                        border-top-width: 1px;
                                        padding: 7px;
                                        border: 1px solid #dde2ef;
                                        width:350px;
                                    ">
                        <small class="text-muted"><i class="fa fa-info-circle"></i> Pajak PPN : </small>
                        <label class="text-tax-lc m-0 tx-20" data-tax="<?= $tax_value; ?>">
                            Rp.<?= number_format($tax_price, 0, '.', '.'); ?><br>
                        </label>
                        <small class="d-block text-right  font-weight-bold text-primary "> <i class="fa fa-check-circle"></i> ( <?= $tax_text . ' ' . $tax_value . '%' ?> )</small>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="
                                        background-color:transparent; 
                                        border-top-width: 1px;
                                        padding: 7px;
                                        border: 1px solid #dde2ef;
                                        width:350px;
                                    ">
                        <small class="text-muted"><i class="fa fa-info-circle"></i> Grand Total Harga</small>
                        <h3 class="text-primary font-weight-bold all-total-lc" style="margin: 0;">Rp.<?= number_format($all_grand_total, 0, '.', '.'); ?></h3>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>