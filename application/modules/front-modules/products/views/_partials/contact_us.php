<div class="row  pt-md-4  pt-4 pb-lg-4 justify-content-center bg-light">
    <div class="col-12 text-center">
        <div class="section-title">
            <h4 class="title mb-4">Jasa Pembuatan Website Terbaik Untuk anda</h4>
            <p class="text-muted para-desc mx-auto">Masih bingung? Hubungi kami sekarang untuk konsultasi gratis tentang aplikasi / website yang anda ingin miliki .</p>
            <a href="<?= base_url('company/contact'); ?>" class="btn btn-primary m-1"><i class="uil uil-envelope"></i> Diskusikan Projectmu Yuk</a>
            <a href="https://api.whatsapp.com/send?phone=62<?= substr($company_number_phone, 1, strlen($company_number_phone)); ?>&text=<?= $whatsapp_message['common']; ?>" target="_blank" class="btn btn-success m-1"><i class="uil uil-whatsapp"></i> Chat WhatsApp</a>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->