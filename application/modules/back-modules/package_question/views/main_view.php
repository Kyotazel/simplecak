<style>
    .borderless thead th,
    .borderless tbody,
    .borderless tbody tr,
    .borderless tbody td {
        border-style: none !important;
    }
</style>

<div class="row row-sm main-content-mail">
    <div class="col-md-12 container_list">
        <div class="card">
            <div class="card-body">
                <div class="mb-3 row">
                    <h3 class="col-md-8">Bank Soal</h3>
                    <div class="col-md-4 text-right">
                        <?= Modules::run('security/create_access', '<a href="' . Modules::run('helper/create_url', 'package_question/add') . '" class="btn btn-primary "> <i class="fa fa-plus-circle"></i> Tambah Bank Soal</a>'); ?>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table borderless" id="table_data" style="width: 100%;">
                        <thead>
                            <tr>
                                <th><span>No</span></th>
                                <th><span>Kode Paket</span></th>
                                <th><span>Nama Paket</span></th>
                                <th><span>Kategori</span></th>
                                <th><span>Pembuat</span></th>
                                <th><span>Jumlah Soal</span></th>
                                <th><span>Nilai Lulus</span></th>
                                <th><span>Aksi</span></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>