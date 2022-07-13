<style>
    .table th,
    .table td {
        vertical-align: middle !important;
    }
</style>
<div class="row">
    <div class="col-4 ">
        <div class="card ">
            <div class="card-body">
                <div class="mb-0 row ">
                    <h4 class="col-md-8 text-uppercase card-title"><i class="fa fa-user"></i> Data customer</h4>
                    <div class="col-md-4 text-right"></div>
                    <div class="col-12">
                        <div class="row col-12 border-dashed" style="white-space:initial;">
                            <div class="col">
                                <div class=" mt-2 mb-2 text-primary tx-16 text-uppercase"><b><?= $data_customer->name; ?></b></div>
                                <p class="tx-11" style="white-space:initial;"><?= $data_customer->address; ?></p>
                            </div>
                            <div class="col-auto align-self-center ">
                                <div class="feature mt-0 mb-0">
                                    <i class="fe fe-user project bg-primary-transparent text-primary "></i>
                                </div>
                            </div>
                        </div>
                        <label for="" class="d-block mt-1">
                            <small class="text-muted"><i class="fa fa-circle"></i> Email :</small>
                            <span class="font-weight-bold"><?= $data_customer->email; ?></span>
                        </label>
                        <label for="" class="d-block">
                            <small class="text-muted"><i class="fa fa-circle"></i> Telp :</small>
                            <span class="font-weight-bold"><?= $data_customer->number_phone; ?></span>
                        </label>
                        <label for="" class="d-block">
                            <small class="text-muted"><i class="fa fa-circle"></i> Telp :</small>
                            <span class="font-weight-bold"><?= $data_customer->pic; ?></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-8 container_list">
        <div class="card">
            <div class="card-body">
                <div class="mb-0 row">
                    <h4 class="col-md-8 text-uppercase card-title"><i class="fa fa-box"></i> Harga Kontainer <span class="font-weight-bold text-primary">(THC)</span></h4>
                    <div class="col-md-4 text-right"></div>
                </div>
                <div class="tabs-style-3" style="border: none;">
                    <div class="tab-menu-heading">
                        <div class="tabs-menu ">
                            <!-- Tabs -->
                            <ul class="nav panel-tabs">
                                <?php
                                $counter = 0;
                                foreach ($list_depo as $item_depo) {
                                    $counter++;
                                    $active = $counter == 1 ? 'active' : '';
                                    echo '
                                        <li class=""><a href="#tab_' . $counter . '" class="' . $active . '" data-toggle="tab"><i class="fa fa-laptop"></i> DEPO : ' . strtoupper($item_depo->name) . '</a></li>
                                    ';
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="panel-body tabs-menu-body">
                        <div class="tab-content">
                            <?php
                            $counter = 0;
                            foreach ($list_depo as $item_depo) {
                                $counter++;
                                $active = $counter == 1 ? 'active' : '';

                                $counter_item = 0;
                                $total_rowspan_teus         = ((count($category_stuffing)) + 1);
                                $total_rowspan_countainer   = ($total_rowspan_teus * count($category_teus)) + 1;
                                $total_rowspan_depo         = ($total_rowspan_countainer * count($category_countainer)) + 1;
                                $html_content = '';

                                foreach ($category_countainer as $key_cat_caountainer => $item) {
                                    $cat_countainer_name = strtoupper($item);

                                    foreach ($category_teus as $key_teus => $item) {
                                        $cat_size_name = strtoupper($item);

                                        foreach ($category_stuffing as $key_take => $item_take) {
                                            $array_where = [
                                                'id_depo' => $item_depo->id,
                                                'category_countainer' => $key_cat_caountainer,
                                                'category_teus' => $key_teus,
                                                'category_stuffing_take' => $key_take,
                                                'type' => 2,
                                                'id_customer' => $data_customer->id,
                                                'is_default' => 1
                                            ];
                                            $get_data = Modules::run('database/find', 'tb_countainer_price', $array_where)->row();
                                            $price_current = isset($get_data->price) ? $get_data->price : 0;
                                            $unique_code =  $item_depo->id . $key_cat_caountainer . $key_teus . $key_take;

                                            $html_item = Modules::run('price_thc/create_html_item', $item_depo->id, $key_cat_caountainer, $key_teus, $key_take, $unique_code, $data_customer->id);
                                            //     //bnn access
                                            $btn_add = Modules::run('security/create_access', ' <small class="text-muted">(* klik untuk tambah harga)</small><a href="javascipt:void(0)" data-depo="' . $item_depo->id . '" data-countainer="' . $key_cat_caountainer . '" data-teus="' . $key_teus . '" data-stuffing="' . $key_take . '" data-unique="' . $unique_code . '" data-customer="' . $data_customer->id . '" class="btn btn-primary-gradient btn-rounded btn_add_price"><i class="fa fa-plus-circle"></i> Tambah Harga</a>');
                                            $html_content .= '
                                                    <tr>
                                                        <td>
                                                            <div class=" row shadow bg-white p-2 rounded ">
                                                                <div class="col-6 html_label_item_' . $unique_code . '">
                                                                    <label for="" class="p-2 border-dashed text-center">
                                                                        <small class="d-block text-muted"><i class="fa fa-check-circle"></i> Kategori Kontainer :</small>
                                                                        <span class="font-weight-bold">' . $cat_countainer_name . '</span>
                                                                    </label>
                                                                    <label for="" class="p-2 border-dashed text-center">
                                                                        <small class="d-block text-muted"><i class="fa fa-check-circle"></i> Size :</small>
                                                                        <span class="font-weight-bold">' . $cat_size_name . '</span>
                                                                    </label>
                                                                    <label for="" class="p-2 border-dashed text-center">
                                                                        <small class="d-block text-muted"><i class="fa fa-check-circle"></i> Stuffing :</small>
                                                                        <span class="font-weight-bold">' . strtoupper($item_take) . '</span>
                                                                    </label>
                                                                </div>
                                                                <div class="col-6 ">
                                                                <small class="d-block mb-1">Harga / Kontainer :</small>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text font-weight-bold">
                                                                                Rp.
                                                                            </div>
                                                                        </div>
                                                                        <input value="' . number_format($price_current, 0, '.', '.') . '" class="form-control money_only border-dashed font-weight-bold  bg-white" readonly   type="text">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                ';
                                        }
                                    }
                                }

                                echo '
                                        <div class="tab-pane ' . $active . '" id="tab_' . $counter . '">
                                            <table  class="table table-bordered table-hover dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <th><i class="fa fa-money-bill"></i> KATEGORI & HARGA</th>
                                                </thead>
                                                <tbody>' . $html_content . '</tbody>
                                            </table>
                                        </div>
                                    ';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- end main content-->

    <div class="modal fade" tabindex="-1" id="modal_form">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                </div>
                <form id="form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 text-center html_label_type"></div>
                            <div class="form-group col-12">
                                <label>Harga</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text font-weight-bold">
                                            Rp.
                                        </div>
                                    </div>
                                    <input class="form-control money_only form-control-lg" name="price" type="text">
                                </div>
                                <span class="help-block notif_price"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn_save"><i class="fa fa-save"></i> Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>