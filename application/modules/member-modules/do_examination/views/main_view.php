<div class="row my-3">
    <div class="col-md-12 text-center">
        <p style="font-size: 20px;" class="text-primary inline" id="timer">0 Jam : 10 Menit : 30 Detik<b> | </b></p>
    </div>
</div>

<div class="container">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="p-2">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h4 class="text-info text-uppercase"><?= $participant->title ?></h4>
                            <p class="text-muted">Pembuat Soal : <b><?= $participant->creator ?></b></p>
                            <hr class="my-4">
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-3">Nama Siswa</div>
                                        <div class="col-md-9"> : <b><?= $this->session->userdata('member_name') ?></b></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">Pelatihan</div>
                                        <div class="col-md-9"> : <b><?= $participant->batch_name ?></b></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-3">Nama Ujian</div>
                                        <div class="col-md-9"> : <b><?= $participant->name ?></b></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">Waktu</div>
                                        <div class="col-md-9"> : <b><?= $participant->processing_time ?> Menit</b></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div id="html_question"></div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 pagination-html" align="center"></div>
    <div class="col-md-4" align="center">
        <button type="button" onclick="show_resume_answer()" style="width:300px;" class="btn btn-lg btn-success"><i class="fa fa-save"></i> Selesai Ujian</button>
    </div>
</div>

<div class="time_element">
    <?php
    $time_element = json_decode($time_exam);
    echo '
			<input type="hidden" id="hour_exam" value="' . $time_element->hour . '">
			<input type="hidden" id="minute_exam" value="' . $time_element->minute . '">
			<input type="hidden" id="second_exam" value="' . $time_element->second . '">
		 ';
    ?>
</div>

<div class="modal fade" id="modal-check-question" data-backdrop="static" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content" style="background-color:#fff;">
        <div class="modal-header">
          <h5 class="modal-title">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <div class="modal-body">
       <div class="html_resume_answer"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="finish_agreement()"><i class="fa fa-save"></i> Submit Ujian</button>
        <button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-timeout-exam" data-backdrop="static" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="background-color:#fff;">
        <div class="modal-body" style="padding:10px;">
         <div class="form-group has-error" id="error_notif" style="color:red;" align="center" ></div>
         	<div align="center">
         		<i class="icon-ban text-danger" style="font-size:100px;"></i>
         	</div> 
          <h2 class="swal2-title" align="center">WAKTU UJIAN HABIS</h2>
          <p align="center">Maaf, anda tidak dapat melanjutkan ujian.</p>
          
          <div class="rating" align="center">
	          <a class="btn btn-danger btn-lg" href="<?php echo base_url('member-area'); ?>">Keluar</a>
          </div>
        </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-blocked-exam" data-backdrop="static" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="background-color:#fff;">
        <div class="modal-body" style="padding:10px;">
         <div class="form-group has-error" id="error_notif" style="color:red;" align="center" ></div>
         	<div align="center">
         		<i class="icon-ban text-danger" style="font-size:100px;"></i>
         	</div> 
          <h2 class="swal2-title" align="center">ANDA TELAH DIBLOKIR</h2>
          <p align="center">Maaf, anda tidak dapat melanjutkan ujian.</p>
          
          <div class="rating" align="center">
	          <a class="btn btn-danger btn-lg" href="<?php echo base_url('member-area/'); ?>">Keluar</a>
          </div>
        </div>
    </div>
  </div>
</div>