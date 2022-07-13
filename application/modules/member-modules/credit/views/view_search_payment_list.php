<div class="col-md-12">
    <table class="table table-hover table_history" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>kode</th>
                <th>Kode Invoice</th>
                <th>Tanggal Piutang</th>
                <th>Sebelum Dibayar</th>
                <th>Setelah Dibayar</th>
                <th>Tgl Pembayaran</th>
                <th>Status piutang</th>
                <th>Petugas</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $counter = 0;
            $array_list_data = [];
            foreach ($data_credit as $item_credit) {
                $array_pattern = [];
                $counter++;
                $label_status  = $item_credit->status ? '<label class="text-primary font-weight-bold">Lunas</label>' : '<label class="font-weight-bold">Belum Lunas</label>';
                $text_status = $item_credit->status ? 'Lunas' : 'Belum Lunas';


                echo '
                    <tr>
                        <td>' . $counter . '</td>
                        <td>' . $item_credit->code . '</td>
                        <td>' . $item_credit->invoice_code . '</td>
                        <td>' . Modules::run('helper/date_indo', $item_credit->date_credit, '-') . '</td>
                        <td class="border">
                            <small>Jumlah Piutang :</small>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text" style="padding:0 10px;">Rp.</div>
                                </div>
                                <input type="text" class="form-control form-control-sm bg-white" readonly value="' . number_format($item_credit->price_credit, 0, '.', '.') . '">
                            </div>
                            <small>Sisa Piutang :</small>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text" style="padding:0 10px;">Rp.</div>
                                </div>
                                <input type="text" class="form-control form-control-sm bg-white" readonly value="' . number_format($item_credit->credit_price, 0, '.', '.') . '">
                            </div>
                        </td>
                        <td class="border">
                            <small>Jumlah Pembayaran :</small>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text" style="padding:0 10px;">Rp.</div>
                                </div>
                                <input type="text" class="form-control form-control-sm bg-white" readonly value="' . number_format($item_credit->payment_price, 0, '.', '.') . '">
                            </div>
                            <small>Sisa tanggungan :</small>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text" style="padding:0 10px;">Rp.</div>
                                </div>
                                <input type="text" class="form-control form-control-sm bg-white" readonly value="' . number_format($item_credit->rest_credit, 0, '.', '.') . '">
                            </div>
                        </td>
                        <td>' . Modules::run('helper/date_indo', $item_credit->date, '-') . '</td>
                        <td>' . $label_status . '</td>
                        <td>' . $item_credit->user_name . '</td>
                    </tr>
                ';

                $array_pattern = [
                    'invoice' => $item_credit->invoice_code,
                    'tanggal_piutang' => $item_credit->date_credit,
                    'total_piutang' => $item_credit->price_credit,
                    'sisa_piutang' => $item_credit->credit_price,
                    'jumlah_bayar' => $item_credit->payment_price,
                    'sisa_tanggugan' => $item_credit->rest_credit,
                    'tanggal_bayar' => $item_credit->date,
                    'status_piutang' => $text_status
                ];
                $array_list_data['data_print'][] = $array_pattern;
            }
            $array_list_data['param'] = $params;
            $data_print = $this->encrypt->encode(json_encode($array_list_data));

            ?>
        </tbody>
    </table>
    <div class="mt-3 text-right">
        <form method="POST" action="<?= base_url('admin/credit/print_payment'); ?>">
            <input type="hidden" name="data_print" value="<?= $data_print; ?>">
            <small>(*klik untuk cetak)</small>
            <button type="submit" class="btn btn-primary">CETAK EXCEL</button>
        </form>
    </div>


</div>