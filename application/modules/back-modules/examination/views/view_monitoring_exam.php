<?php
if ($data_exam['random_status']) {
    $label_random = ' <label style="font-size:16px;" class="badge badge-success">Iya</label>';
} else {
    $label_random = ' <label style="font-size:16px;" class="badge badge-danger">Tidak</label>';
}
//create sho value
if ($data_exam['show_value_status']) {
    $label_show_value = ' <label style="font-size:16px;" class="badge badge-success">Iya</label>';
} else {
    $label_show_value = ' <label style="font-size:16px;" class="badge badge-danger">Tidak</label>';
}
?>

<div class="col-md-12">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card" id="html_exam_description">
                <div class="card-body">
                    <div align="center">
                        <h4 align="center" class="card-title mb-0 text-dark"><?= strtoupper($data_exam['name']); ?></h4>
                    </div>
                    <label>&nbsp;</label>
                    <div class="row">
                        <div class="col-md-6">
                            <table style="font-size:13px;">
                                <tr>
                                    <td width="180px">Nama Acara</td>
                                    <td>: </td>
                                    <td><label class="ml-2 btn btn-sm btn-outline-primary"><?= $data_exam['name']; ?></label></td>
                                </tr>
                                <tr>
                                    <td>Tipe Soal</td>
                                    <td>: </td>
                                    <td><label class="ml-2 btn btn-sm btn-outline-primary"><?= $category['name'] ?></label></td>
                                </tr>
                                <tr>
                                    <td>Waktu Pengerjaan</td>
                                    <td>: </td>
                                    <td><label class="ml-2 btn btn-sm btn-outline-primary"><?= $data_exam['processing_time'] . '&nbsp;Menit'; ?></label></td>
                                </tr>
                                <tr>
                                    <td>Dibuka</td>
                                    <td>: </td>
                                    <td><label class="ml-2 btn btn-sm btn-outline-primary"><?= $data_exam['date_open'] ?></label></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table style="font-size:13px;">
                                <tr>
                                    <td width="180px">Acak Soal</td>
                                    <td>: </td>
                                    <td><?= $label_random; ?></td>
                                </tr>
                                <tr>
                                    <td width="180px">Tampilan Hasil Soal</td>
                                    <td>: </td>
                                    <td><?= $label_show_value; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <p align="center" class="">( *silahkan <b>Klik</b> tombol dibawah ini untuk menutup ujian )</p>
                            <button type="button" class="btn btn-success btn-lg" onclick="recapitulation_exam()" style="width:90%;">TUTUP ACARA UJIAN</button>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mt-5">
    <div class="card-body">
        <div class="row">
            <h5 class="col-md-5 mb-3">
                <label class="badge badge-primary" for="id_batch_course">Pelatihan : </label>
                <select class="form-control select2" name="id_batch_course" id="id_batch_course">
                    <?php
                    foreach ($batch_course as $value) {
                        echo '<option value="' . $value->id . '">' . $value->title . '</option>';
                    }
                    ?>
                </select>
            </h5>
        </div>
        <div class="">
            <div class="bd">
                <div class="m-4">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="home-2-1" role="tabpanel" aria-labelledby="tab-2-1">
                            <div class="col-12">
                                <div class="d-flex table-responsive">
                                    <div class="btn-group mr-2">
                                        <!-- <a href="javascript:void()" onclick="add()"><button class="btn btn-info mt-2"><i class="mdi mdi-plus-circle-outline"></i> TAMBAH DATA</button></a> -->
                                    </div>
                                </div>
                                <span class="clearfix"></span>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered" id="table_recap" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>NAMA PESERTA</th>
                                                <th>PELATIHAN</th>
                                                <th>WAKTU MULAI</th>
                                                <th>STATUS</th>
                                                <th>NILAI UJIAN</th>
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

<div class="modal fade" id="modal_recap" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="">
      <div class="modal-body" style="padding:10px;">
        <div align="center"><span align="center" class="notif_validate" style="color:red;"></span></div>
        <div class="form-group" align="center">
          <label>TUTUP UJIAN</label>
          <input type="password" id="confirm_password_recap" class="form-control form-control-lg ">
        </div>
        <div class="hidden_element"></div>
        <div class="form-group" align="center">
          <button type="button" onclick="recap_confirm()" class="btn btn-success btn-lg">Tutup Ujian</button>
        </div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>