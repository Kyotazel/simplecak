<input type="hidden" id="id_batch_course" value="<?= $id_batch_course ?>">

<style>
    .ui-datepicker {
        z-index: 10000 !important;
    }
</style>

<div class="row row-sm main-content-mail">
    <div class="col-md-12 container_list">
        <div class="card">
            <div class="card-body">
                <div class="mb-3 row">
                    <h3 class="col-md-8"><?= $pelatihan ?></h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="table_data" style="width: 100%;">
                        <thead>
                            <tr>
                                <th><span>No</span></th>
                                <th><span>Nama Peserta</span></th>
                                <th><span>Sertifikat</span></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modal_form">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Input Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </div>
            <div class="modal-body">
                <form class="form_input">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="no_peserta">Nomor Peserta</label>
                            <input type="text" class="form-control" name="no_peserta" id="no_peserta">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="no_sk">Nomor Surat Keputusan</label>
                            <input type="text" class="form-control" name="no_sk" id="no_sk">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="sk_date">Tanggal Surat Keputusan</label>
                            <input type="text" class="form-control datepickera" name="sk_date" id="sk_date">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="jp">Jam Pelajaran</label>
                            <input type="number" class="form-control" name="jp" id="jp">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="kompeten">Apakah Kompeten?</label>
                            <br>
                            <label>
                                <input type="checkbox" name="kompeten" id="kompeten">
                                <span>Kompeten</span>
                            </label>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="certified_date">Tanggal Sertifikasi</label>
                            <input type="text" name="certified_date" id="certified_date" autocomplete="off" class="form-control datepickera">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exp_date">Tanggal Expired</label>
                            <input type="text" name="exp_date" id="exp_date" autocomplete="off" class="form-control datepickera">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary btn_save"><i class="fa fa-gear"></i> Generate</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>