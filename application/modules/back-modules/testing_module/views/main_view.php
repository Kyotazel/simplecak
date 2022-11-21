<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12 container_list">
        <div class="card">
            <div class="card-body">
                <div class="mb-3 row">
                    <h3 class="col-md-8">Modular Test</h3>
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
                    <small>(*klik untuk export)</small>
                    <a href="javascript:void(0)" data-doc="excel" class="btn  btn-outline-dark btn_print"> <i class="mdi mdi-file-excel"></i> Cetak Excel</a>
                    <a href="javascript:void(0)" data-doc="pdf" class="btn  btn-outline-dark btn_print"> <i class="mdi mdi-file-pdf"></i> Cetak PDF</a>
                </div>
            </div>
        </div>
    </div>
</div>

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
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="name" />
                        <span class="help-block notif_name"></span>
                    </div>
                    <div class="form-group text-right">
                        <button type="button" class="btn btn-primary btn_save"><i class="fa fa-save"></i> Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>