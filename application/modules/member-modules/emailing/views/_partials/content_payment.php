<div style="width: 100%;text-align:center;">
    <label style="display: block;">Kode Invoice :</label><br>
    <label for="" style="padding: 10px;font-size:20px;color: #fff;font-weight: 700;background-color: #0162e8;">
        <?= $data_payment->invoice_code; ?>
    </label>
    <p>
        Keterangan Pembayaran :<br>
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
                Tanggal Pembayaran
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
                <b><?= Modules::run('helper/date_indo', $data_payment->date, '-'); ?></b>
            </td>
        </tr>
        <tr>
            <td style="
                        background-color:transparent; 
                        border-top-width: 1px;
                        padding: 7px;
                        border: 1px solid #dde2ef;
                        vertical-align:top;
                        width:200px;
                    ">
                Total tagihan
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
                <b>Rp.<?= number_format($data_payment->credit_price, 0, '.', '.'); ?></b>
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
                Dibayar
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
                <b>Rp.<?= number_format($data_payment->payment_price, 0, '.', '.'); ?></b>

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
                Sisa Tagihan
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
                <b>Rp.<?= number_format($data_payment->rest_credit, 0, '.', '.'); ?></b>
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
                Status Invoice
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
                    <?= $data_payment->rest_credit > 0 ? 'Belum Lunas' : 'Lunas'; ?>
                </b>
            </td>
        </tr>
    </table>
    <p>
        <label for="">Catatan Pembayaran :</label><br>
        <b><?= $data_payment->note; ?></b>
    </p>

    <p>
        klik tombol dibawah ini untuk melihat daftar invoice mu :
    </p>
    <a style="
        color: #fff;
        background: linear-gradient(to left, #efa65f, #f76a2d);
        border: 1px solid #efa65f;
        padding:10px 20px;
        border-radius:50px; 
        text-decoration:none;
        " href="<?= base_url('member-area/credit'); ?>">Lihat Semua Invoice</a>
</div>