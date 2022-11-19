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
                                        <img src="<?= base_url('upload/courses/') . $course->image ?>" alt="course" class="img-fluid mx-auto d-block">
                                    </div>
                                </div>
                                <!-- <div class="text-center mt-4 mb-4 btn-list">
                                    <a href="ecommerce-cart.html" class="btn ripple btn-primary">
                                        <i class="fe fe-shopping-cart"> </i> Add to cart
                                    </a>
                                    <a href="#" class="btn ripple btn-secondary"><i class="fe fe-credit-card"> </i> Buy Now
                                    </a>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="mt-4 mb-4">
                            <h2 class="mt-1 mb-3"><?= $course->name ?></h2>
                            <p class="h5 mb-2 pl-0 ml-0">Kategori keahlian:</p>
                            <h6 class="text-success"><?= ucwords(Modules::run('database/find', 'tb_course_category', ['id' => $course->id_category_course])->row()->name); ?></h6>
                            <h5 class="mb-2">Skill:</h5>
                            <p class="tx-13 text-muted">
                                <?php
                                $q_skill = [
                                    "select" => "c.name skill",
                                    "from" => "tb_course a",
                                    "join" => [
                                        "tb_course_has_skill b, b.id_course = a.id, left",
                                        "tb_skill c, c.id = b.id_skill, left"
                                    ],
                                    "where" => [
                                        'a.id' => $course->id
                                    ]
                                ];
                                $skills = Modules::run('database/get', $q_skill)->result();
                                $i = 0;
                                foreach ($skills as $skill) : ?>
                                    <span class="fw-bold text-primary"><?= ucwords($skill->skill) ?></span>
                                    <?= $i > 0 ? '<span class="text-border px-1">|</span>' : '' ?>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            </p>
                            <h6 class="mt-4 fs-16">Deskripsi</h6>
                            <?= $course->description ?>
                        </div>
                        <!-- <div class="d-flex  mt-2">
                            <div class="mt-2 sizes">Quantity:</div>
                            <div class="d-flex ms-2">
                                <div class="form-group">
                                    <select name="quantity" id="select-countries17" class="form-control select2 wd-150 select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                        <option value="1" selected="">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                    <span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;">
                                        <span class="selection">
                                            <span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-select-countries17-container">
                                                <span class="select2-selection__rendered" id="select2-select-countries17-container" title="1">1</span>
                                                <span class="select2-selection__arrow" role="presentation">
                                                    <b role="presentation"></b>
                                                </span>
                                            </span>
                                        </span>
                                        <span class="dropdown-wrapper" aria-hidden="true"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="colors d-flex me-3 mt-2">
                            <span class="mt-2">colors:</span>
                            <div class="d-flex gutters-xs ms-4">
                                <div class="me-2">
                                    <label class="colorinput">
                                        <input name="color" type="radio" value="azure" class="colorinput-input" checked="">
                                        <span class="colorinput-color bg-dark"></span> </label>
                                </div>
                                <div class="me-2">
                                    <label class="colorinput">
                                        <input name="color" type="radio" value="indigo" class="colorinput-input">
                                        <span class="colorinput-color bg-secondary"></span>
                                    </label>
                                </div>
                                <div class="me-2">
                                    <label class="colorinput"> <input name="color" type="radio" value="purple" class="colorinput-input">
                                        <span class="colorinput-color bg-danger"></span>
                                    </label>
                                </div>
                                <div class="me-2">
                                    <label class="colorinput">
                                        <input name="color" type="radio" value="pink" class="colorinput-input">
                                        <span class="colorinput-color bg-pink"></span>
                                    </label>
                                </div>
                            </div>
                        </div> -->
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
            <h3 class="h6 mb-2 text-uppercase">Kursus terbaik lainnya</h3>
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
                    $q_course = [
                        'select' => '*',
                        'from' => 'tb_course',
                        'where_not_in' => [
                            'id' => $course->id
                        ]
                    ];
                    $all_course = Modules::run('database/get', $q_course)->result();
                    foreach ($all_course as $slide_course) : ?>
                        <a href="<?= base_url('kursus-pelatihan-kerja?data=') . $this->encrypt->encode($slide_course->id) ?>" class="card team bg-transparent" style="text-decoration: none;">
                            <div class="card-img">
                                <img src="<?= base_url('upload/courses/') . $slide_course->image ?>" alt="<?= $slide_course->image ?>" />
                                <div class="card-floating-links text-end">
                                    <?php
                                    $q_skill = [
                                        "select" => "c.name skill",
                                        "from" => "tb_course a",
                                        "join" => [
                                            "tb_course_has_skill b, b.id_course = a.id, left",
                                            "tb_skill c, c.id = b.id_skill, left"
                                        ],
                                        "where" => [
                                            'a.id' => $course->id
                                        ]
                                    ];
                                    $skills = Modules::run('database/get', $q_skill)->result();
                                    $i = 0;
                                    foreach ($skills as $skill) : ?>
                                        <span class="fw-bold text-primary"><?= ucwords($skill->skill) ?></span>
                                        <?= $i > 0 ? '<span class="text-border px-1">|</span>' : '' ?>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                    <!-- <a class="btn-social bs-light me-2" href="#">
                            <i class="ci-facebook"></i>
                        </a>
                        <a class="btn-social bs-light me-2" href="#">
                            <i class="ci-instagram"></i>
                        </a>
                        <a class="btn-social bs-light" href="#">
                            <i class="ci-linkedin"></i>
                        </a> -->
                                </div>
                            </div>
                            <div class="card-body py-3 text-center">
                                <h4 class="card-title h5 mb-1"><?= $slide_course->name ?></h4>
                                <p class="card-text text-muted"><?= ucwords(Modules::run('database/find', 'tb_course_category', ['id' => $course->id_category_course])->row()->name); ?></p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </div> <!-- / Parallax wrapper -->