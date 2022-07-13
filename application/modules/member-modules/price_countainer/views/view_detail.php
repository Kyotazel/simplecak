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
                    <h4 class="col-md-8 text-uppercase card-title"><i class="fa fa-box"></i> Harga Kontainer <span class="font-weight-bold text-primary">(FREIGHT)</span></h4>
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
                                    // $html_content .= '
                                    //     <tr>
                                    //         <td rowspan="' . $total_rowspan_countainer . '"><h4>' . strtoupper($item) . '</h4></td>
                                    //     </tr>
                                    // ';
                                    $cat_countainer_name = strtoupper($item);

                                    foreach ($category_teus as $key_teus => $item) {
                                        // $html_content .= '
                                        //     <tr>
                                        //         <td rowspan="' . $total_rowspan_teus . '"><h4>' . strtoupper($item) . '</h4></td>
                                        //     </tr>
                                        // ';
                                        $cat_size_name = strtoupper($item);

                                        foreach ($category_stuffing as $key_take => $item_take) {
                                            $array_where = [
                                                'id_depo' => $item_depo->id,
                                                'category_countainer' => $key_cat_caountainer,
                                                'category_teus' => $key_teus,
                                                'category_stuffing_take' => $key_take,
                                                'type' => 1,
                                                'id_customer' => $data_customer->id
                                            ];
                                            $get_data = Modules::run('database/find', 'tb_countainer_price', $array_where)->result();
                                            $unique_code =  $item_depo->id . $key_cat_caountainer . $key_teus . $key_take;

                                            $get_price = Modules::run(
                                                'database/find',
                                                'tb_countainer_price',
                                                [
                                                    'type' => 1,
                                                    'id_customer' => $data_customer->id,
                                                    'id_depo' => $item_depo->id,
                                                    'category_countainer' => $key_cat_caountainer,
                                                    'category_teus' => $key_teus,
                                                    'category_stuffing_take' => $key_take,
                                                    'is_default' => 1
                                                ]
                                            )->row();

                                            $price_current = isset($get_price->price) ? $get_price->price : 0;

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