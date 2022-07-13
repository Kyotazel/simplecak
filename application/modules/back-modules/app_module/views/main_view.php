<?php
$type = $this->input->get('type');
?>

<div class="row row-sm main-content-mail">
    <div class="col-lg-4 col-xl-3 col-md-12">
        <div class="card mg-b-20 mg-md-b-0">

            <div class="card-body">
                <div class="">
                    <h3 class="mb-3">Kategori Module</h3>
                </div>
                <div class="main-content-left main-content-left-mail">
                    <div class="main-mail-menu">
                        <nav class="nav main-nav-column mg-b-20">
                            <a class="nav-link <?= $type == 'all' ? 'active' : ''; ?> " href="<?= Modules::run('helper/create_url', 'app_module?type=all'); ?>"><i class="bx bxs-inbox"></i> Semua Module <span><?= $total_module; ?></span></a>
                            <?php
                            foreach ($module_type as $key => $item_module) {
                                $active = $key == $type ? 'active' : '';
                                $count_data = isset($array_count[$key]) ? $array_count[$key] : 0;
                                echo '
                                    <a class="nav-link text-capitalize ' . $active . '" href="' . Modules::run('helper/create_url', 'app_module?type=' . $key) . '"><i class="bx bx-folder-open"></i> ' . $item_module . ' <span>' . $count_data . '</span></a>
                                ';
                            }
                            ?>
                        </nav>
                    </div><!-- main-mail-menu -->
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-xl-9 col-md-12 container_list" data-type="<?= $type ?>">
        <div class="card">
            <div class="card-body">
                <div class="mb-3 row">
                    <h3 class="col-md-8">Daftar Module</h3>
                    <div class="col-md-4 text-right">
                        <?= Modules::run('security/create_access', '<a href="javascript:void(0)" class="btn btn-primary-gradient btn_add"> <i class="fa fa-plus-circle"></i> Tambah Module</a>') ?>
                    </div>
                </div>
                <div class="table-responsive border-top userlist-table">
                    <table class="table card-table table-striped table-vcenter text-nowrap mb-0" id="table_module">
                        <thead>
                            <tr>
                                <th class="wd-lg-8p"><span>No</span></th>
                                <th class="wd-lg-30p"><span>Nama Module</span></th>
                                <th class="wd-lg-20p"><span>Folder</span></th>
                                <th class="wd-lg-20p"><span>Jenis Module</span></th>
                                <th class="wd-lg-10p"><span>status</span></th>
                                <th class="wd-lg-10p">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
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
                    <div class="">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Module</label>
                            <input type="text" class="form-control" name="name" placeholder="masukan nama..">
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Deskripsi</label>
                            <textarea name="description" class="form-control" id="" cols="30" rows="10" placeholder="ketik disini..."></textarea>
                            <span class="help-block"></span>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="form-group col-md-6 p-0">
                                <label for="exampleInputEmail1">Folder</label>
                                <input type="text" class="form-control" name="folder" placeholder="masukan folder..">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Jenis Module</label>
                                <select name="module_type" class="form-control" id="">
                                    <?php
                                    foreach ($module_type as $key => $item_module) {
                                        echo '
                                            <option class="text-capitalize" value="' . $key . '">' . $item_module . '</option>
                                        ';
                                    }
                                    ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
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