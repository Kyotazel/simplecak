<?php
if ($ckeditor_status) {
    echo '
            <style>
                .app-sidebar{
                    display : none !important;
                }
                .main-content.app-content{
                    margin:0px !important;
                }
                .main-header{
                    display : none !important;
                }
                .jumps-prevent{
                    display : none !important;
                }
            </style>
        ';
}
?>
<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12 container_list">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <h4 class=" mb-1">Media</h4>
                        <p class="text-muted card-sub-title">Daftar gambar / media yang diupload.</p>
                    </div>
                    <div class="col-2 text-right">
                        <button data-toggle="dropdown" class="btn btn-primary-gradient btn-block btn-lg btn-rounded p-2 shadow-3"><i class="fa fa-plus-circle"></i> Baru <i class="icon ion-ios-arrow-down tx-11 mg-l-3"></i></button>
                        <div class="dropdown-menu">
                            <a href="javascript:void(0)" class="dropdown-item btn_upload_file"><i class="fa fa-file"></i> Upload File</a>
                            <a href="javascript:void(0)" class="dropdown-item btn_upload_folder"><i class="fa fa-folder"></i> Buat Folder</a>
                        </div><!-- dropdown-menu -->
                    </div>
                </div>
                <div class="panel border-radius">
                    <div class="panel-body">
                        <div class="html_image_countainer" style="min-height: 500px;" data-dir=""></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- end main content-->

<div class="modal fade" tabindex="-1" id="modal_upload_file" data-backdrop="static">
    <div class="modal-dialog" style="max-width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Input Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12 text-center">
                    <div class="dropzone dropzone_main text-center border-radius-5 border-dashed">
                        <div class="dz-message" style="margin-top: 80px;">
                            <i class="fa fa-cloud-upload text-muted"></i>
                            <span class="text-muted">Click or Drop image here</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modal_create_folder" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buat Folder</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-create-folder">
                    <div class="row">
                        <div class="location-current col-12"></div>
                        <div class="col-8">
                            <label for="">Nama Folder</label>
                            <input type="text" class="form-control" name="folder_name">
                            <span class="help-block text-red text-folder"></span>
                        </div>
                        <div class="col-4">
                            <label for="">&nbsp;</label><br>
                            <button type="submit" class="btn btn-primary-gradient font-weight-bold btn_create_folder">Buat Folder</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>