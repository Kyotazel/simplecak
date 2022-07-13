<style>
    .datepicker {
        z-index: 1000 !important;
    }
</style>
<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12 container_list">
        <div class="card">
            <div class="card-body">
                <div class="mb-3 row">
                    <h3 class="col-md-8 card-title">Daftar Transaksi</h3>

                </div>
                <form id="form-search">
                    <input type="hidden" name="search" value="1">
                    <div class="row mb-2 border-dashed rounded-10 pb-2 pt-2">
                        <div class="col-md-5 row">
                            <label for="" class="col-12 font-weight-bold">Tanggal Keberangkatan </label>
                            <div class="col-md-6">
                                <label for="">Tanggal Berangkat <a href="javascript:void(0)" class="empty_form" data-name="date_from" title="empty date"><i class="fa fa-history"></i></a></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text font-weight-bold">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control datepicker bg-white" placeholder="piih tanggal..." readonly name="date_from">
                                </div>

                            </div>
                            <div class="col-md-6">
                                <label for="">Tanggal Sampai <a href="javascript:void(0)" class="empty_form" data-name="date_to" title="empty date"><i class="fa fa-history"></i></a></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text font-weight-bold">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control datepicker bg-white" placeholder="piih tanggal..." readonly name="date_to">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 row">
                            <label for="" class="col-12 font-weight-bold">Rute Tujuan</label>
                            <div class="col-md-6">
                                <label for="">Depo Awal</label>
                                <select name="depo_from" class="form-control" id="">
                                    <option value="">- PILIH DEPO -</option>
                                    <?php
                                    foreach ($data_depo as $item) {
                                        echo '
                                            <option value="' . $item->id . '">' . strtoupper($item->name) . '</option>
                                        ';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="">Depo Tujuan</label>
                                <select name="depo_to" class="form-control" id="">
                                    <option value="">- PILIH DEPO -</option>
                                    <?php
                                    foreach ($data_depo as $item) {
                                        echo '
                                            <option value="' . $item->id . '">' . strtoupper($item->name) . '</option>
                                        ';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label for="" class="col-12 font-weight-bold">&nbsp;</label>
                            <label for="">&nbsp;</label><br>
                            <button type="submit" class="btn btn-primary btn_search btn-rounded btn-block"><i class="fa fa-search"></i> cari</button>
                        </div>

                        <div class="col-12 mt-2 d-flex align-items-center">
                            <label for="" class="mr-2 font-weight-bold">Status Transaksi : </label>
                            <a href="javascript:void(0)" class="btn btn-outline-primary btn-rounded px-4 py-1 mx-1 status_booking_chosen" data-value="all">Semua</a>
                            <a href="javascript:void(0)" class="btn btn-outline-primary btn-rounded px-4 py-1 mx-1 status_booking_chosen" data-value="proceed">Sedang Berlangsung</a>
                            <a href="javascript:void(0)" class="btn btn-outline-primary btn-rounded px-4 py-1 mx-1 status_booking_chosen" data-value="finish">Telah Selesai</a>
                            <a href="javascript:void(0)" class="btn btn-outline-primary btn-rounded px-4 py-1 mx-1 status_booking_chosen" data-value="cancel">Dibatalkan</a>
                        </div>
                        <div class="col-12 mt-2 align-items-center html_proceed_status" style="display: none;">
                            <label for="" class="mr-2 font-weight-bold"> </label>
                            <?php
                            foreach ($data_status_voyage as $key_item => $value_item) {
                                if ($key_item == 1 || $key_item == 8 || $key_item == 9) {
                                    continue;
                                }
                                echo '
                                        <a href="javascript:void(0)" data-status="' . $this->encrypt->encode($key_item) . '" class="btn btn-outline-primary btn-rounded px-4 py-1 mx-1 text-capitalize status_booking_chosen" data-value="' . $key_item . '">' . $value_item . '</a>
                                    ';
                            }
                            ?>
                        </div>
                    </div>
                </form>
                <div class="html_respon_order mt-3"></div>
            </div>
        </div>
    </div>
</div>
<!-- end main content-->

<div class="modal fade" tabindex="-1" id="modal_form_reject">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Input Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </div>
            <div class="modal-body">
                <form id="form-reject-data">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Catatan Pembatalan :</label>
                            <textarea name="note" class="form-control" id="" cols="30" rows="10"></textarea>
                            <span class="help-block notif_note"></span>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn_save_reject"><i class="fa fa-paper-plane"></i> Simpan Data</button>
            </div>
        </div>
    </div>
</div>