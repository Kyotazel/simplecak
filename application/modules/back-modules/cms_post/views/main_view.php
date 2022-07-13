<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="row  mb-2">
                <div class="col-8">
                    <h3 class="">Halaman CMS</h3>
                </div>
                <div class="col-4 mb-2 text-right">
                    <?= Modules::run('security/create_access', '<a href="' . Modules::run('helper/create_url', 'cms_post/add') . '" class="btn btn-primary-gradient "> <i class="fa fa-plus-circle"></i> Tambah Data</a>'); ?>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered " id="table_data">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Halaman</th>
                            <th>Keterangan</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- end main content-->

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
                        <input type="text" class="form-control" name="name" />
                        <span class="help-block notif_name"></span>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea type="text" class="form-control" name="description"></textarea>
                        <span class="help-block notif_description"></span>
                    </div>
                    <div class="form-group">
                        <label>Link</label>
                        <textarea type="text" class="form-control" name="link"></textarea>
                        <span class="help-block notif_link"></span>
                    </div>
                    <div class="form-group">
                        <label>Upload Foto</label>
                        <input type="file" name="media" class="form-control" />
                        <span class="help-block notif_media"></span>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary btn_save"><i class="fa fa-save"></i> Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>