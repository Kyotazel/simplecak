<h2 class="text-center mb-3 text-uppercase">Curriculum Vitae</h2>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header text-center">
                <h5 class="card-title">Buat CV</h5>
                <p>*) Dengan membuat CV melalui link berikut, kamu lebih mudah dilirik bursa kerja</p>
            </div>
            <div class="card-body">
                <a href="<?= Modules::run('helper/create_url', '/for_alumni/make_cv') ?>" class="btn btn-block btn-success">Klik Disini</a>
            </div>
        </div>
    </div>
    <?php if(!$extern_cv): ?>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header text-center">
                <h5 class="card-title">Upload CV</h5>
                <p>Upload CV Buatanmu sendiri</p>
            </div>
            <div class="card-body">
                <form class="form-input">
                    <div class="form-group">
                        <input class="dropify form-control" type="file" name="extern_cv">
                        <div class="invalid-cv text-danger d-none"></div>
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-block btn-success btn_save_cv">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php else: ?>
        <div class="col-md-6">
        <div class="card">
            <div class="card-header text-center">
                <h5 class="card-title">CV Eksternal Kamu</h5>
                <p>Berikut merupakan CV External Kamu</p>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <a target="_blank" href="<?= base_url('upload/extern_cv/' . $extern_cv->file) ?>" class="btn btn-block btn-primary">Lihat CV Eksternal Saya</a>
                </div>
                <div class="text-right">
                    <button class="btn btn-outline-danger btn_delete_extern" data-id="<?= $extern_cv->id ?>"><i class="fa fa-trash"></i> Hapus</button>
                </div>
            </div>
        </div>
    </div>
    <?php endif ?>
</div>