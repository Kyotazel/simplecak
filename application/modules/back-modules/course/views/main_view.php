<div class="row row-sm main-content-mail">
    <div class="col-md-12 container_list">
        <div class="card">
            <div class="card-body">
                <div class="mb-3 row">
                    <h3 class="col-md-8">Daftar Pelatihan</h3>
                    <div class="col-md-4 text-right">
                        <?= Modules::run('security/create_access', '<a href="' . Modules::run('helper/create_url', 'course/add') . '" class="btn btn-primary "> <i class="fa fa-plus-circle"></i> Tambah Pelatihan</a>'); ?>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="table_data" style="width: 100%;">
                        <thead>
                            <tr>
                                <th><span>No</span></th>
                                <th><span>Nama Pelatihan</span></th>
                                <th><span>Kategori Pelatihan</span></th>
                                <th><span>Keahlian</span></th>
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