<style>
    .table th,
    .table td {
        vertical-align: middle !important;
    }
</style>
<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12 container_list">
        <div class="card">
            <div class="card-body">
                <div class="mb-3 row">
                    <h3 class="col-md-8 text-uppercase">Harga Kontainer <span class="font-weight-bold text-primary">(THC)</span></h3>
                    <div class="col-md-4 text-right">
                    </div>
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
                                    $html_content .= '
                                        <tr>
                                            <td rowspan="' . $total_rowspan_countainer . '"><h4>' . strtoupper($item) . '</h4></td>
                                        </tr>
                                    ';
                                    $cat_countainer_name = strtoupper($item);

                                    foreach ($category_teus as $key_teus => $item) {
                                        $html_content .= '
                                            <tr>
                                                <td rowspan="' . $total_rowspan_teus . '"><h4>' . strtoupper($item) . '</h4></td>
                                            </tr>
                                        ';
                                        $cat_size_name = strtoupper($item);

                                        foreach ($category_stuffing as $key_take => $item_take) {



                                            // data-depo="' . $item_depo->id . '" data-teus="' . $key_teus . '" data-coutainer="' . $key_cat_caountainer . '"  data-stuffing-open="' . $key_open . '" data-stuffing-take="' . $key_take . '" 

                                            $array_where = [
                                                'id_depo' => $item_depo->id,
                                                'category_countainer' => $key_cat_caountainer,
                                                'category_teus' => $key_teus,
                                                'category_stuffing_take' => $key_take,
                                                'type' => 2
                                            ];
                                            $get_data = Modules::run('database/find', 'tb_countainer_price', $array_where)->result();
                                            $unique_code =  $item_depo->id . $key_cat_caountainer . $key_teus . $key_take;
                                            $html_item = '';
                                            foreach ($get_data as $item_price) {
                                                $status_active = $item_price->is_default ? 'on' : '';
                                                $html_item .= '
                                                    <div class="col-md-12 row p-2 border-dashed">
                                                        <div class="col-6 border-right">
                                                            <small class="d-block mb-1">Harga :</small>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text font-weight-bold">
                                                                        Rp.
                                                                    </div>
                                                                </div>
                                                                <input value="' . number_format($item_price->price, 0, '.', '.') . '" class="form-control money_only border-dashed font-weight-bold  bg-white" readonly id="' . $item_depo->id . $key_teus . $key_cat_caountainer . $key_take . '"  type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col-2 border-right d-flex flex-wrap justify-content-center">
                                                            <small class="d-block mb-1">Status Default :</small>
                                                            <div data-unique="' . $unique_code . '" data-id="' . $item_price->id . '" class="main-toggle main-toggle-dark change_status status_' . $unique_code . ' ' . $status_active . '"><span></span></div>
                                                        </div>
                                                        <div class="col-4">
                                                            <small class="d-block mb-1">Aksi :</small>
                                                            <a href="javascript:void(0)"  data-id="' . $item_price->id . '"  data-depo="' . $item_depo->id . '" data-countainer="' . $key_cat_caountainer . '" data-teus="' . $key_teus . '" data-stuffing="' . $key_take . '" data-unique="' . $unique_code . '" class="btn btn-warning-gradient btn-rounded btn_update"><i class="fa fa-edit"></i> Update</a>
                                                            <a href="javascript:void(0)" data-id="' . $item_price->id . '"  data-depo="' . $item_depo->id . '" data-countainer="' . $key_cat_caountainer . '" data-teus="' . $key_teus . '" data-stuffing="' . $key_take . '" data-unique="' . $unique_code . '" class="btn btn-danger-gradient btn-rounded btn_delete"><i class="fa fa-trash"></i> Hapus</a>
                                                        </div>
                                                    </div>
                                                ';
                                            }

                                            if (empty($get_data)) {
                                                $html_item = '
                                                <div class="plan-card text-center col-12">
                                                    <i class="fas fa-file plan-icon text-primary"></i>
                                                    <h6 class="text-drak text-uppercase mt-2">Data Kosong</h6>
                                                    <small class="text-muted">Tidak ada daftar harga.</small>
                                                </div>
                                                
                                                ';
                                            }

                                            $html_content .= '
                                                    <tr>
                                                        <td>' . strtoupper($item_take) . '</td>
                                                        <td>
                                                            <div class=" row">
                                                                <div class="col-8 html_label_item_' . $unique_code . '">
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
                                                                <div class="col-4 text-right">
                                                                    <small class="text-muted">(* klik untuk tambah harga)</small>
                                                                    <a href="javascipt:void(0)" data-depo="' . $item_depo->id . '" data-countainer="' . $key_cat_caountainer . '" data-teus="' . $key_teus . '" data-stuffing="' . $key_take . '" data-unique="' . $unique_code . '" class="btn btn-primary-gradient btn_add_price"><i class="fa fa-plus-circle"></i> Tambah Harga</a>
                                                                </div>
                                                            </div>
                                                            <div class="row shadow bg-white p-2 rounded html_container_price_' . $unique_code . '" >
                                                                ' . $html_item . '
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
                                                    <th style="width: 20%;">Kategori Kontainer</th>
                                                    <th style="width: 9%;">SIZE (FEET)</th>
                                                    <th style="width: 10%;">STUFFING </th>
                                                    <th >HARGA</th>
                                                </thead>
                                                <tbody>' . $html_content . '</tbody>
                                            </table>
                                        </div>
                                    ';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="text-right pt-3">
                        <form class="form-print" method="POST" action="<?= Modules::run('helper/create_url', 'division/print'); ?>">
                            <small>(*klik untuk export)</small>
                            <button type="submit" name="print_excel" value="1" class="btn  btn-outline-dark"> <i class="mdi mdi-file-excel"></i> Cetak Excel</button>
                            <button type="submit" name="print_pdf" value="1" class="btn  btn-outline-dark"> <i class="mdi mdi-file-pdf"></i> Cetak PDF</button>
                        </form>
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