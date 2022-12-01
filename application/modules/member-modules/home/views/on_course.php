<div class="mb-3 row rounded-20 bg-primary align-items-center" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);background: url(http://blk.viscode.id/assets/themes/valex/img/svgicons/cargo.svg) no-repeat;height:100px;">
    <div class="col-3 border-right d-flex align-items-center">
        <h3 class="ml-3 text-white mb-0">Halo, <?= $this->session->userdata('member_name') ?></h3>
    </div>
    <div class="col-6">
        <!-- <p class="text-white tx-16 p-0 m-0">Ikuti Pelatihan terbaru untuk menambah kemampuanmu.</p> -->
        <p class="text-white tx-16 p-0 m-0">Jadwal terbaru, 30 November 2022 : Pengenalan Website.</p>
    </div>
    <div class="col-3 text-right">
        <a href="<?= Modules::run('helper/create_url', 'register_course') ?>" class="btn btn-rounded btn-success font-weight-bold">Lihat Sekarang <i class="fa fa-paper-plane"></i></i></a>
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
                            <h4 class="font-weight-bold">3 Pelatihan</h4>
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
                            <h4 class="font-weight-bold">1 Pelatihan</h4>
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
                            <h4 class="font-weight-bold">1 Pelatihan</h4>
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
                        <img class="img-fluid b-img" src="<?= base_url('upload/batch/1666088044915.jpg') ?>" style="height: 200px;" alt="pelatihan">
                        <div class="card-body">
                            <h4>Pelatihan Pemrograman Web Batch 1</h4>
                            <h6 class="text-dark">Kejuruan teknik listrik</h6>
                            <hr>
                            <a href="#" class="btn btn-block btn-outline-primary btn-rounded">Detail Pelatihan</a>
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
                            <tr>
                                <td>29 November 2022</td>
                                <td>Pengenalan website</td>
                                <td class="text-center"><span class="badge badge-pill badge-success-light">Masuk</span></td>
                            </tr>
                            <tr>
                                <td>28 November 2022</td>
                                <td>Pengenalan Lorem, ipsum.</td>
                                <td class="text-center"><span class="badge badge-pill badge-warning-light">Belum Absensi</span></td>
                            </tr>
                            <tr>
                                <td>27 November 2022</td>
                                <td>Instalasi</td>
                                <td class="text-center"><span class="badge badge-pill badge-danger-light">Tidak Masuk</span></td>
                            </tr>
                            <tr>
                                <td>26 November 2022</td>
                                <td>penggunaaan</td>
                                <td class="text-center"><span class="badge badge-pill badge-success-light">Masuk</span></td>
                            </tr>
                            <tr>
                                <td>25 November 2022</td>
                                <td>Lorem, ipsum.</td>
                                <td class="text-center"><span class="badge badge-pill badge-success-light">Masuk</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>