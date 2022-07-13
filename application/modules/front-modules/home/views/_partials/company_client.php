<?php
$get_client = Modules::run('database/find', 'tb_cms_banner', ['isDeleted' => 'N', 'status' => 1, 'type' => 3])->result();
?>
<section class="py-5  bg-light">
    <div class="container">

        <div class="row mt-5 justify-content-center align-items-center">
            <?php
            foreach ($get_client as $item_client) {
                echo '
                        <div class="col-lg-2 col-md-2 col-6 text-center">
                            <img src="' . base_url('upload/banner/' . $item_client->image) . '" class="" style="width:100%" alt="">
                        </div>
                    ';
            }
            ?>
            <!--end col-->
        </div>

        <!--end row-->
    </div>
    <!--end container-->
</section>