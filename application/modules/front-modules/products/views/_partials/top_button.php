<div class="mt-4 pt-2">
    <a href="<?= base_url('company/contact'); ?>" class="btn btn-primary m-1"><i class="uil uil-envelope"></i> Diskusikan Projectmu Yuk</a>
    <a href="https://api.whatsapp.com/send?phone=62<?= substr($company_number_phone, 1, strlen($company_number_phone)); ?>&text=<?= $whatsapp_message['common']; ?>" target="_blank" class="btn btn-success m-1"><i class="uil uil-whatsapp"></i> Chat WhatsApp</a>
</div>