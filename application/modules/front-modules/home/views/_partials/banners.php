<?php
$get_all = Modules::run('database/find', 'tb_cms_banner', ['isDeleted' => 'N', 'type' => 4, 'status' => 1])->result();
foreach ($get_all as $item_data) {

    if ($item_data->position_text == 1) {
        echo '
            <!-- Hero Start -->
            <section class="  d-table w-100 py-5" style="background-color:' . $item_data->background_color . ';color:' . $item_data->text_color . ';">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-7">
                            <div class="title-heading mt-4">
                                <div class="alert alert-white alert-pills shadow" role="alert">
                                    <span class="content">  <span class="text-primary" style="color:' . $item_data->text_color . ' !important;">' . $item_data->name . '</span>
                                </div>
                                ' . $item_data->description . '
                            </div>
                        </div><!--end col-->

                        <div class="col-lg-6 col-md-5 mt-4 pt-2 mt-sm-0 pt-sm-0">
                            <div class="position-relative">
                                <img src="' . base_url('upload/banner/' . $item_data->image) . '" class="rounded img-fluid mx-auto d-block" alt="">
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->
                </div><!--end container--> 
            </section><!--end section-->
            <!-- Hero End -->
        ';
    }
    if ($item_data->position_text == 2) {
        echo '
        <!-- Hero Start -->
        <section class="  d-table w-100 py-5" style="background-color:' . $item_data->background_color . ';color:' . $item_data->text_color . ';">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-5 mt-4 pt-2 mt-sm-0 pt-sm-0">
                        <div class="position-relative">
                            <img src="' . base_url('upload/banner/' . $item_data->image) . '" class="rounded img-fluid mx-auto d-block" alt="">
                        </div>
                    </div><!--end col-->
                    <div class="col-lg-6 col-md-7">
                        <div class="title-heading mt-4">
                            <div class="alert alert-white alert-pills shadow" role="alert">
                                <span class="content">  <span class="text-primary" style="color:' . $item_data->text_color . ' !important;">' . $item_data->name . '</span>
                            </div>
                            ' . $item_data->description . '
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container--> 
        </section><!--end section-->
        <!-- Hero End -->
    ';
    }
    if ($item_data->position_text == 3) {
        echo '
            <section class="bg-marketing d-table w-100" style="background-color:' . $item_data->background_color . ';color:' . $item_data->text_color . ';">
                <div class="container">
                    <div class="row justify-content-center mt-5">
                        <div class="col-lg-7 col-md-7 text-center">
                            <img src="' . base_url('upload/banner/' . $item_data->image) . '" class="img-fluid" style="max-height: 400px" alt="">

                            <div class="title-heading mt-0 mt-md-5 mt-4 mt-sm-0 pt-2 pt-sm-0">
                                <span class="content">  <span class="text-primary" style="color:' . $item_data->text_color . ' !important;">' . $item_data->name . '</span>
                                ' . $item_data->description . '
                            </div>
                        </div>
                    </div><!--end row-->
                </div><!--end container--> 
            </section>
        ';
    }
    if ($item_data->position_text == 4) {
        echo '
            <section class="section" style="padding:200px 0;background: url(' . base_url('upload/banner/' . $item_data->image) . ') center center;">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <div class="section-title me-lg-4" style="color:' . $item_data->text_color . ' !important;">
                                <span class="content">  <span class="text-primary" style="color:' . $item_data->text_color . ' !important;">' . $item_data->name . '</span>
                                ' . $item_data->description . '
                            </div>
                        </div><!--end col-->

                    </div><!--end row-->
                </div><!--end container-->
            </section>
        ';
    }
}
