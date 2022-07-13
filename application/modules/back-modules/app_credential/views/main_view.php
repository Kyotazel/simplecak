<?php
$credential = $this->input->get('credential');
?>
<div class="row">
    <div class="col-sm-12 col-lg-5 col-xl-4">
        <div class="card ">
            <div class="card-header pb-0 row">
                <h4 class="p-3 col-md-6"><i class="si si-layers"></i> Data Credential</h4>
                <div class="col-md-6 p-3 text-right">
                    <a href="javascript:void(0)" class="btn btn-primary-gradient btn_add_credential"> <i class="fa fa-plus-circle"></i> Tambah Hak Akses</a>
                </div>
            </div>
            <div class="">
                <div class="main-content-app main-content-contacts pt-0">
                    <div class="main-content-left main-content-left-contacts">
                        <div class="main-contacts-list ps ps--active-y" id="mainContactList" style="height: auto;min-height:500px;">
                            <?php
                            $status_find = false;
                            foreach ($all_credential as $item_group) {
                                if ($item_group->id == $credential) {
                                    $status_find = true;
                                }
                                $selected = $item_group->id == $credential  ? 'selected' : '';
                                $name = $item_group->name;
                                echo '
                                    
                                    <div class="main-contact-item ' . $selected . '">
                                        <div class="main-avatar">
                                            ' . substr($name, 0, 1) . '
                                        </div>
                                        <div class="main-contact-body row">
                                            <div class="col-sm-8">
                                                <a href="' . Modules::run('helper/create_url', 'app_credential?credential=' . $item_group->id) . '">
                                                    <h5 class="mb-0">' . $name . '</h5>
                                                    <span class="phone">' . $item_group->description . '</span>
                                                </a>

                                                <label class="d-block mt-2">Menu Aplikasi : <span class="badge badge-dark d-block" style="font-size:16px;color:#fff;">' . $item_group->app_menu_name . '</span></label>
                                            </div>
                                            
                                            <nav class="contact-info col-md-4 text-right">
                                                <a href="javascript:void(0)" class="contact-icon border tx-inverse btn_edit" data-toggle="tooltip" data-id="' . $item_group->id . '"><i class="fe fe-edit"></i></a>
                                                <a href="javascript:void(0)" class="contact-icon border tx-inverse btn_delete" data-toggle="tooltip" data-id="' . $item_group->id . '"><i class="fe fe-trash"></i></a>
                                            </nav>
                                            
                                        </div>
                                    <!-- <a class="main-contact-star" href="">
                                            <h4><span class="badge badge-info  badge-pill">active</span></h4>
                                        </a>-->
                                    </div>
                                   
                                    ';
                            }
                            if (empty($all_credential)) {
                                echo '
                                    <div class="main-contact-item text-center">
                                        <div class="main-contact-body text-muted mt-3">
                                            <h4 class="">TIDAK ADA DATA CREDENTIAL</h4>
                                            <p class>Silhakan tambah data credential</p>
                                        </div>
                                    </div>
                                    ';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-lg-7 col-xl-8 credential-data" data-id="<?= $credential; ?>" data-status="<?= $status_find; ?>">
        <div class="card">
            <div class="card-header pb-0 row">
                <h4 class=" mb-0 pb-0 col-md-6 p-3"> <i class="fa fa-list"></i> Daftar Hak Akses Module</h4>
                <div class="col-md-6 p-3 text-right">
                </div>
            </div>
            <div class="card-body">
                <div class="html-menu p-3" style="height: auto;min-height:500px;padding-top:0px !important;"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal_credential" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title"></h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form class="form_credential ">
                    <div class="">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Credential</label>
                            <input type="text" class="form-control" name="name" placeholder="masukan nama..">
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Deskripsi</label>
                            <textarea name="description" class="form-control" id="" cols="30" rows="10" placeholder="ketik disini..."></textarea>
                            <span class="help-block"></span>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Menu Aplikasi</label>
                            <select name="id_menu" class="form-control" id="">
                                <?php
                                foreach ($all_menu as $item_menu) {
                                    echo '
                                            <option value="' . $item_menu->id . '">' . $item_menu->name . '</option>
                                        ';
                                }
                                ?>
                            </select>
                            <span class="help-block"></span>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="exampleInputEmail1">View file <span class="tag">Untuk develeper</span></label>
                            <input type="text" class="form-control" name="view_file" placeholder="masukan nama..">
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary mt-3 mb-0 btn_save_credential"><i class="fa fa-save"></i> Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="modal_menu" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title"></h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form class="form_main_menu ">
                    <div class="">
                        <div class="form-group html_parent_menu"></div>
                        <div class="row">
                            <div class="form-group col-md-8 p-0">
                                <label for="exampleInputEmail1">Label</label>
                                <input type="text" class="form-control" name="name" placeholder="masukan label link..">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1">Devider</label><br>
                                <div class="main-toggle main-toggle-dark" id="devider_status">
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Link</label>
                            <input type="text" class="form-control" name="link" placeholder="masukan url..">
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Css Class</label>
                            <input type="text" class="form-control" name="css" placeholder="masukan css class..">
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Icon</label>
                            <textarea name="icon" class="form-control" id="" cols="30" rows="10" placeholder="code icon atau svg ..."></textarea>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary mt-3 mb-0 btn_main_menu" data-group="<?= $group ?>"><i class="fa fa-save"></i> Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>