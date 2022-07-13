<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Voyage extends BackendController
{
    var $module_name        = 'voyage';
    var $module_directory   = 'voyage';
    var $module_js          = ['voyage'];
    var $app_data           = [];


    public function __construct()
    {
        parent::__construct();
        Modules::run('security/common_security');
        $this->_init();
    }

    private function _init()
    {
        $this->app_data['module_js']    = $this->module_js;
        $this->app_data['module_name']  = $this->module_name;
        $this->app_data['module_directory']  = $this->module_directory;
    }

    public function index()
    {
        $this->app_data['data_status_voyage'] =  json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'voyage_status'])->row()->value, TRUE);
        $this->app_data['data_ship'] = Modules::run('database/find', 'mst_ship', ['isDeleted' => 'N'])->result();
        $this->app_data['data_depo'] = Modules::run('database/find', 'mst_depo', ['isDeleted' => 'N'])->result();
        $this->app_data['page_title'] = "DATA VOYAGE    ";
        $this->app_data['view_file'] = 'main_view';
        echo Modules::run('template/horizontal_layout', $this->app_data);
    }

    public function proceed()
    {
        $this->app_data['data_status_voyage'] =  json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'voyage_status'])->row()->value, TRUE);
        $this->app_data['data_ship'] = Modules::run('database/find', 'mst_ship', ['isDeleted' => 'N'])->result();
        $this->app_data['data_depo'] = Modules::run('database/find', 'mst_depo', ['isDeleted' => 'N'])->result();
        $this->app_data['page_title'] = "DATA VOYAGE DALAM TRANSAKSI PELAYARAN";
        $this->app_data['view_file'] = 'view_proceed_voyage';
        echo Modules::run('template/horizontal_layout', $this->app_data);
    }

    public function list_data()
    {
        Modules::run('security/is_ajax');

        $date_from = $this->input->post('date_from') ? Modules::run('helper/change_date', $this->input->post('date_from'), '-') : '';
        $date_to = $this->input->post('date_to') ? Modules::run('helper/change_date', $this->input->post('date_to'), '-') : '';
        $depo_from = $this->input->post('depo_from');
        $depo_to = $this->input->post('depo_to');
        $status_voyage = $this->encrypt->decode($this->input->post('status_voyage'));
        $code = $this->input->post('code');
        $status_search = $this->input->post('status_search');

        $array_where = [];
        $or_array_where = [];
        $where_not_in = [];
        if ($status_search) {
        } else {
            $where_not_in['tb_voyage.status'] = [9, 8];
        }

        $array_status =  json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'voyage_status'])->row()->value, TRUE);

        if ($status_voyage) {
            $array_where['tb_voyage.status'] = $status_voyage;
        }

        if ($date_from) {
            $array_where['tb_voyage.date_from'] = $date_from;
        }
        if ($date_to) {
            $array_where['tb_voyage.date_to'] = $date_to;
        }
        if ($depo_from) {
            $array_where['tb_voyage.id_depo_from'] = $depo_from;
        }
        if ($depo_to) {
            $array_where['tb_voyage.id_depo_to'] = $depo_to;
        }
        if ($code) {
            $array_where['tb_voyage.code'] = $code;
        }

        $array_search = [];
        $array_query = [
            'select' => '
                tb_voyage.*,
                depo_from.name AS depo_from,
                depo_to.name AS depo_to,
                mst_ship.name AS ship_name
            ',
            'from' => 'tb_voyage',
            'join' => [
                'mst_depo AS depo_from, tb_voyage.id_depo_from = depo_from.id, left',
                'mst_depo AS depo_to, tb_voyage.id_depo_to = depo_to.id, left',
                'mst_ship, tb_voyage.id_ship = mst_ship.id, left'
            ]
        ];
        if (!empty($array_where)) {
            $array_query['where'] = $array_where;
        }
        if (!empty($where_not_in)) {
            $array_query['where_not_in'] = $where_not_in;
        }
        $get_data = Modules::run('database/get', $array_query)->result();

        $no = 0;
        $data = [];
        foreach ($get_data as $data_table) {
            $id_encrypt = $this->encrypt->encode($data_table->id);
            $btn_delete         = $data_table->status == 1 ||  $data_table->status == 2 ?  Modules::run('security/delete_access', ' <a href="javascript:void(0)" data-id="' . $id_encrypt . '" class="dropdown-item"><i class="fas fa-window-close"></i> Batalkan Voyage</a>') : '';
            $btn_transaction    = ($data_table->status > 1 && $data_table->status < 9)  ? '<a href="' . Modules::run('helper/create_url', '/transaction/detail?data=' . urlencode($id_encrypt)) . '" data-id="' . $id_encrypt . '" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Masuk Transaksi</a>' : '';

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_table->code;
            $row[] = $data_table->ship_name;
            $row[] = '
                <small class="text-muted"><i class="fa fa-map"></i> Depo Awal : </small>
                <label for="" class="d-block m-0"> <b>' . $data_table->depo_from . '</b></label>
                <small class="text-muted"><i class="fa fa-map"></i> Depo Tujuan :</small>
                <label for="" class="d-block m-0"><b> ' . $data_table->depo_to . '<b></label>
            ';
            $row[] = '
                <small class="text-muted"><i class="fa fa-calendar"></i> Tanggal Berangkat : </small>
                <label for="" class="d-block m-0"> <b>' . Modules::run('helper/date_indo', $data_table->date_from, '-') . '</b></label>
                <small class="text-muted"><i class="fa fa-calendar"></i> Tanggal Sampai :</small>
                <label for="" class="d-block m-0"><b> ' . Modules::run('helper/date_indo', $data_table->date_to, '-') . '<b></label>
            ';
            $row[] = '
                <small class="text-muted"><i class="fa fa-calendar"></i> Tanggal Dibuka : </small>
                <label for="" class="d-block m-0"> <b>' . Modules::run('helper/date_indo', $data_table->date_open, '-') . '</b></label>
                <small class="text-muted"><i class="fa fa-calendar"></i> Tanggal Ditutup :</small>
                <label for="" class="d-block m-0"><b> ' . Modules::run('helper/date_indo', $data_table->date_close, '-') . '<b></label>
            ';
            $status_name = isset($array_status[$data_table->status]) ? $array_status[$data_table->status] : '';

            $html_item_icon = '';
            $list_status =  json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'voyage_status'])->row()->value, TRUE);
            $list_status_icon =  json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'voyage_status_icon'])->row()->value, TRUE);
            $get_list_status = $this->get_list_status($data_table->id);

            if ($data_table->status == 9) {
                foreach ($get_list_status as $key_status => $value_status) {
                    $icon           = isset($list_status_icon[$key_status]) ? $list_status_icon[$key_status] : '';
                    $text_status    = isset($list_status[$key_status]) ? $list_status[$key_status] : '';
                    $time = Modules::run('helper/datetime_indo', $value_status['date']);
                    $html_item_icon .= '
                    <div class="align-items-center item d-flex row border-bottom p-0">
                        <div class="col-12">
                            <div class="">
                                <h6 class="text-uppercase text-primary">
                                    <i class="fa-lg ' . $icon . ' project bg-primary-transparent  mx-auto "></i> ' . $text_status . '
                                </h6>
                                
                            </div>
                        </div>
                        <div class="col-12">
                            <small class="my-auto  d-block">' . $value_status['description'] . '</small>
                        </div>
                        <div class="col-12">
                            <b><small class="my-auto  d-block">' . $time . '</small></b>
                        </div>
                    </div>
                ';
                }
            } else {
                foreach ($list_status as $key_status => $value_status) {
                    if ($key_status == 9) {
                        continue;
                    }
                    $icon = isset($list_status_icon[$key_status]) ? $list_status_icon[$key_status] : '';
                    $class_text = 'text-muted';
                    $class_bg = '';
                    $description = '-';
                    $date_time = '-';
                    $text_muted = 'text-muted';
                    $active_status = '';
                    if (isset($get_list_status[$key_status])) {
                        $class_text = 'text-primary font-weight-bold ';
                        $class_bg = 'bg-primary-transparent';
                        $description = $get_list_status[$key_status]['description'];
                        $date_time = Modules::run('helper/datetime_indo', $get_list_status[$key_status]['date']);
                        $text_muted = '';
                        $active_status = '
                            <i class="fa fa-check text-success position-absolute" style="right:0;"></i>
                        ';
                    }
                    if ($key_status == $data_table->status) {
                        $active_status = ' <div class="dot-label bg-success mr-1"></div>';
                    }
                    $html_item_icon .= '
                        <div class="align-items-center item d-flex row border-bottom p-2">
                            <div class="col-12 position-relative">
                                <div class="">
                                ' . $active_status . '
                                    <h6 class="text-uppercase ' . $class_text . '">
                                    <i class="fa-lg ' . $icon . ' project ' . $class_bg . ' mx-auto "></i> ' . $value_status . '
                                    </h6>
                                    
                                </div>
                            </div>
                            <div class="col-12">
                                <small class="my-auto ' . $text_muted . ' d-block">KET : ' . $description . '</small>
                            </div>
                            <div class="col-12">
                                <small class="my-auto font-weight-bold ' . $text_muted . ' d-block">TGL : ' . $date_time . '</small>
                            </div>
                        </div>
                    ';
                }
            }

            $icon = isset($list_status_icon[$data_table->status]) ? $list_status_icon[$data_table->status] : '';
            $date_time = Modules::run('helper/datetime_indo', $get_list_status[$data_table->status]['date']);

            $row[] = '
                    <div class="p-1 rounded border-dashed d-block text-center text-capitalize font-weight-bold" >
                    <span class="text-primary text-uppercase">  <i class="fa-lg ' . $icon . ' project bg-primary-transparent mx-auto "></i> ' . $status_name . '</span><br>
                    <small class="text-muted"><i class="fa fa-calendar"></i> ' . $date_time . '</small>
                    </div>
                    <div class="panel panel-default  mt-2 position-relative">
                        <div class="accor bg-primary ">
                            <h5 class="panel-title1" >
                                <a style="font-size:13px;" class="accordion-toggle collapsed p-2" data-toggle="collapse" data-parent="#view_' . $no . '" href="#view_' . $no . '" aria-expanded="false">
                                    <i class="fas fa-angle-down mr-2"></i> Tracking Status Voyage
                                </a>
                            </h5>
                        </div>
                        <div id="view_' . $no . '" class="panel-collapse collapse in position-absolute bg-white" style="z-index:1000;" role="tabpanel" aria-expanded="false">
                            <div class="panel-body border">
                                <div class="browser-stats">' . $html_item_icon . '</div>
                            </div>
                        </div>
                    </div>
            ';
            $row[] = '
                    <a href="' . Modules::run('helper/create_url', '/voyage/detail?data=' . urlencode($id_encrypt)) . '" data-id="' . $id_encrypt . '" class="btn btn-primary"><i class="fa fa-tv"></i> Detail Voyage</a>
                    ' . $btn_transaction . '
            ';
            $data[] = $row;
        }

        $ouput = array(
            "data" => $data
        );

        $array_respon = ['search' => $this->encrypt->encode(json_encode($array_search)), 'list' => $ouput];

        echo json_encode($array_respon);
    }

    public function list_proceed_voyage()
    {
        Modules::run('security/is_ajax');


        $where_not_in['tb_voyage.status'] = [1, 9, 8];

        $array_status =  json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'voyage_status'])->row()->value, TRUE);

        $array_search = [];
        $array_query = [
            'select' => '
                tb_voyage.*,
                depo_from.name AS depo_from,
                depo_to.name AS depo_to,
                mst_ship.name AS ship_name
            ',
            'from' => 'tb_voyage',
            'join' => [
                'mst_depo AS depo_from, tb_voyage.id_depo_from = depo_from.id, left',
                'mst_depo AS depo_to, tb_voyage.id_depo_to = depo_to.id, left',
                'mst_ship, tb_voyage.id_ship = mst_ship.id, left'
            ]
        ];
        if (!empty($where_not_in)) {
            $array_query['where_not_in'] = $where_not_in;
        }
        $get_data = Modules::run('database/get', $array_query)->result();

        $no = 0;
        $data = [];
        foreach ($get_data as $data_table) {
            $id_encrypt = $this->encrypt->encode($data_table->id);
            $btn_action = ' <a href="" class="btn btn-primary-gradient"><i class="fa fa-paper-plane"></i> Masuk Transaksi</a> ';

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_table->code;
            $row[] = $data_table->ship_name;
            $row[] = '
                <small class="text-muted"><i class="fa fa-map"></i> Depo Awal : </small>
                <label for="" class="d-block m-0"> <b>' . $data_table->depo_from . '</b></label>
                <small class="text-muted"><i class="fa fa-map"></i> Depo Tujuan :</small>
                <label for="" class="d-block m-0"><b> ' . $data_table->depo_to . '<b></label>
            ';
            $row[] = '
                <small class="text-muted"><i class="fa fa-calendar"></i> Tanggal Berangkat : </small>
                <label for="" class="d-block m-0"> <b>' . Modules::run('helper/date_indo', $data_table->date_from, '-') . '</b></label>
                <small class="text-muted"><i class="fa fa-calendar"></i> Tanggal Sampai :</small>
                <label for="" class="d-block m-0"><b> ' . Modules::run('helper/date_indo', $data_table->date_to, '-') . '<b></label>
            ';
            $row[] = '
                <small class="text-muted"><i class="fa fa-calendar"></i> Tanggal Dibuka : </small>
                <label for="" class="d-block m-0"> <b>' . Modules::run('helper/date_indo', $data_table->date_open, '-') . '</b></label>
                <small class="text-muted"><i class="fa fa-calendar"></i> Tanggal Ditutup :</small>
                <label for="" class="d-block m-0"><b> ' . Modules::run('helper/date_indo', $data_table->date_close, '-') . '<b></label>
            ';
            $status_name = isset($array_status[$data_table->status]) ? $array_status[$data_table->status] : '';

            $html_item_icon = '';
            $list_status =  json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'voyage_status'])->row()->value, TRUE);
            $list_status_icon =  json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'voyage_status_icon'])->row()->value, TRUE);
            $get_list_status = $this->get_list_status($data_table->id);

            if ($data_table->status == 9) {
                foreach ($get_list_status as $key_status => $value_status) {
                    $icon           = isset($list_status_icon[$key_status]) ? $list_status_icon[$key_status] : '';
                    $text_status    = isset($list_status[$key_status]) ? $list_status[$key_status] : '';
                    $time = Modules::run('helper/datetime_indo', $value_status['date']);
                    $html_item_icon .= '
                    <div class="align-items-center item d-flex row border-bottom p-0">
                        <div class="col-12">
                            <div class="">
                                <h6 class="text-uppercase text-primary">
                                    <i class="fa-lg ' . $icon . ' project bg-primary-transparent  mx-auto "></i> ' . $text_status . '
                                </h6>
                                
                            </div>
                        </div>
                        <div class="col-12">
                            <small class="my-auto  d-block">' . $value_status['description'] . '</small>
                        </div>
                        <div class="col-12">
                            <b><small class="my-auto  d-block">' . $time . '</small></b>
                        </div>
                    </div>
                ';
                }
            } else {
                foreach ($list_status as $key_status => $value_status) {
                    if ($key_status == 9) {
                        continue;
                    }
                    $icon = isset($list_status_icon[$key_status]) ? $list_status_icon[$key_status] : '';
                    $class_text = 'text-muted';
                    $class_bg = '';
                    $description = '-';
                    $date_time = '-';
                    $text_muted = 'text-muted';
                    $active_status = '';
                    if (isset($get_list_status[$key_status])) {
                        $class_text = 'text-primary font-weight-bold ';
                        $class_bg = 'bg-primary-transparent';
                        $description = $get_list_status[$key_status]['description'];
                        $date_time = Modules::run('helper/datetime_indo', $get_list_status[$key_status]['date']);
                        $text_muted = '';
                        $active_status = '
                            <i class="fa fa-check text-success position-absolute" style="right:0;"></i>
                        ';
                    }
                    if ($key_status == $data_table->status) {
                        $active_status = ' <div class="dot-label bg-success mr-1"></div>';
                    }
                    $html_item_icon .= '
                        <div class="align-items-center item d-flex row border-bottom p-2">
                            <div class="col-12 position-relative">
                                <div class="">
                                ' . $active_status . '
                                    <h6 class="text-uppercase ' . $class_text . '">
                                    <i class="fa-lg ' . $icon . ' project ' . $class_bg . ' mx-auto "></i> ' . $value_status . '
                                    </h6>
                                    
                                </div>
                            </div>
                            <div class="col-12">
                                <small class="my-auto ' . $text_muted . ' d-block">KET : ' . $description . '</small>
                            </div>
                            <div class="col-12">
                                <small class="my-auto font-weight-bold ' . $text_muted . ' d-block">TGL : ' . $date_time . '</small>
                            </div>
                        </div>
                    ';
                }
            }

            $icon = isset($list_status_icon[$data_table->status]) ? $list_status_icon[$data_table->status] : '';
            $date_time = Modules::run('helper/datetime_indo', $get_list_status[$data_table->status]['date']);

            $row[] = '
                    <div class="p-1 rounded border-dashed d-block text-center text-capitalize font-weight-bold" >
                    <span class="text-primary text-uppercase">  <i class="fa-lg ' . $icon . ' project bg-primary-transparent mx-auto "></i> ' . $status_name . '</span><br>
                    <small class="text-muted"><i class="fa fa-calendar"></i> ' . $date_time . '</small>
                    </div>
                    <div class="panel panel-default  mt-2 position-relative">
                        <div class="accor bg-primary ">
                            <h5 class="panel-title1" >
                                <a style="font-size:13px;" class="accordion-toggle collapsed p-2" data-toggle="collapse" data-parent="#view_' . $no . '" href="#view_' . $no . '" aria-expanded="false">
                                    <i class="fas fa-angle-down mr-2"></i> Tracking Status Voyage
                                </a>
                            </h5>
                        </div>
                        <div id="view_' . $no . '" class="panel-collapse collapse in  bg-white" style="z-index:1000;" role="tabpanel" aria-expanded="false">
                            <div class="panel-body border">
                                <div class="browser-stats">' . $html_item_icon . '</div>
                            </div>
                        </div>
                    </div>
            ';
            $row[] = '
                    <a href="' . Modules::run('helper/create_url', '/transaction/detail?data=' . urlencode($id_encrypt)) . '" data-id="' . $id_encrypt . '" class="btn-block mb-1 btn btn-primary-gradient"><i class="fa fa-paper-plane"></i> Masuk Transaksi</a>
                    ';
            $data[] = $row;
        }

        $ouput = array(
            "data" => $data
        );

        $array_respon = ['search' => $this->encrypt->encode(json_encode($array_search)), 'list' => $ouput];

        echo json_encode($array_respon);
    }

    private function get_list_status($id_voyage)
    {
        $get_all_status = Modules::run('database/find', 'tb_voyage_has_status', ['id_voyage' => $id_voyage])->result();
        $array_data = [];
        foreach ($get_all_status as $item_status) {
            $array_data[$item_status->status] = [
                'description' => $item_status->description,
                'date' => $item_status->created_date
            ];
        }
        return $array_data;
    }


    private function validate_save()
    {
        Modules::run('security/is_ajax');
        $data = array();

        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        $id = $this->input->post('id');
        if ($this->input->post('voyage') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'voyage';
            $data['status'] = FALSE;
        } else {
            $voyage = $this->input->post('voyage');
            $get_voyage = Modules::run('database/find', 'tb_voyage', ['code' => $voyage])->row();
            if (!empty($get_voyage)) {
                $data['error_string'][] = 'Kode telah dipakai';
                $data['inputerror'][] = 'voyage';
                $data['status'] = FALSE;
            }
        }

        if ($this->input->post('depo_from') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'depo_from';
            $data['status'] = FALSE;
        }
        if ($this->input->post('depo_to') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'depo_to';
            $data['status'] = FALSE;
        }
        if ($this->input->post('depo_from') != '' && $this->input->post('depo_to') != '') {
            if ($this->input->post('depo_from') == $this->input->post('depo_to')) {
                $data['error_string'][] = 'tidak boleh sama dengan depo asal';
                $data['inputerror'][] = 'depo_to';
                $data['status'] = FALSE;
            }
        }
        if ($this->input->post('date_from') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'date_from';
            $data['status'] = FALSE;
        }
        if ($this->input->post('date_to') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'date_to';
            $data['status'] = FALSE;
        }
        if ($this->input->post('date_from') != '' && $this->input->post('date_to') != '') {
            if (strtotime($this->input->post('date_from')) > strtotime($this->input->post('date_to'))) {
                $data['error_string'][] = 'harus lebih besar dari tanggal keberangkatan';
                $data['inputerror'][] = 'date_to';
                $data['status'] = FALSE;
            }
        }
        if ($this->input->post('ship') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'ship';
            $data['status'] = FALSE;
        }
        if ($this->input->post('date_close') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'date_close';
            $data['status'] = FALSE;
        }
        if ($this->input->post('date_open') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'date_open';
            $data['status'] = FALSE;
        }

        if ($this->input->post('date_open') != '' && $this->input->post('date_close') != '') {
            if (strtotime($this->input->post('date_open')) > strtotime($this->input->post('date_close'))) {
                $data['error_string'][] = 'harus lebih besar dari tanggal Open';
                $data['inputerror'][] = 'date_close';
                $data['status'] = FALSE;
            }
        }

        if ($data['status'] == FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    public function save()
    {
        $this->validate_save();

        $voyage       = $this->input->post('voyage');
        $depo_from    = $this->input->post('depo_from');
        $depo_to      = $this->input->post('depo_to');
        $date_from    = Modules::run('helper/change_date', $this->input->post('date_from'), '-');
        $date_to      = Modules::run('helper/change_date', $this->input->post('date_to'), '-');
        $ship         = $this->input->post('ship');
        $date_open    = Modules::run('helper/change_date', $this->input->post('date_open'), '-');
        $date_close   = Modules::run('helper/change_date', $this->input->post('date_close'), '-');

        $array_insert = [
            'code' => $voyage,
            'id_depo_from' => $depo_from,
            'id_depo_to' => $depo_to,
            'id_ship' => $ship,
            'date_from' => $date_from,
            'date_to' => $date_to,
            'date_open' => $date_open,
            'date_close' => $date_close,
            'status' => 1,
            'created_by' => $this->session->userdata('us_id')
        ];
        Modules::run('database/insert', 'tb_voyage', $array_insert);

        //status
        $get_data = Modules::run('database/find', 'tb_voyage', ['code' => $voyage])->row();
        Modules::run('voyage/insert_status_voyage', $get_data->id, 1);
        echo json_encode(['status' => true]);
    }

    public function insert_status_voyage($id_voyage, $status)
    {
        $array_status = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'voyage_status'])->row()->value, TRUE);
        $status_description = isset($array_status[$status]) ? $array_status[$status] : '';
        $description = $status_description . ' oleh petugas ' . $this->session->userdata('us_name');

        $array_insert = [
            'id_voyage' => $id_voyage,
            'status' => $status,
            'description' => $description
        ];
        Modules::run('database/insert', 'tb_voyage_has_status', $array_insert);
        echo json_encode(['status' => TRUE]);
    }


    public function detail()
    {
        Modules::run('security/is_axist_data', ['name' => 'data', 'method' => 'GET', 'encrypt' => TRUE]);
        $id = $this->encrypt->decode($this->input->get('data'));

        $array_query = [
            'select' => '
                tb_voyage.*,
                depo_from.name AS depo_from,
                depo_to.name AS depo_to,
                mst_ship.name AS ship_name,
                mst_ship.image AS image_name,
                mst_ship.tonase_limit,
                mst_ship.container_slot
            ',
            'from' => 'tb_voyage',
            'join' => [
                'mst_depo AS depo_from, tb_voyage.id_depo_from = depo_from.id, left',
                'mst_depo AS depo_to, tb_voyage.id_depo_to = depo_to.id, left',
                'mst_ship, tb_voyage.id_ship = mst_ship.id, left'
            ],
            'where' => [
                'tb_voyage.id' => $id
            ]
        ];
        $get_data = Modules::run('database/get', $array_query)->row();
        $this->app_data['data_detail'] = $get_data;


        $this->app_data['list_status'] =  json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'voyage_status'])->row()->value, TRUE);
        $this->app_data['list_status_icon'] =  json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'voyage_status_icon'])->row()->value, TRUE);
        $this->app_data['get_list_status'] = $this->get_list_status($id);
        $this->app_data['page_title'] = "DETAIL VOYAGE " . $get_data->code;
        $this->app_data['view_file'] = 'view_detail';
        echo Modules::run('template/horizontal_layout', $this->app_data);
    }

    public function close_ticket()
    {
        Modules::run('security/is_ajax');
        $id = $this->encrypt->decode($this->input->post('id'));
        $status_update = 2;
        $array_update = [
            'status' => $status_update
        ];
        Modules::run('database/update', 'tb_voyage', ['id' => $id], $array_update);

        Modules::run('voyage/insert_status_voyage', $id, $status_update);
        echo json_encode(['status' => true]);
    }

    public function cancel_voyage()
    {
        Modules::run('security/is_ajax');
        $id = $this->encrypt->decode($this->input->post('id'));
        $note = $this->input->post('note');
        $status_update = 9;
        $array_update = [
            'additional_note' => $note,
            'status' => $status_update
        ];
        Modules::run('database/update', 'tb_voyage', ['id' => $id], $array_update);

        Modules::run('voyage/insert_status_voyage', $id, $status_update);
        echo json_encode(['status' => true]);
    }


    public function print()
    {
        $encrypt_data_search = $this->encrypt->decode($this->input->post('search'));
        $data_search = json_decode($encrypt_data_search);

        $array_where['mst_customer.isDeleted'] = 'N';
        $array_query = [
            'select' => '
                mst_customer.*
            ',
            'from' => 'mst_customer',
            'where' => $array_where,
            'order_by' => 'mst_customer.id, DESC'
        ];
        $get_data = Modules::run('database/get', $array_query)->result();

        if ($this->input->post('print_excel')) {
            $this->export_excel($get_data);
        }
        if ($this->input->post('print_pdf')) {
            $this->export_pdf($get_data);
        }
    }

    public function export_excel($data)
    {
        error_reporting(0);
        $this->load->library("PHPExcel");
        //membuat objek
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $sheet = $objPHPExcel->getActiveSheet();
        //set column 
        $sheet->getColumnDimension('A')->setWidth('5');
        $sheet->getColumnDimension('B')->setWidth('20');
        $sheet->getColumnDimension('C')->setWidth('30');
        $sheet->getColumnDimension('D')->setWidth('30');
        $sheet->getColumnDimension('E')->setWidth('25');
        $sheet->getColumnDimension('F')->setWidth('20');
        $sheet->getColumnDimension('G')->setWidth('20');
        $sheet->getColumnDimension('H')->setWidth('15');
        $sheet->getColumnDimension('I')->setWidth('40');
        $sheet->getColumnDimension('J')->setWidth('10');

        //bold style 
        $sheet->getStyle("A1:J2")->getFont()->setBold(true);
        $styleThinBlackBorderOutline = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );

        // //marge and center
        $sheet->mergeCells('A1:J2');
        $sheet->getStyle('A1:J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:J2')->getFont()->setSize(18);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'LAPORAN DATA CUSTOMER');
        $sheet->getStyle('A3:J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        //sheet table resume 
        $from = "A3"; // or any value
        $to = "J3"; // or any value
        $objPHPExcel->getActiveSheet()->getStyle("$from:$to")->getFont()->setBold(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', 'No');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', 'NAMA LENGKAP');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', 'EMAIL');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', 'NO.TELP');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', 'NPWP');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', 'PIC');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', 'KREDIT LIMIT (RP)');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', 'LIMIT JATUH TEMPO (HARI)');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', 'ALAMAT');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', 'STATUS');
        $sheet_number_resume = 3;
        $no = 0;

        $objPHPExcel->getActiveSheet()->getStyle('A' . $sheet_number_resume . ':J' . $sheet_number_resume)
            ->applyFromArray($styleThinBlackBorderOutline);
        $sheet->getStyle('A' . $sheet_number_resume . ':J' . $sheet_number_resume)->applyFromArray(
            array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '366092')
                ),
                'font'  => array(
                    'bold'  => true,
                    'color' => array('rgb' => 'FFFFFF'),
                    'size'  => 12
                )
            )
        );


        foreach ($data as $data_table) {
            $active = $data_table->isActive == 'Y' ? 'Aktif' : 'Non-Aktif';
            $sheet_number_resume++;
            $no++;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $sheet_number_resume, $no);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $sheet_number_resume, $data_table->name);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $sheet_number_resume, $data_table->email);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $sheet_number_resume, $data_table->number_phone);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $sheet_number_resume, $data_table->npwp);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $sheet_number_resume, $data_table->pic);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $sheet_number_resume, $data_table->credit_limit);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $sheet_number_resume, $data_table->expired_limit);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $sheet_number_resume, $data_table->address);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $sheet_number_resume, $active);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $sheet_number_resume . ':J' . $sheet_number_resume)
                ->applyFromArray($styleThinBlackBorderOutline);
        }
        //Set Title
        $objPHPExcel->getActiveSheet()->setTitle('LAPORAN DATA');
        //Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        //Header
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //Nama File
        header('Content-Disposition: attachment;filename="LAPORAN DATA CUSTOMER PER ' . date('d-m-Y') . '.xlsx"');
        //Download
        $objWriter->save("php://output");
    }

    public function export_pdf($data_customer)
    {
        error_reporting(0);
        ob_clean();
        $data['data_customer'] = $data_customer;
        //print_r($data['data_profile']);
        //exit;
        ob_start();
        $this->load->view('pdf_customer', $data);
        //print_r($html);
        //exit;
        $html = ob_get_contents();
        ob_end_clean();
        require_once('../assets/plugin/html2pdf/html2pdf.class.php');
        $pdf = new HTML2PDF('L', 'A4', 'en', true, 'UTF-8', array(5, 5, 5, 5));
        $pdf->WriteHTML($html);
        $pdf->Output('LAPORAN DATA CUSTOMER PER -' . date('d-m-Y') . '.pdf', 'D');
    }
}
