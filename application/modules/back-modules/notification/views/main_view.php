<div class="container">
    <div class="col-xl-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header pb-1">
                <div class="row">
                    <div class="col-8">
                        <h3 class="card-title mb-2">Notifikasi</h3>
                        <p class="tx-12 mb-0 text-muted">Daftar notifikasi transaskimu</p>
                    </div>
                    <div class="col-4">
                        <a href="javascript:void(0)" class="badge badge-pill badge-warning ml-auto my-auto float-right mark-notification tx-12 px-2 mark-all-data"> Tandai Telah Dibaca</a>
                    </div>
                </div>
            </div>
            <div class="card-body p-0 customers mt-1">
                <div class="list-group list-lg-group list-group-flush">
                    <?php
                    foreach ($list_notification as $item_data) {
                        echo '
                            <div class="list-group-item list-group-item-action" href="#">
                                <div class="media mt-0">
                                    <div class="notifyimg bg-primary">
                                        <i class="la la-file-alt text-white"></i>
                                    </div>
                                    <div class="media-body ml-3">
                                        <div class="d-flex align-items-center">
                                            <div class="mt-0">
                                                <h5 class="mb-1 tx-15">' . $item_data->title . '</h5>
                                                <p class="mb-0 tx-13 text-muted">
                                                    ' . $item_data->description . '
                                                </p>
                                            </div>
                                            <div class="ml-auto wd-45p fs-16 mt-2 text-right">
                                                <a class="btn btn-rounded btn-primary mark_item" href="javascript:void(0)" data-id="' . $item_data->id . '">Lihat Detail</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ';
                    }
                    if (empty($list_notification)) {
                        echo '
                            <div class="list-group-item list-group-item-action">
                                <div class="col-12 text-center">
                                    <div class="plan-card text-center">
                                        <i class="fas fa-file plan-icon text-primary"></i>
                                        <h6 class="text-drak text-uppercase mt-2">Data Kosong</h6>
                                        <small class="text-muted">Tidak ada notifikasi.</small>
                                    </div>
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