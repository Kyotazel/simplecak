<div class="row row-sm main-content-mail">
    <div class="col-md-12 container_list">
        <div class="card">
            <div class="card-body">
                <div class="mb-3 row">
                    <h3 class="col-md-8">Konfirmasi Pendaftaran</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="table_data" style="width: 100%;">
                        <thead>
                            <tr>
                                <th><span>No</span></th>
                                <th><span>Judul Pelatihan</span></th>
                                <th><span>Konfirmasi Peserta</span></th>
                                <th><span>Tanggal Pendaftaran</span></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_peserta" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Daftar peserta</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table_peserta" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th><span>No</span></th>
                                    <th><span>Nama Akun</span></th>
                                    <th><span>Konfirmasi</span></th>
                                    <th><span>Action</span></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_detail_account" aria-hidden="true">
    <div class="modal-dialog modal-md bg-light" role="document">
        <div class="modal-header">
            <h6 class="modal-title">Detail Peserta</h6>
            <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
            <div id="detail_peserta">
                
            </div>
        </div>
    </div>
</div>