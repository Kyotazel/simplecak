<div class="container mb-4" style="margin-top: 100px;">
    <div class="row">
        <div class="col-md-12">
            <img src="<?= base_url('upload/banner/' . $data_post->image); ?>" class="img-fluid rounded-md shadow" alt="">
        </div>
        <div class="col-md-12 mt-5">
            <h3 class="title mb-4"><?= $data_post->title; ?></h3>
            <div>
                <?= $data_post->content; ?>
            </div>
        </div>
    </div>
</div>