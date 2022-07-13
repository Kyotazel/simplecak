<div class="text-center" style="text-align: center;">
    <p>
        Silahkan klik tombol dibawah untuk reset password:
    </p>
    <a style="
        color: #fff;
        background: linear-gradient(to left, #efa65f, #f76a2d);
        border: 1px solid #efa65f;
        padding:10px 20px;
        border-radius:50px; 
        text-decoration:none;
        " href="<?= base_url('member-area/login/reset_password?key=' . urlencode($encrypt_key)); ?>">RESET PASSWORD</a>
</div>