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

$html_item_countainer = '';
$html_item_lc = '';
$total_teus = 0;
$total_qty_countainer = 0;
$total_price = 0;

$total_qty_lc = 0;
$total_price_lc = 0;
$grand_total_price = 0;
$grand_total_price_lc = 0;

foreach ($data_detail_bs as $item_detail_bs) {
    if ($item_detail_bs->type == 1) {
        $countiner_type = isset($category_countainer[$item_detail_bs->category_countainer]) ? $category_countainer[$item_detail_bs->category_countainer] : '';
        $countainer_teus = isset($category_teus[$item_detail_bs->category_teus]) ? $category_teus[$item_detail_bs->category_teus] : 0;
        $service_type = isset($category_service[$item_detail_bs->category_service]) ? $category_service[$item_detail_bs->category_service] : '';
        $total_teus += ($countainer_teus * $item_detail_bs->qty);
        $total_qty_countainer += $item_detail_bs->qty;
        $total_price += ($item_detail_bs->qty * ($item_detail_bs->price + $item_detail_bs->price_thc));
        $html_item_countainer .= '
                <div class="p-1 border-dashed rounded row">
                    <div class="col-5 ">
                        <label for="" class="col-12 m-0 font-weight-bold">
                            ' . strtoupper($countiner_type) . ' (' . strtoupper($countainer_teus) . ' FEET)
                        </label>
                        <small class="d-block col-12">
                            <span class="text-muted"><i class="fa fa-check-circle"></i> Barang : </span> ' . strtoupper($item_detail_bs->category_load_name) . ' - ' . strtoupper($item_detail_bs->category_stuff_name) . '
                        </small>
                        <small class="d-block col-12">
                            <span class="text-muted"><i class="fa fa-check-circle"></i> Service : </span> ' . strtoupper($service_type) . '
                        </small>
                        <small class="d-block col-12">
                            <span class="text-muted"><i class="fa fa-check-circle"></i> Jumlah : </span> ' . strtoupper($item_detail_bs->qty) . '
                        </small>
                    </div>
                    <div class="col-7 row">
                        <div class="col-6">
                            <small class="d-block text-muted">Harga Freight :</small>
                            <label for="" class="font-weight-bold">' . $item_detail_bs->qty . ' x ' . number_format($item_detail_bs->price, 0, '.', '.') . '</label>
                            <small class="d-block text-muted">Total Harga FREIGHT :</small>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text font-weight-bold">
                                        Rp.
                                    </div>
                                </div>
                                <input value="' . number_format($item_detail_bs->total_price, 0, '.', '.') . '" data-target="text-count-13" data-qty="2" class="form-control border-dashed  font-weight-bold rupiah count_price_item bg-white" name="price[13]" type="text">
                            </div>
                        </div>
                        <div class="col-6">
                            <small class="d-block text-muted">Harga THC :</small>
                            <label for="" class="font-weight-bold">' . $item_detail_bs->qty . ' x ' . number_format($item_detail_bs->price_thc, 0, '.', '.') . '</label>
                            <small class="d-block text-muted">Total Harga THC :</small>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text font-weight-bold">
                                        Rp.
                                    </div>
                                </div>
                                <input value="' . number_format($item_detail_bs->total_price_thc, 0, '.', '.') . '" data-target="text-count-13" data-qty="2" class="form-control border-dashed  font-weight-bold rupiah count_price_item bg-white" name="price[13]" type="text">
                            </div>
                        </div>
                    </div>
                </div>
            ';
    } else {
        $total_qty_lc += $item_detail_bs->qty;
        $total_price_lc += ($item_detail_bs->qty * $item_detail_bs->price);
        $html_item_lc .= '
                <div class="p-1 border-dashed rounded row">
                    <div class="col-5">
                        <label for="" class="col-12 m-0 font-weight-bold">
                            ' . strtoupper($item_detail_bs->transport_name) . ' 
                        </label>
                        <small class="d-block col-12">
                            <span class="text-muted"><i class="fa fa-check-circle"></i> Barang : </span> ' . strtoupper($item_detail_bs->category_load_name) . ' - ' . strtoupper($item_detail_bs->category_stuff_name) . '
                        </small>
                        <small class="d-block col-12">
                            <span class="text-muted"><i class="fa fa-check-circle"></i> Keterangan : </span> ' . nl2br(strtoupper($item_detail_bs->transport_description)) . '
                        </small>
                    </div>
                    <div class="col-7 row">
                        <div class="col-6">
                            <small class="d-block text-muted">Detail Harga :</small>
                            <label for="" class="font-weight-bold">' . $item_detail_bs->qty . ' x ' . number_format($item_detail_bs->price, 0, '.', '.') . '</label>
                        </div>
                        <div class="col-6">
                            <small class="d-block text-muted">Total Harga :</small>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text font-weight-bold">
                                        Rp.
                                    </div>
                                </div>
                                <input value="' . number_format($item_detail_bs->total_price, 0, '.', '.') . '" data-target="text-count-13" data-qty="2" class="form-control border-dashed  font-weight-bold rupiah count_price_item bg-white" name="price[13]" type="text">
                            </div>
                        </div>
                    </div>
                </div>
            ';
    }

    $grand_total_price_lc += $item_detail_bs->total_price;
}

$tax_text   = $data_bs->ppn > 0 ? 'Include' : 'Exclude';
$tax_value  = $data_bs->ppn;
$tax_price_countainer  = $tax_value > 0 ? $total_price * ($tax_value / 100) : 0;
$grand_total_countainer = $total_price + $tax_price_countainer;

$tax_price_lc  = $tax_value > 0 ? $total_price_lc * ($tax_value / 100) : 0;
$grand_total_lc = $total_price_lc + $tax_price_lc;

$html_item_countainer .= '
            <div class="col-12 row  p-2 rounded border-dashed mb-1">
                <div class="col-4 border-right">
                    <div class="d-flex mb-0">
                        <div class="">
                            <p class="mb-0 tx-12 text-muted"><i class="fa fa-money-bill"></i> Total Harga :</p>
                            <h5 class="mb-1   font-weight-bold text-primary">Rp. ' . number_format($total_price, 0, '.', '.') . '</h5>
                        </div>
                    </div>
                </div>
                <div class="col-4 border-right">
                    <div class="d-flex mb-0">
                        <div class="">
                            <p class="mb-0 tx-12 text-muted"><i class="fa fa-money-bill"></i> Pajak : <span class="text-primary font-weight-bold">( ' . $tax_text . ' &nbsp;
                            ' . $tax_value . '% )</span></p>
                            <h5 class="mb-1   font-weight-bold text-primary">Rp. ' . number_format($tax_price_countainer, 0, '.', '.') . '</h5>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="d-flex mb-0">
                        <div class="">
                            <p class="mb-0 tx-12 text-muted"><i class="fa fa-money-bill"></i> Grand Total Harga :</p>
                            <h5 class="mb-1 font-weight-bold text-primary">Rp. ' . number_format($grand_total_countainer, 0, '.', '.') . '</h5>
                        </div>
                    </div>
                </div>
            </div>
    ';

if ($total_qty_countainer == 0) {
    $html_item_countainer = '
            <div class="col-12 text-center">
                <div class="plan-card text-center">
                    <i class="fas fa-cube plan-icon text-primary"></i>
                    <h6 class="text-drak text-uppercase mt-2">Data Kosong</h6>
                    <small class="text-muted">Tidak ada item Kontainer.</small>
                </div>
            </div>
        ';
}

$html_item_lc .= '
        <div class="col-12 row  p-2 rounded border-dashed mb-1">
            <div class="col-4 border-right">
                <div class="d-flex mb-0">
                    <div class="">
                        <p class="mb-0 tx-12 text-muted"><i class="fa fa-money-bill"></i> Total Harga :</p>
                        <h5 class="mb-1   font-weight-bold text-primary">Rp. ' . number_format($total_price_lc, 0, '.', '.') . '</h5>
                    </div>
                </div>
            </div>
            <div class="col-4 border-right">
                <div class="d-flex mb-0">
                    <div class="">
                        <p class="mb-0 tx-12 text-muted"><i class="fa fa-money-bill"></i> Pajak : <span class="text-primary font-weight-bold">( ' . $tax_text . ' &nbsp;
                        ' . $tax_value . '% )</span></p>
                        <h5 class="mb-1   font-weight-bold text-primary">Rp. ' . number_format($tax_price_lc, 0, '.', '.') . '</h5>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="d-flex mb-0">
                    <div class="">
                        <p class="mb-0 tx-12 text-muted"><i class="fa fa-money-bill"></i> Grand Total Harga :</p>
                        <h5 class="mb-1 font-weight-bold text-primary">Rp. ' . number_format($grand_total_lc, 0, '.', '.') . '</h5>
                    </div>
                </div>
            </div>
        </div>
    ';
if ($total_qty_lc == 0) {
    $html_item_lc = '
            <div class="col-12 text-center">
                <div class="plan-card text-center">
                    <i class="fas fa-truck plan-icon text-primary"></i>
                    <h6 class="text-drak text-uppercase mt-2">Data Kosong</h6>
                    <small class="text-muted">Tidak ada item Loss cargo.</small>
                </div>
            </div>
        ';
}

?>

<div class="row">
    <div class="col-12 border-right border-dashed">
        <a href="javascript:void(0)" class="custom chip border-dashed mb-2 mt-2 col-12">
            <span class="avatar cover-image bg-primary-gradient"><i class="fa fa-box"></i></span> Kontainer
        </a>
        <?= $html_item_countainer ?>

    </div>
    <div class="col-12 border-dashed">
        <a href="javascript:void(0)" class="custom chip border-dashed mb-2 mt-2 col-12">
            <span class="avatar cover-image bg-primary-gradient"><i class="fa fa-truck"></i></span> Loss Cargo
        </a>
        <?= $html_item_lc ?>

    </div>

</div>