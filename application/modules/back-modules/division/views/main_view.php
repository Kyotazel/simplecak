<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12 container_list">
        <div class="card">
            <div class="card-body">
                <div class="mb-3 row">
                    <h3 class="col-md-8 text-uppercase">DAFTAR DEVISI PEGAWAI</h3>
                    <div class="col-md-4 text-right">
                        <?= Modules::run('security/create_access', '<a href="javascript:void(0)" class="btn btn-primary-gradient btn_add"> <i class="fa fa-plus-circle"></i> Tambah Data</a>'); ?>
                    </div>
                </div>
                <div class="table-responsive border-top userlist-table">
                    <table id="table_data" class="table table-bordered dt-responsive nowrap table-hover" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <th style="width: 10%;">No</th>
                            <th>Nama</th>
                            <th style="width: 15%;"></th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="text-right pt-3">
                    <form class="form-print" method="POST" action="<?= Modules::run('helper/create_url', 'division/print'); ?>">
                        <small>(*klik untuk export)</small>
                        <button type="submit" name="print_excel" value="1" class="btn  btn-outline-dark"> <i class="mdi mdi-file-excel"></i> Cetak Excel</button>
                        <button type="submit" name="print_pdf" value="1" class="btn  btn-outline-dark"> <i class="mdi mdi-file-pdf"></i> Cetak PDF</button>
                    </form>
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
            <form id="form-data">
                <div class="modal-body">

                    <input type="hidden" name="id" id="id" />
                    <div class="form-group">
                        <label>Nama Devisi</label>
                        <input type="text" class="form-control" name="name" />
                        <span class="help-block notif_name"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success btn_save"><i class="fa fa-save"></i> Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>