<div class="card">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h4 class="page-title mb-1">Riwayat Piutang</h4>
            </div>
            <div class="col-md-4">
                <div class="float-right d-md-block">
                    <div class="dropdown">

                    </div>
                </div>
            </div>
        </div>
        <form class="form-search">
            <div class="row">
                <div class="col-md-2 form-group p-10">
                    <label>Cari Berdasarkan</label>
                    <select name="type_search" class="form-control">
                        <option value="1">Range Tangggal</option>
                        <option value="2">Kode Invoice</option>
                    </select>
                    <span class="help-block text-danger"></span>
                </div>
                <div class="col-md-10 border p-1 border-radius-5 row">
                    <div class="col-md-10 html_date_range row">
                        <div class="col-md-2 form-group">
                            <label>Status Lunas</label>
                            <select name="status" class="form-control">
                                <?= $html_option_status; ?>
                            </select>
                            <span class="help-block text-danger"></span>
                        </div>
                        <div class="col-md-3 form-group">
                            <label>Status Jatuh Tempo</label>
                            <select name="status_expired" class="form-control">
                                <option value="">Semua</option>
                                <option value="1">Belum Jatuh Tempo</option>
                                <option value="2">Telah Jatuh Tempo</option>
                            </select>
                            <span class="help-block text-danger"></span>
                        </div>
                        <div class="col-md-3 form-group">
                            <label>Tanggal Awal</label> | <a href="javscript:void(0)" class="reset_date" data-date="date-from"><i class="fa fa-refresh"></i> Reset Tanggal</a>
                            <input type="text" class="form-control bg-white datepicker_form" name="date_from" data-language="en" readonly>
                            <span class="help-block text-danger"></span>
                        </div>
                        <div class="col-md-1 text-center">
                            <label for=""></label><br>
                            <label for="">S/D</label>
                        </div>
                        <div class="col-md-3 form-group">
                            <label>Tanggal Akhir</label> | <a href="javscript:void(0)" class="reset_date" data-date="date-to"><i class="fa fa-refresh"></i> Reset Tanggal</a>
                            <input type="text" class="form-control bg-white datepicker_form" name="date_to" data-language="en" readonly>
                            <span class="help-block text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-6 html_code" style="display: none;">
                        <div class="col-md-12 form-group">
                            <label>Masukan Kode Invoice</label>
                            <input type="text" class="form-control" name="code">
                            <span class="help-block text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label for="">&nbsp;</label><br>
                        <button type="submit" class="btn btn-primary btn_search_credit"><i class="fa fa-search"></i> Cari Data</button>
                    </div>
                </div>

            </div>
        </form>
        <!-- end row -->
        <div class="html_respon mt-3">
            <div class="bg-empty-data"></div>
            <h5 class="text-center text-muted">Isilah form pencarian terlebih dahulu</h5>
        </div>
    </div>
</div>


<div class="modal" id="modal-form">
    <div class="modal-dialog" style="width:50%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Form Member</h4>
            </div>
            <div class="box-body pad">
                <div class="html_respon_modal"></div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
</div>