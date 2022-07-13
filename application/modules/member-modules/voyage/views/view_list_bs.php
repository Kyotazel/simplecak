<div class="col-12">
    <h3>Daftar Booking Slot</h3>
    <div class="table-responsive">
        <table class="table table-bordered t-shadow" id="table_detail_bs">
            <thead class="bg-primary-gradient text-white">
                <tr>
                    <th class="text-white" style="background-color:transparent;width:5%;">No</th>
                    <th class="text-white" style="background-color:transparent;width:30%;">Booking Slot</th>
                    <th class="text-white" style="background-color:transparent;">Kategori Kontainer</th>
                </tr>
            </thead>
            <tbody class="tbody_item_booking">
                <?php
                $counter  = 0;
                foreach ($data_bs as $item_bs) {
                    $counter++;
                    $array_query_detail_bs = [
                        'select' => '
                            tb_booking_has_detail.*,
                            mst_category_load.name AS category_load_name,
                            mst_category_stuff.name AS category_stuff_name,
                            mst_transportation.name AS transport_name
                        ',
                        'from' => 'tb_booking_has_detail',
                        'where' => [
                            'id_booking' =>  $item_bs->id
                        ],
                        'join' => [
                            'mst_category_load, tb_booking_has_detail.id_category_load = mst_category_load.id , left',
                            'mst_category_stuff, tb_booking_has_detail.id_category_stuff = mst_category_stuff.id , left',
                            'mst_transportation, tb_booking_has_detail.id_transportation = mst_transportation.id , left'
                        ]
                    ];

                    $data_detail_bs = Modules::run('database/get', $array_query_detail_bs)->result();

                    $html_item_countainer = '';
                    $html_item_lc = '';
                    $total_teus = 0;
                    $total_qty_countainer = 0;
                    $total_price = 0;

                    $total_qty_lc = 0;
                    $total_price_lc = 0;
                    $grand_total_price = 0;

                    foreach ($data_detail_bs as $item_detail_bs) {
                        if ($item_detail_bs->type == 1) {
                            $countiner_type = isset($category_countainer[$item_detail_bs->category_countainer]) ? $category_countainer[$item_detail_bs->category_countainer] : '';
                            $countainer_teus = isset($category_teus[$item_detail_bs->category_teus]) ? $category_teus[$item_detail_bs->category_teus] : 0;
                            $service_type = isset($category_service[$item_detail_bs->category_service]) ? $category_service[$item_detail_bs->category_service] : '';
                            $total_teus += ($countainer_teus * $item_detail_bs->qty);
                            $total_qty_countainer += $item_detail_bs->qty;
                            $total_price += ($item_detail_bs->qty * $item_detail_bs->price);
                            $html_item_countainer .= '
                                <div class="p-1 border-dashed rounded row">
                                    <label for="" class="col-7 m-0 font-weight-bold">
                                        ' . strtoupper($countiner_type) . ' (' . strtoupper($countainer_teus) . ' FEET)
                                    </label>
                                    <label for="" class="col-5 m-0 text-right">' . $item_detail_bs->qty . ' x ' . number_format($item_detail_bs->price, 0, '.', '.') . '</label>
                                    <small class="d-block col-12">
                                        <span class="text-muted"><i class="fa fa-check-circle"></i> Barang : </span> ' . strtoupper($item_detail_bs->category_load_name) . ' - ' . strtoupper($item_detail_bs->category_stuff_name) . '
                                    </small>
                                    <small class="d-block col-12">
                                        <span class="text-muted"><i class="fa fa-check-circle"></i> Service : </span> ' . strtoupper($service_type) . '
                                    </small>
                                </div>
                            ';
                        } else {
                            $total_qty_lc += $item_detail_bs->qty;
                            $total_price_lc += ($item_detail_bs->qty * $item_detail_bs->price);
                            $html_item_lc .= '
                                <div class="p-1 border-dashed rounded row">
                                    <label for="" class="col-7 m-0 font-weight-bold">
                                        ' . strtoupper($item_detail_bs->transport_name) . ' 
                                    </label>
                                    <label for="" class="col-5 m-0 text-right">' . $item_detail_bs->qty . ' x ' . number_format($item_detail_bs->price, 0, '.', '.') . '</label>
                                    <small class="d-block col-12">
                                        <span class="text-muted"><i class="fa fa-check-circle"></i> Barang : </span> ' . strtoupper($item_detail_bs->category_load_name) . ' - ' . strtoupper($item_detail_bs->category_stuff_name) . '
                                    </small>
                                    <small class="d-block col-12">
                                        <span class="text-muted"><i class="fa fa-check-circle"></i> Keterangan : </span> ' . nl2br(strtoupper($item_detail_bs->transport_description)) . '
                                    </small>
                                </div>
                            ';
                        }

                        $grand_total_price += $item_detail_bs->total_price;
                    }

                    $html_item_countainer .= '
                        <div class="row   align-items-center">
                            <label for="" class="col-4 m-0">Resume :</label>
                            <div class="col-3">
                                <small class="d-block text-muted">Qty :</small>
                                <h4 class="mb-1">' . $total_qty_countainer . '</h4>
                            </div>
                            <div class="col-3">
                                <small class="d-block text-muted">Total Teus :</small>
                                <h4 class="mb-1">' . $total_teus . '</h4>
                            </div>
                            <div class="col-12 mb-1">
                                <small class="d-block text-muted">Grand Total Harga :</small>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text font-weight-bold">
                                            Rp.
                                        </div>
                                    </div>
                                    <input value="' . number_format($total_price, 0, '.', '.') . '" data-target="text-count-13" data-qty="2" class="form-control border-dashed  font-weight-bold rupiah count_price_item bg-white" name="price[13]" type="text">
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
                                <div class="row  align-items-center">
                                    <label for="" class="col-4 m-0">Resume :</label>
                                    <div class="col-3">
                                        <small class="d-block text-muted">Qty :</small>
                                        <h4 class="mb-1">' . $total_qty_lc . '</h4>
                                    </div>
                                    <div class="col-12 mb-1">
                                        <small class="d-block text-muted">Grand Total Harga :</small>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text font-weight-bold">
                                                    Rp.
                                                </div>
                                            </div>
                                            <input value="' . number_format($total_price_lc, 0, '.', '.') . '" data-target="text-count-13" data-qty="2" class="form-control border-dashed  font-weight-bold rupiah count_price_item bg-white" name="price[13]" type="text">
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


                    $tax_text   = $item_bs->ppn > 0 ? 'Include' : 'Exclude';
                    $tax_value  = $item_bs->ppn;
                    $tax_price  = $tax_value > 0 ? $grand_total_price * ($tax_value / 100) : 0;
                    $all_grand_total = $grand_total_price + $tax_price;
                    $data['data_bs'] = $item_bs;

                    $html_detail_item = $this->load->view('component_item_booking_countainer_lc', $data, TRUE);

                    echo '
                            <tr class="">
                                <td>' . $counter . '</td>
                                <td>
                                    <h3 class="text-center"><span class="badge badge-light">' . $item_bs->code . '</span></h3>
                                    
                                    <div class="p-1 rounded border-dashed d-block text-center text-capitalize font-weight-bold">
                                        <span class="text-primary text-uppercase"> <i class="fa-lg fa fa-    project bg-primary-transparent mx-auto "></i> ' . $booking_status[$item_bs->status] . '</span><br>
                                        <small class="text-muted"><i class="fa fa-calendar"></i> ' . Modules::run('helper/date_indo', $item_bs->date, '-') . '</small>
                                    </div>
                                    
                                
                                    <div class="row col-12 border-dashed">
                                        <div class="col">
                                            <div class=" mt-2 mb-2 text-primary"><b>' . $item_bs->customer_name . '</b></div>
                                            <p class="tx-12">' . $item_bs->customer_address . '</p>
                                        </div>
                                        <div class="col-auto align-self-center ">
                                            <div class="feature mt-0 mb-0">
                                                <i class="fe fe-user project bg-primary-transparent text-primary "></i>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    ' . $html_detail_item . '
                                
                                </td>
                            </tr>
                        ';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>