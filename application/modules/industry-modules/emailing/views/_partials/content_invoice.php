<div style="width: 100%;text-align:center;">
    <label style="display: block;">Kode Order :</label><br>
    <label for="" style="padding: 10px;font-size:20px;color: #fff;font-weight: 700;background-color: #0162e8;">
        <?= $data_invoice->booking_code; ?>
    </label>
    <p>
        Keterangan Invoice :<br>
    </p>
    <table style=" border-collapse: collapse;margin:0 auto;text-align:left;">
        <tr>
            <td style="
                        background-color:transparent; 
                        border-top-width: 1px;
                        padding: 7px;
                        border: 1px solid #dde2ef;
                        vertical-align:top;
                        width:200px;
                    ">
                Kode Invoice
            </td>
            <td style="
                        background-color:transparent; 
                        border-top-width: 1px;
                        padding: 7px;
                        border: 1px solid #dde2ef;
                        vertical-align:top;
                        width:10px;
                    ">
                :
            </td>
            <td style="
                        background-color:transparent; 
                        border-top-width: 1px;
                        padding: 7px;
                        border: 1px solid #dde2ef;
                        vertical-align:top;
                        width:200px;
                    ">
                <b>#<?= $data_invoice->code; ?></b>
            </td>
        </tr>
        <tr>
            <td style="
                        background-color:transparent; 
                        border-top-width: 1px;
                        padding: 7px;
                        border: 1px solid #dde2ef;
                        vertical-align:top;
                    ">
                Tanggal Invoice
            </td>
            <td style="
                        background-color:transparent; 
                        border-top-width: 1px;
                        padding: 7px;
                        border: 1px solid #dde2ef;
                        vertical-align:top;
                    ">
                :
            </td>
            <td style="
                        background-color:transparent; 
                        border-top-width: 1px;
                        padding: 7px;
                        border: 1px solid #dde2ef;
                        vertical-align:top;
                    ">
                <b><?= Modules::run('helper/date_indo', $data_invoice->invoice_date, '-'); ?></b>
            </td>
        </tr>
        <tr>
            <td style="
                        background-color:transparent; 
                        border-top-width: 1px;
                        padding: 7px;
                        border: 1px solid #dde2ef;
                        vertical-align:top;
                    ">
                Tanggal Jatuh Tempo
            </td>
            <td style="
                        background-color:transparent; 
                        border-top-width: 1px;
                        padding: 7px;
                        border: 1px solid #dde2ef;
                        vertical-align:top;
                    ">
                :
            </td>
            <td style="
                        background-color:transparent; 
                        border-top-width: 1px;
                        padding: 7px;
                        border: 1px solid #dde2ef;
                        vertical-align:top;
                    ">
                <b><?= Modules::run('helper/date_indo', $data_invoice->due_date, '-'); ?></b>
            </td>
        </tr>
        <tr>
            <td style="
                        background-color:transparent; 
                        border-top-width: 1px;
                        padding: 7px;
                        border: 1px solid #dde2ef;
                        vertical-align:top;
                    ">
                Jenis Invoice
            </td>
            <td style="
                        background-color:transparent; 
                        border-top-width: 1px;
                        padding: 7px;
                        border: 1px solid #dde2ef;
                        vertical-align:top;
                    ">
                :
            </td>
            <td style="
                        background-color:transparent; 
                        border-top-width: 1px;
                        padding: 7px;
                        border: 1px solid #dde2ef;
                        vertical-align:top;
                    ">
                <b>
                    <?php
                    $array_invoice = [1 => 'Freight', '2' => 'THC', '3' => 'Loss Cargo', 4 => 'Activity'];
                    $label_name = isset($array_invoice[$data_invoice->type]) ? $array_invoice[$data_invoice->type] : '-';
                    echo $label_name;
                    ?>
                </b>
            </td>
        </tr>
        <tr>
            <td style="
                        background-color:transparent; 
                        border-top-width: 1px;
                        padding: 7px;
                        border: 1px solid #dde2ef;
                        vertical-align:top;
                    ">
                Total Transaksi
            </td>
            <td style="
                        background-color:transparent; 
                        border-top-width: 1px;
                        padding: 7px;
                        border: 1px solid #dde2ef;
                        vertical-align:top;
                    ">
                :
            </td>
            <td style="
                        background-color:transparent; 
                        border-top-width: 1px;
                        padding: 7px;
                        border: 1px solid #dde2ef;
                        vertical-align:top;
                    ">
                <b>Rp.<?= number_format($data_invoice->grand_total_price, 0, '.', '.'); ?></b>
            </td>
        </tr>
        <tr>
            <td style="
                        background-color:transparent; 
                        border-top-width: 1px;
                        padding: 7px;
                        border: 1px solid #dde2ef;
                        vertical-align:top;
                    ">
                Diskon
            </td>
            <td style="
                        background-color:transparent; 
                        border-top-width: 1px;
                        padding: 7px;
                        border: 1px solid #dde2ef;
                        vertical-align:top;
                    ">
                :
            </td>
            <td style="
                        background-color:transparent; 
                        border-top-width: 1px;
                        padding: 7px;
                        border: 1px solid #dde2ef;
                        vertical-align:top;
                    ">
                <b>Rp.<?= number_format($data_invoice->discount_price, 0, '.', '.'); ?></b>
            </td>
        <tr>
            <td style="
                        background-color:transparent; 
                        border-top-width: 1px;
                        padding: 7px;
                        border: 1px solid #dde2ef;
                        vertical-align:top;
                    ">
                Total Tagihan
            </td>
            <td style="
                        background-color:transparent; 
                        border-top-width: 1px;
                        padding: 7px;
                        border: 1px solid #dde2ef;
                        vertical-align:top;
                    ">
                :
            </td>
            <td style="
                        background-color:transparent; 
                        border-top-width: 1px;
                        padding: 7px;
                        border: 1px solid #dde2ef;
                        vertical-align:top;
                    ">
                <b style="font-size: 20px;">Rp.<?= number_format($data_invoice->total_invoice, 0, '.', '.'); ?></b>
            </td>
        </tr>
        </tr>
    </table>
    <p>
        untuk detail transaksi silahkan klik tombol dibawah ini:
    </p>
    <a style="
        color: #fff;
        background: linear-gradient(to left, #efa65f, #f76a2d);
        border: 1px solid #efa65f;
        padding:10px 20px;
        border-radius:50px; 
        text-decoration:none;
        " href="<?= base_url('member-area/' . 'booking/detail?data=' . urlencode($this->encrypt->encode($data_invoice->booking_id))); ?>">Lihat Transaksi</a>
</div>