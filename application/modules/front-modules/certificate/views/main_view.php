<?php if(!$data) : ?>
    <section class="container pt-lg-5 pt-4 pb-5 mt-5">
        <div class="row mt-2 mb-5">
            <div class="col-md-12 col-lg-12">
                <h1>Sertifikat tidak ada atau tidak terdaftar</h1>
            </div>
        </div>
    </section>

<?php else: ?>
    <section class="container pt-lg-5 pt-4 pb-5 mt-5">
        <div class="row mt-2 mb-5">
            <div class="col-md-12 col-lg-12">
                <h1>Sertifikat Berikut Resmi</h1>
                <!-- <?php var_dump($data) ?> -->
                <iframe src="<?= base_url('upload/certificate/'. $data->file) ?>" height="800"></iframe>
            </div>
        </div>
    </section>

<?php endif ?>
