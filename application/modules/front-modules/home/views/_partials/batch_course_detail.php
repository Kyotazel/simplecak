<div class="row row-sm mt-5 pt-4">
    <div class="col-lg-12 col-md-12">
        <div class="card custom-card productdesc border-0">
            <div class="card-body h-100">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="product-carousel">
                            <div id="carousel" class="carousel slide" data-bs-ride="false">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="<?= base_url('upload/batch/') . $batch_course->image ?>" alt="course" class="img-fluid mx-auto d-block">
                                    </div>
                                </div>
                                <div class="text-center mt-4 mb-4 btn-list">
                                    <?php 
                                    $date = date('Y-m-d');
                                    $badge_date = '';
                                    $badge_registrar = '';
                                    $badge_close = '';
                                    $btn_register = '<a href="'.base_url('member-area/register_course/detail?data='). $this->encrypt->encode($batch_course->id).'" class="btn btn-gradient btn-hover-shadow d-sm-inline-block d-none ms-4"><i class="fe fa-check-circle"> </i> Daftar Sekarang</a>';
                                    if ($date <= $batch_course->closing_registration_date) {
                                        $badge_close = '<span class="badge bg-success">Pelatihan Dibuka</span>';
                                        $badge_date = '<h6 class="btn btn-outline-success mb-2"><i class="fa fa-calendar-check-0"></i> '. $batch_course->opening_date .' - ' . $batch_course->closing_date .' </h6>';
                                        $badge_registrar = '<h6 class="btn btn-outline-success mb-2"><i class="fa fa-user"></i> '. $count_peserta->total .'/'. $batch_course->target_registrant . ' Peserta </h6>'; 
                                    } else {
                                        $badge_close = '<span class="badge bg-danger">Pelatihan Ditutup</span>';
                                        $badge_date = '<h6 class="btn btn-outline-danger mb-2"><i class="fa fa-calendar-check-0"></i> '. $batch_course->opening_date .' - ' . $batch_course->closing_date .' | <i class="fa fa-user"></i> '. $count_peserta->total .'/'. $batch_course->target_registrant . ' Peserta </h6>';
                                        $badge_registrar = '<h6 class="btn btn-outline-danger mb-2"><i class="fa fa-user"></i> '. $count_peserta->total .'/'. $batch_course->target_registrant . ' Peserta </h6>'; 
                                        // if ($count_peserta->total >= $batch_course->target_registrant) {
                                            $btn_register = '<a href="#" class="btn ripple btn-light border border-2"><i class="fe fa-check-circle"> </i> Daftar Sekarang</a>';
                                        // }
                                    }
                                    echo $btn_register;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="mt-4 mb-4">
                            <h2 class="mt-1 mb-3"><?= $batch_course->title ?></h2>
                            <?= $badge_close ?>
                            <p class="h6 m-0">Waktu Pendaftaran: </p>
                            <?= $badge_date ?>
                            <p class="h6 m-0">Jumlah Peserta: </p>
                            <?= $badge_registrar ?>
                            <h6 class="mt-2 fs-16">Deskripsi</h6>
                            <div style="max-height: 35vh" data-simplebar data-simplebar-auto-hide="false">
                                <?= $batch_course->description ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Parallax wrapper -->
    <div class="pt-5 bg-secondary jarallax" data-jarallax data-speed="0.8">


        <!-- Parallax image -->
        <div class="jarallax-img" style="background-image: url(https://createx.createx.studio/assets/img/online-courses/home/shapes/03-team-testimonials.svg);"></div>


        <!-- Team -->
        <section class="container pt-lg-5 pt-4 pb-lg-4 pb-4">
            <h3 class="h6 mb-2 text-uppercase">Pelatihan lainnya</h3>
            <div class="mb-lg-5 mb-4 pb-md-2 d-flex justify-content-between">
                <h2 class="h1 mb-0">mungkin anda tertarik</h2>
                <div class="tns-custom-controls tns-controls-inverse mb-md-n4" id="tns-team-controls" tabindex="0">
                    <button type="button" data-controls="prev" tabindex="-1">
                        <i class="ci-arrow-left"></i>
                    </button>
                    <button type="button" data-controls="next" tabindex="-1">
                        <i class="ci-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- Carousel component -->
            <div class="tns-carousel-wrapper">
                <div class="tns-carousel-inner" data-carousel-options='{
  "gutter": 30,
  "nav": false,
  "controlsContainer": "#tns-team-controls",
  "responsive": {
    "0": {
      "items": 1
    },
    "576": {
      "items": 2
    },
    "768": {
      "items": 3
    },
    "992": {
      "items": 4
    }
  }
}'>
                    <?php
                    $q_batch_courses = [
                        'select' => 'a.id, a.title, a.description, a.target_registrant, 
                                DATE_FORMAT(a.opening_registration_date, "%d %M %Y") opening_date,
                                DATE_FORMAT(a.closing_registration_date, "%d %M %Y") closing_date,
                                a.image, a.target_registrant, a.closing_registration_date',
                        'from' => 'tb_batch_course a',
                        'order_by' => 'a.created_date DESC',
                        'where_not_in' => [
                            'a.id' => $batch_course->id
                        ]
                    ];
                    $all_batch_course = Modules::run('database/get', $q_batch_courses)->result();
                    foreach ($all_batch_course as $slide_batch) : 
                        $badge_date = '';
                        $date = date('Y-m-d');
                        $array_peserta = [
                            "select" => "count(*) as total",
                            "from" => "tb_batch_course_has_account",
                            "where" => "id_batch_course = $slide_batch->id AND status = 5"
                        ];
                        $count_peserta      = Modules::run("database/get", $array_peserta)->row();
                        if ($date >= $slide_batch->closing_registration_date) {
                            $badge_date = '<span class="badge bg-danger fw-bold">'.$slide_batch->closing_date.' | ' . $count_peserta->total .'/'. $slide_batch->target_registrant . ' Peserta</span>';          
                        } else {
                            $badge_date = '<span class="badge bg-success fw-bold">'.$slide_batch->closing_date.' | ' . $count_peserta->total .'/'. $slide_batch->target_registrant . ' Peserta</span>';
                        }?>
                        <a href="<?= base_url('pendaftaran-pelatihan?data=') . $this->encrypt->encode($slide_batch->id) ?>" class="card team bg-transparent" style="text-decoration: none;">
                            <div class="card-img">
                                <img src="<?= base_url('upload/batch/') . $slide_batch->image ?>" alt="<?= $slide_batch->image ?>" />
                                <div class="card-floating-links text-end">
                                    <?= $badge_date ?>
                                </div>
                            </div>
                            <div class="card-body py-3 text-center">
                                <h4 class="card-title h5 mb-1"><?= $slide_batch->title ?></h4>
                                <p class="card-text text-muted" style="height: 20vh;overflow: hidden;"><?= strip_tags($slide_batch->description); ?></p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </div> <!-- / Parallax wrapper -->