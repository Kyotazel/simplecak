<?php
$type = $this->input->get('type');
?>

<style>
    #unregistered_module .card-body {
        max-height: 300px;
        overflow: auto;
    }

    #unregistered_module .card-body {
        /* padding: 0; */
    }

    #unregistered_module .card-body ul {
        padding: 0;
    }

    #unregistered_module .card-body li {
        list-style: none;
        padding: 5px;
        border-bottom: 1px dashed #ccc;
        font-size: 12px;
    }
</style>

<div class="row row-sm main-content-mail">
    <div class="col-lg-4 col-xl-3 col-md-12">

        <?php
        if (!empty($list_unregistered_modul)) {
            $html_list = '';
            foreach ($list_unregistered_modul as $item_data) {
                $html_list .= '
                    <li><i class="bx bx-folder-open tx-14"></i> ' . $item_data . '</li>
                ';
            }

            $html_data = '
                    <div class="alert alert-info alert-dismissible fade show mb-2" role="alert">
                        <strong class="text-red"><i class="fe fe-info"></i> <span class="tx-20">' . count($list_unregistered_modul) . '</span> Modul Belum Terdaftar ke System</strong>, 
                        Tekan <a data-toggle="collapse" href="#unregistered_module" role="button" aria-expanded="false" class="btn btn-light btn-rounded btn-sm tx-12 font-weight-bold">Tombol ini</a> untuk melihat daftar modul.
                        
                    </div>
                    <div class="collapse" id="unregistered_module">
                        <div class="card card-body">
                            <b> Daftar Modul Belum Terdaftar ke Database :</b>
                            <ul>' . $html_list . '</ul>
                        </div>
                    </div>
                ';

            echo $html_data;
        }
        ?>

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

        <div class="card mt-2">
            <div class="card-body">
                <div class="">
                    <a href="javascript:void(0)" class="btn btn-lg btn-rounded btn-warning-gradient btn-block font-weight-bold btn_create_all_config"><i class="fa fa-sync"></i> Create All ( config.php )</a>
                    <small class="d-block text-muted"><i class="fa fa-info-circle"></i> klik tombol untuk membuat file config.php pada masing-masing modul.</small>
                </div>
                <hr>
                <div class="">
                    <a href="javascript:void(0)" class="btn btn-lg btn-rounded btn-success-gradient btn-block font-weight-bold btn_sync_all_config"><i class="fa fa-sync"></i> Sync All ( config.php )</a>
                    <small class="d-block text-muted"><i class="fa fa-info-circle"></i> klik tombol untuk melakukan sinkronisasi data konfigurasi pada semua modul.</small>
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

<div class="modal" id="modal_route" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="min-width:60%;">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title"></h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="html_respon_route"></div>
            </div>
        </div>
    </div>
</div>