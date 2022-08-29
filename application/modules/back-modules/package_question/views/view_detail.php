<?php
$btn_edit   = Modules::run('security/edit_access', '<a href="' . Modules::run('helper/create_url', 'package_category/edit?data=' . urlencode($this->encrypt->encode($data_detail->id))) . '" class="btn btn-success btn-rounded mr-3"><i class="fa fa-edit"></i> Edit Data</a>');
$btn_delete = Modules::run('security/delete_access', '<a href="javascript:void(0)" data-id="' . urlencode($this->encrypt->encode($data_detail->id)) . '" data-redirect="1" class="btn_delete btn btn-danger btn-rounded mr-3"><i class="fa fa-trash"></i> Hapus Data</a>');
?>

<div class="container">
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="col-12  row mb-2">
                <div class="col-2">
                    <a href="<?= Modules::run('helper/create_url', 'package_category') ?>" class="btn btn-primary btn-block"><i class="fa fa-arrow-left"></i> Kembali</a>
                </div>
                <div class="col-4"></div>
                <div class="col-6 text-right">
                    <?= $btn_edit . $btn_delete; ?>
                </div>
            </div>
            <div class="card custom-card mt-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?= $data_detail->name; ?>
                        </div>
                        <div class="col-md-12">
                            <?= $data_detail->description ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>