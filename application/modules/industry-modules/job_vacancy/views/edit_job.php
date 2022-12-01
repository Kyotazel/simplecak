<form class="form_input">
    <div class="row row-sm main-content-mail mb-5">
        <div class="col-md-12 container_list">
            <div class="card mb-5">
                <div class="card-header d-flex">
                    <a class="btn float-start mr-2 text-dark btn-rounded mb-3 tx-18" href="<?= base_url('industry-area/job_vacancy/detail?data=') . $this->encrypt->encode($data_detail->id) ?>">
                        <i class="mdi mdi-arrow-left-thick"></i>
                    </a>
                    <h2>Edit Lowongan Pekerjaan</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-9">
                            <div class="form-group">
                                <label for="job_name">Nama Pekerjaan</label>
                                <input type="text" id="job_name" name="job_name" class="form-control" placeholder="Pekerjaan..." value="<?= isset($data_detail->job_name) ? $data_detail->job_name : '' ?>">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group">
                                <label for="end_vacancy">Lowongan Ditutup</label>
                                <input type="text" name="end_vacancy" id="end_vacancy" autocomplete="off" class="form-control datepicker" placeholder="Lowongan Berakhir... " value="<?= isset($data_detail->end_vacancy) ? $data_detail->end_vacancy : '' ?>">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="min_salary">Rentang Gaji <small class="text-danger tx-bold">* Samakan nominal gaji jika tidak ingin menggunakan rentang gaji</small></label>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="min_salary" name="min_salary" class="form-control" placeholder="Gaji Minimum..." value="<?= isset($data_detail->minimum_salary) ? $data_detail->minimum_salary : '' ?>">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="max_salary" name="max_salary" class="form-control" placeholder="Gaji Maximum..." value="<?= isset($data_detail->maximum_salary) ? $data_detail->maximum_salary : '' ?>">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="job_position">Posisi Pekerjaan</label>
                                <input type="text" id="job_position" name="job_position" class="form-control" placeholder="Posisi dalam pekerjaan ini..." value="<?= isset($data_detail->position) ? $data_detail->position : '' ?>">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="education">Minimal Pendidikan</label>
                                <select name="education[]" id="education" class="form-control" multiple="multiple">
                                    <?php foreach ($education as $value) : ?>
                                        <?php
                                        if (in_array(0, $has_education)) {
                                            $no_edu = 'selected';
                                        } else {
                                            $no_edu = '';
                                        }
                                        $selected = (in_array($value->id, $has_education)) ? 'selected' : '';
                                        echo '<option value="' . $value->id . '" ' . $selected . '>' . $value->name . '</option>';
                                        ?>
                                    <?php endforeach; ?>
                                    <?php 
                                    echo '<option value="0" '. $no_edu .'>Tidak dibatasi</option>';
                                    ?>

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
                                                <?php 
                                                if (isset($data_detail->work_field)) {
                                                    $selected = ($value->id == $data_detail->work_field) ? 'selected' : '';
                                                    echo '<option value="' . $value->id . '" ' . $selected . '>' . $value->name . '</option>';
                                                } else {
                                                    echo "<option value='$value->id'>$value->name</option>";
                                                }    
                                                ?>
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
                                                <?php 
                                                    $selected = (in_array($value->id, $has_skill)) ? 'selected' : '';
                                                    echo '<option value="' . $value->id . '" ' . $selected . '>' . $value->name . '</option>';
                                                ?>
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
                                            <?php foreach ($employment_status as $value) : ?>
                                                <?php 
                                                if (isset($data_detail->employment_status)) {
                                                    $selected = ($value['id'] == $data_detail->employment_status) ? 'selected' : '';
                                                    echo '<option value="' . $value['id'] . '" ' . $selected . '>' . $value['name'] . '</option>';
                                                } else {
                                                    echo '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
                                                } ?>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <div class="form-group">
                                        <label for="experience">Minimal Pengalaman</label>
                                        <input type="text" id="experience" name="experience" class="form-control" placeholder="Minimal pengalaman untuk lowongan ini..." value="<?= isset($data_detail->experience) ? $data_detail->experience : '' ?>">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <div class="form-group">
                                        <label for="applicant_gender">Gender</label>
                                        <select name="applicant_gender" id="applicant_gender" class="form-control">
                                            <option value="">Lowongan ini dikhususkan untuk gender</option>
                                            <?php foreach ($applicant_gender as $value) : ?>
                                                <?php 
                                                if (isset($data_detail->applicant_gender)) {
                                                    $selected = ($value['id'] == $data_detail->applicant_gender) ? 'selected' : '';
                                                    echo '<option value="' . $value['id'] . '" ' . $selected . '>' . $value['name'] . '</option>';
                                                } else {
                                                    echo '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
                                                } ?>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <div class="form-group">
                                        <label for="job_address">Alamat Pekerjaan</label>
                                        <textarea name="job_address" class="form-control" id="job_address" cols="30" rows="3" placeholder="Alamat pekerjaan ini dikerjakan"><?= isset($data_detail->job_address) ? $data_detail->job_address : '' ?></textarea>
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
                                <textarea id="job_desc" class="ckeditor_form" cols="30" rows="10"><?= isset($data_detail->job_desc) ? $data_detail->job_desc : ''; ?></textarea>
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