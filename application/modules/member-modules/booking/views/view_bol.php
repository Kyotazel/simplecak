<div class="col-12">
    <h3>Bill Of Lading</h3>
    <div class="table-responsive">
        <table class="table table-bordered t-shadow" id="table_detail_bs">
            <thead class="bg-primary-gradient text-white">
                <tr>
                    <th class="text-white" style="background-color:transparent;width:5%;">No</th>
                    <th class="text-white" style="background-color:transparent;width:35%;">Booking Slot</th>
                    <th class="text-white" style="background-color:transparent;">Kategori Kontainer</th>
                    <th class="text-white" style="background-color:transparent;width:20%">NO Dokumen</th>
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
                            mst_category_stuff.name AS category_stuff_name
                        ',
                        'from' => 'tb_booking_has_detail',
                        'where' => [
                            'id_booking' =>  $item_bs->id,
                            'tb_booking_has_detail.type' => 1
                        ],
                        'join' => [
                            'mst_category_load, tb_booking_has_detail.id_category_load = mst_category_load.id , left',
                            'mst_category_stuff, tb_booking_has_detail.id_category_stuff = mst_category_stuff.id , left'
                        ]
                    ];

                    $data_detail_bs = Modules::run('database/get', $array_query_detail_bs)->result();

                    $html_item_countainer = '';
                    $total_teus = 0;
                    $total_qty_countainer = 0;
                    $total_price = 0;
                    foreach ($data_detail_bs as $item_detail_bs) {
                        $countiner_type = isset($category_countainer[$item_detail_bs->category_countainer]) ? $category_countainer[$item_detail_bs->category_countainer] : '';
                        $countainer_teus = isset($category_teus[$item_detail_bs->category_teus]) ? $category_teus[$item_detail_bs->category_teus] : 0;
                        $service_type = isset($category_service[$item_detail_bs->category_service]) ? $category_service[$item_detail_bs->category_service] : '';
                        $total_teus += ($countainer_teus * $item_detail_bs->qty);
                        $total_qty_countainer += $item_detail_bs->qty;
                        $total_price += ($item_detail_bs->qty * $item_detail_bs->price);
                        $html_item_countainer .= '
                        <div class="p-1 border-dashed rounded row">
                            <label for="" class="col-9 m-0 font-weight-bold">
                                ' . strtoupper($countiner_type) . ' (' . strtoupper($countainer_teus) . ' TEUS)
                            </label>
                            <label for="" class="col-3 font-weight-bold m-0 tx-16"> x ' . $item_detail_bs->qty . ' </label>
                            <small class="d-block col-12">
                                <span class="text-muted"><i class="fa fa-check-circle"></i> Barang : </span> ' . strtoupper($item_detail_bs->category_load_name) . ' - ' . strtoupper($item_detail_bs->category_stuff_name) . '
                            </small>
                            <small class="d-block col-12">
                                <span class="text-muted"><i class="fa fa-check-circle"></i> Service : </span> ' . strtoupper($service_type) . '
                            </small>
                        </div>
                    ';
                    }

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
                                    ' . $html_item_countainer . '
                                </td>
                                <td>
                                    <div class="p-2 border-dashed rounded">
                                        <small class="d-block">SO NUMBER :</small>
                                        <h6 class="m-0 p-0">W-SO-2021-12-000509</h6>
                                    </div>
                                    <div class="p-2 border-dashed rounded">
                                        <small class="d-block">NO BL :</small>
                                        <h6 class="m-0 p-0">W-SO-2021-12-000509</h6>
                                    </div>
                                    <div class="text-center mt-2">
                                        <a href="javascript:void(0)" data-type="3" data-so="" data-bs="' . $item_bs->id . '"  class="btn btn-block btn-primary-gradient btn_print_bl"><i class="fa fa-print"></i> Cetak Dokumen</a>
                                    </div>
                                </td>
                            </tr>
                        ';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>