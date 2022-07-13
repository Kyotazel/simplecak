<?php
$array_query  = [
    'select' => '
        tb_booking_has_lc.*,
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
        tb_booking_has_detail.transport_description,
        mst_category_stuff.name AS category_stuff_name,
        mst_transportation.name AS transport_type_name
        
    ',
    'from' => 'tb_booking_has_lc',
    'join' => [
        'tb_booking , tb_booking_has_lc.id_booking = tb_booking.id , left',
        'tb_booking_has_detail , tb_booking_has_lc.id_booking_detail = tb_booking_has_detail.id , left',
        'mst_category_stuff, tb_booking_has_detail.id_category_stuff = mst_category_stuff.id , left',
        'mst_transportation, tb_booking_has_detail.id_transportation = mst_transportation.id , left'
    ],
    'where' => [
        'tb_booking.is_confirm' => 1,
        'tb_booking.id' => $data_bs->id
    ]
];
$get_data_lc = Modules::run('database/get', $array_query)->result();
?>


<div class="table-responsive">
    <table class="table table-bordered t-shadow" id="table_list_lc">
        <thead class="bg-primary-gradient text-white">
            <tr>
                <th class="text-white" style="background-color:transparent;">No</th>
                <th class="text-white" style="background-color:transparent;">MUATAN</th>
                <th class="text-white" style="background-color:transparent;">Kendaraan</th>
        </thead>
        <tbody class="tbody_item_booking">
            <?php
            $counter = 0;
            foreach ($get_data_lc as $item_lc) {
                $counter++;

                echo '
                        <tr class="item_detail item_container countainer_2124">
                            <td style="width:10px;">' . $counter . '</td>
                            <td>
                                <small class="d-block text-muted">Barang Muatan:</small>
                                <label for="" class="d-block p-2 border-dashed">' . strtoupper($item_lc->category_stuff_name) . '</label>
                                <small class="d-block text-muted">Deskripsi :</small>
                                <p for="" class="d-block p-2 border-dashed">' . nl2br(strtoupper($item_lc->transport_description)) . '</p>
                            </td>
                            <td>
                                <small for="" class="d-block text-muted">Jenis Kendaraan:</small>
                                <label for="" class="m-0 d-block p-2 border-dashed"> ' . strtoupper($item_lc->transport_type_name) . '</label>
                                <small for="" class="d-block text-muted mt-2">Detail Kendaraan:</small>
                                <label for="" class="m-0 d-block p-2 border-dashed"> ' . strtoupper($item_lc->transport_name) . '</label>
                            </td>
                        </tr>
                        ';
            }
            ?>

        </tbody>
    </table>
</div>