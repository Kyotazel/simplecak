<div class="text-center" style="text-align: center;">
    <a style="
        color: #fff;
        background: linear-gradient(to left, #efa65f, #f76a2d);
        border: 1px solid #efa65f;
        padding:10px 20px;
        border-radius:50px; 
        text-decoration:none;
        " href="<?= base_url('admin/register_account/confirm_email?key=' . urlencode($encrypt_key)); ?>">KONFIRMASI EMAIL</a>

        <br><br>
        <p>Username : <b><?= $username ?></b></p>
        <p>Password : <b><?= $password ?></b> </p>
</div>