<div class="card">
    <div class="card-header">
        <h3 class="col-md-8 card-title">Transaksi Menunggu Konfirmasi Admin</h3>
    </div>
    <div class="card-body">
        <?php
        $html_respon = '';
        foreach ($get_data as $data_table) {
            $id_encrypt = $this->encrypt->encode($data_table->id);
            $data['data_bs'] = $data_table;
            $html_respon .= $this->load->view('_partials/component_order', $data, TRUE);
        }

        if (empty($get_data)) {
            $html_respon = '
                     <div class="col-12 text-center shadow-3 p-3">
                         <div class="plan-card text-center">
                             <i class="fas fa-file plan-icon text-primary"></i>
                             <h6 class="text-drak text-uppercase mt-2">Data Kosong</h6>
                             <small class="text-muted">Tidak ada hasil pencarian.</small>
                         </div>
                     </div>
                 ';
        }
        echo $html_respon;
        ?>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modal_form_reject">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Input Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </div>
            <div class="modal-body">
                <form id="form-reject-data">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Catatan Pembatalan :</label>
                            <textarea name="note" class="form-control" id="" cols="30" rows="10"></textarea>
                            <span class="help-block notif_note"></span>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn_save_reject"><i class="fa fa-paper-plane"></i> Simpan Data</button>
            </div>
        </div>
    </div>
</div>