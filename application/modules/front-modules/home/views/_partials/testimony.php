<!-- Start -->
<?php 
$q_company = [
    'select' => 'testimony, name',
    'from' => 'tb_industry',
    'where' => 'testimony IS NOT NULL'
];
$company = Modules::run('database/get', $q_company)->result();
if (!empty($company)) : ?>
<section class="section pt-0">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="section-title mb-4 pb-2 text-center">
                    <h4 class="title mb-4">Testimoni Perusahaan tentang <span class="text-primary">BLK</span> SURABAYA</h4>
                    <p class="text-muted para-desc mx-auto mb-0">Bergabunglah Bersama <span class="text-primary fw-bold">BLK SURABAYA</span>, kami siap memberikan pekerja terbaik untuk anda.</p>
                </div>
                <div class="row">
                    <div class="col-12 mt-4">
                        <div class="tiny-three-item">
                            <?php 
                            $i = 0;
                            foreach ($company as $value) : ?>
                                <?php if (!empty($value->testimony)) : ?>
                                <div class="tiny-slide text-center">
                                    <div class="client-testi rounded shadow m-2 p-4">
                                        <img src="images/client/amazon.svg" class="img-fluid avatar avatar-ex-sm mx-auto" alt="">
                                        <p class="text-muted mt-4">" <?= $value->testimony ?> "</p>
                                        <h6 class="text-primary">- <?= $value->name ?></h6>
                                    </div>
                                </div>        
                                <?php 
                                if ($i >= 5) {
                                    break;
                                }
                                $i++; endif; ?>
                            <?php endforeach;?>
                        </div>
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
            </div>
            <!--end col-->
        </div>
        <!--end row -->
    </div>
    <!--end container-->
</section>
<?php endif;?>
<!--end section-->
<!-- End section -->