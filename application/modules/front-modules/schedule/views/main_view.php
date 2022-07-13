<section style="margin-top: 100px;" class="mb-5  bg-light">
    <div class="container mt-100 mt-60" style="min-height: 500px;">
        <div class="row align-items-center">
            <div class="col-lg-12 col-md-12">
                <div class="card shadow" style="border: none;margin-top:20px;">
                    <div class="card-body">
                        <form id="form-search">
                            <input type="hidden" name="search" value="1">
                            <div class="row mb-2 pb-2 pt-2 justify-content-center">
                                <div class="col-md-4 row">
                                    <label for="" class="col-12">Pencarian Tanggal Berangkat</label>
                                    <div class="col-md-6">
                                        <label for="" class="font-weight-bold">Sejak Tanggal :</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                                </div>
                                            </div>
                                            <input style="height: 50px;" class="form-control datepicker " name="date_from" placeholder="Pilih tanggal..." type="text">
                                        </div>
                                        <span class="help-block notif_date_buy"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="font-weight-bold">Sampai Tanggal :</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                                </div>
                                            </div>
                                            <input style="height: 50px;" class="form-control datepicker " name="date_to" placeholder="Pilih tanggal..." type="text">
                                        </div>
                                        <span class="help-block notif_date_buy"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 row">
                                    <label for="" class="col-12">Rute Keberangkatan :</label>
                                    <div class="col-md-6">
                                        <label for="" class="font-weight-bold">Depo Asal</label>
                                        <select name="depo_from" class="form-control " style="height: 50px;" id="">
                                        </select>
                                        <span class="help-block notif_depo_from"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="font-weight-bold">Depo Tujuan</label>
                                        <select name="depo_to" class="form-control " style="height: 50px;" id="">
                                        </select>
                                        <span class="help-block notif_depo_to text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-2 text-center">
                                    <label for="" class="font-weight-bold">&nbsp;</label><br>
                                    <br>
                                    <button type="submit" class="btn btn-warning btn-pills btn_search btn-block btn-lg  btn-rounded font-weight-bold"><i class="fa fa-search"></i> Cari Jadwal</button>
                                </div>

                            </div>
                        </form>
                        <div class="col-12">
                            <div class="html_response">
                                <i class="fa fa-info-circle"></i> Silahkan isi form pencarian untuk mendapakan <span class="text-primary font-weight-bold">jadwal voyage</span> .
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
</section>