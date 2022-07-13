<style>
    .dz-remove {
        display: block !important;
    }
</style>
<form action="" id="form-data">
    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    <div class="row  mb-2">
                        <div class="col-8">
                            <h3 class="">Tambah Halaman CMS</h3>
                        </div>
                        <div class="col-4 mb-2 text-right">
                            <?= Modules::run('security/create_access', '<a href="' . Modules::run('helper/create_url', 'cms_post') . '" class="btn btn-light "> <i class="fa fa-arrow-circle-left"></i> Kembali</a>'); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="">
                                <textarea name="description" id="content_profile" class="ckeditor_form" cols="30" rows="10"><?= isset($data_detail->content) ? $data_detail->content : ''; ?></textarea>
                                <span class="help-block text-danger notif_content"></span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <div class="form-group row mb-2">
                        <label for="" class="col-3 text-right">Judul Halaman</label>
                        <div class="col-9">
                            <input type="text" class="form-control" name="title" value="<?= isset($data_detail->title) ? $data_detail->title : ''; ?>">
                            <span class="help-block text-danger notif_title"></span>
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label for="" class="col-3 text-right">Keyword</label>
                        <div class="col-9">
                            <input type="text" class="form-control" name="keyword" value="<?= isset($data_detail->keyword) ? $data_detail->keyword : ''; ?>">
                            <span class="help-block text-danger notif_keyword"></span>
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label for="" class="col-3 text-right">Slug</label>
                        <div class="col-9">
                            <input type="text" class="form-control" name="slug" value="<?= isset($data_detail->slug) ? $data_detail->slug : ''; ?>">
                            <span class="help-block text-danger notif_slug"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="dropzone dropzone_main text-center border-radius-5 border-dashed">
                            <div class="dz-message" style="margin-top: 80px;">
                                <i class="fa fa-cloud-upload text-muted"></i>
                                <span class="text-muted">Click or Drop image here</span>
                            </div>
                        </div>
                        <?php
                        if (isset($data_detail->image)) {
                            echo '
                                    <img src="' . base_url('upload/banner/' . $data_detail->image) . '" alt="">
                                ';
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <div class="col-12 text-right mt-3">
                            <button class="btn btn-warning-gradient btn-lg btn-rounded font-weight-bold btn_save" data-id="<?= isset($data_detail->id) ? $data_detail->id : ''; ?>" data-method="<?= $method; ?>" style="width: 250px;">Simpan <i class="fa fa-paper-plane"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>