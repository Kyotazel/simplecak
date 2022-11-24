<!-- Team -->
<section class="container pt-lg-6 pt-5 pb-lg-5 pb-4">
    <h3 class="h6 mb-2 text-uppercase">Instruktur terbaik kami</h3>
    <div class="mb-lg-5 mb-4 pb-md-2 d-flex justify-content-between">
        <h2 class="h1 mb-0">kenalan dengan instruktur kami yuk</h2>
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
            $instructor = Modules::run('database/find', 'tb_cms_team', ['isDeleted' => 'N'])->result();
            foreach ($instructor as $value) : ?>
                <div class="card team bg-transparent">
                    <div class="card-img">
                        <img src="<?= base_url('upload/team/') . $value->image?>" alt="Team member" />
                    </div>
                    <div class="card-body py-3 text-center">
                        <h4 class="card-title h5 mb-1"><?= $value->name ?></h4>
                        <p class="card-text text-muted"><?= $value->position ?></p>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
</section>