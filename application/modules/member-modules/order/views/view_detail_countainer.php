<div class="col-12 p-2">
    <h4>Daftar Kontainer :</h4>
    <div class="table-responsive">
        <table class="table table-bordered" id="id_table_item" data-container="body" data-popover-color="head-primary" data-placement="left" title="" data-content="Mohon detail kontainer diisi terlebih dahulu ." data-original-title="KONTAINER KOSONG">
            <thead class="bg-primary-gradient text-white">
                <tr>
                    <th class="text-white" style="background-color:transparent;">Jenis Kontainer</th>
                    <th class="text-white" style="background-color:transparent;">STUFFING</th>
                    <th class="text-white" style="background-color:transparent;">MUATAN</th>
                    <th class="text-white" style="background-color:transparent;">Kontainer</th>
                    <th class="text-white" style="background-color:transparent;">Tonase</th>
                    <th class="text-white" style="background-color:transparent;">No.segel</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="tbody_item_booking">
                <?php
                $grand_total_price = 0;
                foreach ($data_detail_bs as $item_bs) {
                    if ($item_bs->type != 1) {
                        continue;
                    }
                    $countiner_type = isset($category_countainer[$item_bs->category_countainer]) ? $category_countainer[$item_bs->category_countainer] : '';
                    $countainer_teus = isset($category_teus[$item_bs->category_teus]) ? $category_teus[$item_bs->category_teus] : 0;
                    $stuffing_take = isset($category_stuffing[$item_bs->stuffing_take]) ? $category_stuffing[$item_bs->stuffing_take] : 0;
                    $stuffing_open = isset($category_stuffing[$item_bs->stuffing_open]) ? $category_stuffing[$item_bs->stuffing_open] : 0;

                    //check price
                    $price_use = 0;
                    if ($item_bs->price) {
                        $price_use = $item_bs->price;
                    } else {

                        $array_where = [
                            'id_depo' => $id_depo_from,
                            'category_countainer' => $item_bs->category_countainer,
                            'category_teus' => $item_bs->category_teus,
                            'category_stuffing_take' => $item_bs->stuffing_take,
                            'category_stuffing_open' => $item_bs->stuffing_open
                        ];
                        $get_price = Modules::run('database/find', 'tb_countainer_price', $array_where)->row();
                        $price_use = $get_price->price;
                    }
                    $total_price = $price_use * $item_bs->qty;
                    $grand_total_price += $total_price;

                    $array_query = [
                        'select' => '
                            tb_booking_has_countainer.*,
                            mst_countainer.code AS countainer_code
                        ',
                        'from' => 'tb_booking_has_countainer',
                        'join' => [
                            'mst_countainer, tb_booking_has_countainer.id_countainer = mst_countainer.id, left'
                        ],
                        'where' => [
                            'tb_booking_has_countainer.id_booking_detail' => $item_bs->id
                        ]
                    ];
                    $get_data_countainer = Modules::run('database/get', $array_query)->result();
                    $count_data = Modules::run('database/get', $array_query)->num_rows();
                    $row_span = $count_data > 1 ?  $count_data + 1 : 2;

                    $html_td_container = '';
                    foreach ($get_data_countainer as $item_countainer) {

                        $html_code_coutainer = '
                            <h2><span class="badge badge-light">' . $item_countainer->countainer_code . '</span></h2>
                        ';
                        $html_lock = '
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text font-weight-bold">
                                        <i class="fa fa-lock"></i>
                                    </div>
                                </div>
                                <input value="' . $item_countainer->seal_code . '" data-target="text-count-' . $item_bs->id . '" data-qty="' . $item_bs->qty . '" class="form-control rupiah count_price_item bg-white" readonly disabled  type="text">
                            </div>
                        ';
                        $html_track = '
                            <a href="javascript:void(0)" data-id="' . $item_bs->id_booking . '" data-countainer="' . $item_countainer->id_countainer . '" class="btn btn-primary">Tracking</a>
                        ';
                        $html_tonase = $item_countainer->total_tonase . ' TON';

                        if ($item_countainer->countainer_code == '') {
                            $html_code_coutainer = ' <small>Belum Diisi</small> ';
                            $html_track = '-';
                        }
                        if ($item_countainer->seal_code == '') {
                            $html_lock = ' <small>Belum Diisi</small> ';
                        }
                        if ($item_countainer->total_tonase == 0) {
                            $html_tonase = ' <small>Belum Diisi</small> ';
                        }

                        $html_td_container .= '
                            <tr>
                                <td>' . $html_code_coutainer . '</td>
                                <td>' . $html_tonase . '</td>
                                <td>' . $html_lock . '</td>
                                <td>' . $html_track . '</td>
                            </tr>
                        ';
                    }

                    echo '
                        <tr class="item_detail item_container countainer_2124">
                            <td rowspan="' . $row_span . '">
                                <small for="" class="d-block text-muted">Kategori Kontainer :</small>
                                <label for=""> ' . strtoupper($countiner_type) . '</label>
                                <small for="" class="d-block text-muted">Teus :</small>
                                <label for=""> ' . strtoupper($countainer_teus) . ' FEET</label>
                            </td>
                            <td rowspan="' . $row_span . '">
                                <small for="" class="d-block text-muted">Stuffing (Pengisian) :</small>
                                <label for="" class="m-0"> ' . strtoupper($stuffing_take) . '</label>
                                <p class="border-dashed tx-13 p-1 mb-1">
                                    Alamat :<br>
                                    ' . $item_bs->stuffing_take_address . '
                                </p>
                                <small for="" class="d-block text-muted">Stuffing (Pengambilan) :</small>
                                <label for="" class="m-0"> ' . strtoupper($stuffing_open) . '</label>
                                <p class="border-dashed tx-13 p-1 m-0">
                                    Alamat :<br>
                                    ' . $item_bs->stuffing_open_address . '
                                </p>
                            </td>
                            <td rowspan="' . $row_span . '">
                                <small class="d-block text-muted">Kategori Barang Muatan :</small>
                                <label for="" class="d-block p-2 border-dashed">' . strtoupper($item_bs->category_load_name) . '</label>
                                <small class="d-block text-muted">Barang Muatan:</small>
                                <label for="" class="d-block p-2 border-dashed">' . strtoupper($item_bs->category_stuff_name) . '</label>
                            </td>
                        </tr>
                        ' . $html_td_container . '
                        
                    ';
                }
                ?>

            </tbody>
        </table>
    </div>
</div>