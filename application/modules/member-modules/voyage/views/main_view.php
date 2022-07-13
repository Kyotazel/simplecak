<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12 container_list">
        <div class="card">
            <div class="card-body">
                <div class="mb-3 row">
                    <h3 class="col-md-8">DATA VOYAGE</h3>
                    <div class="col-md-4 text-right">
                        <?= Modules::run('security/create_access', '<a href="javascript:void(0)" class="btn btn-primary-gradient btn_add"> <i class="fa fa-plus-circle"></i> Tambah Data</a>'); ?>
                    </div>
                </div>
                <form id="form-search">
                    <input type="hidden" name="search" value="1">
                    <div class="row mb-2 border pb-2 pt-2">
                        <div class="col-md-3 row">
                            <label for="" class="col-12 font-weight-bold">Tanggal Keberangkatan </label>
                            <div class="col-md-6">
                                <label for="">Tanggal Berangkat <a href="javascript:void(0)" class="empty_form" data-name="date_from" title="empty date"><i class="fa fa-history"></i></a></label>
                                <input type="text" class="form-control datepicker bg-white" placeholder="piih tanggal..." readonly name="date_from">
                            </div>
                            <div class="col-md-6">
                                <label for="">Tanggal Sampai <a href="javascript:void(0)" class="empty_form" data-name="date_to" title="empty date"><i class="fa fa-history"></i></a></label>
                                <input type="text" class="form-control datepicker bg-white" placeholder="piih tanggal..." readonly name="date_to">
                            </div>
                        </div>
                        <div class="col-md-4 row">
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
                            <label for="">status Voyage</label>
                            <select name="status_voyage" class="form-control" id="">
                                <option value="">Semua Status</option>
                                <?php
                                foreach ($data_status_voyage as $key_item => $value_item) {
                                    echo '
                                            <option value="' . $this->encrypt->encode($key_item) . '" class="text-capitalize">' . $value_item . '</option>
                                        ';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="" class="col-12 font-weight-bold">&nbsp;</label>
                            <label for="">Kode Voyage</label>
                            <input type="text" class="form-control" name="code">
                        </div>
                        <div class="col-md-1">
                            <label for="" class="col-12 font-weight-bold">&nbsp;</label>
                            <label for="">&nbsp;</label><br>
                            <button type="submit" class="btn btn-primary btn_search"><i class="fa fa-search"></i></button>
                        </div>

                    </div>
                </form>
                <div class="table-responsive  userlist-table mt-3">
                    <table id="table_data" class="table table-bordered dt-responsive nowrap table-hover" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <th style="width: 5%;">No</th>
                            <th>NO.VOYAGE</th>
                            <th>KAPAL</th>
                            <th style="width: 15%;">RUTE KEBERANGKATAN</th>
                            <th style="width: 15%;">ESTIMASI PERJALANAN</th>
                            <th style="width: 15%;">TANGGAL TIKET</th>
                            <th>STATUS VOYAGE</th>
                            <th style="width: 10%;"></th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end main content-->

<div class="modal fade" tabindex="-1" id="modal_form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Input Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </div>
            <div class="modal-body">
                <form id="form-data">
                    <input type="hidden" name="id" id="id" />
                    <label for=""><b>Data Keberangkatan</b></label>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>No. Voyage</label>
                            <input type="text" class="form-control" name="voyage" />
                            <span class="help-block notif_voyage"></span>
                        </div>
                    </div>
                    <hr>
                    <label for=""><b>Rute Keberangkatan</b></label>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Depo Asal</label>
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
                            <span class="help-block notif_depo_from"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Depo Tujuan</label>
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
                            <span class="help-block notif_depo_to"></span>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Tanggal Keberangkatan</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                    </div>
                                </div>
                                <input class="form-control datepicker bg-white" readonly name="date_from" placeholder="DD-MM-YYYY" type="text">
                            </div>
                            <span class="help-block notif_date_from"></span>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Estimasi Sampai</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                    </div>
                                </div>
                                <input class="form-control datepicker bg-white" readonly name="date_to" placeholder="DD-MM-YYYY" type="text">
                            </div>
                            <span class="help-block notif_date_to"></span>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Kapal</label>
                            <select name="ship" class="form-control" id="">
                                <option value="">- PILIH KAPAL -</option>
                                <?php
                                foreach ($data_ship as $item) {
                                    echo '
                                            <option value="' . $item->id . '">' . strtoupper($item->name) . '</option>
                                        ';
                                }
                                ?>
                            </select>
                            <span class="help-block notif_ship"></span>
                        </div>
                    </div>
                    <hr>
                    <label for=""><b>Pengaturan Tiket</b></label>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Tanggal Open</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                    </div>
                                </div>
                                <input class="form-control datepicker bg-white" readonly name="date_open" placeholder="DD-MM-YYYY" type="text">
                            </div>
                            <span class="help-block notif_date_open"></span>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Tanggal Closing</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                    </div>
                                </div>
                                <input class="form-control bg-white datepicker" readonly name="date_close" placeholder="DD-MM-YYYY" type="text">
                            </div>
                            <span class="help-block notif_date_close"></span>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn_save"><i class="fa fa-save"></i> Simpan Data</button>
            </div>
        </div>
    </div>
</div>