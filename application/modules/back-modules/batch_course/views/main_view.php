<div class="row row-sm main-content-mail">
    <div class="col-md-12 container_list">
        <div class="card">
            <div class="card-body">
                <div class="mb-3 row">
                    <h3 class="col-md-8">Daftar Gelombang Pelatihan</h3>
                    <div class="col-md-4 text-right">
                    <?= Modules::run('security/create_access', '<a href="' . Modules::run('helper/create_url', 'batch_course/add') . '" class="btn btn-primary "> <i class="fa fa-plus-circle"></i> Tambah Batch Pelatihan</a>'); ?>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-responsive table-hover" id="table_data" style="width: 100%;">
                        <thead>
                            <tr>
                                <th><span>No</span></th>
                                <th><span>Judul Pelatihan</span></th>
                                <th><span>Tipe Pelatihan</span></th>
                                <th><span>Peserta Pelatihan</span></th>
                                <th><span>Tanggal Pelatihan</span></th>
                                <th><span>Action</span></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_tambah" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Tambahkan peserta</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <!-- <div class="input-group">
                    <input class="form-control" placeholder="Search for..." type="text">
                    <span class="input-group-btn"><button class="btn ripple btn-primary" type="button">
                            <span class="input-group-btn"><i class="fa fa-search"></i></span></button></span>
                </div>
                <br><br> -->
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table_add" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th><span>No</span></th>
                                    <th><span>Nama Akun</span></th>
                                    <th><span>keahlian</span></th>
                                    <th><span>Action</span></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_peserta" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Daftar peserta</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <!-- <div class="input-group">
                    <input class="form-control" placeholder="Search for..." type="text">
                    <span class="input-group-btn"><button class="btn ripple btn-primary" type="button">
                            <span class="input-group-btn"><i class="fa fa-search"></i></span></button></span>
                </div>
                <br><br> -->
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table_peserta" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th><span>No</span></th>
                                    <th><span>Nama Akun</span></th>
                                    <th><span>keahlian</span></th>
                                    <th><span>Action</span></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>