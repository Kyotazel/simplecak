<div class="row row-sm main-content-mail">
    <div class="col-md-12 container_list">
        <div class="card">
            <div class="card-body">
                <div class="mb-3 row">
                    <h3 class="col-md-8">Daftar Kategori Pelatihan</h3>
                    <div class="col-md-4 text-right">
                        <?= Modules::run("security/create_access", '<a href="javascript:void(0)" class="btn btn-primary btn_add"><i class="fa fa-plus-circle"></i> Tambah Kategori </a>') ?>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="table_data" style="width: 100%">
                        <thead>
                            <tr>
                                <th><span>No</span></th>
                                <th><span>Nama Kategori</span></th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal_form" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title"></h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form class="form_input">
                    <div>
                        <div class="form-group">
                            <label for="name">Nama Kategori Pelatihan</label>
                            <input type="text" class="form-control" name="name" placeholder="Masukkan Kategori Pelatihan...">
                            <span class="invalid-feedback"></span>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary mt-3 mb-0 btn_save"><i class="fa fa-save"></i> Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>