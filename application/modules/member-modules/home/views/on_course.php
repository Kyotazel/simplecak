<div class="mb-3 row rounded-20 bg-primary align-items-center" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);background: url(http://blk.viscode.id/assets/themes/valex/img/svgicons/cargo.svg) no-repeat;height:100px;">
    <div class="col-3 border-right d-flex align-items-center">
        <h3 class="ml-3 text-white mb-0">Halo, <?= $this->session->userdata('member_name') ?></h3>
    </div>
    <div class="col-6">
        <!-- <p class="text-white tx-16 p-0 m-0">Ikuti Pelatihan terbaru untuk menambah kemampuanmu.</p> -->
        <?php if ($last_schedule) : ?>
            <p class="text-white tx-16 p-0 m-0">Jadwal terbaru, <?= Modules::run('helper/date_indo', $last_schedule->date, '-') ?> : <?= $last_schedule->title ?></p>
        <?php else : ?>
            <p class="text-white tx-16 p-0 m-0">Jadwal terbaru belum tersedia.</p>
        <?php endif ?>
        <!-- <p class="text-white tx-16 p-0 m-0">Selamat Kamu Lulus pelatihan, Lihat ke menu alumni yuk</p> -->
        <!-- <p class="text-white tx-16 p-0 m-0">CV Kamu sudah terisi semua, lihat ke lowongan kerja yuk</p> -->
        <!-- <p class="text-white tx-16 p-0 m-0">Selamat Kamu diterima di pt abc sebagai staff administrasi</p> -->
    </div>
    <div class="col-3 text-right">
        <!-- <a href="<?= Modules::run('helper/create_url', 'register_course') ?>" class="btn btn-rounded btn-success font-weight-bold">Lihat Sekarang <i class="fa fa-paper-plane"></i></i></a> -->
    </div>
</div>

<div class="row row-sm">
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
        <div class="card custom-card">
            <div class="card-body">
                <div class="card-item">
                    <div class="card-item-icon card-icon">
                        <div class="text-primary" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24" viewBox="0 0 24 24" width="24">
                            <i class="fa fa-book "></i>
                        </div>
                    </div>
                    <div class="card-item-title mb-2">
                        <label class="main-content-label tx-13 font-weight-bold mb-1">Total Pelatihan</label>
                        <span class="d-block tx-12 mb-0 text-muted">Pelatihan yang kamu daftar</span>
                    </div>
                    <div class="card-item-body">
                        <div class="card-item-stat">
                            <h4 class="font-weight-bold"><?= count($course) ?> Pelatihan</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
        <div class="card custom-card">
            <div class="card-body">
                <div class="card-item">
                    <div class="card-item-icon card-icon">
                        <div class="text-primary" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24" viewBox="0 0 24 24" width="24">
                            <i class="fa fa-check "></i>
                        </div>
                    </div>
                    <div class="card-item-title mb-2">
                        <label class="main-content-label tx-13 font-weight-bold mb-1">Terdaftar Pelatihan</label>
                        <span class="d-block tx-12 mb-0 text-muted">Dalam proses seleksi / selesai pelatihan</span>
                    </div>
                    <div class="card-item-body">
                        <div class="card-item-stat">
                            <h4 class="font-weight-bold"><?= count(Modules::run('database/find', 'tb_batch_course_has_account', "id_account = $data_account->id AND status != 10")->result()) ?> Pelatihan</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
        <div class="card custom-card">
            <div class="card-body">
                <div class="card-item">
                    <div class="card-item-icon card-icon">
                        <div class="text-primary" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24" viewBox="0 0 24 24" width="24">
                            <i class="fa fa-close "></i>
                        </div>
                    </div>
                    <div class="card-item-title mb-2">
                        <label class="main-content-label tx-13 font-weight-bold mb-1">Tidak lolos pelatihan</label>
                        <span class="d-block tx-12 mb-0 text-muted">Pendaftaranmu gagal / ditolak</span>
                    </div>
                    <div class="card-item-body">
                        <div class="card-item-stat">
                            <h4 class="font-weight-bold"><?= count(Modules::run('database/find', 'tb_batch_course_has_account', "id_account = $data_account->id AND status = 10")->result()) ?> Pelatihan</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card custom-card overflow-hidden">
            <div class="card-header border-bottom-0">
                <div>
                    <label class="main-content-label mb-2">Pelatihanmu</label> <span class="d-block tx-12 mb-0 text-muted">Berikut merupakan pelatihan yang kamu ikuti</span>
                </div>
            </div>
            <div class="card-body">
                <div class="container">
                    <div class="card overflow-hidden custom-card bg-light" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <img class="img-fluid b-img" src="<?= base_url('upload/batch/' . $course_active->image) ?>" style="height: 200px;" alt="pelatihan">
                        <div class="card-body">
                            <h4><?= $course_active->title ?></h4>
                            <h6 class="text-dark"><?= $course_active->category_name ?></h6>
                            <hr>
                            <a href="<?= Modules::run('helper/create_url', 'my_course/detail?data=' . urlencode($this->encrypt->encode($course_active->id))) ?>" class="btn btn-block btn-outline-primary btn-rounded">Detail Pelatihan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card custom-card mg-b-20">
            <div class="card-body">
                <div class="card-header border-bottom-0 pt-0 pl-0 pr-0 d-flex">
                    <div>
                        <label class="main-content-label mb-2">Jadwal</label> <span class="d-block tx-12 mb-3 text-muted">Jadwal pelatihan yang kamu ikuti.</span>
                    </div>
                </div>
                <?php if($schedule) : ?>
                <div class="table-responsive tasks">
                    <table class="table card-table table-vcenter text-nowrap mb-0  border">
                        <thead>
                            <tr>
                                <th class="wd-lg-20p">Tanggal</th>
                                <th class="wd-lg-20p">Judul</th>
                                <th class="wd-lg-20p text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($schedule as $value) : ?>
                            <tr>
                                <td><?= Modules::run('helper/date_indo', $value->date, '-') ?></td>
                                <td><?= $value->title ?></td>
                                <?php if($value->label) : ?>
                                    <td class="text-center"><span class="badge badge-pill badge-<?= $value->params ?>-light"><?= $value->label ?></span></td>
                                <?php else: ?>
                                    <td class="text-center"><span class="badge badge-pill badge-warning-light">Belum absensi</span></td>
                                <?php endif ?>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                    <div class="card custom-card text-center" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <h3 class="p-2">Belum ada Jadwal</h3>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>