<style>
    .jsplus_ui_toolbar_line,
    .cke_bottom,
    .n1ed_top_right_block {
        display: none !important
    }
</style>

<form class="form_input">
    <div class="row row-sm main-content-mail mb-5">
        <div class="col-md-12 container_list">
            <div class="card mb-5">
                <div class="card-header">
                    <h3>Form Pembuatan Soal</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="mg-b-5">
                                <span class="badge badge-primary">Upload Gambar (Opsional)</span>
                                <p></p>
                            </div>
                            <div class="row row-sm">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="input-group file-browser">
                                        <input type="text" class="form-control border-right-0 browse-file" placeholder="choose" readonly>
                                        <label class="input-group-btn">
                                            <span class="btn btn-primary">
                                                Browse <input name="file_media" type="file" style="display: none;">
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3 mb-2">
                            <div class="mg-b-5">
                                <span class="badge badge-primary">Text Pertanyaan</span>
                                <p></p>
                            </div>
                            <div>
                                <textarea name="text_question" id="text_question" class="ckeditor_forma" cols="30" rows="10"><?= isset($data_detail->text_question) ? $data_detail->text_question : ''; ?></textarea>
                            </div>
                            <hr>
                        </div>
                        <div class="col-md-6 mt-3">
                            <div class="mg-b-5">
                                <span class="badge badge-primary">Pilihan Ganda A</span>
                                <p></p>
                            </div>
                            <div>
                                <textarea name="result_a" id="result_a" class="ckeditor_forma" cols="30" rows="10"><?= isset($data_detail->text_question) ? $data_detail->text_question : ''; ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">
                            <div class="mg-b-5">
                                <span class="badge badge-primary">Pilihan Ganda B</span>
                                <p></p>
                            </div>
                            <div>
                                <textarea name="result_b" id="result_b" class="ckeditor_forma" cols="30" rows="10"><?= isset($data_detail->text_question) ? $data_detail->text_question : ''; ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">
                            <div class="mg-b-5">
                                <span class="badge badge-primary">Pilihan Ganda C</span>
                                <p></p>
                            </div>
                            <div>
                                <textarea name="result_c" id="result_c" class="ckeditor_forma" cols="30" rows="10"><?= isset($data_detail->text_question) ? $data_detail->text_question : ''; ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">
                            <div class="mg-b-5">
                                <span class="badge badge-primary">Pilihan Ganda D</span>
                                <p></p>
                            </div>
                            <div>
                                <textarea name="result_d" id="result_d" class="ckeditor_forma" cols="30" rows="10"><?= isset($data_detail->text_question) ? $data_detail->text_question : ''; ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">
                            <div class="mg-b-5">
                                <span class="badge badge-primary">Pilihan Ganda E</span>
                                <p></p>
                            </div>
                            <div>
                                <textarea name="result_e" id="result_e" class="ckeditor_forma" cols="30" rows="10"><?= isset($data_detail->text_question) ? $data_detail->text_question : ''; ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="col-md-12">
                            <div class="mg-b-5 mb-3">
                                <span class="badge badge-primary">Jawaban</span>
                            </div>
                            <div class="row mg-t-10">
                                <div class="col-lg-2">
                                    <label class="rdiobox"><input name="answer" value="A" type="radio"> <span>Pilihan Ganda A</span></label>
                                </div>
                                <div class="col-lg-2 mg-t-20 mg-lg-t-0">
                                    <label class="rdiobox"><input name="answer" value="B" type="radio"> <span>Pilihan Ganda B</span></label>
                                </div>
                                <div class="col-lg-2 mg-t-20 mg-lg-t-0">
                                    <label class="rdiobox"><input name="answer" value="C" type="radio"> <span>Pilihan Ganda C</span></label>
                                </div>
                                <div class="col-lg-2 mg-t-20 mg-lg-t-0">
                                    <label class="rdiobox"><input name="answer" value="D" type="radio"> <span>Pilihan Ganda D</span></label>
                                </div>
                                <div class="col-lg-2 mg-t-20 mg-lg-t-0 mb-3">
                                    <label class="rdiobox"><input name="answer" value="E" type="radio"> <span>Pilihan Ganda E</span></label>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="col-md-12">
                            <div class="mg-b-5">
                                <span class="badge badge-primary">Penyelesaian (Opsional)</span>
                                <p></p>
                            </div>
                            <div>
                                <textarea name="solution" id="solution" class="ckeditor_forma" cols="10" rows="10"><?= isset($data_detail->solution) ? $data_detail->solution : ''; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <input type="hidden" name="id_parent" value="<?= $id_parent ?>" id="id_parent">
                        </div>
                        <div class="col-md-12 text-right mt-3">
                            <button type="submit" class="btn btn-primary btn_save" data-id="<?= isset($data_detail->id) ? $data_detail->id : ''; ?>" data-method="<?= $method ?>"><i class="fa fa-save"></i> Simpan Data</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- <form class="form_input">
    <div class="row row-sm main-content-mail mb-5">
        <div class="col-md-12 container_list">
            <div class="card mt-2">
                <div class="card-header">
                    <h3>Form Pembuatan Soal</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="mg-b-5">
                                <span class="badge badge-primary">Upload Gambar (Opsional)</span>
                                <p></p>
                            </div>
                            <div class="row row-sm">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="input-group file-browser">
                                        <input type="text" class="form-control border-right-0 browse-file" placeholder="choose" readonly>
                                        <label class="input-group-btn">
                                            <span class="btn btn-primary">
                                                Browse <input type="file" style="display: none;" multiple>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3 mb-2">
                            <div class="mg-b-5">
                                <span class="badge badge-primary">Text Pertanyaan</span>
                                <p></p>
                            </div>
                            <div>
                                <textarea name="text_question" id="text_question" class="summernote" cols="30" rows="10"><?= isset($data_detail->text_question) ? $data_detail->text_question : ''; ?></textarea>
                            </div>
                            <hr>
                        </div>
                        <div class="col-md-6 mt-3">
                            <div class="mg-b-5">
                                <span class="badge badge-primary">Pilihan Ganda A</span>
                                <p></p>
                            </div>
                            <div>
                                <textarea name="result_a" id="result_a" class="summernote" cols="30" rows="10"><?= isset($data_detail->text_question) ? $data_detail->text_question : ''; ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">
                            <div class="mg-b-5">
                                <span class="badge badge-primary">Pilihan Ganda B</span>
                                <p></p>
                            </div>
                            <div>
                                <textarea name="result_b" id="result_b" class="summernote" cols="30" rows="10"><?= isset($data_detail->text_question) ? $data_detail->text_question : ''; ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">
                            <div class="mg-b-5">
                                <span class="badge badge-primary">Pilihan Ganda C</span>
                                <p></p>
                            </div>
                            <div>
                                <textarea name="result_c" id="result_c" class="summernote" cols="30" rows="10"><?= isset($data_detail->text_question) ? $data_detail->text_question : ''; ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">
                            <div class="mg-b-5">
                                <span class="badge badge-primary">Pilihan Ganda D</span>
                                <p></p>
                            </div>
                            <div>
                                <textarea name="result_d" id="result_d" class="summernote" cols="30" rows="10"><?= isset($data_detail->text_question) ? $data_detail->text_question : ''; ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">
                            <div class="mg-b-5">
                                <span class="badge badge-primary">Pilihan Ganda E</span>
                                <p></p>
                            </div>
                            <div>
                                <textarea name="result_e" id="result_e" class="summernote" cols="30" rows="10"><?= isset($data_detail->text_question) ? $data_detail->text_question : ''; ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="col-md-12">
                            <div class="mg-b-5 mb-3">
                                <span class="badge badge-primary">Jawaban</span>
                            </div>
                            <div class="row mg-t-10">
                                <div class="col-lg-2">
                                    <label class="rdiobox"><input name="rdio" value="A" type="radio"> <span>Pilihan Ganda A</span></label>
                                </div>
                                <div class="col-lg-2 mg-t-20 mg-lg-t-0">
                                    <label class="rdiobox"><input name="rdio" value="B" type="radio"> <span>Pilihan Ganda B</span></label>
                                </div>
                                <div class="col-lg-2 mg-t-20 mg-lg-t-0">
                                    <label class="rdiobox"><input name="rdio" value="C" type="radio"> <span>Pilihan Ganda C</span></label>
                                </div>
                                <div class="col-lg-2 mg-t-20 mg-lg-t-0">
                                    <label class="rdiobox"><input name="rdio" value="D" type="radio"> <span>Pilihan Ganda D</span></label>
                                </div>
                                <div class="col-lg-2 mg-t-20 mg-lg-t-0 mb-3">
                                    <label class="rdiobox"><input name="rdio" value="E" type="radio"> <span>Pilihan Ganda E</span></label>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="col-md-12">
                            <div class="mg-b-5">
                                <span class="badge badge-primary">Penyelesaian (Opsional)</span>
                                <p></p>
                            </div>
                            <div>
                                <textarea name="answer" id="answer" class="summernote" cols="10" rows="10"><?= isset($data_detail->text_question) ? $data_detail->text_question : ''; ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-12 text-right mt-3">
                        <button type="submit" class="btn btn-primary btn_save" data-id="<?= isset($data_detail->id) ? $data_detail->id : ''; ?>" data-method="<?= $method ?>"><i class="fa fa-save"></i> Simpan Data</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form> -->