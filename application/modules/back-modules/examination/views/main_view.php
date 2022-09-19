<div class="card my-4" id="here">
    <div class="card-body">
        <h5><i class="fa fa-desktop"></i> UJIAN BERLANGSUNG</h5>
        <div class="row my-3" id="html_active_exam">
            <!-- <div class="col-md-12">
                <h2>TIDAK ADA UJIAN BERLANGSUNG</h2>
            </div> -->
        </div>
    </div>
</div>

<div class="bd-b"></div>

<div class="card mt-5">
    <div class="card-body">
        <h4 class="card_title"><?= $page_title ?></h4>
        <div class="">
            <ul class="nav nav-tabs mb-3" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="tab-2-1" data-toggle="tab" href="#home-2-1" role="tab" aria-controls="home-2-1" aria-selected="true"><i class="fa fa-desktop"></i> Ujian Baru</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-2-2" data-toggle="tab" href="#profile-2-2" role="tab" aria-controls="profile-2-2" aria-selected="false"><i class="fa fa-check"></i> Telah Selesai</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-2-3" data-toggle="tab" href="#contact-2-3" role="tab" aria-controls="contact-2-3" aria-selected="false"><i class="fa fa-times"></i> Dibatalkan</a>
                </li>
            </ul>
            <div class="bd">
                <div class="m-4">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="home-2-1" role="tabpanel" aria-labelledby="tab-2-1">
                            <div class="col-12">
                                <div class="d-flex table-responsive">
                                    <div class="btn-group mr-2">
                                        <a href="javascript:void()" onclick="add()"><button class="btn btn-info mt-2"><i class="mdi mdi-plus-circle-outline"></i> TAMBAH DATA</button></a>
                                    </div>
                                </div>
                                <span class="clearfix"></span>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered" id="table-examination" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>NAMA UJIAN</th>
                                                <th>TIPE SOAL</th>
                                                <th>STATUS</th>
                                                <th width="50px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="profile-2-2" role="tabpanel">
                        <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered" id="table_finished_exam" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal Ujian</th>
                                                <th>NAMA UJIAN</th>
                                                <th>TIPE SOAL</th>
                                                <th>STATUS</th>
                                                <th width="50px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="contact-2-3" role="tabpanel">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered" id="table_canceled_exam" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal Ujian</th>
                                                <th>NAMA UJIAN</th>
                                                <th>TIPE SOAL</th>
                                                <th>STATUS</th>
                                                <th width="50px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-examination" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document" style="width:80%;">
        <div class="modal-content" style="background-color:#fff;">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form_input">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group" align="center">
                                <label>Nama Acara Ujian</label>
                                <input type="text" name="name" placeholder="masukan nama ujian.." class="form-control form-control-lg">
                                <div class="is-invalid"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tipe Soal</label>
                                <select class="form-control select2" id="id_type_package" name="id_type_package" onchange="get_package()">
                                    <?php
                                    foreach ($package_category as $value) {
                                        echo '<option value="' . $value->id . '">' . $value->name . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Waktu Pengerjaan </label>
                                <div class="input-group">
                                    <input type="text" aria-describedby="basic-addon2" name="time_processing" placeholder="masukan waktu pengerjaan soal.." class="form-control border-right-0" />
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">Menit</span>
                                    </div>
                                </div>
                                <div class="is-invalid"></div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <label for="id_batch_course">Gelombang dipilih</label>
                            <select name="id_batch_course[]" id="id_batch_course" class="form-control select2" multiple="multiple">
                                <?php
                                foreach ($batch_registration as $value) {
                                    echo "<option value=$value->id> $value->title</option>";
                                }
                                ?>
                            </select>
                            <div class="form-group border-blue" style="padding:10px;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label><u>Acak Soal</u></label>
                                        <table width="100%">
                                            <tr>
                                                <td>
                                                    <label class="cover-rdo" style="font-size:17px;">
                                                        <input type="radio" value="1" name="random_status">
                                                        <span class="checkmark"></span>
                                                        Iya
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="cover-rdo" style="font-size:17px;">
                                                        <input type="radio" value="0" checked name="random_status">
                                                        <span class="checkmark"></span>
                                                        Tidak
                                                    </label>
                                                </td>
                                            </tr>
                                        </table>
                                        <span id="notif_time_processing" class="help-block"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label><u>Tampilkan Hasil Ujian</u></label>
                                        <table width="100%">
                                            <tr>
                                                <td>
                                                    <label class="cover-rdo" style="font-size:17px;">
                                                        <input type="radio" value="1" name="show_value">
                                                        <span class="checkmark"></span>
                                                        Iya
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="cover-rdo" style="font-size:17px;">
                                                        <input type="radio" checked value="0" name="show_value">
                                                        <span class="checkmark"></span>
                                                        Tidak
                                                    </label>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group html_content_package"></div>
                        </div>

                    </div>
                </form>
                <hr>
                <div class="form-group" style="padding:0 200px;" align="center">
                    <div align="center">
                        <label><input type="checkbox" name="agree" id="agree" style="width:20px;height:20px;"></label>
                        <label style="font-size:20px;">Saya Setuju</label>
                        <span class="help-block" id="notif_aggree" style="color:red;font-size:12px;"></span>
                    </div>
                    <p style="font-size:12px;">Dengan ini saya menyetujui peembuatan akun UJIIAN Sesuai Data.</p>
                </div>

                <div class="col-md-12" align="center">
                    <button type="button" class="btn btn-success btn-lg btn_save">Buat Ujian Online</button>
                </div>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_detail_account" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" style="background-color:#fff;">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="html_detail_account"></div>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<!-- Modal Ends -->

<div class="modal fade" id="modal_confirm_account" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="">
      <div class="modal-body" style="padding:10px;">
        <div align="center"><span align="center" class="notif_validate" style="color:red;"></span></div>
        <div class="form-group" align="center">
          <label>KONFIRMASI PASSWORD</label>
          <input type="password" id="confirm_password_login" class="form-control form-control-lg ">
        </div>
        <div class="hidden_element"></div>
        <div class="form-group" align="center">
          <button type="button" onclick="validate_monitoring_exam()" class="btn btn-success btn-lg">Konfirmasi</button>
        </div>
      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>
</div>