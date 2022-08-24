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

 <!-- <input type="hidden" name="end_date" id="end_date" value="<?= $data_detail->closing_registration_date ?>">
                                    <div class="row expired d-none">
                                        <div class="text-center">
                                            <h2 class="text-danger">E X P I R E D</h2>
                                        </div>
                                    </div>
                                    <div class="row not_expired">
                                        <div class="col-xl-3 col-lg-6 col-sm-6 p-0 border">
                                            <div class="card-body py-1 text-center">
                                                <h4 class="text-primary"><span class="day"></span></h4>
                                                <h6 class="mb-0" style="font-size: 12px;">Hari</h6>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-sm-6 p-0 border">
                                            <div class="card-body py-1 text-center">
                                                <h4 class="text-primary"><span class="hour"></span></h4>
                                                <h6 class="mb-0" style="font-size: 12px;">Jam</h6>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-sm-6 p-0 border">
                                            <div class="card-body py-1 text-center">
                                                <h4 class="text-primary"><span class="minute"></span></h4>
                                                <h6 class="mb-0" style="font-size: 12px;">Menit</h6>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-sm-6 p-0 border">
                                            <div class="card-body py-1 text-center">
                                                <h4 class="text-primary"><span class="second"></span></h4>
                                                <h6 class="mb-0" style="font-size: 12px;">Detik</h6>
                                            </div>
                                        </div>
                                    </div> -->