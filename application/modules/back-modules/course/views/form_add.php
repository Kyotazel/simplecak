<form class="form_input mb-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h3>Konten Pelatihan</h3>
                            <div class="">
                                <textarea name="description" id="description" class="ckeditor_form" cols="30" rows="10"><?= isset($data_detail->description) ? $data_detail->description : ''; ?></textarea>
                                <span class="invalid-feedback notif_content"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="container">
                    <div class="card-body">
                        <h4 class="mb-3">Parameter Pelatihan : </h4>
                        <div>
                            <div class="form-group">
                                <label for="name">Nama Pelatihan</label>
                                <input type="text" class="form-control" name="name" placeholder="Masukkan Pelatihan..." value="<?= isset($data_detail->name) ? $data_detail->name : ''; ?>">
                                <span class="invalid-feedback"></span>
                            </div>
                            <div class="form-group">
                                <label for="id_category_course">Kategori Pelatihan</label>
                                <select name="id_category_course" id="id_category_course" class="form-control select2">
                                    <?php
                                    foreach ($get_course_category as $value) {
                                        if (isset($data_detail->id_category_course)) {
                                            $selected = ($value->id == $data_detail->id_category_course) ? 'selected' : '';
                                            echo '<option value="' . $value->id . '" ' . $selected . '>' . $value->name . '</option>';
                                        } else {
                                            echo "<option value='$value->id'>$value->name</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <span class="invalid-feedback"></span>
                            </div>
                            <div class="form-group">
                                <label for="skill">Skill</label>
                                <select name="skill[]" id="skill" class="form-control select2" multiple="multiple">
                                    <?php
                                    foreach ($get_skill as $value) {
                                        $selected = (in_array($value->id, $detail_skill)) ? 'selected' : '';
                                        echo '<option value="' . $value->id . '" ' . $selected . '>' . $value->name . '</option>';
                                    }
                                    ?>
                                </select>
                                <span class="invalid-feedback"></span>
                            </div>
                            <div class="text-right">
                                <a href="<?= Modules::run('helper/create_url', 'course'); ?>" class="btn btn-rounded btn-light font-weight-bold mt-3">Kembali</a>
                                <button type="submit" class="btn btn-primary mt-3 mb-0 btn_save" data-id="<?= isset($data_detail->id) ? $data_detail->id : ''; ?>" data-method="<?= $method ?>"><i class="fa fa-save"></i> Simpan Data</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</form>