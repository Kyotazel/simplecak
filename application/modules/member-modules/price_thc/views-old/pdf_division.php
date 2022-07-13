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

function date_indo($date, $delimiter)
{
    $array_month = [
        '01' => 'januari', '02' => 'februari', '03' => 'maret', '04' => 'april', '05' => 'mei', '06' => 'juni', '07' => 'juli', '08' => 'agustus', '09' => 'september', '10' => 'oktober', '11' => 'november', '12' => 'december'
    ];
    $explode_date = explode($delimiter, $date);
    $date_return = $explode_date[2] . ' ' . ucfirst($array_month[$explode_date[1]]) . ' ' . $explode_date[0];
    return $date_return;
}


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
        <h4 style="padding:0;margin:0;">LAPORAN DAFTAR DEVISI</h4>
    </div>

    <table class="table" style="vertical-align: top;">
        <tr>
            <th style="width:20px;padding:5px;background-color:#366092;color:#fff;">No</th>
            <th style="width:500px;padding:5px;background-color:#366092;color:#fff;">NAMA DEVISI</th>

        </tr>
        <?php
        $counter = 0;
        foreach ($data_position as $data_table) {
            $counter++;

            echo '
                <tr>
                    <td style="width:40px;padding:5px;">' . $counter . '</td>
                    <td style="width:610px;padding:5px;">' . $data_table->name . '</td>
                </tr>
                ';
        }
        ?>
    </table>
</body>

</html>