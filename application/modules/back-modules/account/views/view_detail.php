<?php
$btn_edit   = Modules::run('security/edit_access', '<a href="' . Modules::run('helper/create_url', 'account/edit?data=' . urlencode($this->encrypt->encode($data_detail->id))) . '" class="btn btn-block btn-success"><i class="fa fa-edit"></i> Edit Data</a>');
$btn_delete = Modules::run('security/delete_access', '<a href="javascript:void(0)" data-id="' . urlencode($this->encrypt->encode($data_detail->id)) . '" data-redirect="1" class="btn_delete btn btn-block btn-danger"><i class="fa fa-trash"></i> Hapus Data</a>');
?>
<div class="row mb-5">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3>Data Profil</h3>
            </div>
            <div class="card-body">
                <div class="main-profile-overview text-center">
                    <div class="main-img-user profile-user">
                        <img alt="" src="<?= base_url('upload/member/') . $data_detail->image ?>">
                    </div>
                    <div class=" mg-b-20">
                        <div>
                            <h5 class="main-profile-name"><?= $data_detail->name; ?></h5>
                            <p class="main-profile-name-text"><?= $data_detail->email; ?></p>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-12 border">
                            <div class="row p-2">
                                <div class="col-md-4">
                                    <i class="fa fa-map-marker"></i> Alamat :
                                </div>
                                <div class="col-md-8">
                                    <div>
                                        <?= $city_current->name . ", " . $regency_current->name ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-12 border">
                            <div class="row p-2">
                                <div class="col-md-4">
                                    <i class="fa fa-map-marker"></i> Email :
                                </div>
                                <div class="col-md-8">
                                    <div>
                                        <?= $data_detail->email ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-12 border">
                            <div class="row p-2">
                                <div class="col-md-4">
                                    <i class="fa fa-map-marker"></i> Skill :
                                </div>
                                <div class="col-md-8">
                                    <div>
                                        <?= $skill ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1 mt-3">
                        <div class="col-md-6">
                            <?= $btn_edit ?>
                        </div>
                        <div class="col-md-6">
                            <?= $btn_delete ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3>Data Pendukung</h3>
            </div>
            <div class="card-body">
                <div class="row border-bottom">
                    <div class="col-md-5 my-3">NIK</div>
                    <div class="col-md-7 my-3"><?= $data_detail->no_ktp ?></div>
                </div>
                <div class="row border-bottom">
                    <div class="col-md-5 my-3">NO KK</div>
                    <div class="col-md-7 my-3"><?= $data_detail->no_kk ?></div>
                </div>
                <div class="row border-bottom">
                    <div class="col-md-5 my-3">Pendidikan Terakhir</div>
                    <div class="col-md-7 my-3"><?= $education->name ?></div>
                </div>
                <div class="row border-bottom">
                    <div class="col-md-5 my-3">Asal Sekolah</div>
                    <div class="col-md-7 my-3"><?= $data_detail->last_school ?></div>
                </div>
                <div class="row border-bottom">
                    <div class="col-md-5 my-3">Tempat Lahir</div>
                    <div class="col-md-7 my-3"><?= $data_detail->birth_place ?></div>
                </div>
                <div class="row border-bottom">
                    <div class="col-md-5 my-3">Tanggal Lahir</div>
                    <div class="col-md-7 my-3"><?= $data_detail->birth_date ?></div>
                </div>
                <div class="row border-bottom">
                    <div class="col-md-5 my-3">Jenis Kelamin</div>
                    <div class="col-md-7 my-3"><?= $gender->label ?></div>
                </div>
                <div class="row border-bottom">
                    <div class="col-md-5 my-3">Agama</div>
                    <div class="col-md-7 my-3"><?= $religion->label ?></div>
                </div>
                <div class="row border-bottom">
                    <div class="col-md-5 my-3">Provinsi Asal</div>
                    <div class="col-md-7 my-3"><?= $province->name ?></div>
                </div>
                <div class="row border-bottom">
                    <div class="col-md-5 my-3">Kota Asal</div>
                    <div class="col-md-7 my-3"><?= $city->name ?></div>
                </div>
                <div class="row border-bottom">
                    <div class="col-md-5 my-3">Kecamatan Asal</div>
                    <div class="col-md-7 my-3"><?= $regency->name ?></div>
                </div>
                <div class="row border-bottom">
                    <div class="col-md-5 my-3">Desa Asal</div>
                    <div class="col-md-7 my-3"><?= $village->name ?></div>
                </div>
                <div class="row border-bottom">
                    <div class="col-md-5 my-3">Alamat</div>
                    <div class="col-md-7 my-3"><?= $data_detail->address ?></div>
                </div>
                <div class="row border-bottom">
                    <div class="col-md-5 my-3">Provinsi Sekarang</div>
                    <div class="col-md-7 my-3"><?= $province_current->name ?></div>
                </div>
                <div class="row border-bottom">
                    <div class="col-md-5 my-3">Kota Sekarang</div>
                    <div class="col-md-7 my-3"><?= $city_current->name ?></div>
                </div>
                <div class="row border-bottom">
                    <div class="col-md-5 my-3">Kecamatan Sekarang</div>
                    <div class="col-md-7 my-3"><?= $regency_current->name ?></div>
                </div>
                <div class="row border-bottom">
                    <div class="col-md-5 my-3">Desa Sekarang</div>
                    <div class="col-md-7 my-3"><?= $village_current->name ?></div>
                </div>
                <div class="row border-bottom">
                    <div class="col-md-5 my-3">Alamat Sekarang</div>
                    <div class="col-md-7 my-3"><?= $data_detail->address_current ?></div>
                </div>
            </div>
        </div>
    </div>
</div>