<?php
$type = $this->input->get('type');
$array_schedule = json_decode($company_schedule, TRUE);
?>
<div class="container">
    <div class="row row-sm">
        <div class="col-12">
            <div class="card  box-shadow-0">
                <div class="card-header">
                    <h4 class="card-title mb-1"><i class="fa fa-home"></i> Data Umum</h4>
                    <p class="mb-2">Berisi tentang data umum perusahaan dan jadwal kerja.</p>
                </div>
                <div class="card-body pt-0">
                    <form class="form-profile">
                        <div class="row">
                            <div class="col-8">
                                <label for="" class="font-weight-bold"> Profil Perusahaan</label>
                                <table class="" style="width: 100%;">
                                    <tbody>
                                        <tr>
                                            <td width="150px">Nama Perusahaan</td>
                                            <td width="10px;">:</td>
                                            <td>
                                                <input type="text" class="form-control" name="name" value="<?= $company_name; ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tagline</td>
                                            <td>:</td>
                                            <td id="tagline">
                                                <input type="text" class="form-control" name="tagline" value="<?= $company_tagline; ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>No.Telp</td>
                                            <td>:</td>
                                            <td id="tagline">
                                                <input type="text" class="form-control" name="number_phone" value="<?= $company_number_phone; ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>:</td>
                                            <td id="email">
                                                <input type="text" class="form-control" name="email" value="<?= $company_email; ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Website</td>
                                            <td>:</td>
                                            <td id="website">
                                                <input type="text" class="form-control" name="website" value="<?= $company_website; ?>">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Alamat</td>
                                            <td>:</td>
                                            <td id="address">
                                                <textarea name="address" class="form-control" id="" rows="5"><?= $company_address; ?></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Id Video Youtube</td>
                                            <td>:</td>
                                            <td id="link_video">
                                                <input type="text" class="form-control" name="link_profile" value="<?= $company_link_video; ?>">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-4">
                                <label for="" class="font-weight-bold"> Jadwal Kerja :</label>
                                <table class="" style="width: 100%;">
                                    <tbody>
                                        <tr>
                                            <td width="150px">Senin</td>
                                            <td width="10px;">:</td>
                                            <td>
                                                <input type="text" name="schedule[senin]" value="<?= isset($array_schedule['senin']) ? $array_schedule['senin'] : ''; ?>" class="form-control">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="150px">Selasa</td>
                                            <td width="10px;">:</td>
                                            <td>
                                                <input type="text" name="schedule[selasa]" value="<?= isset($array_schedule['selasa']) ? $array_schedule['selasa'] : ''; ?>" class="form-control">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="150px">Rabu</td>
                                            <td width="10px;">:</td>
                                            <td>
                                                <input type="text" name="schedule[rabu]" value="<?= isset($array_schedule['rabu']) ? $array_schedule['rabu'] : ''; ?>" class="form-control">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="150px">kamis</td>
                                            <td width="10px;">:</td>
                                            <td>
                                                <input type="text" name="schedule[kamis]" value="<?= isset($array_schedule['kamis']) ? $array_schedule['kamis'] : ''; ?>" class="form-control">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="150px">Jumat</td>
                                            <td width="10px;">:</td>
                                            <td>
                                                <input type="text" name="schedule[jumat]" value="<?= isset($array_schedule['jumat']) ? $array_schedule['jumat'] : ''; ?>" class="form-control">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="150px">Sabtu</td>
                                            <td width="10px;">:</td>
                                            <td>
                                                <input type="text" name="schedule[sabtu]" value="<?= isset($array_schedule['sabtu']) ? $array_schedule['sabtu'] : ''; ?>" class="form-control">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="150px">Minggu</td>
                                            <td width="10px;">:</td>
                                            <td>
                                                <input type="text" name="schedule[minggu]" value="<?= isset($array_schedule['minggu']) ? $array_schedule['minggu'] : ''; ?>" class="form-control">
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-primary-gradient btn-rounded font-weight-bold btn_update_profile">Simpan Data <i class="fa fa-paper-plane"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card  box-shadow-0 ">
                <div class="card-header">
                    <h4 class="card-title mb-1"><i class="fa fa-building"></i> Deskripsi Perusahaan</h4>
                    <p class="mb-2">Berisi tentang profil dan deskripsi perusahaan.</p>
                </div>
                <style>
                    #short_desc .cke_contents.cke_reset {
                        height: 200px !important;
                    }
                </style>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-4 border-dashed">
                            <form class="form_update_front_profile">
                                <div class="main-img-user profile-user" style="width: 100%;height:100%;">
                                    <?php
                                    if (!empty($company_front_banner)) {
                                        echo '
                                                <img alt="" style="border-radius:0px;" src="' . base_url('upload/banner/' . $company_front_banner) . '">
                                            ';
                                    }
                                    ?>
                                    <a class="fas fa-camera profile-edit" href="JavaScript:void(0);"></a>
                                    <input type="file" class="profile-edit upload_form" name="upload_profile">
                                </div>
                            </form>
                        </div>
                        <div class="col-8" id="short_desc">
                            <label for="" class="font-weight-bold">Deskripsi Pendek</label>
                            <textarea name="description" id="content_short_profile" class="ckeditor_form" cols="30" rows="10"><?= $company_short_description; ?></textarea>
                        </div>
                        <div class="col-12 mt-3">
                            <label for="" class="font-weight-bold">Deskripsi Panjang</label>
                            <textarea name="description" id="content_profile" class="ckeditor_form" cols="30" rows="10"><?= $company_description; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-12 text-right">
                        <a href="javascript:void(0)" class="btn btn-primary-gradient btn-rounded font-weight-bold btn_save_description">Simpan Data <i class="fa fa-paper-plane"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card  box-shadow-0 ">
                <div class="card-header">
                    <h4 class="card-title mb-1"><i class="fa fa-tv"></i> Akun Social Media</h4>
                    <p class="mb-2">Berisi tentang daftar akun social media perusahaan.</p>
                </div>
                <div class="card-body pt-0">
                    <form class="form-sosmed">
                        <div class="col-12">
                            <table class="" style="width: 100%;">
                                <tbody>
                                    <tr>
                                        <td width="150px"> Facebook</td>
                                        <td width="10px;">:</td>
                                        <td>
                                            <input type="text" class="form-control" name="facebook" value="<?= $company_facebook; ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="150px">Instagram</td>
                                        <td width="10px;">:</td>
                                        <td>
                                            <input type="text" class="form-control" name="instagram" value="<?= $company_instagram; ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="150px">Twitter</td>
                                        <td width="10px;">:</td>
                                        <td>
                                            <input type="text" class="form-control" name="twitter" value="<?= $company_twitter; ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="150px">Line</td>
                                        <td width="10px;">:</td>
                                        <td>
                                            <input type="text" class="form-control" name="line" value="<?= $company_line; ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="150px">Youtube</td>
                                        <td width="10px;">:</td>
                                        <td>
                                            <input type="text" class="form-control" name="youtube" value="<?= $company_youtube; ?>">
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <div class="col-12 text-right mt-3">
                            <button type="submit" class="btn btn-primary-gradient btn-rounded font-weight-bold btn_update_sosmed">Simpan Data <i class="fa fa-paper-plane"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card  box-shadow-0 ">
                <div class="card-header">
                    <h4 class="card-title mb-1"><i class="fa fa-star"></i> Service Perusahaan</h4>
                    <p class="mb-2">Berisi daftar service perusahaan.</p>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-12 text-right mb-2">
                            <small>(*klik untuk tambah data)</small>
                            <a href="javascript:void(0)" class="btn btn-primary-gradient font-weight-bold btn-rounded btn-add-service"><i class="fa fa-plus-circle"></i> Tambah Data</a>
                        </div>
                        <div class="col-12">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th clas>Service</th>
                                        <th style="width:200px;"></th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-service"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" tabindex="-1" id="modal_service">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Input Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </div>
            <div class="modal-body">
                <form id="form-service">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control" name="title" id="tonase" />
                                <span class="help-block notif_tonase"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Keterangan</label>
                                <textarea name="description" class="form-control" rows="10"></textarea>
                                <span class="help-block notif_slot"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Icon</label>
                                <input type="file" name="media" class="form-control" />
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-right">
                        <small>(*Klik untuk simpan data)</small>
                        <button type="submit" class="btn btn-primary-gradient btn-rounded btn_save_service" type="submit">Simpan <i class="fa fa-paper-plane"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>