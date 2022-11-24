    <div class="mb-md-5 py-4">
        <ul class="d-md-flex d-none align-items-center justify-content-between flex-md-nowrap flex-wrap list-unstyled">
            <li class="d-flex flex-lg-row flex-column align-items-center mb-md-0 mb-4 text-dark text-nowrap">
                <span class="h1 mb-lg-0 mb-1 me-lg-2">
                    <?php
                    $q_alumni = [
                        'select' => 'count(1) total',
                        'from' => 'tb_account',
                        'where' => 'is_alumni = 1'
                    ];
                    $alumni = Modules::run('database/get', $q_alumni)->row();
                    $total = empty($alumni) ? 0 : $alumni->total;
                    echo $total;
                    ?>
                </span>
                Alumni
            </li>
            <li class="d-md-block d-none fs-sm text-primary">•</li>
            <li class="d-flex flex-lg-row flex-column align-items-center mb-md-0 mb-4 text-dark text-nowrap">
                <span class="h1 mb-lg-0 mb-1 me-lg-2">
                    <?php
                    $q_pelatihan = [
                        'select' => 'count(1) total',
                        'from' => 'tb_course'
                    ];
                    $pelatihan = Modules::run('database/get', $q_pelatihan)->row();
                    $total = empty($pelatihan) ? 0 : $pelatihan->total;
                    echo $total;
                    ?>
                </span>
                Pelatihan
            </li>
            <li class="d-md-block d-none fs-sm text-primary">•</li>
            <li class="d-flex flex-lg-row flex-column align-items-center mb-md-0 mb-4 text-dark text-nowrap">
                <span class="h1 mb-lg-0 mb-1 me-lg-2">
                    <?php
                    $q_industry = [
                        'select' => 'count(1) total',
                        'from' => 'tb_industry'
                    ];
                    $industry = Modules::run('database/get', $q_industry)->row();
                    $total = empty($industry) ? 0 : $industry->total;
                    echo $total;
                    ?>
                </span>
                Perusahaan
            </li>
            <li class="d-md-block d-none fs-sm text-primary">•</li>
            <li class="d-flex flex-lg-row flex-column align-items-center mb-md-0 mb-4 text-dark text-nowrap">
                    <span class="h1 mb-lg-0 mb-1 me-lg-2">
                        <?php
                        $q_industry = [
                            'select' => 'count(1) total',
                            'from' => 'tb_job_vacancy',
                            'where' => 'vacancy_status = 1'
                        ];
                        $industry = Modules::run('database/get', $q_industry)->row();
                        $total = empty($industry) ? 0 : $industry->total;
                        echo $total;
                        ?>
                    </span>
                <a href="<?= base_url('member-area/jobfair') ?>" class="text-decoration-none text-dark">
                    Lowongan Kerja
                </a>
            </li>
        </ul>
    </div>
</div>
</section>