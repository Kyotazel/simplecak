<?php
$type = $this->input->get('type');
?>

<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12 container_list">
        <div class="card">
            <div class="card-body">
                <div class="mb-3 row">
                    <h3 class="col-md-8"><i class="fa fa-tv"></i> Pengaturan Data</h3>
                    <div class="col-md-4 text-right">
                        <?= Modules::run('security/create_access', '<a href="javascript:void(0)" class="btn btn-primary-gradient btn_add"> <i class="fa fa-plus-circle"></i> Tambah Data</a>'); ?>
                    </div>
                </div>
                <nav class="nav main-nav-line main-nav-line-chat  pl-3">
                    <a class="nav-link <?= $type == 'text' || $type == ''  ? 'active' : ''; ?>" href="<?= Modules::run('helper/create_url', 'app_module_configuration?type=text'); ?>">DATA TEXT <span class="badge badge-light">Pengaturan Data Text</span></a>
                    <!-- <a class="nav-link <?= $type == 'json' ? 'active' : ''; ?> " href="<?= Modules::run('helper/create_url', 'app_module_configuration?type=json'); ?>">DATA JSON <span class="badge badge-light">Pengaturan Data JSON</span></a> -->
                </nav>
                <div class="row">
                    <?php
                    $data_type = '';
                    if ($type == 'json') {
                        $data_type = 'json';
                        $this->load->view('view_json');
                    } else {
                        $data_type = 'text';
                        $this->load->view('view_text');
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" id="modal_form_main">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Input Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </div>
            <div class="modal-body">
                <form id="form-data-main">
                    <div class="form-group">
                        <label>Field <span class="badge badge-light">Keyword</span></label>
                        <input type="text" class="form-control" name="field" />
                        <span class="help-block notif_name text-danger"></span>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label>Label</label>
                        <input type="text" class="form-control" name="label" />
                        <span class="help-block notif_name text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label>Params</label>
                        <input type="text" class="form-control" name="params" />
                        <span class="help-block notif_name text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label>Value</label>
                        <input type="text" class="form-control" name="value" />
                        <span class="help-block notif_name text-danger"></span>
                    </div>
                    <div class="form-group text-right">
                        <button class="btn btn-primary-gradient btn-rounded btn_save" data-type="<?= $data_type; ?>" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>