<?php
$array_month = [
    '01' => 'januari',
    '02' => 'februari',
    '03' => 'maret',
    '04' => 'april',
    '05' => 'mei',
    '06' => 'juni',
    '07' => 'juli',
    '08' => 'agustus',
    '09' => 'september',
    '10' => 'oktober',
    '11' => 'november',
    '12' => 'december'
];

$get_period_accounting = $this->db->select('
YEAR(date_from) AS year_from,
MONTH(date_from) AS month_from,
YEAR(date_to) AS year_to,
MONTH(date_to) AS month_to,
date_from,
date_to
')->where(['status' => 1])->get('tb_book_period')->row();

$date_from_period = isset($get_period_accounting->date_from) ? $get_period_accounting->date_from : '';
$date_to_period =  isset($get_period_accounting->date_to) ? $get_period_accounting->date_to : '';

$count_bs = Modules::run('database/find', 'tb_booking', ['date >=' => $date_from_period, 'date <=' => $date_to_period])->num_rows();
$count_invoice = Modules::run('database/find', 'tb_invoice', ['invoice_date >=' => $date_from_period, 'invoice_date <=' => $date_to_period])->num_rows();

$date_today         = date('Y-m-d');
$date_last_month    = date('Y-m-d', strtotime('-1 month', strtotime($date_today)));
$month_today        = date("m", strtotime($date_today));
$month_last_month   = date("m", strtotime($date_last_month));
$year_today         = date("Y", strtotime($date_today));
$year_last_month    = date("Y", strtotime($date_last_month));


?>
<div class="breadcrumb-header justify-content-between">
    <div class="left-content">
        <div>
            <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Halo <b><?= $this->session->userdata('us_name'); ?></b></h2>
            <p class="mg-b-0">selamat datang kembali, silahkan gunakan hak akses dengan baik. terimkasih. <b><? ?></b>.</p>
        </div>
    </div>
    <div class="main-dashboard-header-right">
        <!-- <div>
            <label class="tx-13">Customer Ratings</label>
            <div class="main-star">
                <i class="typcn typcn-star active"></i> <i class="typcn typcn-star active"></i> <i class="typcn typcn-star active"></i> <i class="typcn typcn-star active"></i> <i class="typcn typcn-star"></i> <span>(14,873)</span>
            </div>
        </div> -->
        <div>
            <label class="tx-13"><i class="fa fa-calendar"></i> Periode Akuntansi</label>
            <label class="tx-15 d-block font-weight-bold" style="color: #1c273c;">
                <?= $date_to_period != '' ? Modules::run('helper/date_indo', $date_from_period, '-') : ''; ?>
                &nbsp;-&nbsp;
                <?= $date_to_period != '' ? Modules::run('helper/date_indo', $date_to_period, '-') : ''; ?>
            </label>
        </div>
        <div>
            <label class="tx-13"><i class="fa fa-tv"></i> Total Booking Slot</label>
            <label class="tx-15 d-block font-weight-bold" style="color: #1c273c;">
                <?= $count_bs; ?> Data
            </label>
        </div>
        <div>
            <label class="tx-13"><i class="fa fa-tv"></i> Total Invoice</label>
            <label class="tx-15 d-block font-weight-bold" style="color: #1c273c;">
                <?= $count_invoice; ?> Invoice
            </label>
        </div>
    </div>
</div>

<div class="row row-sm">
    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-primary-gradient">
            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                <div class="">
                    <h6 class="mb-3 tx-12 text-white text-uppercase">total Booking Slot ( <?= $array_month[$month_today] . ' ' . $year_today; ?> )</h6>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <div class="">
                            <?php
                            //count
                            $get_total_invoice_today        = $this->db->select('SUM(total_invoice) AS total_invoice')->where(['YEAR(invoice_date)' => $year_today, 'MONTH(invoice_date)' => $month_today])->get('tb_invoice')->row();
                            $get_total_invoice_last_month   = $this->db->select('SUM(total_invoice) AS total_invoice')->where(['YEAR(invoice_date)' => $year_last_month, 'MONTH(invoice_date)' => $month_last_month])->get('tb_invoice')->row();
                            $status = '';
                            if ($get_total_invoice_today->total_invoice > $get_total_invoice_last_month->total_invoice) {
                                //plus
                                $status = '+';
                                $percentage = round((($get_total_invoice_today->total_invoice - $get_total_invoice_last_month->total_invoice) / $get_total_invoice_last_month->total_invoice) * 100);
                            } else {
                                //minus
                                $status = '-';
                                $percentage = round(((($get_total_invoice_last_month->total_invoice - $get_total_invoice_today->total_invoice) / $get_total_invoice_last_month->total_invoice * 100)), 2);
                            }
                            ?>
                            <h4 class="tx-20 font-weight-bold mb-1 text-white">Rp.<?= number_format($get_total_invoice_today->total_invoice, 0, '.', '.'); ?></h4>
                            <p class="mb-0 tx-12 text-white op-7">Dibandingkan Bulan kemarin</p>
                        </div>
                        <span class="float-right my-auto ml-auto">
                            <?= $status == '+' ? '<i class="fas fa-arrow-circle-up text-white"></i>' : '<i class="fas fa-arrow-circle-down text-white"></i>' ?>
                            <span class="text-white op-7"> <?= $status . ' ' . $percentage . '%'; ?></span>
                        </span>
                    </div>
                </div>
            </div>
            <span id="compositeline" class="pt-1"><canvas width="392" height="30" style="display: inline-block; width: 392px; height: 30px; vertical-align: top;"></canvas></span>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-danger-gradient">
            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                <div class="">
                    <h6 class="mb-3 tx-12 text-white text-uppercase">total pembayaran invoice ( <?= $array_month[$month_today] . ' ' . $year_today; ?> )</h6>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <?php
                        //count
                        $get_total_data         = $this->db->select('SUM(payment_price) AS total_data')->where(['YEAR(date)' => $year_today, 'MONTH(date)' => $month_today])->get('tb_credit_has_payment')->row();
                        $get_total_last_month   = $this->db->select('SUM(payment_price) AS total_data')->where(['YEAR(date)' => $year_last_month, 'MONTH(date)' => $month_last_month])->get('tb_credit_has_payment')->row();
                        $status = '';
                        if ($get_total_data->total_data > $get_total_last_month->total_data) {
                            //plus
                            $status = '+';
                            $percentage = round(((($get_total_data->total_data - $get_total_last_month->total_data) / $get_total_last_month->total_data *  100)), 2);
                        } else {
                            //minus
                            $status = '-';
                            $percentage = round(((($get_total_last_month->total_data - $get_total_data->total_data) / $get_total_last_month->total_data * 100)), 2);
                        }
                        ?>
                        <div class="">
                            <h4 class="tx-20 font-weight-bold mb-1 text-white">Rp.<?= number_format($get_total_data->total_data, 0, '.', '.'); ?></h4>
                            <p class="mb-0 tx-12 text-white op-7">Dibandingkan Bulan kemarin</p>
                        </div>
                        <span class="float-right my-auto ml-auto">
                            <?= $status == '+' ? '<i class="fas fa-arrow-circle-up text-white"></i>' : '<i class="fas fa-arrow-circle-down text-white"></i>' ?>
                            <span class="text-white op-7"> <?= $status . ' ' . $percentage . '%'; ?></span>
                        </span>
                    </div>
                </div>
            </div>
            <span id="compositeline2" class="pt-1"><canvas width="392" height="30" style="display: inline-block; width: 392px; height: 30px; vertical-align: top;"></canvas></span>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-success-gradient">
            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                <div class="">
                    <h6 class="mb-3 tx-12 text-white text-uppercase">biaya operasional voyage ( <?= $array_month[$month_today] . ' ' . $year_today; ?> )</h6>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <?php
                        //count
                        $get_total_data         = $this->db->select('SUM(price) AS total_data')->where(['YEAR(date)' => $year_today, 'MONTH(date)' => $month_today])->get('tb_voyage_has_cost')->row();
                        $get_total_last_month   = $this->db->select('SUM(price) AS total_data')->where(['YEAR(date)' => $year_last_month, 'MONTH(date)' => $month_last_month])->get('tb_voyage_has_cost')->row();
                        $status = '';
                        if ($get_total_data->total_data > $get_total_last_month->total_data) {
                            //plus
                            $status = '+';
                            $percentage = round(((($get_total_data->total_data - $get_total_last_month->total_data) / $get_total_last_month->total_data *  100)), 2);
                        } else {
                            //minus
                            $status = '-';
                            $percentage = round(((($get_total_last_month->total_data - $get_total_data->total_data) / $get_total_last_month->total_data * 100)), 2);
                        }
                        ?>
                        <div class="">
                            <h4 class="tx-20 font-weight-bold mb-1 text-white">Rp.<?= number_format($get_total_data->total_data, 0, '.', '.'); ?></h4>
                            <p class="mb-0 tx-12 text-white op-7">Dibandingkan bulan kemarin</p>
                        </div>
                        <span class="float-right my-auto ml-auto">
                            <?= $status == '+' ? '<i class="fas fa-arrow-circle-up text-white"></i>' : '<i class="fas fa-arrow-circle-down text-white"></i>' ?>
                            <span class="text-white op-7"> <?= $status . ' ' . $percentage . '%'; ?></span>
                        </span>
                    </div>
                </div>
            </div>
            <span id="compositeline3" class="pt-1"><canvas width="392" height="30" style="display: inline-block; width: 392px; height: 30px; vertical-align: top;"></canvas></span>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
        <div class="card overflow-hidden sales-card bg-warning-gradient">
            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                <div class="">
                    <h6 class="mb-3 tx-12 text-white text-uppercase">resume maintenance ( <?= $array_month[$month_today] . ' ' . $year_today; ?> )</h6>
                </div>
                <div class="pb-0 mt-0">
                    <div class="d-flex">
                        <?php
                        //count
                        $get_total_data         = $this->db->select('SUM(price) AS total_data')->where(['YEAR(date_start)' => $year_today, 'MONTH(date_start)' => $month_today])->get('tb_maintenance')->row();
                        $get_total_last_month   = $this->db->select('SUM(price) AS total_data')->where(['YEAR(date_start)' => $year_last_month, 'MONTH(date_start)' => $month_last_month])->get('tb_maintenance')->row();
                        $status = '';
                        if ($get_total_data->total_data > $get_total_last_month->total_data) {
                            //plus
                            $status = '+';
                            $percentage = round(((($get_total_data->total_data - $get_total_last_month->total_data) / $get_total_last_month->total_data *  100)), 2);
                        } else {
                            //minus
                            $status = '-';
                            $percentage = round(((($get_total_last_month->total_data - $get_total_data->total_data) / $get_total_last_month->total_data * 100)), 2);
                        }
                        ?>
                        <div class="">
                            <h4 class="tx-20 font-weight-bold mb-1 text-white">Rp.<?= number_format($get_total_data->total_data, 0, '.', '.'); ?></h4>
                            <p class="mb-0 tx-12 text-white op-7">Dibandingkan bulan kemarin</p>
                        </div>
                        <span class="float-right my-auto ml-auto">
                            <?= $status == '+' ? '<i class="fas fa-arrow-circle-up text-white"></i>' : '<i class="fas fa-arrow-circle-down text-white"></i>' ?>
                            <span class="text-white op-7"> <?= $status . ' ' . $percentage . '%'; ?></span>
                        </span>
                    </div>
                </div>
            </div>
            <span id="compositeline4" class="pt-1"><canvas width="392" height="30" style="display: inline-block; width: 392px; height: 30px; vertical-align: top;"></canvas></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-lg-12 col-xl-12">
        <div class="card">
            <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mb-0">Resume Pendapatan Booking Slot</h4>
                </div>
                <p class="tx-12 text-muted mb-0">Silahkan lacak pendapatan dengan melakukan pencarian dibawah ini.</p>
            </div>
            <div class="card-body">
                <?php
                $get_invoice_year = $this->db->select('MAX(YEAR(date_to))AS max_year,MIN(YEAR(date_from)) AS min_year')->get('tb_book_period')->row();
                $min_year = $get_invoice_year->min_year;
                $max_year = $get_invoice_year->max_year;
                $loop = (($max_year - $min_year) + 1);

                $html_option_year = '';
                for ($i = 0; $i < $loop; $i++) {
                    $year_current = $min_year++;
                    $selected = isset($get_period_accounting->year_from) && $get_period_accounting->year_from == $year_current ? 'selected' : '';
                    $html_option_year   .= ' <option ' . $selected . ' value="' . $year_current . '">' . $year_current . '</option> ';
                }
                $html_option_month = '';
                $month_current = isset($get_period_accounting->month_from) ? sprintf("%02s", $get_period_accounting->month_from) : '';
                foreach ($array_month as $key => $value) {
                    $selected = $month_current == $key ? 'selected' : '';
                    $html_option_month .= '
                        <option ' . $selected . ' value="' . $key . '">' . strtoupper($value) . '</option>
                    ';
                }

                // print_r($get_period_accounting->year_to);
                $html_option_year_to = '';
                $min_year = $get_invoice_year->min_year;
                for ($i = 0; $i < $loop; $i++) {
                    $year_current = $min_year++;
                    $selected = isset($get_period_accounting->year_to) && $get_period_accounting->year_to == $year_current ? 'selected' : '';
                    $html_option_year_to   .= ' <option ' . $selected . ' value="' . $year_current . '">' . $year_current . '</option> ';
                }
                $html_option_month_to = '';
                $month_current = isset($get_period_accounting->month_to) ? sprintf("%02s", $get_period_accounting->month_to) : '';
                foreach ($array_month as $key => $value) {
                    $selected = $month_current == $key ? 'selected' : '';
                    $html_option_month_to .= '
                        <option ' . $selected . ' value="' . $key . '">' . strtoupper($value) . '</option>
                    ';
                }

                ?>
                <form class="form_resume_bs">
                    <div class="row p-2 border-dashed">
                        <div class="col-3">
                            <label for=""><i class="fa fa-calendar"></i> Periode Awal</label>
                            <div class="d-flex">
                                <select name="year_period_from" class="form-control col-6" id="">
                                    <?= $html_option_year; ?>
                                </select>
                                <select name="month_period_from" class="form-control col-6" id="">
                                    <?= $html_option_month; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <label for=""><i class="fa fa-calendar"></i> Periode Akhir</label>
                            <div class="d-flex">
                                <select name="year_period_to" class="form-control col-6" id="">
                                    <?= $html_option_year_to; ?>
                                </select>
                                <select name="month_period_to" class="form-control col-6" id="">
                                    <?= $html_option_month_to; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-5">
                            <label for=""><i class="fa fa-users"></i> Customer</label>
                            <select name="customer[]" multiple class="form-control chosen" id="">
                                <?php
                                foreach ($members as $item_member) {
                                    echo '
                                            <option value="' . $item_member->id . '">' . $item_member->name . '</option>
                                        ';
                                }
                                ?>
                            </select>
                        </div>
                        <!-- <div class="col-2">
                            <label for=""><i class="fa fa-list"></i> Group Data</label>
                            <select name="group_by" class="form-control" id="">
                                <option value="1">Per bulan</option>
                                <option value="2">Per Minggu</option>
                                <option value="3">Per Hari</option>

                            </select>
                        </div> -->
                        <div class="col-1">
                            <label for="">&nbsp;</label><br>
                            <button class="btn btn-primary-gradient btn-block btn-rounded" id="btn_search_chart_resume_invoice"><i class="fa fa-search"></i> Cari</button>
                        </div>
                    </div>
                </form>

                <div class="total-revenue mt-2">
                    <div class="border-right pr-2">
                        <h4 class="text-invoice-freight">---</h4>
                        <label class="text-uppercase tx-10"><span class="bg-primary"></span>Total FREIGHT</label>
                    </div>
                    <div class="border-right pr-2">
                        <h4 class="text-invoice-thc">---</h4>
                        <label class="text-uppercase"><span class="bg-warning"></span>total thc</label>
                    </div>
                    <div class="border-right pr-2">
                        <h4 class="text-invoice-lc">---</h4>
                        <label class="text-uppercase"><span class="bg-danger"></span>total LC</label>
                    </div>
                    <div>
                        <h4 class="text-invoice-activity">---</h4>
                        <label class="text-uppercase"><span class="bg-success"></span>total activity</label>
                    </div>
                </div>
                <div id="container_bar_invoice" class="sales-bar mt-4"></div>
            </div>
        </div>
    </div>
</div>
<div class="row row-sm row-deck">
    <div class="col-xl-4 col-md-12 col-lg-6">
        <div class="card">
            <div class="card-header pb-1">
                <h3 class="card-title mb-2">Resume transaksi Sedang Berlangsung</h3>
                <p class="tx-12 mb-0 text-muted">Berikut resume transaksi yang sedang berjalan saat ini</p>
            </div>
            <div class="product-timeline card-body pt-2 mt-1">
                <ul class="timeline-1 mb-0">
                    <li class="mt-0"> <i class="ti-file bg-primary-gradient text-white product-icon"></i> <span class="font-weight-semibold mb-4 tx-14 ">Voyage Aktif</span>
                        <?php
                        $count_data = Modules::run('database/find', 'tb_voyage', ['status' => 1])->num_rows();
                        echo '
                            <a href="' . Modules::run('helper/create_url', 'voyage') . '" class="float-right btn btn-light btn-rounded">' . $count_data . ' Data</a>
                        ';
                        ?>
                        <p class="mb-0 text-muted tx-12">Total jumlah voyage yang sedang dibuka</p>
                    </li>
                    <li class="mt-0"> <i class="ti-truck bg-danger-gradient text-white product-icon"></i> <span class="font-weight-semibold mb-4 tx-14 ">Voyage dalam Transaksi</span>
                        <?php
                        $count_data = Modules::run('database/find', 'tb_voyage', ['status > ' => 1, 'status <' => 8])->num_rows();
                        echo '
                            <a href="' . Modules::run('helper/create_url', '/booking/confirm') . '" class="float-right btn btn-light btn-rounded">' . $count_data . ' Data</a>
                        ';
                        ?>
                        <p class="mb-0 text-muted tx-12">Total jumlah voyage dalam transaksi pelayaran</p>
                    </li>
                    <li class="mt-0"> <i class="ti-wallet bg-warning-gradient text-white product-icon"></i> <span class="font-weight-semibold mb-4 tx-14 ">Konfirmasi Booking Slot</span>
                        <?php
                        $count_data = Modules::run('database/find', 'tb_booking', ['is_confirm' => 0])->num_rows();
                        echo '
                            <a href="' . Modules::run('helper/create_url', '/booking/confirm') . '" class="float-right btn btn-light btn-rounded">' . $count_data . ' Data</a>
                        ';
                        ?>
                        <p class="mb-0 text-muted tx-12">Jumlah BS belum dikonfirmasi</p>
                    </li>
                    <li class="mt-0"> <i class="fa fa-box bg-purple-gradient text-white product-icon"></i> <span class="font-weight-semibold mb-4 tx-14 ">Pembongkaran Kontainer</span>
                        <?php
                        $count_data = Modules::run('database/find', ' tb_booking_has_countainer', ['status' => 5, 'id_booking_detail >' => 0])->num_rows();
                        echo '
                            <a href="' . Modules::run('helper/create_url', '/transaction/container_unloading') . '" class="float-right btn btn-light btn-rounded">' . $count_data . ' Data</a>
                        ';
                        ?>
                        <p class="mb-0 text-muted tx-12">Jumlah kontainer siap dibongkar</p>
                    </li>
                    <li class="mt-0"> <i class="fa fa-box bg-success-gradient text-white product-icon"></i> <span class="font-weight-semibold mb-4 tx-14 ">Pengembalian Kontainer</span>
                        <?php
                        $count_data = Modules::run('database/find', ' tb_booking_has_countainer', ['status' => 6, 'id_booking_detail >' => 0])->num_rows();
                        echo '
                            <a href="' . Modules::run('helper/create_url', '/transaction/container_return') . '" class="float-right btn btn-light btn-rounded">' . $count_data . ' Data</a>
                        ';
                        ?>
                        <p class="mb-0 text-muted tx-12">Jumlah kontainer siap Dikembalikan</p>
                    </li>
                    <li class="mt-0 mb-0"> <i class="icon-note icons bg-primary-gradient text-white product-icon"></i> <span class="font-weight-semibold mb-4 tx-14 ">Antrian Maintenance</span>
                        <?php
                        $count_data = Modules::run('database/find', ' tb_maintenance_queue', ['type' => 1])->num_rows();
                        echo '
                            <a href="' . Modules::run('helper/create_url', '/maintenance/list') . '" class="float-right btn btn-light btn-rounded">' . $count_data . ' Data</a>
                        ';
                        ?>
                        <p class="mb-0 text-muted tx-12">Jumlah antrian maintenance</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-8 col-xl-8">
        <div class="card card-table-two">
            <div class="d-flex justify-content-between">
                <h4 class="card-title mb-1">Rating Booking Slot Customer</h4>
            </div>
            <span class="tx-12 tx-muted mb-3 ">Berikut urutan customer dengan nilai transaksi terbesar.</span>
            <div class="table-responsive country-table">
                <table class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap">
                    <thead>
                        <tr>
                            <th class="wd-lg-25p">Customer</th>
                            <th class="wd-lg-25p tx-right">Jumlah BS</th>
                            <th class="wd-lg-25p tx-right">Jml Kontainer & LC</th>
                            <th class="wd-lg-25p tx-right">Total BS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $array_query = [
                            'select' => '
                                COUNT(tb_booking.id) AS total_bs,
                                SUM(tb_booking_has_detail.qty) AS total_qty,
                                SUM(tb_booking.grand_total) AS total_price,
                                mst_customer.name AS customer_name
                            ',
                            'from' => 'mst_customer',
                            'join' => [
                                'tb_booking, tb_booking.id_customer = mst_customer.id AND tb_booking.is_confirm = 1 ,left',
                                'tb_booking_has_detail, tb_booking.id = tb_booking_has_detail.id_booking ,left'
                            ],
                            'group_by' => 'tb_booking.id_customer',
                            'order_by' => 'total_price, DESC',
                            'limit' => 8
                        ];
                        $get_data = Modules::run('database/get', $array_query)->result();
                        $counter = 0;
                        foreach ($get_data as $item_data) {
                            $counter++;
                            echo '
                                <tr>
                                    <td>' . $item_data->customer_name . '</td>
                                    <td class="tx-right tx-medium tx-inverse">' . $item_data->total_bs . '</td>
                                    <td class="tx-right tx-medium tx-inverse">' . $item_data->total_qty . '</td>
                                    <td class="tx-right tx-medium tx-danger">Rp. ' . number_format($item_data->total_price, 0, '.', '.') . '</td>
                                </tr>
                            ';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="card overflow-hidden">
        <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
            <div class="d-flex justify-content-between">
                <h4 class="card-title mb-0">Resume Pengeluaran</h4>
            </div>
            <p class="tx-12 text-muted mb-0">Silahkan lacak data dengan melakukan pencarian dibawah ini.</p>
        </div>
        <div class="card-body">
            <form class="form_search_cost">
                <div class="row p-2 border-dashed">
                    <div class="col-2">
                        <label for=""><i class="fa fa-calendar"></i> Tanggal Awal</label>
                        <input type="text" class="form-control bg-white datepicker" readonly value="<?= Modules::run('helper/change_date', $date_from_period, '-') ?>" readonly name="date_from">
                    </div>
                    <div class="col-2">
                        <label for=""><i class="fa fa-calendar"></i> Tanggal akhir</label>
                        <input type="text" class="form-control bg-white datepicker" readonly value="<?= Modules::run('helper/change_date', $date_to_period, '-') ?>" readonly name="date_to">
                    </div>
                    <div class="col-7">
                        <label for=""><i class="fa fa-tv"></i> Jenis Pengeluaran</label>
                        <select name="cost[]" multiple class="form-control chosen" id="">
                            <?php
                            $get_data_cost = Modules::run('database/get', ['from' => 'tb_book_account', 'where' => ['type_account' => 5, 'isDeleted' => 'N', 'id_parent > ' => 0], 'order_by' => 'name'])->result();

                            foreach ($get_data_cost as $item_data) {
                                echo '
                                            <option value="' . $item_data->id . '">' . $item_data->name . '</option>
                                        ';
                            }
                            ?>
                        </select>
                    </div>
                    <!-- <div class="col-2">
                            <label for=""><i class="fa fa-list"></i> Group Data</label>
                            <select name="group_by" class="form-control" id="">
                                <option value="1">Per bulan</option>
                                <option value="2">Per Minggu</option>
                                <option value="3">Per Hari</option>

                            </select>
                        </div> -->
                    <div class="col-1">
                        <label for="">&nbsp;</label><br>
                        <button type="submit" class="btn btn-primary-gradient btn-block btn-rounded btn_search_cost"><i class="fa fa-search"></i> Cari</button>
                    </div>
                </div>
            </form>
            <div class="chartjs-wrapper-demo mt-3">
                <div class="container_line_cost">

                </div>

            </div>
        </div>
    </div>
</div><!-- col-6 -->