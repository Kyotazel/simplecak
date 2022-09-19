<?php
    $session_image = $this->session->userdata('us_image');
    $image = base_url('assets/themes/valex/img/faces/6.jpg');
    if (!empty($session_image)) {
        $base_dir = str_replace(PREFIX_CREDENTIAL_DIRECTORY . '/', '', BASE_DIR);
        $dir = $base_dir . 'upload/user/' . $session_image;
        if (file_exists($dir)) {
            $image = base_url('upload/user/' . $session_image);
        }
    }

    $btn_update   = '<a href="' . Modules::run('helper/create_url', 'app_profile/update_profile') . '" class="btn btn-block btn-success"><i class="fa fa-edit"></i> Update Profil </a>';
    $btn_reset   = '<a href="' . Modules::run('helper/create_url', 'app_profile/reset_password') . '" class="btn btn-block btn-primary mt-2"><i class="fa fa-edit"></i> Update Password </a>';

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
                        <div class="col-md-12 border text-left">
                            <div class="row p-2">
                                <div class="col-md-4">
                                    <i class="fa fa-phone"></i> No HP :
                                </div>
                                <div class="col-md-8">
                                    <div>
                                        <?= $data_detail->phone_number?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-12 border text-left">
                            <div class="row p-2">
                                <div class="col-md-4">
                                    <i class="fa fa-envelope"></i> Email :
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
                        <div class="col-md-12 border text-left">
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
                        <div class="col-md-12">
                            <?= $btn_update ?>
                        </div>
                        <div class="col-md-12">
                            <?= $btn_reset ?>
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
                    <div class="col-md-7 my-3"><?= isset($education->name) ? $education->name : '' ?></div>
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
                    <div class="col-md-7 my-3"><?= Modules::run("helper/date_indo", $data_detail->birth_date, "-"); ?></div>
                </div>
                <div class="row border-bottom">
                    <div class="col-md-5 my-3">Jenis Kelamin</div>
                    <div class="col-md-7 my-3"><?= isset($gender->label) ? $gender->label : '' ?></div>
                </div>
                <div class="row border-bottom">
                    <div class="col-md-5 my-3">Agama</div>
                    <div class="col-md-7 my-3"><?= isset($religion->label) ? $religion->label : '' ?></div>
                </div>
                <div class="row border-bottom">
                    <div class="col-md-5 my-3">Provinsi Asal</div>
                    <div class="col-md-7 my-3"><?= isset($province->name) ? $province->name : '' ?></div>
                </div>
                <div class="row border-bottom">
                    <div class="col-md-5 my-3">Kota Asal</div>
                    <div class="col-md-7 my-3"><?= isset($city->name) ? $city->name : '' ?></div>
                </div>
                <div class="row border-bottom">
                    <div class="col-md-5 my-3">Kecamatan Asal</div>
                    <div class="col-md-7 my-3"><?= isset($city->name) ? $city->name : '' ?></div>
                </div>
                <div class="row border-bottom">
                    <div class="col-md-5 my-3">Desa Asal</div>
                    <div class="col-md-7 my-3"><?= isset($village->name) ? $village->name : '' ?></div>
                </div>
                <div class="row border-bottom">
                    <div class="col-md-5 my-3">Alamat</div>
                    <div class="col-md-7 my-3"><?= $data_detail->address ?></div>
                </div>
                <div class="row border-bottom">
                    <div class="col-md-5 my-3">Provinsi Sekarang</div>
                    <div class="col-md-7 my-3"><?= isset($province_current->name) ? $province_current->name : '' ?></div>
                </div>
                <div class="row border-bottom">
                    <div class="col-md-5 my-3">Kota Sekarang</div>
                    <div class="col-md-7 my-3"><?= isset($city_current->name) ? $city_current->name : '' ?></div>
                </div>
                <div class="row border-bottom">
                    <div class="col-md-5 my-3">Kecamatan Sekarang</div>
                    <div class="col-md-7 my-3"><?= isset($regency_current->name) ? $regency_current->name : '' ?></div>
                </div>
                <div class="row border-bottom">
                    <div class="col-md-5 my-3">Desa Sekarang</div>
                    <div class="col-md-7 my-3"><?= isset($village_current->name) ? $village_current->name : '' ?></div>
                </div>
                <div class="row border-bottom">
                    <div class="col-md-5 my-3">Alamat Sekarang</div>
                    <div class="col-md-7 my-3"><?= $data_detail->address_current ?></div>
                </div>
                <div class="row border-bottom">
                    <div class="col-md-5 my-3">Pendaftaran Akun</div>
                    <div class="col-md-7 my-3"><?= Modules::run("helper/date_indo",$data_detail->registration_date, "-") ?></div>
                </div>
            </div>
        </div>
    </div>
</div>