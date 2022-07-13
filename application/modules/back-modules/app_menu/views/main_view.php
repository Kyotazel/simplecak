<?php
$type = $this->input->get('type');
$status_menu = 1;
$backoffice_menu = 'active';
$frontoffice_menu = '';
if ($type == 2) {
    $backoffice_menu = '';
    $frontoffice_menu = 'active';
    $status_menu = 2;
}

$group = $this->input->get('group');
$status_find = false;


?>

<div class="row">
    <div class="col-sm-12 col-lg-5 col-xl-4">
        <div class="card">
            <div class="card-header pb-0 row">
                <h4 class="p-3 col-md-6"><i class="si si-layers"></i> Group Menu</h4>
                <div class="col-md-6 p-3 text-right">
                    <a href="javascript:void(0)" class="btn btn-primary-gradient btn_add_group"> <i class="fa fa-plus-circle"></i> Tambah Group</a>
                </div>
            </div>
            <div class="">
                <div class="main-content-app main-content-contacts pt-0">
                    <div class="main-content-left main-content-left-contacts">
                        <nav class="nav main-nav-line main-nav-line-chat  pl-3">
                            <a class="nav-link <?= $backoffice_menu; ?>" href="<?= Modules::run('helper/create_url', 'app_menu?type=1'); ?>">Halaman Admin</a>
                            <a class="nav-link <?= $frontoffice_menu; ?>" href="<?= Modules::run('helper/create_url', 'app_menu?type=2'); ?>">Halaman Depan</a>
                        </nav>
                        <div class="main-contacts-list ps ps--active-y" id="mainContactList" style="height: auto;min-height:500px;">
                            <?php
                            foreach ($data_list_menu as $item_group) {
                                if ($item_group->id == $group) {
                                    $status_find = true;
                                }
                                $selected = $item_group->id == $group  ? 'selected' : '';

                                $html_action_front = '';
                                if ($type == 2) {
                                    $selected_front_menu    =  $item_group->is_front_menu ? 'on' : '';
                                    $selected_member_menu   = $item_group->is_member_menu ? 'on' : '';

                                    $html_action_front = '
                                    <div class="col-md-8 d-flex">
                                        <div class="" style="width:50%;">
                                            <small>Front Office Menu :</small>
                                            <div data-menu="sidebar" data-type="1" data-id="' . $item_group->id . '" class="' . $selected_front_menu . ' main-toggle main-toggle-dark front_group_menu change_status_front_group"><span></span></div>
                                        </div>
                                        <div class="" style="width:50%;">
                                            <small>Member Area Menu :</small>
                                            <div data-menu="horizontal" data-type="2" data-id="' . $item_group->id . '" class="' . $selected_member_menu . ' main-toggle main-toggle-dark member_group_menu change_status_front_group "><span></span></div>
                                        </div>
                                    </div>
                                    ';
                                }

                                echo '
                                    
                                    <div class="main-contact-item ' . $selected . '">
                                        <div class="main-avatar">
                                            ' . substr($item_group->name, 0, 1) . '
                                        </div>
                                        <div class="main-contact-body row">
                                            <div class="col-sm-8">
                                                <a href="' . Modules::run('helper/create_url', 'app_menu?type=' . $item_group->status . '&group=' . $item_group->id) . '">
                                                    <h5 class="mb-0">' . $item_group->name . '</h5>
                                                    <span class="phone">' . $item_group->description . '</span>
                                                </a>
                                            </div>
                                            
                                            <nav class="contact-info col-md-4 text-right">
                                                <a href="javascript:void(0)" class="contact-icon border tx-inverse btn_duplicate_group" data-toggle="tooltip" data-id="' . $item_group->id . '"><i class="fe fe-copy"></i></a>
                                                <a href="javascript:void(0)" class="contact-icon border tx-inverse btn_edit_group" data-toggle="tooltip" data-id="' . $item_group->id . '"><i class="fe fe-edit"></i></a>
                                                <a href="javascript:void(0)" class="contact-icon border tx-inverse btn_delete_group" data-toggle="tooltip" data-id="' . $item_group->id . '"><i class="fe fe-trash"></i></a>
                                            </nav>
                                            ' . $html_action_front . '
                                        </div>
                                    </div>
                                    ';
                            }
                            if (empty($data_list_menu)) {
                                echo '
                                    <div class="main-contact-item text-center">
                                        <div class="main-contact-body text-muted mt-3">
                                            <h4 class="">TIDAK ADA MENU</h4>
                                            <p class>Silhakan tambah data menu</p>
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

    <div class="col-sm-12 col-lg-7 col-xl-8 group-data" data-id="<?= $group; ?>" data-status="<?= $status_find; ?>">
        <div class="card">
            <div class="card-header pb-0 row">
                <h4 class=" mb-0 pb-0 col-md-6 p-3"> <i class="fa fa-list"></i> Daftar Menu</h4>
                <div class="col-md-6 p-3 text-right">
                    <?php
                    if ($status_find) {
                        echo '
                                <a href="javascript:void(0)" class="btn btn-primary-gradient btn_add_menu"> <i class="fa fa-plus-circle"></i> Tambah Menu Utama</a>
                            ';
                    }
                    ?>
                </div>
            </div>
            <div class="card-body">
                <div class="html-menu p-3" style="height: auto;min-height:500px;padding-top:0px !important;"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal_group" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title"></h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form class="form_group_menu ">
                    <div class="">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Group Menu</label>
                            <input type="text" class="form-control" name="name" placeholder="masukan nama..">
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Deskripsi</label>
                            <textarea name="description" class="form-control" id="" cols="30" rows="10" placeholder="ketik disini..."></textarea>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary mt-3 mb-0 btn_save_group" data-status="<?= $status_menu ?>"><i class="fa fa-save"></i> Simpan Data</button>
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