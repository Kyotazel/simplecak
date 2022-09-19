<div style="width: 100%;text-align:center;">
    <label style="display: block;">Kode Order :</label><br>
    <label for="" style="padding: 10px;font-size:20px;color: #fff;font-weight: 700;background-color: #0162e8;">
        <?= $data_bs->code; ?>
    </label>
    <p>
        Telah dibatalkan oleh admin<br><br>
        Catatan admin :
    <p style="border: 1px #ccc dashed;padding:10px;"><?= nl2br($data_bs->reject_note); ?></p>
    untuk detail transaksi silahkan klik tombol dibawah ini:
    </p>
    <a style="
        color: #fff;
        background: linear-gradient(to left, #efa65f, #f76a2d);
        border: 1px solid #efa65f;
        padding:10px 20px;
        border-radius:50px; 
        text-decoration:none;
        " href="<?= base_url('member-area/' . 'booking/detail?data=' . urlencode($this->encrypt->encode($data_bs->id))); ?>">Lihat Transaksi</a>
</div>