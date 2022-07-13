<div class="col-12">
    <h3>Daftar Invoice Activity</h3>
    <div class="table-responsive">
        <table class="table table-bordered t-shadow" id="table_detail_bs">
            <thead class="bg-primary-gradient text-white">
                <tr>
                    <th class="text-white" style="background-color:transparent;width:5%;">No</th>
                    <th class="text-white" style="background-color:transparent;width:30%;">Booking Slot</th>
                    <th class="text-white" style="background-color:transparent;">Resume Activity</th>
                </tr>
            </thead>
            <tbody class="tbody_item_booking">
                <?php
                $counter  = 0;
                foreach ($data_bs as $item_bs) {
                    $counter++;
                    $html_detail_item = '';

                    $get_all_invoice = Modules::run('database/find', 'tb_invoice', ['type' => 4, 'id_booking' => $item_bs->id])->result();
                    if (!empty($get_all_invoice)) {
                        foreach ($get_all_invoice as $item_invoice) {
                            $html_detail_item .= '
                                <div class="row ">
                                    <div class="col-4 border-dashed d-flex  align-items-center ">
                                        <label class="tag mb-1 text-decoration-underline">No. Invoice</label>
                                    </div>
                                    <div class="col-8 border-dashed p-2">
                                        <small class="text-muted d-block"><i class="fa fa-info-circle"></i> Total Invoice :</small>
                                        <label class=" text-grand-total-freight font-weight-bold m-0 tx-20 text-primary">' . $item_invoice->code . '</label>
                                        <small class="d-block "> <i class="fa fa-file"></i> ( Total tagihan : <b>Rp.' . number_format($item_invoice->total_invoice, 0, '.', '.') . '</b> )</small>
                                    </div>
                                </div>
                            ';
                        }

                        $html_detail_item = '
                            <div class="mb-3">
                                ' . $html_detail_item . '
                                <div class="text-right mt-2">
                                    <a href="javascript:void(0)" data-id="' . $item_bs->id . '" class="btn btn-primary-gradient btn_preview_invoice_activity"><i class="fa fa-file"></i> Preview Invoice</a>
                                </div>
                            </div>
                        ';
                    }

                    $array_query_activity = [
                        'select' => '
                            tb_booking_has_countainer_activity.*,
                            tb_category_activity.name AS activity_name,
                            SUM(qty) AS total_qty,
                            SUM(total_price) AS grand_total_price
                        ',
                        'from' => 'tb_booking_has_countainer_activity',
                        'join' => [
                            'tb_category_activity, tb_booking_has_countainer_activity.id_activity_booking = tb_category_activity.id , left'
                        ],
                        'where' => [
                            'tb_booking_has_countainer_activity.id_booking' => $item_bs->id,
                            'tb_booking_has_countainer_activity.id_invoice' => 0
                        ],
                        'order_by' => 'tb_category_activity.name',
                        'group_by' => 'tb_booking_has_countainer_activity.id_activity_booking'
                    ];
                    $get_activity = Modules::run('database/get', $array_query_activity)->result();
                    if (!empty($get_activity)) {
                        $grand_total = 0;
                        foreach ($get_activity as $item) {
                            $html_detail_item .= '
                            <div class="row">
                                <div class="col-5 p-1 border-dashed">
                                    <small class="text-muted d-block">Nama Activity :</small>
                                    <label for="" class="m-0 tag mb-1 text-decoration-underline">' . strtoupper($item->activity_name) . '</label>
                                </div>
                                <div class="col-2 p-1 border-dashed">
                                    <small class="text-muted d-block">Total Qty :</small>
                                    <label for="" class="m-0 font-weight-bold d-block">' . strtoupper($item->total_qty) . '</label>
                                </div>
                                <div class="col-5 p-1 border-dashed">
                                    <small class="text-muted">Total Harga :</small>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text font-weight-bold">
                                                Rp.
                                            </div>
                                        </div>
                                        <input value="' . number_format($item->grand_total_price, 0, '.', '.') . '" data-target="text-count-13" data-qty="2" class="form-control border-dashed bg-white font-weight-bold" readonly name="price[13]" type="text">
                                    </div>
                                </div>
                            </div>
                        ';
                            $grand_total += $item->grand_total_price;
                        }

                        $html_detail_item .= '
                            <div class="row">
                                <div class="col-7 p-1  border-dashed">
                                    <small>Berikut nilai yang ditagihkan kepada customer</small>
                                    <h4 class="font-weight-bold">Grand Total tagihan :</h4>
                                </div>
                                <div class="col-5 p-1 border-dashed">
                                    <small class="text-muted">Grand Total Harga :</small>
                                    <h4 class="text-primary font-weight-bold">Rp.' . number_format($grand_total, 0, '.', '.') . '</h4>
                                </div>
                            </div>
                            <div class="col-12 text-right mt-2">
                                <a href="javascript:void(0)" data-id="' . $item_bs->id . '" class="btn btn-warning-gradient btn-rounded font-weight-bold btn_preview_detail_activity">Rilis Invoice <i class="fa fa-paper-plane"></i></a>
                            </div>
                        ';
                    }



                    if (empty($get_activity) && empty($get_all_invoice)) {
                        $html_detail_item = '
                        <div class="col-12 text-center">
                            <div class="plan-card text-center">
                                <i class="fas fa-file plan-icon text-primary"></i>
                                <h6 class="text-drak text-uppercase mt-2">Data Kosong</h6>
                                <small class="text-muted">Tidak ada item activity.</small>
                            </div>
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
                                <td class="countainer_invoice_' . $item_bs->id . '">
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



<div class="modal fade" tabindex="-1" id="modal_detail_activity" data-backdrop="static">
    <div class="modal-dialog" style="max-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">DETAIL AKTIFITAS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </div>
            <div class="modal-body">
                <div class="html_respon_activity"></div>
            </div>
        </div>
    </div>
</div>