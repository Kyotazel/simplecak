<form class="form_input mb-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h3>Konten Kategori Paket Soal</h3>
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
                        <h4 class="mb-3">Parameter Paket Soal : </h4>
                        <div>
                            <div class="form-group">
                                <label for="name">Nama Kategori Paket Soal</label>
                                <input type="text" class="form-control" name="name" placeholder="Masukkan Kategori..." value="<?= isset($data_detail->name) ? $data_detail->name : ''; ?>">
                                <span class="invalid-feedback"></span>
                            </div>
                            <div class="text-right">
                                <a href="<?= Modules::run('helper/create_url', 'package_category'); ?>" class="btn btn-rounded btn-light font-weight-bold mt-3">Kembali</a>
                                <button type="submit" class="btn btn-primary mt-3 mb-0 btn_save" data-id="<?= isset($data_detail->id) ? $data_detail->id : ''; ?>" data-method="<?= $method ?>"><i class="fa fa-save"></i> Simpan Data</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</form>