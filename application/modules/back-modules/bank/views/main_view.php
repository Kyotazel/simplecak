<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12 container_list">
        <div class="card">
            <div class="card-body">
                <div class="mb-3 row">
                    <h3 class="col-md-8">DAFTAR BANK</h3>
                    <div class="col-md-4 text-right">
                        <?= Modules::run('security/create_access', '
                        <a href="javascript:void(0)" class="btn btn-primary-gradient btn_add"> <i class="fa fa-plus-circle"></i> Tambah Data</a>
                        '); ?>
                    </div>
                </div>
                <div class="table-responsive border-top userlist-table">
                    <table id="table_data" class="table table-bordered dt-responsive nowrap table-hover" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <th style="width: 10%;">No</th>
                            <th>Image</th>
                            <th>Nama bank</th>
                            <th>Nama pemilik</th>
                            <th>No. Rekening</th>
                            <th style="width: 15%;"></th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="text-right pt-3">
                    <small>(*klik untuk export)</small>
                    <a href="<?= Modules::run('helper/create_url', 'ship/export_excel') ?>" class="btn  btn-outline-dark"> <i class="mdi mdi-file-excel"></i> Cetak Excel</a>
                    <a href="<?= Modules::run('helper/create_url', 'ship/export_pdf') ?>" class="btn  btn-outline-dark"> <i class="mdi mdi-file-pdf"></i> Cetak PDF</a>
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
                    <div class="form-group">
                        <label>Nama bank</label>
                        <input type="text" class="form-control" name="name" id="kapal" />
                        <span class="help-block notif_name"></span>
                    </div>
                    <div class="form-group">
                        <label>No. Rekening Bank</label>
                        <input type="text" class="form-control" name="account_number" id="kapal" />
                        <span class="help-block notif_name"></span>
                    </div>
                    <div class="form-group">
                        <label>Nama Pemilik Bank</label>
                        <input type="text" class="form-control" name="account_name" id="kapal" />
                        <span class="help-block notif_name"></span>
                    </div>
                    <div class="form-group">
                        <label>Logo Bank</label>
                        <input type="file" name="media" class="form-control" />
                        <span class="help-block"></span>
                    </div>

                    <div class="form-group" style="margin:10px;">
                        <div class="card" id="cardImageDetail" style="display: none;">
                            <div class="card-img-actions">
                                <img class="card-img-top img-fluid" style="height: 200px;" id="h_1" src="" alt="">
                                <button id="closeBtn" type="button" style="position: relative;float: right;margin-top: -63%;margin-right: -12px;cursor: pointer;" class="btn btn-outline-danger btn-rounded waves-effect waves-light" onclick="resetFile()"><i class="far fa-window-close"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn_save"><i class="fa fa-save"></i> Simpan Data</button>
            </div>
        </div>
    </div>
</div>