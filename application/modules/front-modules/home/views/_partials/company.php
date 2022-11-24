<section class="container mt-md-4 py-lg-6 pt-5 pb-sm-5 pb-4 px-0">
  <div class="tns-carousel-wrapper tns-nav-outside">
    <div class="tns-outer" id="tns3-ow">
      <div class="tns-liveregion tns-visually-hidden" aria-live="polite" aria-atomic="true">slide <span class="current">14 to 18</span> of 12</div>
      <div id="tns3-mw" class="tns-ovh">
        <div class="tns-inner" id="tns3-iw">
          <div class="tns-carousel-inner  tns-slider tns-carousel tns-subpixel tns-calc tns-horizontal" data-carousel-options="{
            &quot;nav&quot;: false,
            &quot;controls&quot;: false,
            &quot;autoplay&quot;: true,
            &quot;autoplayTimeout&quot;: 4000,
            &quot;responsive&quot;: {
              &quot;0&quot;: {
                &quot;items&quot;: 2
              },
              &quot;576&quot;: {
                &quot;items&quot;: 3
              },
              &quot;768&quot;: {
                &quot;items&quot;: 4
              },
              &quot;992&quot;: {
                &quot;items&quot;: 5
              },
              &quot;1200&quot;: {
                &quot;items&quot;: 6
              }
            }
          }" id="tns3" style="transform: translate3d(-43.3333%, 0px, 0px);">
            <?php
            $company = Modules::run('database/get_all', 'tb_industry')->result();
            foreach ($company as $value) : ?>
              <div class="px-3 text-center tns-item tns-slide-cloned" aria-hidden="true" tabindex="-1">
                <a href="#" class="swap-image">
                  <img src="<?= base_url('upload/company/') . $value->image ?>" class="swap-from" width="120" alt="Brand logo hover">
                  <img src="<?= base_url('upload/company/') . $value->image ?>" class="swap-to" width="120" alt="Brand logo hover">
                </a>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>