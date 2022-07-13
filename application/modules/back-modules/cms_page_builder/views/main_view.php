<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="row  mb-2">
                <div class="col-8">
                    <h3 class="">Home Builder</h3>
                </div>
                <div class="col-4 mb-2 text-right">
                    <?= Modules::run('security/create_access', '<a href="' . Modules::run('helper/create_url', 'cms_page_builder/add') . '" class="btn btn-primary-gradient btn_add"> <i class="fa fa-plus-circle"></i> Tambah Data</a>'); ?>
                </div>
            </div>
            <div class="html_respon row"></div>

        </div>
    </div>
</div>

<!-- end main content-->
<style>
    .cke_reset_all {
        z-index: 100000 !important;
    }
</style>

<div class="modal fade" tabindex="-1" id="modal_form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Input Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </div>
            <div class="modal-body">
                <form id="form-data">
                    <input type="hidden" name="id" id="id" />
                    <div class="form-group">
                        <label>Judul</label>
                        <textarea name="name" id="" class="form-control" rows="5"></textarea>
                        <span class="help-block notif_name"></span>
                    </div>
                    <style>
                        #desc .cke_contents.cke_reset {
                            height: 200px !important;
                        }
                    </style>
                    <div class="form-group" id="desc">
                        <label>Deskripsi</label>
                        <textarea type="text" class="form-control ckeditor_form" id="content" rows="5" name="description"></textarea>
                        <span class="help-block notif_description"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Posisi Text</label>
                        <select name="position_text" class="form-control" id="">
                            <option value="1">Left</option>
                            <option value="2">Right</option>
                            <option value="3">center</option>
                            <option value="4">Background Image</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Background color</label>
                                <div>
                                    <input name="color" type="color">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>text color</label>
                                <div>
                                    <input name="text_color" type="color">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Upload Gambar</label>
                            <input type="file" name="media" class="form-control" />
                            <span class="help-block notif_media"></span>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary btn_save"><i class="fa fa-save"></i> Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>