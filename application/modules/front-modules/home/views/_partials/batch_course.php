<section class="py-lg-5 py-4 bg-faded-primary jarallax" data-jarallax data-speed="0.8">
    <div class="jarallax-img" style="background-image: url(https://createx.createx.studio/assets/img/online-courses/home/shapes/02-events.svg);"></div>
    <?php 
    if (!$this->uri->segment(1) == 'pendaftaran-pelatihan') : ?>
        <div class="container py-4">
            <h3 class="h6 mb-2 text-uppercase text-sm-center">Pembukaan Pendaftaran Pelatihan</h3>
            <h2 class="h1 mb-lg-5 pb-md-2 text-sm-center">Daftar Pelatihan</h2>
            
            <?php 
            $q_batch_courses = [
                'select' => 'a.id, a.title, a.description, a.target_registrant, 
                        DATE_FORMAT(a.opening_registration_date, "%d %M %Y") opening_date,
                        DATE_FORMAT(a.closing_registration_date, "%d %M %Y") closing_date',
                'from' => 'tb_batch_course a',
                'where' => 'NOW() BETWEEN a.opening_registration_date AND a.closing_registration_date',
                'order_by' => 'a.created_date DESC'        
            ];
            $batch_courses = Modules::run('database/get', $q_batch_courses)->result();
            $i = 0;
            foreach ($batch_courses as $batch) : 
            $date = explode(' ', $batch->closing_date);
            ?>
            <!-- Card horizontal -->
            <div class="card card-horizontal border-0 mb-4 px-sm-5 py-sm-0 py-3">
                <div class="card-header flex-shrink-0 my-sm-4 ms-sm-n2 py-sm-2 px-sm-0 border-0">
                    <div class="d-flex">
                        <span class="display-4 mb-0 text-primary" style="font-size: 3rem;"><?= $date[0] ?></span>
                        <div class="ms-3 ps-1">
                            <h6 class="h5 mb-1"><?= $date[1] ?></h6>
                            <span class="text-muted"><?= $date[2] ?></span>
                        </div>
                    </div>
                </div>
                <div class="card-body m-sm-4 py-sm-2 py-0 px-sm-3">
                    <h3 class="h5 mb-sm-1 mb-2">
                        <a href="<?= base_url('pendaftaran-pelatihan?data=') . $this->encrypt->encode($batch->id) ?>" class="nav-link"><?= $batch->title ?></a>
                    </h3>
                    <span class="text-muted"><?= strip_tags($batch->description); ?></span>
                </div>
                <div class="card-footer flex-shrink-0 my-sm-4 mt-5 me-sm-n2 py-sm-2 px-sm-0 border-0">
                    <a href="<?= base_url('pendaftaran-pelatihan?data=') . $this->encrypt->encode($batch->id) ?>" class="btn btn-outline-primary btn-hover-shadow d-sm-inline-block d-block">Detail</a>
                </div>
            </div>
            <?php
            if ($i == 2) {
                break;
            }
            $i++; 
            endforeach; ?>
            <h4 class="h3 pt-sm-4 pt-3 mb-0 text-center">
                Ingin cari tau lebih?
                <a href="<?= base_url('pendaftaran-pelatihan') ?>" class="btn btn-lg btn-gradient btn-hover-shadow d-sm-inline-block d-block mt-sm-0 mt-4 ms-sm-4">Explore semua pelatihan</a>
            </h4>
        </div>
    <?php else: ?>
        <div class="container py-4">
            <h2 class="h1 mb-lg-3 pb-md-2 text-sm-center">Pembukaan Pendaftaran Pelatihan</h2>
            <form method="post" id="filter-batch-courses">
                <div class="row mb-5 text-center justify-content-center">
                    <div class="col-md-3 form-group">
                        <select name="open_course" id="open_course" class="form-control">
                            <option value="ALL">Semua Pelatihan</option>
                            <option value="1">Sedang Dibuka</option>
                            <option value="0">Sudah Ditutup</option>
                        </select>
                    </div>
                </div>
            </form>
            <div class="row" id="list-batch-courses">
            <?php 
            foreach ($batch_courses as $batch) :
                $badge_date = '';
                $date = date('Y-m-d');
                $array_peserta = [
                    "select" => "count(*) as total",
                    "from" => "tb_batch_course_has_account",
                    "where" => "id_batch_course = $batch->id AND status = 5"
                ];
                $count_peserta      = Modules::run("database/get", $array_peserta)->row();
                if ($date > $batch->closing_date) {
                    $badge_date = '<span class="badge bg-danger fw-bold">'.$batch->closing_date.' | ' . $count_peserta->total .'/'. $batch->target_registrant . ' Peserta</span>';          
                } else {
                    $badge_date = '<span class="badge bg-success fw-bold">'.$batch->closing_date.' | ' . $count_peserta->total .'/'. $batch->target_registrant . ' Peserta</span>';
                }
            ?>
            <!-- Card horizontal -->
            <div class="col-md-4">
                <div class="card border-0 mb-4 px-sm-3 py-sm-0 py-3">
                    <div class="card-header flex-shrink-0 ms-sm-n2 border-0">
                        <img src="<?= base_url('upload/batch/') . $batch->image ?>" alt="<?= $batch->image ?>" class="img-thumbnail">
                        <div class="card-floating-links text-end">
                            <?= $badge_date ?>
                        </div>
                    </div>
                    <div class="card-body py-sm-2 py-0 px-sm-3">
                        <h3 class="h5 mb-sm-1 mb-2">
                            <a href="<?= base_url('pendaftaran-pelatihan?data=') . $this->encrypt->encode($batch->id) ?>" class="nav-link"><?= $batch->title ?></a>
                        </h3>
                        <span class="text-muted"><?= strip_tags($batch->description); ?></span>
                    </div>
                    <div class="card-footer flex-shrink-0 my-sm-2 mt-5 me-sm-n2 py-sm-2 px-sm-0 border-0">
                        <a href="<?= base_url('pendaftaran-pelatihan?data=') . $this->encrypt->encode($batch->id) ?>" class="btn btn-outline-primary btn-hover-shadow d-sm-inline-block d-block float-end">Detail</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</section>