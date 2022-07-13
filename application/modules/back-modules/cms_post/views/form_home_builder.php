<div class="col-12 p-0">
    <iframe name="iframe1" style="width: 100%;min-height:800px;border-style: none" src="<?= base_url('?token=' . urldecode($this->encrypt->encode($this->session->userdata('us_token')))); ?>"></iframe>
</div>