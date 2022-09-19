<div class="row">
    <div class="col-md-12 text-center">
        <h2 class="text-uppercase">* <?= $data_current->name ?> *</h2>
        <div class="bd-b mt-3"></div>
    </div>
    <div class="col-md-6 mt-4">
        <table class="table">
            <tr class="bd-y">
                <td style="width: 30%;">Nama Acara</td>
                <td style="width: 10%;" class="text-center"> : </td>
                <td><?= $data_current->name ?></td>
            </tr>
            <tr class="bd-b">
                <td>Tipe Soal</td>
                <td class="text-center">:</td>
                <td><?= $type ?></td>
            </tr>
            <tr class="bd-b">
                <td>Waktu Pengerjaan</td>
                <td class="text-center">:</td>
                <td><?= $data_current->processing_time ?> Menit</td>
            </tr>
            <tr class="bd-b">
                <td>Tanggal Dibuat</td>
                <td class="text-center">:</td>
                <td><?= Modules::run('helper/date_indo', $data_current->date, '-') ?></td>
            </tr>
        </table>
        <?php if ($data_current->status == 0) : ?>
            <div class="bd bd-primary mb-2">
                <div class="m-4">
                    <div class="text-center">
                        <p>Silahkan <b>Masukkan Password</b> dan klik <b>Tombol Mulai Ujian</b> untuk memulai ujian ini <b>TERIMAKASIH.</b></p>
                        <input class="form-control input-lg" id="confirm_password" name="confirm_password" type="password" placeholder="konfirmasi password akun anda">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
            </div>
            <button type="button" onclick="confirm_exam('<?= $data_current->id ?>')" class="btn btn-block btn-success"><i class="fa fa-desktop"></i> Mulai Ujian</button>
            <button type="button" onclick="cancel_exam('<?= $data_current->id ?>')" class="btn btn-block btn-light m-0"><i class="fa fa-times"></i> Batalkan</button>
        <?php else : ?>
            <?php
            $status = '';
            if ($data_current->status == 3) {
                $status .= "DIBATALKAN";
            } else {
                $status .= "SELESAI";
            }
            ?>
            <div class="card bg-light">
                <div class="m-5 text-center text-dark">
                    <h4>UJIAN INI TELAH <?= $status ?> PADA :</h4>
                    <h4><?= $data_current->date_close ?></h4>
                </div>
            </div>
        <?php endif ?>
    </div>
    <div class="col-md-6 mt-4">
        <div class="section1">
            <div class="mb-2">Diikuti Oleh : </div>
            <?php foreach ($batch as $value) {
                echo "<div class='btn btn-outline-primary'>$value->title</div>";
            } ?>
        </div>
        <div class="bd-b mt-5"></div>
        <div class="section2 mt-2">
            <?php
            $btn_random = '';
            if ($data_current->random_status == 1) {
                $btn_random .= '<div class="btn btn-sm btn-outline-success">Iya</div>';
            } else {
                $btn_random .= '<div class="btn btn-sm btn-outline-danger">Tidak</div>';
            }

            $btn_show = '';
            if ($data_current->show_value_status == 1) {
                $btn_show .= '<div class="btn btn-sm btn-outline-success">Iya</div>';
            } else {
                $btn_show .= '<div class="btn btn-sm btn-outline-danger">Tidak</div>';
            }
            ?>
            <table class="table">
                <tr>
                    <td>Pengaturan : </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="width: 40%;">Acak Soal</td>
                    <td style="width: 10%;" class="text-center"> : </td>
                    <td><?= $btn_random ?></td>
                </tr>
                <tr>
                    <td style="width: 40%;">Tampilkan Hasil Ujian</td>
                    <td style="width: 10%;" class="text-center"> : </td>
                    <td><?= $btn_show ?></td>
                </tr>
            </table>
        </div>
        <div class="bd-b mt-3"></div>
        <div class="section3 mt-3">
            <h6>Paket Tersedia : </h6>
            <table class="table table-hover table-bordered">
                <?php $no = 1 ?>
                <tr>
                    <th>No</th>
                    <th>Paket Soal</th>
                </tr>
                <?php foreach ($package as $value) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $value->package_name ?></td>
                    </tr>
                <?php endforeach ?>
            </table>
        </div>
    </div>
</div>