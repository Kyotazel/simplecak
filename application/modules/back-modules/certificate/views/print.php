<html>

<style>
    .times {
        font-family: Times;
    }
</style>

<body style="margin: 0;">
    <div style="border: double 8px black; height: 93%">
        <table style="width: 100%; margin-top: 20px;">
            <tr>
                <td style="width: 20%;">
                    <img src="<?= base_url('assets/') ?>img/jatim.png" style="height: 125px;">
                </td>
                <td style="text-align: center; width: 60%">
                    <b style="text-align: center; font-size: 24px;" class="times">PEMERINTAH PROVINSI JAWA TIMUR</b><br>
                    <b style="text-align: center; font-size: 20px;" class="times">DINAS TENAGA KERJA DAN TRANSMIGRASI</b><br>
                    <b><u style="text-align: center; font-size: 28px;" class="times">UPT BALAI LATIHAN KERJA SURABAYA</u></b><br>
                    <img src="<?= base_url('assets/') ?>img/asdasdas.png" alt="" style="height: 40px; margin-top: 8px"><br>
                    <u><i>Certificate</i></u><br><br>
                    <b>Nomor Peserta : <?= $no_peserta ?></b><br>
                    <i>Participant Number : <?= $no_peserta ?></i>
                </td>
                <td style="width:20%">
                    <img src="<?= base_url('assets/') ?>img/iso.png" style="height: 110px; float: right">
                </td>
            </tr>
        </table>
        <div style="margin-left: 16px">
            <br>
            <b style="font-size: 16px;">Kepala Unit Pelaksana Teknis Balai Latihan Kerja Surabaya Berdasarkan Surat Keputusan Penyelenggaraan Pelatihan</b><br>
            <i>Head of The Technical Implementation Unit of Surabaya Vocational Training Center Based on The Decree of Training Organization</i><br>
            <b style="font-size: 16px;">No. <?= $no_sk ?> Tanggal <?= Modules::run('helper/date_indo', $sk_date, '-') ?> menyatakan, bahwa :</b><br>
            <i>No. <?= $no_sk ?> dated <?= Modules::run('helper/change_date', $sk_date, '-') ?> declares, that :</i>
            <table style="margin-top: 20px; width: 100%">
                <tr>
                    <td style="width: 22%;">
                        <b style="font-size: 16px;">Nama</b><br>
                        <i>Name</i>
                    </td>
                    <td style="text-align:center; width:3%;"><b style="font-size: 20px;">:</b></td>
                    <td style="width: 75%;" style="font-size: 21px;"><b><?= strtoupper($data->name) ?></b></td>
                </tr>
                <tr>
                    <td style="width: 22%;">
                        <b style="font-size: 16px;">Tempat dan Tanggal Lahir</b><br>
                        <i>Place and date of birth</i>
                    </td>
                    <td style="text-align:center; width:3%;"><b style="font-size: 20px;">:</b></td>
                    <td style="width: 75%;" style="font-size: 21px;"><b><?= $data->birth_place . ', ' . Modules::run('helper/date_indo', $data->birth_date, '-') ?> </b></td>
                </tr>
                <tr>
                    <td style="width: 22%;">
                        <b style="font-size: 16px;">Alamat</b><br>
                        <i>Address</i>
                    </td>
                    <td style="text-align:center; width:3%;"><b style="font-size: 20px;">:</b></td>
                    <td style="width: 75%;" style="font-size: 21px;"><b><?= $data->address ?> </b></td>
                </tr>
            </table>
            <div style="text-align: center;">
            <br>
                <b style="font-size: 18px;">TELAH MENGIKUTI</b><br>
                <i>Have Followed</i>
            </div>
            <div>
                <b style="font-size: 16px;"><?= $data->title ?> dari tanggal <?= Modules::run('helper/date_indo', $data->starting_date, '-') ?> sampai dengan <?= Modules::run('helper/date_indo', $data->ending_date, '-') ?></b><br>
                <i>Competency Based Training Vocational MULTIMEDIA From <?= Modules::run('helper/change_date', $data->starting_date, '-') ?> up to <?= Modules::run('helper/change_date', $data->ending_date, '-') ?></i><br>
                <b style="font-size: 16px;">(<?= $jp ?> JP) <?= $kompetensi ?></b><br>
                <i>(<?= $jp ?> JP) <?= $kompetensi_en ?></i>
            </div>
            <table style="width: 100%;">
                <tr>
                    <td style="width: 43%; text-align:center">
                        <img src="<?= base_url('upload/') ?>/barcode/<?= $qrcode ?>" alt="" style="height: 140px">
                    </td>
                    <td style="width: 14%; text-align:center">
                    <?php if($data->photo == '') : ?>
                        <img src="<?= base_url('upload/') ?>/member/1668143398667.jpg" alt="" style="height: 140px">
                    <?php else: ?>
                        <img src="<?= base_url('upload/') ?>/member/<?= $data->photo ?>" alt="" style="height: 140px">
                    <?php endif ?>
                    </td>
                    <td style="width: 43%; text-align:center;">
                        Surabaya, <?= Modules::run('helper/date_indo', date('Y-m-d'), '-') ?> <br>
                        <b style="font-size: 16px;">Plt.Kepala UPT Balai Latihan Kerja Surabaya</b> <br>
                        Head on Duty of Surabaya Vocational Training Center
                        <br><br><br><br><br>
                        <b><u style="font-size: 16px;">SUNARYA, S.E.,M.M.</u></b> <br>
                        Pembina Tk.I <br>
                        NIP.19670812 199003 1 013 <br>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <p style="margin: 0; margin-left: 12px">Per.Menakertrans R.I. No. 08 Tahun 2014</p>
</body>

</html>