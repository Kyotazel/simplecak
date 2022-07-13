<!-- Start Features -->
<section class="py-4 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <form class="p-4 shadow bg-white rounded">
                    <h4 class="mb-3">Cari Jadwal</h4>
                    <div class="row text-start">
                        <div class="col-lg-3 col-md-6">
                            <div class="mb-3 mb-lg-0">
                                <label class="form-label"> Tanggal Berangkat : </label>
                                <input name="date" type="text" class="form-control start" placeholder="Select date :">
                            </div>
                        </div>
                        <!--end col-->

                        <div class="col-lg-3 col-md-6">
                            <div class="mb-3 mb-lg-0">
                                <label class="form-label"> Tanggal Sampai : </label>
                                <input name="date" type="text" class="form-control end" placeholder="Select date :">
                            </div>
                        </div>
                        <!--end col-->

                        <div class="col-lg-6">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <div class="mb-3 mb-lg-0">
                                        <label class="form-label">Depo Awal : </label>
                                        <input type="number" min="0" autocomplete="off" id="adult" required="" class="form-control" placeholder="Adults :">
                                    </div>
                                </div>
                                <!--end col-->

                                <div class="col-md-4">
                                    <div class="mb-3 mb-lg-0">
                                        <label class="form-label">Depo Tujuan : </label>
                                        <input type="number" min="0" autocomplete="off" id="children" class="form-control" placeholder="Children :">
                                    </div>
                                </div>
                                <!--end col-->

                                <div class="col-md-4 mt-lg-4 pt-2 pt-lg-1">
                                    <div class="d-grid">
                                        <input type="submit" id="search" name="cari" class="searchbtn btn btn-primary" value="Cari">
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--end row-->
    </div>
    <!--end container-->
</section>
<!--end section-->
<!-- End Features -->