<?php
$btn_edit   = Modules::run('security/edit_access', '<a href="' . Modules::run('helper/create_url', 'course/edit?data=' . urlencode($this->encrypt->encode($data_detail->id))) . '" class="btn btn-success btn-rounded mr-3"><i class="fa fa-edit"></i> Edit Data</a>');
$btn_delete = Modules::run('security/delete_access', '<a href="javascript:void(0)" data-id="' . urlencode($this->encrypt->encode($data_detail->id)) . '" data-redirect="1" class="btn_delete btn btn-danger btn-rounded mr-3"><i class="fa fa-trash"></i> Hapus Data</a>');
?>

<style>
    .dz-remove {
        display: block !important;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="col-12  row mb-2">
                <div class="col-6">
                    <a href="<?= Modules::run('helper/create_url', 'course') ?>" class="btn btn-primary btn-rounded"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
                </div>
                <div class="col-6 text-right">
                    <?= $btn_edit . $btn_delete; ?>
                </div>
            </div>
            <div class="card custom-card">
                <div class="card-body">
                    <h3 class="mb-3"><?= $data_detail->name; ?></h3>
                    <div>
                        <?= $data_detail->description; ?>
                    </div>
                    <a class="btn ripple btn-primary" href="#">Read More<i class="fe fe-arrow-right ml-1"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>