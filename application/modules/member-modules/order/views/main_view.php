<div class="row justify-content-center">
    <div class="col-12 container_list">
        <div class="card">
            <div class="card-body">
                <div class="mb-3 row">
                    <!-- <h3 class="col-md-8 card-title">INPUT BOOKING SLOT</h3> -->
                    <!-- <div class="col-md-4 text-right">
                        <?= Modules::run('security/create_access', '<a href="javascript:void(0)" class="btn btn-primary-gradient btn_add"> <i class="fa fa-plus-circle"></i> Tambah Data</a>'); ?>
                    </div> -->
                </div>
                <form id="form-search">
                    <input type="hidden" name="search" value="1">
                    <div class="row mb-2 pb-2 pt-2 justify-content-center">
                        <div class="col-md-4 row">
                            <label for="" class="col-12">Pencarian Tanggal Berangkat</label>
                            <div class="col-md-6">
                                <label for="" class="font-weight-bold">Sejak Tanggal :</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                        </div>
                                    </div>
                                    <input style="height: 50px;" class="form-control datepicker form-control-lg" name="date_from" placeholder="Pilih tanggal..." type="text">
                                </div>
                                <span class="help-block notif_date_buy"></span>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="font-weight-bold">Sampai Tanggal :</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                        </div>
                                    </div>
                                    <input style="height: 50px;" class="form-control datepicker form-control-lg" name="date_to" placeholder="Pilih tanggal..." type="text">
                                </div>
                                <span class="help-block notif_date_buy"></span>
                            </div>
                        </div>
                        <div class="col-md-6 row">
                            <label for="" class="col-12">Rute Keberangkatan :</label>
                            <div class="col-md-6">
                                <label for="" class="font-weight-bold">Depo Asal</label>
                                <select name="depo_from" class="form-control form-control-lg" style="height: 50px;" id="">
                                    <option value="">SEMUA DEPO</option>
                                    <?php
                                    foreach ($data_depo as $item_depo) {
                                        echo '
                                            <option value="' . $this->encrypt->encode($item_depo->id) . '">' . strtoupper($item_depo->name) . '</option>
                                        ';
                                    }
                                    ?>
                                </select>
                                <span class="help-block notif_depo_from"></span>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="font-weight-bold">Depo Tujuan</label>
                                <select name="depo_to" class="form-control form-control-lg" style="height: 50px;" id="">
                                    <option value="">SEMUA DEPO</option>
                                    <?php
                                    foreach ($data_depo as $item_depo) {
                                        echo '
                                            <option value="' . $this->encrypt->encode($item_depo->id) . '">' . strtoupper($item_depo->name) . '</option>
                                        ';
                                    }
                                    ?>
                                </select>
                                <span class="help-block notif_depo_to text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-2 text-center">
                            <label for="" class="font-weight-bold">&nbsp;</label><br>
                            <label for=""><a href="" class="font-un"><i class="fa fa-paper-plane"></i><u> Lihat Semua Voyage</u></a></label><br>
                            <button type="submit" class="btn btn-warning-gradient btn_search btn-block btn-lg  btn-rounded font-weight-bold"><i class="fa fa-search"></i> Cari Jadwal Voyage</button>
                        </div>

                    </div>
                </form>
                <div class="col-12">
                    <div class="html_response">
                        <i class="fa fa-info-circle"></i> Silahkan isi form pencarian untuk mendapakan <span class="text-primary font-weight-bold">jadwal Kapal</span> .
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- end main content-->