<?php
$item_voyage = $data_detail;
$file = base_url('upload/ship/' . $item_voyage->image_name);

$get_teus_filled = $this->db->select('SUM(total_teus) AS total_teus')->where(['is_confirm' => 1, 'id_voyage' => $item_voyage->id])->get('tb_booking')->row();
$total_teus_filled = $get_teus_filled->total_teus ? $get_teus_filled->total_teus : 0;
$rest_teus = $item_voyage->container_slot - $total_teus_filled;
$parcentage_fill = round(($rest_teus / $item_voyage->container_slot) * 100);

echo '
        <div class="row voyage-data" data-id="' . $item_voyage->id . '">
            <div class="col-md-3">
                <h5 class="card-title col-12"><i class="fa fa-file"></i> No. Voyage : <b class="border-dashed p-2 text-primary" style="font-size: 20px;">' . $item_voyage->code . '</b></h5>
                <div class="col-md-12">
                    <label class="col-12 m-0 p-0 font-weight-bold" for="" class="d-block">Keterangan Kapal :</label>
                    <div class="border-dashed p-2 row d-flex">
                        <img class="img-sm mr-1" src="' . $file . '" alt="">
                        <div class="ml-3 p-2">
                            <h5 class="text-uppercase">' . $item_voyage->ship_name . '</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-12   row">
                    <div class="col-8">
                        <div class="row">
                            <div class="col">
                                <label>Total Feet Tersedia :</label>
                                <div class="h3 mt-2 mb-2"><b>' . $rest_teus . '</b><span class="text-success tx-13 ml-2">FEET</span></div>
                            </div>
                            <div class="col-auto align-self-center ">
                                <div class="feature mt-0 mb-0">
                                    <i class="fe fe-box project bg-primary-transparent text-primary "></i>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="progress progress-sm h-1 mb-1">
                                <div class="progress-bar bg-primary " style="width:' . $parcentage_fill . '%" role="progressbar"></div>
                            </div>
                            <small class="mb-0 text-muted">persentase feet tersedia<span class="float-right text-muted">' . $parcentage_fill . '%</span></small>
                        </div>
                    </div>
                    <div class="col-4">
                            <label for="" class="d-block"><small>Total Feet kapal: </small><br><b> ' . number_format($item_voyage->container_slot, 0, '.', '.') . ' FEET</b></label>
                            <label for="" class="d-block"><small>Total Feet Terisi: </small><br> <b>' . number_format($total_teus_filled, 0, '.', '.') . ' FEET</b> </label>
                    </div>
                </div>
                <div class="col-md-12 div_action">
                    <div class="row mb-1 countdown_ticket" data-date-now="' . date('Y-m-d') . '" data-date-to="' . $item_voyage->date_close . '">
                        <div class="col-3 p-1 border rounded text-center">
                            <h5 for="" class="p-0 m-0 text-danger text_day">--</h5>
                            <small for="" class="d-block font-weight-bold">Hari</small>
                        </div>
                        <div class="col-3 p-1 border rounded text-center">
                            <h5 for="" class="p-0 m-0 text-danger text_hour">--</h5>
                            <small for="" class="d-block font-weight-bold">Jam</small>
                        </div>
                        <div class="col-3 p-1 border rounded text-center">
                            <h5 for="" class="p-0 m-0 text-danger text_minute">--</h5>
                            <small for="" class="d-block font-weight-bold">Menit</small>
                        </div>
                        <div class="col-3 p-1 border rounded text-center">
                            <h5 for="" class="p-0 m-0 text-danger text_second">--</h5>
                            <small for="" class="d-block font-weight-bold">Detik</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 row p-2">
                        <label class="col-12 m-0 p-0 font-weight-bold" for="" class="d-block">Rute Keberangkatan :</label>
                        <div class="col-6 border-dashed p-2">
                            <small class="d-block text-muted"><i class="fa fa-map"></i> Depo Awal :</small>
                            <label for="" class="d-block text-uppercase font-weight-bold">' . $item_voyage->depo_from . '</label>
                        </div>
                        <div class="col-6 border-dashed p-2">
                            <small class="d-block text-muted"><i class="fa fa-map"></i> Depo Tujuan :</small>
                            <label for="" class="d-block font-weight-bold text-uppercase">' . $item_voyage->depo_to . '</label>
                        </div>
                    </div>
                    <div class="col-12 row p-2">
                        <label class="col-12 m-0 p-0 font-weight-bold" for="" class="d-block">Tanggal Keberangkatan :</label>
                        <div class="col-6 border-dashed p-2">
                            <small class="d-block text-muted"><i class="fa fa-calendar"></i> Tanggal Berangkat :</small>
                            <label for="" class="d-block font-weight-bold">' . Modules::run('helper/date_indo', $item_voyage->date_from, '-') . '</label>
                        </div>
                        <div class="col-6 border-dashed p-2">
                            <small class="d-block text-muted"><i class="fa fa-calendar"></i> Tanggal sampai :</small>
                            <label for="" class="d-block font-weight-bold">' . Modules::run('helper/date_indo', $item_voyage->date_to, '-') . '</label>
                        </div>
                    </div>
                    <div class="col-12 row p-2">
                        <label class="col-12 m-0 p-0 font-weight-bold" for="" class="d-block">Tanggal Tiket :</label>
                        <div class="col-6 border-dashed p-2">
                            <small class="d-block text-muted"><i class="fa fa-calendar"></i> Tanggal Dibuka :</small>
                            <label for="" class="d-block font-weight-bold">' . Modules::run('helper/date_indo', $item_voyage->date_open, '-') . '</label>
                        </div>
                        <div class="col-6 border-dashed p-2">
                            <small class="d-block text-muted"><i class="fa fa-calendar"></i> Tanggal Ditutup :</small>
                            <label for="" class="d-block font-weight-bold">' . Modules::run('helper/date_indo', $item_voyage->date_close, '-') . '</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-9 border p-3 rounded mb-3 shadow-2 bg-white">
                <h5 class="card-title">Input Booking Slot</h5>
                <form class="form-transaction">
                    <div class="row">
                        <div class="col-7 p-2 pt-0" style="padding-top:0 !important;">
                            <div>
                                <label for="" class="font-weight-bold d-block border-dashed p-2 text-center m-0">Customer :</label>
                                <div class="row col-12 border-dashed" style="white-space:initial;" id="data_customer" data-id="' . $this->session->userdata('member_id') . '">
                                    <div class="col">
                                        <div class=" mt-2 mb-2 text-primary tx-16 text-uppercase"><b>' . $this->session->userdata('member_data')->name . '</b></div>
                                        <p class="tx-11" style="white-space:initial;">' . $this->session->userdata('member_data')->address . '</p>
                                    </div>
                                    <div class="col-auto align-self-center ">
                                        <div class="feature mt-0 mb-0">
                                            <i class="fe fe-user project bg-primary-transparent text-primary "></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2">
                                <label class="font-weight-bold" for="">Penerima :</label>
                                <input class="form-control" name="receiver">
                                <span class="help-block notif_receiver"></span>
                            </div>
                            <div class="mt-1">
                                <label for="" class="font-weight-bold">Alamat Tujuan :</label>
                                <div class="input-group">
                                    <textarea name="address" id="" class="form-control"  rows="2"></textarea>
                                </div>
                            </div>
                            <div class="mt-1">
                                <label for="" class="font-weight-bold">Catatan untuk admin :</label>
                                <div class="input-group">
                                    <textarea name="note" id="" class="form-control"  rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="border-dashed col-5 p-2 rounded text-center">
                            <label for="" class="font-weight-bold">Resume Detail Item :</label>
                            <div class="row justify-content-center border-top border-bottom p-2">
                                <div class="col-4 d-flex justify-center align-items-center">
                                    <a href="javascript:void(0)" class="custom chip border-dashed">
                                        <span class="avatar cover-image bg-primary-gradient"><i class="fa fa-box"></i></span> Kontainer
                                    </a>
                                </div>
                                <div class="col-8 row">
                                    <div class="col-md-5 col text-center border-right  d-flex justify-center align-items-center">
                                        <label class="tx-12 mr-2 m-0">Jumlah Qty :</label>
                                        <h2 class="mb-1 font-weight-bold text-primary text-total-countainer">0</h2>
                                    </div>
                                    <div class="col-md-7 col text-center  d-flex justify-center align-items-center">
                                        <label class="tx-12 mr-2 m-0">Total Feet :</label>
                                        <h2 class="mb-1 font-weight-bold text-primary text-total-teus">0</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center border-bottom p-2">
                                <div class="col-4 d-flex justify-center align-items-center">
                                    <a href="javascript:void(0)" class="custom chip border-dashed">
                                        <span class="avatar cover-image bg-primary-gradient"><i class="fa fa-truck"></i></span> Loss Cargo
                                    </a>
                                </div>
                                <div class="col-8 row">
                                    <div class="col-md-12 col text-center d-flex justify-center align-items-center">
                                        <label class="tx-12 mr-2 m-0">Jumlah Qty :</label>
                                        <h2 class="mb-1 font-weight-bold text-primary text-total-lc">0</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-2">
                            <div class="col-4 text-center">
                                <div data-menu="sidebar" class="main-toggle main-toggle-dark change_materai" style="margin:0 auto;"><span></span></div>
                                <small class="p-1"><span> ( Dokumen + Materai )</span></small>
                            </div>
                        </div>
                            
                            <button type="submit" class="btn btn-primary-gradient btn-lg mt-3  btn-rounded font-weight-bold btn_save_order"><i class="fa fa-paper-plane"></i> Simpan Pemesanan</button>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <table class="table table-bordered" id="id_table_item" >
                                <thead class="bg-primary-gradient text-white"  id="head_table_item" data-container="body" data-popover-color="head-primary" data-placement="left" title="" data-content="Mohon detail kontainer diisi terlebih dahulu ." data-original-title="KONTAINER KOSONG">
                                    <tr>
                                        <th class="text-white" style="background-color:transparent;">TIPE</th>
                                        <th class="text-white" style="background-color:transparent;">Kontainer / LC</th>
                                        <th class="text-white" style="background-color:transparent;">STUFFING</th>
                                        <th class="text-white" style="background-color:transparent;">MUATAN</th>
                                        <th class="text-white" style="background-color:transparent;">QTY</th>
                                        <th class="text-white" style="background-color:transparent;">TOTAL</th>
                                        <th class="text-white" style="background-color:transparent;"></th>
                                    </tr>
                                </thead>
                                <tbody class="tbody_item_booking">
                                    <tr class="tr_add">
                                        <td colspan="7" class="text-center">
                                            <div  class="form_btn_act">
                                                <a href="javascript:void(0)" id="btn_add_item" class="btn btn-primary-gradient  btn-rounded "><i class="fa fa-plus-circle"></i> Tambah Kontainer</a>&nbsp;
                                                <a href="javascript:void(0)" id="btn_add_lc" class="btn btn-primary-gradient  btn-rounded "><i class="fa fa-plus-circle"></i> Tambah Loss Cargo</a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    ';
?>

<div class="modal fade" tabindex="-1" id="modal_member">
    <div class="modal-dialog" style="max-width: 50%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Input Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table_member">
                            <thead class="bg-primary-gradient text-white">
                                <tr>
                                    <th class="text-white" style="background-color:transparent;">No</th>
                                    <th class="text-white" style="background-color:transparent;">Nama Customer</th>
                                    <th class="text-white" style="background-color:transparent;">Alamat</th>
                                    <th class="text-white" style="background-color:transparent;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $counter = 0;

                                foreach ($data_member as $item_member) {
                                    $counter++;
                                    echo '
                                            <tr>
                                                <td>' . $counter . '</td>
                                                <td>' . $item_member->name . '</td>
                                                <td>' . $item_member->address . '</td>
                                                <td>
                                                    <a href="javascript:void(0)" data-name="' . $item_member->name . '" data-id="' . $item_member->id . '" class="btn btn-primary btn_choose_member"><i class="fa fa-paper-plane"></i> Pilih</a>
                                                </td>
                                            </tr>
                                        ';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" data-backdrop="static" tabindex="-1" id="modal_add_countainer">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Input Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </div>
            <div class="modal-body">
                <form action="" id="form_add_countainer">
                    <div class="row">
                        <div class="col-8 row">
                            <label for="" class="col-12 font-weight-bold text-uppercase">Keterangan kontainer :</label>
                            <div class="col-12 d-flex">
                                <label style="margin-right: 20px;"><span>Size :</span></label>
                                <?php
                                foreach ($category_teus as $key => $value) {
                                    echo '
                                        <label class="rdiobox" style="margin-right: 10px;">
                                            <input name="teus" value="' . $this->encrypt->encode($key) . '" type="radio"> <span>' . $value . ' FEET</span>
                                        </label>
                                    ';
                                }
                                ?>
                                <span class="d-block text-danger help-block notif_teus"></span>
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="">QTY</label>
                            <input type="text" name="qty" class="form-control number_only">
                            <span class="help-block text-danger notif_qty"></span>
                        </div>
                        <div class="form-group col-8 mt-1">
                            <label for="">Jenis Kontainer</label>
                            <select name="container_type" class="form-control" id="">
                                <?php
                                foreach ($category_countainer as $key => $value) {
                                    echo '
                                        <option value="' . $this->encrypt->encode($key) . '">' . strtoupper($value) . '</option>
                                    ';
                                }
                                ?>
                            </select>
                            <span class="help-block text-danger notif_container_type"></span>
                        </div>
                        <div class="form-group col-4 mt-1">
                            <label for="">Service</label>
                            <select name="service" class="form-control" id="">
                                <?php
                                foreach ($category_service as $key => $value) {
                                    echo '
                                            <option value="' . $key . '">' . $value . '</option>
                                        ';
                                }
                                ?>
                            </select>
                            <span class="help-block text-danger notif_service"></span>
                        </div>
                        <hr class="col-12">
                        <label for="" class="col-12 font-weight-bold  text-uppercase">Keterangan Stuffing & Stripping:</label>
                        <div class="form-group col-6">
                            <label for="">Stuffing</label>
                            <select name="stuffing_take" class="form-control" id="">
                                <option data-val="" value="">PILIH STUFFING</option>
                                <?php
                                foreach ($category_stuffing as $key => $value) {
                                    echo '
                                        <option data-val="' . $key . '" value="' . $this->encrypt->encode($key) . '">' . strtoupper($value) . '</option>
                                    ';
                                }
                                ?>
                            </select>
                            <span class="help-block text-danger notif_stuffing_take"></span>
                        </div>
                        <div class="form-group col-6">
                            <label for="">Stripping</label>
                            <select name="stuffing_open" class="form-control" id="">
                                <option data-val="" value="">PILIH STRIPPING</option>
                                <?php
                                foreach ($category_stuffing as $key => $value) {
                                    echo '
                                        <option data-val="' . $key . '" value="' . $this->encrypt->encode($key) . '">' . strtoupper($value) . '</option>
                                    ';
                                }
                                ?>
                            </select>
                            <span class="help-block text-danger notif_stuffing_open"></span>
                        </div>
                        <div class="form-group col-12" style="display: none;" id="address_stuffing_take">
                            <label for="">Alamat Stuffing</label>
                            <textarea name="address_stuffing_take" class="form-control" rows="3"></textarea>
                            <span class="help-block text-danger"></span>
                        </div>
                        <div class="form-group col-12" style="display: none;" id="address_stuffing_open">
                            <label for="">Alamat Stripping</label>
                            <textarea name="address_stuffing_open" class="form-control" rows="3"></textarea>
                            <span class="help-block text-danger notif_address_stuffing_open"></span>
                        </div>
                        <hr class="col-12">
                        <label for="" class="col-12 font-weight-bold">Keterangan Muatan :</label>
                        <div class="form-group col-12">
                            <label for="">Jenis Kategori Barang Muatan</label>
                            <select name="category_load" class="form-control">
                                <option value="">PILIH KATEGORI</option>
                                <?php
                                foreach ($category_load as $item_data) {
                                    $array_value = ['id' => $item_data->id, 'value' => $item_data->name];
                                    echo '
                                        <option value="' . $this->encrypt->encode(json_encode($array_value)) . '">' . strtoupper($item_data->name) . '</option>
                                    ';
                                }
                                ?>
                            </select>
                            <span class="help-block text-danger notif_category_load"></span>
                        </div>
                        <div class="form-group col-12">
                            <label for="">Barang Muatan</label>
                            <select name="category_stuff" class="form-control" id="category_stuff">
                                <option value="">PILIH KATEGORI</option>
                                <?php
                                foreach ($category_stuff as $item_data) {
                                    $array_value = ['id' => $item_data->id, 'value' => $item_data->name];
                                    echo '
                                        <option value="' . $this->encrypt->encode(json_encode($array_value)) . '">' . strtoupper($item_data->name) . '</option>
                                    ';
                                }
                                ?>
                            </select>
                            <span class="help-block text-danger notif_category_stuff"></span>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary-gradient btn-block" data-id-depo="<?= $item_voyage->id_depo_from; ?>" id="btn_act_add"><i class="fa fa-plus-circle"></i> Tambah Data</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" data-backdrop="static" tabindex="-1" id="modal_add_lc">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Input Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </div>
            <div class="modal-body">
                <form action="" id="form_add_lc">
                    <div class="row">
                        <label for="" class="col-12 font-weight-bold text-uppercase">Keterangan Angkutan :</label>
                        <div class="col-12 row">
                            <div class="col-12">
                                <label for="">Jenis Transportasi</label>
                                <select name="transport" id="transport" class="form-control" id="">
                                    <option value="">Pilih Transportasi</option>
                                    <?php
                                    foreach ($list_transport as $item) {
                                        $array_value = ['id' => $item->id, 'value' => $item->name];
                                        echo '
                                            <option value="' . $this->encrypt->encode(json_encode($array_value)) . '">' . strtoupper($item->name) . '</option>
                                        ';
                                    }
                                    ?>
                                </select>
                                <span class="help-block text-danger notif_transport"></span>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <label for="">Detail Kendaraan : </label>
                            <div class="html_transport">
                                <div class="item_transport  mb-1">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-truck"></i></span>
                                        </div><input class="form-control detail_transport" name="detail_transport[]" placeholder="ketik nama kendaraan..." type="text">
                                    </div>
                                    <span class="help-block text-danger"></span>
                                </div>
                            </div>
                            <div class="text-center mt-2">
                                <a href="javascript:void(0)" class="btn btn-light btn-rounded btn_add_transport"><i class="fa fa-plus-circle"></i> Tambah kendaraan</a>
                            </div>
                        </div>

                        <hr class="col-12">
                        <label for="" class="col-12 font-weight-bold">Keterangan Muatan :</label>
                        <div class="form-group col-12">
                            <label for="">Barang Muatan</label>
                            <select name="category_stuff" class="form-control" id="category_stuff_lc">
                                <option value="">PILIH MUATAN</option>
                                <?php
                                foreach ($category_stuff as $item_data) {
                                    $array_value = ['id' => $item_data->id, 'value' => $item_data->name];
                                    echo '
                                        <option value="' . $this->encrypt->encode(json_encode($array_value)) . '">' . strtoupper($item_data->name) . '</option>
                                    ';
                                }
                                ?>
                            </select>
                            <span class="help-block text-danger notif_category_stuff"></span>
                        </div>
                        <div class="col-12 mb-2">
                            <label for="">Keterangan Tambahan :</label>
                            <textarea name="description" class="form-control" id="" rows="5"></textarea>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary-gradient btn-block" data-id-depo="<?= $item_voyage->id_depo_from; ?>" id="btn_act_add_lc"><i class="fa fa-plus-circle"></i> Tambah Data</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>