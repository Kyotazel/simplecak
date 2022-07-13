<div class="text-right">
    <a href="" class="btn btn-primary"><i class="fa fa-print"></i> Cetak Dokumen</a>
</div>
<div id="printarea">

    <style>
        @media print {
            footer {
                page-break-after: always;
            }
        }

        #background {
            position: absolute;
            z-index: 900;
            background: white;
            display: block;
            min-height: 50%;
            min-width: 50%;
            width: 100%;
            padding: 10px;
            color: white;
            top: 15%;
            left: 0;
        }

        #content {
            /* position: absolute; */
            z-index: 950;
        }

        #bg-text {
            position: absolute;
            min-height: 50%;
            min-width: 50%;
            width: 100%;
            padding: 10px;
            /* color: white; */
            top: 45%;
            left: 35%;
            color: #2fa97c;
            font-size: 80px;
            transform: rotate(340deg);
            -webkit-transform: rotate(340deg);
            opacity: 0.2;
        }
    </style>


    <div id="content" style="padding-left:25px;padding-right:25px;padding-top:50px">
        <p id="bg-text">ORIGINAL</p>
        <!-- <div id="background">
            
        </div> -->
        <!-- <br>
        <br> -->
        <table width="100%" style="border:none">
            <tbody>
                <tr>
                    <td rowspan="2" style="vertical-align: top;" align="center">
                        <img src="<?= base_url('upload/' . $company_logo); ?>" style="max-height:80px">
                    </td>
                    <td colspan="2" style="vertical-align: top;vertical-align: top;">
                        <div style="margin-left:0px">
                            <h1 style="margin-bottom: 0rem;"><strong><?= strtoupper($company_name); ?></strong></h1>
                            <!-- <p style="font-size:12px;padding-top:0px;margin-bottom: 0rem;">Komplek Ruko Harbour Citi-Nine F9 Jl. Gresik no 10-16 Perak Surabaya, Telp. 031-3503555</p> -->
                        </div>
                    </td>
                </tr>

                <tr>
                    <td colspan="5" style="text-align:end;font-size:25px;font-weight:bold;vertical-align: bottom;">BILL OF LADING</td>
                </tr>

                <tr>
                    <td colspan="6" style="text-align:end;font-size:15px;font-weight:bold;border:none">(CONTRACT TERM CONTINUED FROM OVERPAGE)</td>
                </tr>

                <tr>
                    <td colspan="4" style="border:none;">SHIPPER on board m/v </td>
                    <td colspan="2" style="text-align:end;font-weight:bold;border:none">the good.s packages sald to contain goods herein mentioned</td>

                </tr>

                <tr>

                    <td colspan="5" style="border:none">in apparent good order and condition uniess otherwise indecated to be transported and delivered or transhipped as herein provided</td>

                </tr>

                <tr>

                    <td colspan="5" style="border-top:1px solid #000;font-weight:bold;padding-top:10px">SHIPPER</td>

                    <td style="border-top:1px solid #000;border-left:1px solid #000;padding-left:5px;font-weight:bold">SO NUMBER</td>


                </tr>

                <tr>

                    <td colspan="5" style="border-bottom:1px solid #000;padding-left:70px;padding-bottom:10px"><?= $data_bs->customer_name; ?></td>

                    <td style="border-bottom:1px solid #000;border-left:1px solid #000;padding-left:5px"><?= $data_bs->code; ?></td>

                </tr>

                <tr>

                    <td colspan="5" style="border-top:1px solid #000;font-weight:bold;padding-bottom:10px">CONSIGNEED TO ORDER OF</td>

                    <td style="border-top:1px solid #000;border-left:1px solid #000;padding-left:5px;font-weight:bold">SPM NUMBER</td>

                </tr>

                <tr>

                    <td colspan="5" style="border-bottom:1px solid #000;padding-left:70px;padding-bottom:10px"><?= strtoupper($data_bs->receiver); ?></td>

                    <td style="border-bottom:1px solid #000;border-left:1px solid #000;padding-left:5px"><?= $data_bs->manifest_number; ?></td>

                </tr>

                <tr>

                    <td colspan="5" style="border-bottom:0px solid #000;font-weight:bold;padding-top:10px">ADDRESS ARRIVAL NOTICE TO</td>

                    <td rowspan="2" style="border-bottom:0px solid #000;border-left:1px solid #000;padding-left:5px;font-weight:bold">ALSO NOTIFY</td>

                </tr>

                <tr>

                    <td colspan="5" style="border-bottom:1px solid #000;padding-left:70px;padding-bottom:10px"><?= strtoupper($data_bs->receiver_address); ?></td>

                </tr>

                <tr>

                    <td style="border-bottom:0px solid #000;font-weight:bold;padding-top:7px">VESSEL</td>

                    <td style="border-bottom:0px solid #000;"><?= strtoupper($data_bs->ship_name); ?></td>

                    <td colspan="3" style="border-bottom:0px solid #000;font-weight:bold">FLAG</td>

                    <td style="border-bottom:0px solid #000;border-left:1px solid #000;font-weight:bold;padding-left:5px;">PORT OF LADING</td>

                </tr>

                <tr>

                    <td style="border-bottom:1px solid #000;font-weight:bold;padding-top:5px;padding-bottom:7px">VOYAGE NO.</td>

                    <td style="border-bottom:1px solid #000;"><?= strtoupper($data_bs->voyage_code); ?></td>

                    <td colspan="3" style="border-bottom:1px solid #000;">INDONESIA</td>

                    <td style="border-bottom:1px solid #000;border-left:1px solid #000;padding-left:5px;"><?= strtoupper($data_bs->depo_from); ?></td>

                </tr>

                <tr>

                    <td colspan="5" style="border-right:1px solid #000;font-weight:bold;padding-top:7px">PORT OF DISCHARGE (Where goos are to be delivered to consignee)</td>

                    <td style="padding-left:5px;">BILL OF LADING NUMBER</td>

                </tr>

                <tr>

                    <td colspan="5" style="border-bottom:5px solid #000;border-right:1px solid #000;padding-bottom:7px">Waingapu consignee or carrier</td>

                    <td style="border-bottom:5px solid #000;padding-left:5px;"><?= strtoupper($data_bs->bl_number); ?></td>

                </tr>

                <tr>

                    <td colspan="6" style="border-bottom:1px solid #000;font-weight:bold;text-align:center;padding-bottom:10px;padding-top:7px">PARTICULARS FURNISHED SHIPPER</td>

                </tr>

            </tbody>
        </table>

        <table width="100%" style="border:none">

            <tbody>
                <tr>
                    <td style="font-weight:bold;border-left:1px solid #000;border-bottom:1px solid #000;text-align:center">MARKS AND NUMBERS</td>

                    <td style="font-weight:bold;border-left:1px solid #000;border-bottom:1px solid #000;text-align:center">NO. OF PKGS</td>

                    <td colspan="2" style="font-weight:bold;border-left:1px solid #000;border-bottom:1px solid #000;text-align:center">DESCRIPTION OF PACKAGES AND GOODS</td>

                    <td style="font-weight:bold;border-left:1px solid #000;border-bottom:1px solid #000;text-align:center">MEASUREMENT (M3)</td>

                    <td style="font-weight:bold;border-left:1px solid #000;border-bottom:1px solid #000;text-align:center;border-right:1px solid #000;">GROSS WEIGHT(Kgs)</td>
                </tr>
                <?php
                $min_height = 700; //800px
                $height_item = 70;
                foreach ($data_countainer_bs as $item_countainer) {
                    $countiner_type = isset($category_countainer[$item_countainer->category_countainer]) ? $category_countainer[$item_countainer->category_countainer] : '';
                    $countainer_teus = isset($category_teus[$item_countainer->category_teus]) ? $category_teus[$item_countainer->category_teus] : 0;
                    $service_type = isset($category_service[$item_countainer->category_service]) ? $category_service[$item_countainer->category_service] : '';
                    $stuffing_take = isset($category_stuffing[$item_countainer->stuffing_take]) ? $category_stuffing[$item_countainer->stuffing_take] : 0;
                    $stuffing_open = isset($category_stuffing[$item_countainer->stuffing_open]) ? $category_stuffing[$item_countainer->stuffing_open] : 0;
                    $min_height -= $height_item;
                    echo '
                            <tr>

                                <td style="border-left:1px solid #000;" align="center">CY - DOOR</td>
            
                                <td style="border-left:1px solid #000;" align="right">-</td>
            
                                <td style="border-left:1px solid #000;padding-top:1px;padding-bottom:1px;padding-left:5px">
                                    <p style="margin-bottom:5px;margin-top:5px">' . $item_countainer->countainer_code . '</p>
                                    <p style="margin-bottom:5px;margin-top:5px">' . $item_countainer->category_load_name . ' - ' . $item_countainer->category_stuff_name . '</p>
                                </td>
            
                                <td align="right" style="padding-right:5px">
                                    <p style="margin-bottom:5px;margin-top:5px">' . $item_countainer->seal_code . '</p>
                                    <p style="margin-bottom:5px;margin-top:5px">' . $countainer_teus . ' feet </p>
                                </td>
            
                                <td style="border-left:1px solid #000;text-align:center">0,00</td>
            
                                <td style="border-left:1px solid #000;text-align:center;border-right:1px solid #000;">' . $item_countainer->total_tonase . ' Kg</td>
                            </tr>
                        ';

                    if ($min_height <= 0) {
                        $min_height = 800;
                    }
                }
                if ($min_height > 0) {
                    echo '
                    <tr style="color:transparent !important;height:' . $min_height . 'px;">
                        <td style="border-left:1px solid #000;" align="center">0</td>
                        <td style="border-left:1px solid #000;" align="right">0</td>
                        <td style="border-left:1px solid #000;padding-top:1px;padding-bottom:1px;padding-left:5px">
                            <p style="margin-bottom:5px;margin-top:5px">0</p>
                            <p style="margin-bottom:5px;margin-top:5px">0</p>
                        </td>
                        <td>0</td>
                        <td style="border-left:1px solid #000;text-align:center">0</td>
                        <td style="border-left:1px solid #000;text-align:center;border-right:1px solid #000;">0</td>
                    </tr>
                    ';
                }
                ?>

                <tr>
                    <td colspan="4" rowspan="4" style="font-weight:bold;border-left:1px solid #000;padding-left:15px;border-bottom:1px solid #000;border-top:1px solid #000;">Freight detalls, charged, etc </td>

                    <td colspan="2" style="font-weight:bold;border-left:1px solid #000;padding-left:5px;border-right:1px solid #000;border-top:1px solid #000;">Number of Original B/L :

                    </td>
                </tr>
                <tr>

                    <td style="font-weight:bold;border-left:1px solid #000;padding-left:15px">Dated at</td>
                    <td style="border-right:1px solid #000;"> : <?= $data_bs->depo_from; ?></td>

                </tr>

                <tr>

                    <td style="font-weight:bold;border-left:1px solid #000;border-bottom:1px solid #000;padding-left:15px">To be Paid at</td>
                    <td style="border-right:1px solid #000;border-bottom:1px solid #000;"> : <?= $data_bs->depo_from; ?></td>

                </tr>

                <tr>

                    <td style="font-weight:bold;border-left:1px solid #000;border-bottom:1px solid #000;padding-top:7px;padding-bottom:7px">DATE</td>
                    <td style="border-right:1px solid #000;border-bottom:1px solid #000;"><?= Modules::run('helper/change_date', $data_bs->bl_date, '-'); ?></td>

                </tr>



                <tr>

                    <td colspan="4" style="font-weight:bold;border-left:1px solid #000;padding-left:15px;border-bottom:1px solid #000;padding-top:10px;padding-bottom:10px">OTHER CHARGES</td>

                    <td colspan="2" style="border-left:1px solid #000;padding-left:15px;border-right:1px solid #000" align="center"> VANDA, R.D</td>

                </tr>

                <tr>

                    <td colspan="4" style="font-weight:bold;border-left:1px solid #000;padding-left:15px;border-bottom:1px solid #000;padding-top:10px;padding-bottom:10px">TOTAL CHARGES</td>

                    <td colspan="2" style="border-left:1px solid #000;padding-left:15px;border-right:1px solid #000;border-bottom:1px solid #000">For The master : </td>

                </tr>

                <tr>

                    <td colspan="4" style="font-weight:bold;border-left:1px solid #000;padding-left:15px;border-bottom:1px solid #000;padding-top:10px;padding-bottom:10px;"><span style="color:transparent !important">0</span></td>

                    <td colspan="2" style="border-left:1px solid #000;padding-left:15px;border-right:1px solid #000;border-bottom:1px solid #000" align="center"><?= $data_bs->customer_name; ?></td>

                </tr>

                <!-- <tr>

                <td colspan="4" style="font-weight:bold;border-left:1px solid #000;padding-left:15px;border-bottom:1px solid #000;">HEAD OFFICE<br>Komplek Ruko Harbour Citi-Nine F9 <br>Ph. 031 3503555 WA. 085 1020 88000</td> 

                <td colspan="2" style="border-left:1px solid #000;padding-left:15px;border-right:1px solid #000;border-bottom:1px solid #000">BRANCH OFFICE<br/>Jl. Pakoki, Kel. Temu, Kanatang, Kab. Waingapu, Sumba Timur, NTT<br>Ph. 081 131 8565</td>

            </tr>  -->


            </tbody>
        </table>
    </div>
    <br>
    <br>
    <br>
    <br>
    <footer></footer>


</div>