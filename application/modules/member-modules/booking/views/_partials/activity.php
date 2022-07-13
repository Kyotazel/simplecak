<?php
$category_teus        = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_teus'])->row()->value, TRUE);
$category_countainer  = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'countainer_category'])->row()->value, TRUE);
$booking_status       = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'booking_status'])->row()->value, TRUE);
$category_service     = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_service'])->row()->value, TRUE);
$category_unit_lc     = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_unit_lc'])->row()->value, TRUE);

$countiner_type = isset($category_countainer[$data_countainer->category_countainer]) ? $category_countainer[$data_countainer->category_countainer] : '';
$countainer_teus = isset($category_teus[$data_countainer->category_teus]) ? $category_teus[$data_countainer->category_teus] : 0;
$service_type = isset($category_service[$data_countainer->category_service]) ? $category_service[$data_countainer->category_service] : '';
$stuffing_take = isset($category_stuffing[$data_countainer->stuffing_take]) ? $category_stuffing[$data_countainer->stuffing_take] : 0;
$stuffing_open = isset($category_stuffing[$data_countainer->stuffing_open]) ? $category_stuffing[$data_countainer->stuffing_open] : 0;

?>
<div class="row" style="min-height: 700px;">
    <div class="col-4">
        <div>
            <div class="p-1 rounded bg-primary-gradient d-block text-center text-capitalize font-weight-bold">
                <h4 class="text-center text-bold text-white font-weight-bold m-0 p-0">
                    <?= $data_countainer->booking_code; ?>
                </h4>
            </div>
            <div class="row">
                <div class="row col-8 border-dashed">
                    <div class="col">
                        <div class=" mt-2 mb-2 text-primary"><b><?= strtoupper($data_countainer->customer_name) ?></b></div>
                        <p class="tx-12"><?= $data_countainer->customer_address; ?></p>
                    </div>
                    <div class="col-auto align-self-center ">
                        <div class="feature mt-0 mb-0">
                            <i class="fe fe-user project bg-primary-transparent text-primary "></i>
                        </div>
                    </div>
                </div>
                <div class="border-dashed col-4 text-center p-1">
                    <img style="width:80px;" src="<?= base_url('upload/barcode/' . $data_countainer->countainer_code . '.png') ?>" alt="">
                    <label class="d-block font-weight-bold m-0"><?= $data_countainer->countainer_code; ?></label>
                    <small class="text-mdi-tab-unselected"><i class="fa fa-info-circle"></i> ID kontainer</small>
                </div>
                <div class="border-dashed col-12 row">
                    <div class="col-6 border-right">
                        <small for="" class="d-block text-muted"> Kategori Kontainer :</small>
                        <label for=""> <?= $countiner_type; ?></label>
                        <small for="" class="d-block text-muted">Feet :</small>
                        <label for=""> <?= $countainer_teus; ?> FEET</label>
                        <small for="" class="d-block text-muted">Service :</small>
                        <label for=""> <?= $service_type; ?> </label>
                    </div>
                    <div class="col-6">
                        <small class="d-block text-muted">Kategori Barang Muatan :</small>
                        <label for="" class="d-block"><?= strtoupper($data_countainer->category_load_name); ?></label>
                        <small class="d-block text-muted">Barang Muatan:</small>
                        <label for="" class="d-block"><?= strtoupper($data_countainer->category_stuff_name); ?></label>
                    </div>
                </div>

                <div class="col-12 p-2 text-center border-dashed">
                    <small>(* Detail Booking Slot dan ID Kontainer)</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-8">
        <div class=" p-3 shadow-1">
            <form class="form-activity">
                <div class="row">
                    <div class="col-6">
                        <label for="">Pilih Transaksi</label>
                        <select class="form-control" name="activity" id="">
                            <option value="">Pilih Transaksi</option>
                            <?php
                            foreach ($data_activity as $item_activity) {
                                echo '
                                        <option value="' . $item_activity->id . '">' . $item_activity->name . '</option>
                                    ';
                            }
                            ?>
                        </select>
                        <span class="help-block notif_activity text-danger"></span>
                    </div>
                    <div class="col-3">
                        <label for="">Status</label>
                        <select name="status" class="form-control" id="">
                            <option value="0">Tidak ada</option>
                            <option value="1">Full</option>
                            <option value="2">Empty</option>
                        </select>
                        <span class="help-block notif_status text-danger"></span>
                    </div>
                    <div class="col-3 align-items-center d-flex">
                        <small>(* Pilih transaksi aktivitas)</small>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-2">
                        <label for="">Tanggal Awal</label>
                        <input type="text" name="date_from" readonly class="form-control bg-white datepicker">
                        <span class="help-block notif_date_from text-danger"></span>
                    </div>
                    <div class="col-2">
                        <label for="">Tanggal Akhir</label>
                        <input type="text" name="date_to" readonly class="form-control bg-white datepicker">
                        <span class="help-block notif_date_to text-danger"></span>
                    </div>

                    <div class="col-2">
                        <label for="">Qty</label>
                        <input type="text" name="qty" class="form-control rupiah">
                        <span class="help-block notif_qty text-danger"></span>
                    </div>
                    <div class="col-4">
                        <label for="">Harga</label>
                        <input type="text" name="price" class="form-control rupiah">
                        <span class="help-block notif_price text-danger"></span>
                    </div>
                    <div class="col-2">
                        <label for="">&nbsp;</label><br>
                        <button type="submit" data-bs="<?= $data_countainer->id_booking; ?>" data-countainer="<?= $data_countainer->id; ?>" class="btn btn-primary font-weight-bold btn_save_activity"><i class="fa fa-plus-circle"></i> Tambah</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="mt-3">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 15px;">No</th>
                            <th>Transaksi</th>
                            <th>Status</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Total Harga</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="html_item_activity"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>