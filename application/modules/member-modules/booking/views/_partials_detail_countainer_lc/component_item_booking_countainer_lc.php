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

$btn_save = Modules::run('security/edit_access', '<button type="submit" class="btn btn-primary-gradient  btn-rounded btn_save-countainer"><i class="fa fa-paper-plane"></i> Simpan Harga Kontainer</button>');
$readonly = Modules::run('security/edit_access', '1') ? '' : 'readonly disabled';


?>
<div class="col-12 p-2">
    <a href="javascript:void(0)" class="custom chip border-dashed mb-2 mt-2 col-12">
        <span class="avatar cover-image bg-primary-gradient"><i class="fa fa-box"></i></span> Kontainer
    </a>
    <div class="table-responsive">
        <table class="table table-bordered" id="id_table_item">
            <thead class="bg-primary-gradient text-white">
                <tr>
                    <th class="text-white" style="background-color:transparent;">Jenis Kontainer</th>
                    <th class="text-white" style="background-color:transparent;">STUFFING</th>
                    <th class="text-white" style="background-color:transparent;">MUATAN</th>
                    <th class="text-white" style="background-color:transparent;">QTY</th>
                    <th class="text-white" style="background-color:transparent;">TOTAL</th>
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
                                    <td rowspan="2">
                                        <small for="" class="d-block text-muted">Kategori Kontainer :</small>
                                        <label for=""> ' . strtoupper($countiner_type) . '</label>
                                        <small for="" class="d-block text-muted">Feet :</small>
                                        <label for=""> ' . strtoupper($countainer_teus) . ' FEET</label>
                                        <small for="" class="d-block text-muted">Service :</small>
                                        <label for=""> ' . strtoupper($service_type) . ' </label>
                                    </td>
                                    <td rowspan="2">
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
                                    <td rowspan="2">
                                        <small class="d-block text-muted">Kategori Barang Muatan :</small>
                                        <label for="" class="d-block p-2 border-dashed">' . strtoupper($item_bs->category_load_name) . '</label>
                                        <small class="d-block text-muted">Barang Muatan:</small>
                                        <label for="" class="d-block p-2 border-dashed">' . strtoupper($item_bs->category_stuff_name) . '</label>
                                    </td>
                                    <td>
                                        <small class="d-block text-muted">Jumlah :</small>
                                        <h3 class="mb-1">' . $item_bs->qty . '</h3>
                                    </td>
                                    <td style="width:500px;" class="item-price">
                                        <div class="row">
                                            <div class="col-6 border-right">
                                                <small class="d-block text-muted">
                                                    Harga Freight : 
                                                    ' . $btn_update_freight . '
                                                </small>
                                                <div class="input-group mt-1">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text font-weight-bold">
                                                            Rp.
                                                        </div>
                                                    </div>
                                                    <input value="' . number_format($item_bs->price, 0, '.', '.') . '" readonly data-target="text-count-' . $item_bs->id . '" data-qty="' . $item_bs->qty . '" data-id="' . $item_bs->id . '" class="border-dashed font-weight-bold form-control rupiah count_price_item bg-white price_freight price_freight_' . $item_bs->id . '" name="price[' . $item_bs->id . ']"  type="text">
                                                </div>
                                                <span class="help-block notif text-red text_' . $item_bs->id . '"></span>
                                                <label class="m-0 mt-1 tx-10">(' . $item_bs->qty . ' x <span class="span_price_freight_' . $item_bs->id . '">' . number_format($item_bs->price, 0, '.', '.') . '</span> ) = <span class="font-weight-bold span_total_price_freight_' . $item_bs->id . '">Rp. ' . number_format(($item_bs->qty * $item_bs->price), 0, '.', '.') . '</span></label>
                                            </div>
                                            <div class="col-6">
                                                <small class="d-block text-muted">
                                                    Harga THC : 
                                                    ' . $btn_update_thc . '
                                                </small>
                                                <div class="input-group mt-1">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text font-weight-bold">
                                                            Rp.
                                                        </div>
                                                    </div>
                                                    <input value="' . number_format($item_bs->price_thc, 0, '.', '.') . '" readonly data-target="text-count-' . $item_bs->id . '" data-qty="' . $item_bs->qty . '" class="border-dashed font-weight-bold form-control rupiah count_price_item bg-white price_thc price_thc_' . $item_bs->id . '" name="price[' . $item_bs->id . ']"  type="text">
                                                </div>
                                                <span class="help-block notif text-red text_' . $item_bs->id . '"></span>
                                                <label class="m-0 mt-1 tx-10">(' . $item_bs->qty . ' x <span class="span_price_thc_' . $item_bs->id . '">' . number_format($item_bs->price_thc, 0, '.', '.') . '</span> ) = <span class="font-weight-bold span_total_price_thc_' . $item_bs->id . '">Rp. ' . number_format(($item_bs->qty * $item_bs->price_thc), 0, '.', '.') . '</span></label>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="2" class="text-right">
                                        <small class="d-block text-muted">Total Harga :</small>
                                        <label for="" class="p-1 border-dashed d-block tx-20">
                                            <span class="text-price text-count-' . $item_bs->id . '">' . number_format($total_price, 0, '.', '.') . '</span>
                                        </label>
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
                    <td colspan="4" rowspan="5" class="text-right ">
                        <div class="alert alert-default alert-dismissible fade show" role="alert">
                            <span class="alert-inner--icon"><i class="ti-bell"></i></span>
                            <span class="alert-inner--text"><strong>Info!</strong> Berikut adalah nilai yang ditagihkan ke customer :</span>
                        </div>
                    </td>
                </tr>
                <tr class="">
                    <td class="text-right ">
                        <small class="tag mb-2 text-decoration-underline">Total Tagihan Freight</small>
                        <div class="row ">
                            <div class="col-4 border-right">
                                <small class="text-muted d-block"><i class="fa fa-info-circle"></i> Total Harga :</small>
                                <label class=" text-total-price-freight m-0 tx-14 font-weight-bold">Rp.<?= number_format($total_price_freight, 0, '.', '.'); ?></label>
                            </div>
                            <div class="col-4 border-right ">
                                <small class="text-muted d-block"><i class="fa fa-info-circle"></i> Pajak PPN :</small>
                                <label data-tax="<?= $tax_value; ?>" class=" text-total-tax-freight m-0 tx-14 font-weight-bold">Rp.<?= number_format($tax_price_freight, 0, '.', '.'); ?></label>
                                <small class="d-block text-right font-weight-bold text-primary"> <i class="fa fa-check-circle"></i> ( <?= $tax_text . ' ' . $tax_value . '%' ?> )</small>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block"><i class="fa fa-info-circle"></i> Total Invoice :</small>
                                <label class=" text-grand-total-freight font-weight-bold m-0 tx-14">Rp.<?= number_format(($total_price_freight + $tax_price_freight), 0, '.', '.'); ?></label>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right">
                        <small class="tag mb-2 text-decoration-underline">Total Tagihan THC</small>
                        <div class="row ">
                            <div class="col-4 border-right">
                                <small class="text-muted d-block"><i class="fa fa-info-circle"></i> Total Harga :</small>
                                <label class=" text-grand-total-price-thc font-weight-bold m-0 tx-14">Rp.<?= number_format($total_price_thc, 0, '.', '.'); ?></label>
                            </div>
                            <div class="col-4 border-right ">
                                <small class="text-muted d-block"><i class="fa fa-info-circle"></i> Pajak PPN :</small>
                                <label data-tax="<?= $tax_value; ?>" class=" text-total-tax-thc font-weight-bold m-0 tx-14">Rp.<?= number_format($tax_price_thc, 0, '.', '.'); ?></label>
                                <small class="d-block text-right  font-weight-bold text-primary"> <i class="fa fa-check-circle"></i> ( <?= $tax_text . ' ' . $tax_value . '%' ?> )</small>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block"><i class="fa fa-info-circle"></i> Total Invoice :</small>
                                <label class="text-grand-total-tnc m-0 font-weight-bold tx-14">Rp.<?= number_format(($total_price_thc + $tax_price_thc), 0, '.', '.'); ?></label>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right">
                        <small class="text-muted"><i class="fa fa-info-circle"></i> Dokumen & Materai : &nbsp;&nbsp;</small>
                        <label class="m-0 font-weight-bold text-materai" data-price="<?= $data_bs->price_materai; ?>">Rp.<?= number_format($data_bs->price_materai, 0, '.', '.'); ?></label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right">
                        <small class="text-muted"><i class="fa fa-info-circle"></i> Grand Total Harga : &nbsp;&nbsp;</small>
                        <label class="text-primary font-weight-bold all-grand-total-price tx-30">Rp.<?= number_format($all_grand_total, 0, '.', '.'); ?></label>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <a href="javascript:void(0)" class="custom chip border-dashed mb-2 mt-2 col-12">
        <span class="avatar cover-image bg-primary-gradient"><i class="fa fa-truck"></i></span> Loss Cargo
    </a>
    <div class="table-responsive">
        <table class="table table-bordered" id="id_table_item">
            <thead class="bg-primary-gradient text-white">
                <tr>
                    <th class="text-white" style="background-color:transparent;">Jenis Loss cargo</th>
                    <th class="text-white" style="background-color:transparent;">STUFFING</th>
                    <th class="text-white" style="background-color:transparent;">MUATAN</th>
                    <th class="text-white" style="background-color:transparent;">QTY</th>
                    <th class="text-white" style="background-color:transparent;">TOTAL</th>
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
                        if ($data_bs->is_confirm == 0) {
                            $btn_update_lc = '
                                    <div class="input-group-prepend">
                                        <a href="javascript:void(0)" class="btn btn-light btn_save_price_lc" data-id="' . $item_bs->id . '"><i class="fa fa-save"></i></a>
                                    </div>
                                ';
                            $readonly_lc = '';
                        }


                        //get datail
                        $get_detail_transport = Modules::run('database/find', 'tb_booking_has_lc', ['id_booking_detail' => $item_bs->id])->result();
                        $html_detail_transport = '';
                        foreach ($get_detail_transport as $item_transport) {
                            $html_detail_transport .= '
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-truck"></i></span>
                                        </div>
                                        <input class="form-control bg-white border-dashed" readonly value="' . $item_transport->transport_name . '" type="text">
                                    </div>
                                ';
                        }

                        echo '
                                <tr class="item_detail ">
                                    <td rowspan="2" colspan="2">
                                        <small for="" class="d-block text-muted">Jenis Kendaraan :</small>
                                        <label for=""> ' . strtoupper($item_bs->transport_name) . '</label>
                                        <small for="" class="d-block text-muted">Detail Kendaraan :</small>
                                        ' . $html_detail_transport . '
                                    </td>
                                    <td rowspan="2">
                                        <small class="d-block text-muted">Barang Muatan:</small>
                                        <label for="" class="d-block p-2 border-dashed">' . strtoupper($item_bs->category_stuff_name) . '</label>
                                        <small class="d-block text-muted">Keterangan :</small>
                                        <p for="" class="d-block p-2 border-dashed">' . nl2br(strtoupper($item_bs->transport_description)) . '</p>
                                    </td>
                                    <td>
                                        <small class="d-block text-muted">Jumlah :</small>
                                        <h3 class="mb-1">' . $item_bs->qty . '</h3>
                                    </td>
                                    <td style="width:350px;" class="item-price">
                                        <small class="d-block text-muted">Update Harga :</small>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text font-weight-bold">
                                                    Rp.
                                                </div>
                                            </div>
                                            <input value="' . number_format($item_bs->price, 0, '.', '.') . '" ' . $readonly_lc . ' data-target="text-count-' . $item_bs->id . '" data-qty="' . $item_bs->qty . '" class="form-control rupiah price_lc bg-white lc_' . $item_bs->id . '" data-id="' . $item_bs->id . '" name="price[' . $item_bs->id . ']"  type="text">
                                            ' . $btn_update_lc . '
                                        </div>
                                        <span class="help-block notif text-red text_' . $item_bs->id . '"></span>
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="2" class="text-right">
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
                    <td colspan="4" rowspan="4" class="text-right">
                        <div class="alert alert-default alert-dismissible fade show" role="alert">
                            <span class="alert-inner--icon"><i class="ti-bell"></i></span>
                            <span class="alert-inner--text"><strong>Info!</strong> Berikut adalah nilai yang ditagihkan ke customer :</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right">
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
                    <td colspan="2" class="text-right">
                        <small class="text-muted"><i class="fa fa-info-circle"></i> Pajak PPN : </small>
                        <label class="text-tax-lc m-0 tx-20" data-tax="<?= $tax_value; ?>">
                            Rp.<?= number_format($tax_price, 0, '.', '.'); ?><br>
                        </label>
                        <small class="d-block text-right  font-weight-bold text-primary "> <i class="fa fa-check-circle"></i> ( <?= $tax_text . ' ' . $tax_value . '%' ?> )</small>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right">
                        <small class="text-muted"><i class="fa fa-info-circle"></i> Grand Total Harga</small>
                        <h3 class="text-primary font-weight-bold all-total-lc">Rp.<?= number_format($all_grand_total, 0, '.', '.'); ?></h3>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>