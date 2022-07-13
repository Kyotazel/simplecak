<div class="row border-bottom mb-2">
    <div class="col-8">
        <h3 class="card-title">Daftar Tim Perusahaan</h3>
    </div>
    <div class="col-4 mb-2">
        <?= Modules::run('security/create_access', '<a href="javascript:void(0)" class="btn btn-primary-gradient btn_add"> <i class="fa fa-plus-circle"></i> Tambah Data</a>'); ?>
    </div>
</div>
<div class="row html_respon">

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
                        <label>Nama Lengkap</label>
                        <input type="text" class="form-control" name="name" />
                        <span class="help-block notif_name"></span>
                    </div>
                    <div class="form-group">
                        <label>Jabatan</label>
                        <input type="text" class="form-control" name="position" />
                        <span class="help-block notif_position"></span>
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