<div class="row row-sm main-content-mail">
    <div class="col-md-12 container_list">
        <div class="card">
            <div class="card-body">
                <div class="mb-3 row">
                    <h3 class="col-md-8"><i class="fa fa-male"><i class="fa fa-female"></i></i> Daftar Member</h3>
                    <div class="col-md-4 text-right">
                    <?= Modules::run('security/create_access', '<a href="' . Modules::run('helper/create_url', 'account/add') . '" class="btn btn-primary "> <i class="fa fa-plus-circle"></i> Tambah Akun</a>'); ?>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="table_data" style="width: 100%;">
                        <thead>
                            <tr>
                                <th><span>No</span></th>
                                <th><span>Nama</span></th>
                                <th><span>Email <i class='far fa-envelope'></i></span></th>
                                <th><span>Keahlian</span></th>
                                <th><span>Pendaftaran Akun <i class='far fa-calendar-alt'></i></span></th>
                                <th><span>Status Konfirmasi <i class='fa fa-check-circle'></i></span></th>
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
