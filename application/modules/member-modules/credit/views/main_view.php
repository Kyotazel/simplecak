<?php
$act = $this->input->get('act');
$total_invoice = '';
$id_customer = $this->session->userdata('member_id');
if ($act == 'unpaid' || $act == '') {
}
$count_unpaid = $this->db->select('
        COUNT(id) AS count_invoice,
        SUM(rest_credit) AS total_credit
    ')->where(['id_customer' => $id_customer, 'status' => 0])->get('tb_credit')->row();

$count_paid = $this->db->select('
    COUNT(id) AS count_invoice,
    SUM(rest_credit) AS total_credit
')->where(['id_customer' => $id_customer, 'status' => 1])->get('tb_credit')->row();


?>
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <h5 class="header-title mb-4 col-md-4">DAFTAR TAGIHAN</h5>
            </div>

            <div class="panel panel-primary tabs-style-2">
                <div class=" tab-menu-heading row">
                    <div class="tabs-menu1 col-4">
                        <!-- Tabs -->
                        <ul class="nav panel-tabs main-nav-line">
                            <li><a href="<?= Modules::run('helper/create_url', 'credit?act=unpaid'); ?>" class="nav-link font-weight-bold status_payment tx-16 <?= $act == 'unpaid' || $act == '' ? 'active' : ''; ?> " data-status="0">Belum Lunas <span class="badge badge-pill badge-danger tx-16 px-2"><?= $count_unpaid->count_invoice; ?></span></a></li>
                            <li><a href="<?= Modules::run('helper/create_url', 'credit?act=paid'); ?>" class="nav-link font-weight-bold status_payment tx-16 <?= $act == 'paid' ? 'active' : ''; ?>" data-status="1">Telah Lunas <span class="badge badge-pill badge-danger tx-16 px-2"><?= $count_paid->count_invoice; ?></span></a></li>
                        </ul>
                    </div>
                    <div class="col-8">
                        <form id="form-search">
                            <div class="row">
                                <div class="col-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text font-weight-bold">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control datepicker bg-white" placeholder="tanggal Awal Invoice..." readonly="" name="date_from">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text font-weight-bold bg-white" style="border:none">
                                                <a href="javascript:void(0)" class="clear_date"><i class="fa fa-history"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text font-weight-bold">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control datepicker bg-white" placeholder="tanggal Akhir Invoice..." readonly="" name="date_to">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text font-weight-bold bg-white" style="border:none">
                                                <a href="javascript:void(0)" class="clear_date"><i class="fa fa-history"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" name="invoice-code" placeholder="kode invoice">
                                </div>
                                <div class="col-2">
                                    <button type="submit" class="btn btn-rounded btn-primary btn-block btn_search"><i class="fa fa-search"></i> Cari</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="html_respon_invoice col-12 mt-2"></div>
        </div>
    </div>
</div>


<div class="modal fade in" id="modal-form">
    <div class="modal-dialog " style="max-width:80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Input Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <div class="html_respon_modal"></div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>