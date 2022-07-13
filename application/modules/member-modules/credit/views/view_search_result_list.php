<div class="col-md-12">
    <table class="table table-hover table_history" width="100%">
        <thead>
            <tr>
            <tr>
                <th>No</th>
                <th>kode</th>
                <th>Kode Invoice</th>
                <th>Nominal Piutang</th>
                <th>Angsuran</th>
                <th>Sisa Pembayaran</th>
                <th>Tgl Piutang</th>
                <th>Usia (hr)</th>
                <th>Status Jatuh Tempo</th>
                <th>Customer</th>

                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 0;
            $array_status = [
                0 => '<label class="label label-warning">Belum Lunas</label>',
                1 => '<label class="label label-success">Telah Lunas</label>',
                2 => '<label class="label label-default">Dibatalkan</label>'
            ];
            $grand_total_credit     = 0;
            $grand_total_has_paid   = 0;
            $grand_total_rejected   = 0;
            $grand_rest_credit     = 0;
            $jumlah_angsuran = 0;
            $array_list_data = [];
            foreach ($data_credit as $data_table) {
                $array_pattern_data = [];
                $id_encrypt = $this->encrypt->encode($data_table->id);
                $no++;
                if (strtotime(date('Y-m-d')) > strtotime($data_table->deadline)) {
                    //expired
                    $label_expired = $data_table->status ? '<label class="text-primary font-weight-bold">LUNAS</label>' : '<label class="text-danger font-weight-bold">Telah Jatuh Tempo</label>';
                    $array_pattern_data['status_jatuh_tempo'] = $data_table->status ? '-' : 'Telah Jatuh Tempo';
                } else {
                    //expired
                    $label_expired = $data_table->status ? '<label class="text-primary font-weight-bold">LUNAS</label>' : '<label class=" font-weight-bold">Belum Jatuh Tempo</label>';
                    $array_pattern_data['status_jatuh_tempo'] = $data_table->status ? '-' : 'Belum Jatuh Tempo';
                }
                //reject button
                $btn_reject = '';
                $btn_payment = '
                    <div class="dropdown-menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(76px, -174px, 0px);">
                        <a class="dropdown-item" href="' . base_url('admin/credit/add_payment?data=' . urlencode($id_encrypt)) . '"><i class="fa fa-send"></i> Masukan Pembayaran</a>
                    </div>
                ';
                if ($data_table->status) {
                    $btn_payment = '';
                }

                $tgl1 = strtotime($data_table->date);
                $tgl2 = strtotime(date('Y-m-d'));
                $jarak = $tgl2 - $tgl1;
                $hari = $jarak / 60 / 60 / 24;


                echo '
                        <tr>
                            <td>' . $no . '</td>
                            <td>' . $data_table->code . '</td>
                            <td>' . $data_table->invoice_code . '</td>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text" style="padding:0 10px;">Rp.</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm bg-white" readonly value="' . number_format($data_table->price, 0, '.', '.') . '">
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text" style="padding:0 10px;">Rp.</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm bg-white" readonly value="' . number_format($data_table->total_payment, 0, '.', '.') . '">
                                </div>
                                <small>Jml Angsuran :</small> <span class="badge badge-primary"> ' . $data_table->count_paid . ' Kali</span>
                            </td>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text" style="padding:0 10px;">Rp.</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm bg-white" readonly value="' . number_format($data_table->rest_credit, 0, '.', '.') . '">
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-primary">Tgl Piutang</span><br>' . Modules::run('helper/date_indo',  $data_table->date, '-') . '<span class="badge badge-primary">Tgl Jatuh Tempo</span><br>' . Modules::run('helper/date_indo',  $data_table->deadline, '-') . '
                            </td>
                            <td>' . round($hari) . '</td>
                            <td>' . $label_expired . '</td>
                            <td>' .  $data_table->member_name . '</td>
                            <td>
                                <div class="btn-group mt-1 mr-1">
                                    <a class="btn btn-primary" href="' . base_url('admin/credit/detail?data=' . urlencode($id_encrypt)) . '" class="btn btn-default btn_link">Detail</a>
                                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    </button>
                                    ' . $btn_payment . '
                                </div>
                            </td>
                        </tr>
                    ';

                $grand_total_credit += $data_table->price;
                $grand_total_has_paid += $data_table->total_payment;
                if ($data_table->status == 2) {
                    $grand_total_rejected += $data_table->price;
                }
                $grand_rest_credit += $data_table->rest_credit;
                $jumlah_angsuran +=  $data_table->count_paid;


                $array_pattern_data = [
                    'invoice_code' => $data_table->invoice_code,
                    'total_piutang' => $data_table->price,
                    'total_bayar' => $data_table->total_payment,
                    'total_angsuran' => $data_table->count_paid,
                    'sisa_piutang' => $data_table->rest_credit,
                    'tgl_piutang' => $data_table->date,
                    'tgl_jatuh_tempo' => $data_table->deadline,
                    'status_lunas' => $data_table->status,
                    'customer' => $data_table->member_name,
                    'usia' => round($hari)
                ];
                if (strtotime(date('Y-m-d')) > strtotime($data_table->deadline)) {
                    $array_pattern_data['status_jatuh_tempo'] = $data_table->status ? '-' : 'Telah Jatuh Tempo';
                } else {
                    //expired
                    $array_pattern_data['status_jatuh_tempo'] = $data_table->status ? '-' : 'Belum Jatuh Tempo';
                }
                $array_list_data['data_print'][] = $array_pattern_data;
            }
            $grand_rest_credit = $grand_rest_credit - $grand_total_rejected;
            $array_list_data['resume'] = [
                'total_piutang' => $grand_total_credit,
                'telah_bayar' => $grand_total_has_paid,
                'belum_bayar' => $grand_rest_credit,
                'jumlah_angsuran' => $jumlah_angsuran
            ];
            $array_list_data['param'] = $data_param;
            $data_print_encrypt = $this->encrypt->encode(json_encode($array_list_data));
            ?>
            <!-- </tbody>
        <tfoot>
            <tr>
                <th class="text-right" colspan="8">Total piutang</th>
                <th>:</th>
                <th colspan="3"><b>Rp.<?= number_format($grand_total_credit, 0, '.', '.'); ?></b></th>
            </tr>
            <tr>
                <th class="text-right" colspan="8">Total telah Dibayar</th>
                <th>:</th>
                <th colspan="3"><b>Rp.<?= number_format($grand_total_has_paid, 0, '.', '.'); ?></b></th>
            </tr>
            <tr>
                <th class="text-right" colspan="8">Sisa Belum Dibayar</th>
                <th>:</th>
                <th colspan="3"><b>Rp.<?= number_format($grand_rest_credit, 0, '.', '.'); ?></b></th>
            </tr>
        </tfoot> -->
    </table>
    <div class="row justify-content-end mt-3">
        <h3 class="text-right col-12">Resume :</h3>
        <div class="col-md-2 border">
            <div class="media my-2">
                <div class="media-body">
                    <p class="text-muted mb-2">Total Piutang</p>
                    <h5 class="mb-0">Rp.<?= number_format($grand_total_credit, 0, '.', '.'); ?> </h5>
                </div>
                <div class="icons-lg ml-2 align-self-center">
                    <span class="uim-svg" style=""><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="1em">
                            <path class="uim-quaternary" d="M12,14.19531a1.00211,1.00211,0,0,1-.5-.13379l-9-5.19726a1.00032,1.00032,0,0,1,0-1.73242l9-5.19336a1.00435,1.00435,0,0,1,1,0l9,5.19336a1.00032,1.00032,0,0,1,0,1.73242l-9,5.19726A1.00211,1.00211,0,0,1,12,14.19531Z"></path>
                            <path class="uim-tertiary" d="M21.5,11.13184,19.53589,9.99847,12.5,14.06152a1.0012,1.0012,0,0,1-1,0L4.46411,9.99847,2.5,11.13184a1.00032,1.00032,0,0,0,0,1.73242l9,5.19726a1.0012,1.0012,0,0,0,1,0l9-5.19726a1.00032,1.00032,0,0,0,0-1.73242Z"></path>
                            <path class="uim-primary" d="M21.5,15.13184l-1.96411-1.13337L12.5,18.06152a1.0012,1.0012,0,0,1-1,0L4.46411,13.99847,2.5,15.13184a1.00032,1.00032,0,0,0,0,1.73242l9,5.19726a1.0012,1.0012,0,0,0,1,0l9-5.19726a1.00032,1.00032,0,0,0,0-1.73242Z"></path>
                        </svg></span>
                </div>
            </div>
        </div>
        <div class="col-md-2 border">
            <div class="media my-2">
                <div class="media-body">
                    <p class="text-muted mb-2">Telah Dibayar</p>
                    <h5 class="mb-0">Rp.<?= number_format($grand_total_has_paid, 0, '.', '.'); ?></h5>
                </div>
                <div class="icons-lg ml-2 align-self-center">
                    <span class="uim-svg" style=""><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="1em">
                            <path class="uim-quaternary" d="M12,14.19531a1.00211,1.00211,0,0,1-.5-.13379l-9-5.19726a1.00032,1.00032,0,0,1,0-1.73242l9-5.19336a1.00435,1.00435,0,0,1,1,0l9,5.19336a1.00032,1.00032,0,0,1,0,1.73242l-9,5.19726A1.00211,1.00211,0,0,1,12,14.19531Z"></path>
                            <path class="uim-tertiary" d="M21.5,11.13184,19.53589,9.99847,12.5,14.06152a1.0012,1.0012,0,0,1-1,0L4.46411,9.99847,2.5,11.13184a1.00032,1.00032,0,0,0,0,1.73242l9,5.19726a1.0012,1.0012,0,0,0,1,0l9-5.19726a1.00032,1.00032,0,0,0,0-1.73242Z"></path>
                            <path class="uim-primary" d="M21.5,15.13184l-1.96411-1.13337L12.5,18.06152a1.0012,1.0012,0,0,1-1,0L4.46411,13.99847,2.5,15.13184a1.00032,1.00032,0,0,0,0,1.73242l9,5.19726a1.0012,1.0012,0,0,0,1,0l9-5.19726a1.00032,1.00032,0,0,0,0-1.73242Z"></path>
                        </svg></span>
                </div>
            </div>
        </div>
        <div class="col-md-2 border">
            <div class="media my-2">
                <div class="media-body">
                    <p class="text-muted mb-2">Belum Dibayar</p>
                    <h5 class="mb-0">Rp.<?= number_format($grand_rest_credit, 0, '.', '.'); ?></h5>
                </div>
                <div class="icons-lg ml-2 align-self-center">
                    <span class="uim-svg" style=""><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="1em">
                            <path class="uim-quaternary" d="M12,14.19531a1.00211,1.00211,0,0,1-.5-.13379l-9-5.19726a1.00032,1.00032,0,0,1,0-1.73242l9-5.19336a1.00435,1.00435,0,0,1,1,0l9,5.19336a1.00032,1.00032,0,0,1,0,1.73242l-9,5.19726A1.00211,1.00211,0,0,1,12,14.19531Z"></path>
                            <path class="uim-tertiary" d="M21.5,11.13184,19.53589,9.99847,12.5,14.06152a1.0012,1.0012,0,0,1-1,0L4.46411,9.99847,2.5,11.13184a1.00032,1.00032,0,0,0,0,1.73242l9,5.19726a1.0012,1.0012,0,0,0,1,0l9-5.19726a1.00032,1.00032,0,0,0,0-1.73242Z"></path>
                            <path class="uim-primary" d="M21.5,15.13184l-1.96411-1.13337L12.5,18.06152a1.0012,1.0012,0,0,1-1,0L4.46411,13.99847,2.5,15.13184a1.00032,1.00032,0,0,0,0,1.73242l9,5.19726a1.0012,1.0012,0,0,0,1,0l9-5.19726a1.00032,1.00032,0,0,0,0-1.73242Z"></path>
                        </svg></span>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3 text-right">
        <form method="POST" action="<?= base_url('admin/credit/print_credit'); ?>">
            <small>(* Klik untuk cetak data)</small>
            <input type="hidden" name="data" value="<?= $data_print_encrypt; ?>">
            <button type="submit" class="btn btn-primary">CETAK EXCEL</button>
        </form>
    </div>

</div>