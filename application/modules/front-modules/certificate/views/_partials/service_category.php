<?php
$get_all_data = Modules::run('database/find', 'tb_service_company', ['type' => 1])->result();
?>
<section class="py-5 bg-light">
    <div class="container mb-3">
        <!--end row-->

        <div class="row">
            <?php
            foreach ($get_all_data as $item_data) {
                echo '
                    <div class="col-lg-3 col-md-6  pt-2">
                        <div class=" features feature-clean explore-feature p-4 border-0 rounded-md  text-center">
                            <div class="icons text-primary text-center mx-auto">
                                <img style="width:40%;" src="' . base_url('upload/profile/' . $item_data->image) . '" alt="">
                            </div>

                            <div class="card-body p-0 content">
                                <h5 class="mt-4"><a href="javascript:void(0)" class="title text-dark">' . $item_data->name . '</a></h5>
                                <p class="text-muted">' . $item_data->description . '</p>
                            </div>
                        </div>
                    </div>
                ';
            }
            ?>
        </div>
        <!--end row-->
    </div>
    <!--end container-->
</section>
<!--end section-->