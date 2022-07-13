<?php
function change_date($date)
{
    $date_explode = explode('-', $date);
    $date_return = $date_explode[2] . '-' . $date_explode[1] . '-' . $date_explode[0];
    return $date_return;
}

function date_function($date, $type, $return)
{
    if ($type == 'timestamp') {
        $timestamp_explode = explode(' ', $date);
        //create date indo
        $date_explode = explode('-', $timestamp_explode[0]);
        $date_indo = $date_explode[2] . '-' . $date_explode[1] . '-' . $date_explode[0];
        if ($return == 'time') {
            return $timestamp_explode[1];
        } elseif ($return == 'date') {
            return $timestamp_explode[0];
        } else {
            return $date_indo;
        }
    } else {
        $date_explode = explode('-', $date);
        $date_indo = $date_explode[2] . '-' . $date_explode[1] . '-' . $date_explode[0];
        if ($return == 'time') {
            return '-';
        } elseif ($return == 'date') {
            return $date;
        } else {
            return $date_indo;
        }
    }
}

$array_month = [
    '01' => 'Januari',
    '02' => 'Februari',
    '03' => 'Maret',
    '04' => 'April',
    '05' => 'Mei',
    '06' => 'Juni',
    '07' => 'Juli',
    '08' => 'Agustus',
    '09' => 'September',
    '10' => 'Oktober',
    '11' => 'November',
    '12' => 'December'
];

?>
<style type="text/css">
    .body {
        font-size: 10px;
        font-family: Times, serif;
    }

    .jarak {
        height: 25px;
    }

    .lebar {
        width: 70px;
    }

    .lebar-kecil {
        width: 40px;
    }

    /*table{
		width: 90%;
	}*/
    .table {
        /*width: 100px;*/
        border: 1px solid #000;
        border-collapse: collapse;
        padding-left: 8px;
        padding-right: 8px;
    }

    th {
        border: 1px solid #000;
        border-collapse: collapse;
        padding-left: 8px;
        padding-right: 8px;
        font-size: 11px;
    }

    .table tr td {
        border: 1px solid #000;
        border-collapse: collapse;
        padding-left: 8px;
        padding-right: 8px;
        font-size: 11px;
    }

    .more_width {
        width: 100px;
    }

    .small_width {
        width: 3px;
    }

    .much_width {
        width: 300px;
    }

    .width_200 {
        width: 200px;
    }

    .more_than_width {
        width: 150px;
    }

    /*hr{
		border-top: 0.1px solid #8c8b8b;
	}*/
    .hr_style {
        border-top: 1px dashed #808080;
        border-bottom: 1px dashed #fff;
    }

    .delivery_address {
        /*background-color: red;*/
        border: 1px dashed #808080;
    }

    .text-capitalize {
        text-transform: capitalize;
    }
</style>
<html>

<head>
    <title></title>
</head>

<body>
    <!-- <table class="">
        <tr>
            <td></td>
            <td>
                <h1 style="margin:0"><?php echo strtoupper($data_profile['name']); ?></h1>
                <h4 style="margin:0"><?php echo $data_profile['address']; ?></h4>
            </td>
        </tr>
    </table> -->
    <div align="center" style="margin-bottom: 10px;">
        <h4 style="padding:0;margin:0;">LAPORAN DATA KAPAL</h4>
    </div>

    <table class="table">
        <tr>
            <th style="width:20px;padding:5px;background-color:#366092;color:#fff;">No</th>
            <th style="width:80px;padding:5px;background-color:#366092;color:#fff;">KODE KAPAL</th>
            <th style="width:150px;padding:5px;background-color:#366092;color:#fff;">KAPAL</th>
            <th style="width:120px;padding:5px;background-color:#366092;color:#fff;">BATAS TONASE (GT)</th>
            <th style="width:130px;padding:5px;background-color:#366092;color:#fff;">BATAS KONTAINER</th>
            <th style="width:90px;padding:5px;background-color:#366092;color:#fff;">TANGGAL BELI</th>
        </tr>
        <?php
        $counter = 0;
        foreach ($data_ship as $data_table) {
            $counter++;
            echo '
                <tr>
                    <td style="width:20px;padding:5px;">' . $counter . '</td>
                    <td style="width:80px;padding:5px;">' . $data_table->code . '</td>
                    <td style="width:150px;padding:5px;">' . strtoupper($data_table->name) . '</td>
                    <td style="width:120px;padding:5px;">' . $data_table->tonase_limit . '</td>
                    <td style="width:130px;padding:5px;">' . $data_table->container_slot . '</td>
                    <td style="width:90px;padding:5px;">' . date_function($data_table->date_buy, 'date', 'date') . '</td>
                </tr>
                ';
        }
        ?>

    </table>
</body>

</html>