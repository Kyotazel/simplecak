<?php
$get_slider = Modules::run('database/find', 'tb_cms_banner', ['isDeleted' => 'N', 'status' => 1, 'type' => 2])->result();
?>
<!-- Hero Start -->
<section class="home-slider position-relative">
    <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php
            foreach ($get_slider as $item_slider) {
                echo '
                        <div class="carousel-item active" data-bs-interval="3000">
                            <div class="bg-home d-flex align-items-center" style="background: url(' . base_url('upload/banner/' . $item_slider->image) . ') center center;">
                                <div class=""></div>
                                <div class="container">
                                    <div class="row justify-content-left">
                                        <div class="col-lg-12 text-left">
                                            <div class="title-heading mt-4">
                                                <h1 class="heading mb-3 text-white title-dark animated fadeInUpBig animation-delay-2">' . nl2br($item_slider->name) . '</h1>
                                                <p class="para-desc text-light para-dark animated fadeInUpBig animation-delay-4">' . nl2br($item_slider->description) . '</p>
            
                                                <div class="text-left subcribe-form mt-4 pt-2 animated fadeInUpBig animation-delay-7">
                                                    <form class="m-0">
                                                        <input type="text" id="date" name="text" class="rounded" placeholder="silhakan pilih tanggal keberangkatan..">
                                                        <button type="submit" class="btn btn-primary">Lihat Jadwal</button>
                                                    </form>
                                                    <!--end form-->
                                                </div>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </div>
                                <!--end container-->
                            </div>
                            <!--end slide-->
                        </div>
                    ';
            }
            ?>




        </div>
        <a class="carousel-control-prev" href="#carouselExampleInterval" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleInterval" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </a>
    </div>
</section>
<!--end section-->
<!-- Hero End -->