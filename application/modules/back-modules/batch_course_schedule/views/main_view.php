<div class="row row-sm main-content-mail">
    <div class="col-md-12 container_list">
        <div class="card">
            <div class="card-body">
                <div class="mb-3 row">
                    <h3 class="col-md-8">Daftar Gelombang Pelatihan</h3>
                    <div class="col-md-4 text-right">
                    <?= Modules::run('security/create_access', '<a href="' . Modules::run('helper/create_url', 'batch_course_schedule/add') . '" class="btn btn-primary "> <i class="fa fa-plus-circle"></i> Tambah Batch Pelatihan</a>'); ?>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="table_data" style="width: 100%;">
                        <thead>
                            <tr>
                                <th><span>No</span></th>
                                <th><span>Nama Pelatihan</span></th>
                                <th><span>Judul</span></th>
                                <th><span>Waktu</span></th>
                                <th><span>Media</span></th>
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