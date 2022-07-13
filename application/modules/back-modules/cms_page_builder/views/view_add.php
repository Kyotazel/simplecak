<form id="form-data">
    <div class="row">
        <div class="col-9">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <textarea class="ckeditor_form " id="content" cols="30" rows="10"><?= isset($data_page->description) ? $data_page->description : ''; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card">
                <div class="card-body">
                    <div class="col-12">
                        <label for="">Nama:</label>
                        <input class="form-control" name="name" value="<?= isset($data_page->name) ? $data_page->name : ''; ?>">
                    </div>
                    <div class="text-right mt-2">
                        <a href="javascript:void(0)" class="btn btn-warning-gradient btn-rounded font-weight-bold btn_save" data-id="<?= isset($data_page->id) ? $data_page->id : ''; ?>" data-act="<?= $save_method; ?>">Simpan Data <i class="fa fa-paper-plane"></i></a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>