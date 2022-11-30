<form class="form_input">
    <div class="row row-sm main-content-mail mb-5">
        <div class="col-md-12 container_list">
            <div class="card mb-5">
                <div class="card-header d-flex">
                    <a class="btn float-start mr-2 text-dark btn-rounded mb-3 tx-18" href="<?= base_url('industry-area/job_vacancy') ?>">
                        <i class="mdi mdi-arrow-left-thick"></i>
                    </a>
                    <h2>Lowongan Pekerjaan</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-9">
                            <div class="form-group">
                                <label for="job_name">Nama Pekerjaan</label>
                                <input type="text" id="job_name" name="job_name" class="form-control" placeholder="Pekerjaan..." value="<?= isset($data_detail->title) ? $data_detail->title : '' ?>">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group">
                                <label for="end_vacancy">Lowongan Ditutup</label>
                                <input type="text" name="end_vacancy" id="end_vacancy" autocomplete="off" class="form-control datepicker" placeholder="Lwwongan Berakhir... " value="<?= isset($data_detail->end_date) ? $data_detail->end_date : '' ?>">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="min_salary">Rentang Gaji <small class="text-danger tx-bold">* Samakan nominal gaji jika tidak ingin menggunakan rentang gaji</small></label>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="min_salary" name="min_salary" class="form-control" placeholder="Gaji Minimum..." value="<?= isset($data_detail->title) ? $data_detail->title : '' ?>">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="max_salary" name="max_salary" class="form-control" placeholder="Gaji Maximum..." value="<?= isset($data_detail->title) ? $data_detail->title : '' ?>">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="job_position">Posisi Pekerjaan</label>
                                <input type="text" id="job_position" name="job_position" class="form-control" placeholder="Posisi dalam pekerjaan ini..." value="<?= isset($data_detail->title) ? $data_detail->title : '' ?>">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="education">Minimal Pendidikan</label>
                                <select name="education[]" id="education" class="form-control" multiple="multiple">
                                    <option value="0">Tidak dibatasi</option>
                                    <?php foreach ($education as $value) : ?>
                                        <option value="<?= $value->id ?>"><?= $value->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label for="work_field">Bidang Pekerjaan</label>
                                        <select name="work_field" id="work_field" class="form-control">
                                            <option value="">Bidang pekerjaan yang dikerjakan di lowongan ini</option>
                                            <?php foreach ($work_field as $value) : ?>
                                                <option value="<?= $value->id ?>"><?= $value->name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-8">
                                    <div class="form-group">
                                        <label for="job_skill">Keahlian</label>
                                        <select name="job_skill[]" id="job_skill" class="form-control" multiple="multiple">
                                            <option value="">Keahlian yang diperlukan di lowongan ini</option>
                                            <?php foreach ($skill as $value) : ?>
                                                <option value="<?= $value->id ?>"><?= $value->name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>       
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-sm-12 col-md-3">
                                    <div class="form-group">
                                        <label for="employment_status">Jenis Pekerjaan</label>
                                        <select name="employment_status" id="employment_status" class="form-control">
                                            <option value="">Jenis pekerjaan di lowongan ini</option>
                                            <option value="0">Fulltime</option>
                                            <option value="1">Partime</option>
                                            <option value="2">Kontrak</option>
                                            <option value="3">Magang</option>
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <div class="form-group">
                                        <label for="experience">Minimal Pengalaman</label>
                                        <input type="text" id="experience" name="experience" class="form-control" placeholder="Minimal pengalaman untuk lowongan ini..." value="<?= isset($data_detail->title) ? $data_detail->title : '' ?>">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <div class="form-group">
                                        <label for="applicant_gender">Gender</label>
                                        <select name="applicant_gender" id="applicant_gender" class="form-control">
                                            <option value="">Lowongan ini dikhususkan untuk gender</option>
                                            <option value="0">Perempuan</option>
                                            <option value="1">Laki - Laki</option>
                                            <option value="2">Semua Gender</option>
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <div class="form-group">
                                        <label for="job_address">Alamat Pekerjaan</label>
                                        <textarea name="job_address" id="job_address" cols="30" rows="3" placeholder="Alamat pekerjaan ini dikerjakan"></textarea>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3>Deskripsi Pekerjaan</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="">
                                <textarea id="job_desc" class="ckeditor_form" cols="30" rows="10"><?= isset($data_detail->description) ? $data_detail->description : ''; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 text-right mt-3">
                <button type="submit" class="btn btn-primary btn_save" data-id="<?= isset($data_detail->id) ? $this->encrypt->encode($data_detail->id) : ''; ?>" data-method="<?= $method ?>"><i class="fa fa-save"></i> Simpan Data</button>
            </div>
        </div>
    </div>
</form>