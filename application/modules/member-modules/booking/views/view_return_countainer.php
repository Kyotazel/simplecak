<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12 container_list">
        <div class="card">
            <div class="card-body">
                <div class="mb-3 row">
                    <h3 class="col-md-8">DAFTAR KONTAINER DALAM PEMBONGKARAN</h3>

                </div>
                <form id="form-search-return">
                    <input type="hidden" name="search" value="1">
                    <div class="row mb-2 border pb-2 pt-2">
                        <div class="col-md-2 row">
                            <label for="" class="col-12 font-weight-bold">Estimasi Tanggal Pembongkaran </label>
                            <div class="col-md-12">
                                <label for="">Max.Tanggal Bongkar <a href="javascript:void(0)" class="empty_form" data-name="date_from" title="empty date"><i class="fa fa-history"></i></a></label>
                                <input type="text" class="form-control datepicker bg-white" placeholder="piih tanggal..." readonly name="date_from">
                            </div>
                        </div>
                        <div class="col-md-3 row">
                            <label for="" class="col-12 font-weight-bold">&nbsp;</label>
                            <div class="col-md-12">
                                <label for="">Depo Pembongkaran</label>
                                <select name="depo_to" class="form-control" id="">
                                    <option value="">SEMUA</option>
                                    <?php
                                    foreach ($data_depo as $item) {
                                        echo '
                                            <option value="' . $item->id . '">' . strtoupper($item->name) . '</option>
                                        ';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="" class="col-12 font-weight-bold">&nbsp;</label>
                            <label for="">ID Kontainer</label>
                            <input type="text" class="form-control" name="countainer">
                        </div>
                        <div class="col-md-3">
                            <label for="" class="col-12 font-weight-bold">&nbsp;</label>
                            <label for="">NO. BOOKING SLOT</label>
                            <input type="text" class="form-control" name="code_bs">
                        </div>
                        <div class="col-md-1">
                            <label for="" class="col-12 font-weight-bold">&nbsp;</label>
                            <label for="">&nbsp;</label><br>
                            <button type="submit" class="btn btn-primary btn_search_return"><i class="fa fa-search"></i></button>
                        </div>

                    </div>
                </form>
                <div class="table-responsive  mt-3">
                    <table id="table_return" class="table table-bordered dt-responsive nowrap t-shadow" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <th style="width: 5%;">No</th>
                            <th>BOOKING SLOT</th>
                            <th>VOYAGE</th>
                            <th>JENIS KONTAINER</th>
                            <th style="width: 15%;">MUATAN</th>
                            <th style="width: 15%;">KONTAINER & SEGEL</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end main content-->

<div class="modal fade" tabindex="-1" id="modal_return_countainer">
    <div class="modal-dialog" style="max-width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Input Pengembalian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </div>
            <div class="modal-body">
                <div class="html_respon_countainer"></div>
            </div>
        </div>
    </div>
</div>