<?php
$array_query  = [
    'select' => '
        tb_booking_has_countainer.*,
        tb_booking.code AS booking_code,
        tb_booking.date AS booking_date,
        tb_booking_has_detail.id_category_load,
        tb_booking_has_detail.id_category_stuff,
        tb_booking_has_detail.category_countainer,
        tb_booking_has_detail.category_teus,
        tb_booking_has_detail.category_service,
        tb_booking_has_detail.stuffing_take,
        tb_booking_has_detail.stuffing_open,
        tb_booking_has_detail.stuffing_take_address,
        tb_booking_has_detail.stuffing_open_address,
        mst_category_load.name AS category_load_name,
        mst_category_stuff.name AS category_stuff_name,
        mst_countainer.code AS countainer_code,
        mst_countainer.barcode AS countainer_barcode
        
    ',
    'from' => 'tb_booking_has_countainer',
    'join' => [
        'mst_countainer , tb_booking_has_countainer.id_countainer = mst_countainer.id , left',
        'tb_booking , tb_booking_has_countainer.id_booking = tb_booking.id , left',
        'tb_booking_has_detail , tb_booking_has_countainer.id_booking_detail = tb_booking_has_detail.id , left',
        'mst_category_load, tb_booking_has_detail.id_category_load = mst_category_load.id , left',
        'mst_category_stuff, tb_booking_has_detail.id_category_stuff = mst_category_stuff.id , left'
    ],
    'where' => [
        'tb_booking.is_confirm' => 1,
        'tb_booking.id_voyage' => $data_voyage->id
    ]
];
$get_data_countainer = Modules::run('database/get', $array_query)->result();

?>
<div class="col-md-12">
    <h3>Daftar Kontainer</h3>
    <div class="table-responsive">
        <table class="table table-bordered" id="table_list_countainer">
            <thead class="bg-primary-gradient text-white" style="position: sticky;top: 0">
                <tr>
                    <th class="text-white" style="background-color:transparent;">No</th>
                    <th class="text-white" style="background-color:transparent;">Booking Slot</th>
                    <th class="text-white" style="background-color:transparent;">Jenis Kontainer</th>
                    <th class="text-white" style="background-color:transparent;">STUFFING</th>
                    <th class="text-white" style="background-color:transparent;">MUATAN</th>
                    <th class="text-white" style="background-color:transparent;">Kontainer</th>
                    <th class="text-white" style="background-color:transparent;">SEGEL</th>
                    <th class="text-white" style="background-color:transparent;">Tonase</th>

            </thead>
            <tbody class="tbody_item_booking">
                <?php
                $counter = 0;
                foreach ($get_data_countainer as $item_countainer) {
                    $countiner_type = isset($category_countainer[$item_countainer->category_countainer]) ? $category_countainer[$item_countainer->category_countainer] : '';
                    $countainer_teus = isset($category_teus[$item_countainer->category_teus]) ? $category_teus[$item_countainer->category_teus] : 0;
                    $service_type = isset($category_service[$item_countainer->category_service]) ? $category_service[$item_countainer->category_service] : '';
                    $stuffing_take = isset($category_stuffing[$item_countainer->stuffing_take]) ? $category_stuffing[$item_countainer->stuffing_take] : 0;
                    $stuffing_open = isset($category_stuffing[$item_countainer->stuffing_open]) ? $category_stuffing[$item_countainer->stuffing_open] : 0;
                    $counter++;

                    $html_act = '';
                    $html_act = '
                        <div class="text-center">
                            <img style="width:80px;" src="' . base_url('upload/barcode/' . $item_countainer->countainer_barcode) . '" alt="">
                            <label class="d-block font-weight-bold">' . $item_countainer->countainer_code . '</label>
                        </div>
                    ';
                    $html_seal = '-';
                    if (!empty($item_countainer->seal_code)) {
                        $barcode = $item_countainer->seal_code . '.png';
                        $html_seal = '
                        <div class="text-center">
                            <img style="width:80px;" src="' . base_url('upload/barcode/' . $barcode) . '" alt="">
                            <label class="d-block font-weight-bold">' . $item_countainer->seal_code . '</label>
                        </div>
                        ';
                    }

                    $html_tonase = '';
                    if ($item_countainer->total_tonase > 0) {
                        $html_tonase = '
                            <div class="row p-2 border-dashed" style="width:200px">
                                <div class="col">
                                    <div class="">
                                        <small class="text-uppercase tx-9"><i class="fa fa-info-circle"></i> Berat Kontainer </small>
                                    </div>
                                    <div class="h2 mt-2 mb-2"><b>' . $item_countainer->total_tonase . '</b><span class="text-primary tx-13 ml-2">(Kg)</span></div>
                                </div>
                                <div class="col-auto align-self-center ">
                                    <div class="feature mt-0 mb-0">
                                        <i class="mdi mdi-cube project bg-primary-transparent text-primary "></i>
                                    </div>
                                </div>
                            </div>
                        ';
                    }

                    echo '
                        <tr class="item_detail item_container countainer_2124">
                            <td>' . $counter . '</td>
                            <td>
                                <h3 class="text-center"><span class="badge badge-light">' . $item_countainer->booking_code . '</span></h3>
                                <small class="d-block p-2 border-dashed text-muted text-center"><i class="fa fa-calendar"></i> ' . Modules::run('helper/date_indo', $item_countainer->booking_date, '-') . '</small>
                            </td>
                            <td>
                                <small for="" class="d-block text-muted"> Kategori Kontainer :</small>
                                <label for=""> ' . strtoupper($countiner_type) . '</label>
                                <small for="" class="d-block text-muted">Teus :</small>
                                <label for=""> ' . strtoupper($countainer_teus) . ' TEUS</label>
                                <small for="" class="d-block text-muted">Service :</small>
                                <label for=""> ' . strtoupper($service_type) . ' </label>
                            </td>
                            <td>
                                <small for="" class="d-block text-muted">Stuffing (Pengisian) :</small>
                                <label for="" class="m-0"> ' . strtoupper($stuffing_take) . '</label>
                                <p class="border-dashed tx-13 p-1 mb-1">
                                    Alamat :<br>
                                    ' . $item_countainer->stuffing_take_address . '
                                </p>
                                <small for="" class="d-block text-muted mt-2">Stuffing (Pengambilan) :</small>
                                <label for="" class="m-0"> ' . strtoupper($stuffing_open) . '</label>
                                <p class="border-dashed tx-13 p-1 m-0">
                                    Alamat :<br>
                                    ' . $item_countainer->stuffing_open_address . '
                                </p>
                            </td>
                            <td>
                                <small class="d-block text-muted">Kategori Barang Muatan :</small>
                                <label for="" class="d-block p-2 border-dashed">' . strtoupper($item_countainer->category_load_name) . '</label>
                                <small class="d-block text-muted">Barang Muatan:</small>
                                <label for="" class="d-block p-2 border-dashed">' . strtoupper($item_countainer->category_stuff_name) . '</label>
                            </td>
                            <td class="html_respon_countainer_' . $item_countainer->id . '">
                                ' . $html_act . '
                            </td>
                            <td>' . $html_seal . '</td>
                            <td>' . $html_tonase . '</td>
                        </tr>
                        ';
                }
                ?>

            </tbody>
        </table>
    </div>
</div>


<div class="modal fade" tabindex="-1" id="modal_mst_countainer">
    <div class="modal-dialog" style="max-width: 50%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Kontainer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </div>
            <div class="modal-body">
                <div class="html_respon_mst_countainer"></div>
            </div>
        </div>
    </div>
</div>