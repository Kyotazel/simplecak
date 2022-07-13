<div class="col-12">
    <h3>Daftar Booking Slot</h3>
    <div class="col-12">
        <?php
        $data['data_bs'] = $data_bs;
        $html_detail_item = $this->load->view('_partials_detail_countainer_lc/component_item_booking_countainer_lc', $data, TRUE);
        echo $html_detail_item;
        ?>
    </div>
</div>