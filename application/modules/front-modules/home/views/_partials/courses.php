<section class="container pt-lg-5 pt-4 pb-5">
    <h3 class="h6 mb-2 text-uppercase">Siap untuk belajar?</h3>
    <div class="d-flex align-items-center justify-content-between mb-lg-5 mb-4 pb-md-2">
        <h2 class="h1 mb-0">Kategori Pelatihan</h2>
        <div class="d-sm-block d-none">
            <a href="courses.html" class="btn btn-lg btn-outline-primary btn-hover-shadow">View all courses</a>
        </div>
    </div>
    <div class="row">
        <?php
        $courses = Modules::run('database/get_all', 'tb_course')->result();
        $y = 0;
        foreach ($courses as $course) : ?>
            <div class="col-md-6 mb-grid-gutter">
                <a href="course-single.html" class="card card-horizontal card-hover shadow heading-highlight">
                    <div class="card-img-top bg-position-center-top" style="background-image: url(<?= base_url('upload/courses/') . $course->image ?>);"></div>
                    <div class="card-body">
                        <span class="badge bg-success mb-3 fs-sm"><?= Modules::run('database/find', 'tb_course_category', ['id' => $course->id_category_course])->row()->name; ?></span>
                        <h5 class="card-title mb-3 py-1"><?= $course->name ?></h5>
                        <div class="text-muted">
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
                                <span class="fw-bold text-primary"><?= $skill->skill ?></span>
                                <?= $i > 0 ? '<span class="text-border px-1">|</span>' : '' ?>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </a>
            </div>
        <?php
        if ($y == 5) {
            break;
        }
        $y++;
        endforeach;
        ?>
    </div>
    <div class="d-sm-none d-block py-3 text-center">
        <a href="courses.html" class="btn btn-lg btn-outline-primary">View all courses</a>
    </div>
</section>