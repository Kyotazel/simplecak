<?php
$type = $this->input->get('type');
?>

<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12 container_list">
        <div class="card">
            <div class="card-body">
                <div class="mb-3 row">
                    <h3 class="col-md-8">Daftar User</h3>
                    <div class="col-md-4 text-right">
                        <?= Modules::run('security/create_access', '<a href="' . Modules::run('helper/create_url', '/app_user/add') . '" class="btn btn-primary-gradient"> <i class="fa fa-plus-circle"></i> Tambah User</a>'); ?>
                    </div>
                </div>
                <div class="table-responsive border-top userlist-table">
                    <table class="table card-table table-striped table-vcenter text-nowrap mb-0" id="table_module">
                        <thead>
                            <tr>
                                <th class="wd-lg-3p"><span>No</span></th>
                                <th class="wd-lg-35p"><span>Nama</span></th>
                                <th class="wd-lg-20p"><span>Email & Telp</span></th>
                                <th class="wd-lg-20p"><span>Credential</span></th>
                                <th class="wd-lg-10p"><span>status</span></th>
                                <th>is create</th>
                                <th>is update</th>
                                <th>is delete</th>
                                <th class="wd-lg-10p">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>