<section class=" py-3">
    <div class="container mt-100 mt-60 mb-4">
        <div class="row justify-content-center">
            <div class="col-12 text-center">
                <div class="section-title mb-4 pb-2">
                    <h4 class="title mb-4">Galery Kami</h4>
                    <!-- <p class="text-muted para-desc mx-auto mb-0">Start working with <span class="text-primary fw-bold">Landrick</span> that can provide everything you need to generate awareness, drive traffic, connect.</p> -->
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->

        <div class="row">
            <?php
            $get_all = Modules::run('database/find', 'tb_cms_banner', ['isDeleted' => 'N', 'type' => 1])->result();
            foreach ($get_all as $item_data) {
                echo '
                        <div class="col-lg-4 col-md-6 mt-4 pt-2">
                            <div class="card blog rounded border-0 shadow">
                                <div class="position-relative">
                                    <img src="' . base_url('upload/banner/' . $item_data->image) . '" class="card-img-top rounded-top" alt="...">
                                    <div class="overlay rounded-top"></div>
                                </div>
                                <div class="card-body content">
                                    <h5><a href="javascript:void(0)" class="card-title title text-dark">' . $item_data->name . '</a></h5>
                                    <p>' . $item_data->description . '</p>
                                </div>
                            </div>
                        </div>
                    ';
            }
            ?>

            <!--end col-->




            <!--end col-->
        </div>
        <!--end row-->
    </div>
</section>