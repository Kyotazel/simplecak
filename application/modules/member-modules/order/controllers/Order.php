<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends BackendController
{
    var $module_name        = 'order';
    var $module_directory   = 'order';
    var $module_js          = ['order'];
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



        $this->app_data['page_title'] = "INPUT BOOKING SLOT KONTAINER";
        $this->app_data['view_file'] = 'main_view';
        echo Modules::run('template/horizontal_layout', $this->app_data);
    }

    private function validate_search()
    {
        Modules::run('security/is_ajax');
        $data = array();

        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        $id = $this->input->post('id');

        if ($this->encrypt->decode($this->input->post('depo_from')) != '' &&  $this->encrypt->decode($this->input->post('depo_to')) != '') {
            if ($this->encrypt->decode($this->input->post('depo_from')) == $this->encrypt->decode($this->input->post('depo_to'))) {
                $data['error_string'][] = 'tidak boleh sama dengan depo asal';
                $data['inputerror'][] = 'depo_to';
                $data['status'] = FALSE;
            }
        }

        if ($data['status'] == FALSE) {
            echo json_encode($data);
            exit();
        }
    }
    public function list_data()
    {
        Modules::run('security/is_ajax');
        $this->validate_search();

        $date_from = $this->input->post('date_from') ? Modules::run('helper/change_date', $this->input->post('date_from'), '-') : '';
        $date_to = $this->input->post('date_to') ? Modules::run('helper/change_date', $this->input->post('date_to'), '-') : '';

        $depo_from = $this->encrypt->decode($this->input->post('depo_from'));
        $depo_to = $this->encrypt->decode($this->input->post('depo_to'));

        $array_where = [];
        $array_where['tb_voyage.status'] = 1;
        if (!empty($date_from)) {
            $array_where['tb_voyage.date_from >='] = $date_from;
        }
        if (!empty($date_to)) {
            $array_where['tb_voyage.date_from <='] = $date_to;
        }

        if (!empty($depo_from)) {
            $array_where['tb_voyage.id_depo_from'] = $depo_from;
        }
        if (!empty($depo_to)) {
            $array_where['tb_voyage.id_depo_to'] = $depo_to;
        }

        $array_search = [];
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
            'order_by' => 'tb_voyage.date_from'
        ];

        if (!empty($array_where)) {
            $array_query['where'] = $array_where;
        }

        $get_data = Modules::run('database/get', $array_query)->result();

        $data['data_voyage'] = $get_data;
        $html_respon = $this->load->view('view_search_result', $data, TRUE);

        $array_respon = ['status' => TRUE, 'html_respon' => $html_respon];

        echo json_encode($array_respon);
    }

    public function transaction()
    {
        Modules::run('security/is_axist_data', ['name' => 'data', 'method' => 'GET', 'encrypt' => TRUE]);
        $id = $this->encrypt->decode($this->input->get('data'));
        $this->app_data['data_member'] = Modules::run('database/find', 'mst_customer', ['isDeleted' => 'N'])->result();

        // $array = [
        //     1 => 'CY - CY',
        //     2 => 'CY - DOOR',
        //     3 => 'DOOR - DOOR',
        //     4 => 'DOOR - CY',
        //     5 => 'REPO - REPO'
        // ];
        // print_r(json_encode($array));
        // exit;

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

        $this->app_data['category_countainer']  = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'countainer_category'])->row()->value, TRUE);
        $this->app_data['category_stuffing']    = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_stuffing'])->row()->value, TRUE);
        $this->app_data['category_teus']        = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_teus'])->row()->value, TRUE);
        $this->app_data['category_service']        = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_service'])->row()->value, TRUE);
        $this->app_data['ppn_tax'] = Modules::run('database/find', 'app_module_setting', ['field' => 'ppn_tax'])->row()->value;

        $this->app_data['category_load'] = Modules::run('database/find', 'mst_category_load', ['isDeleted' => 'N'])->result();
        $this->app_data['category_stuff'] = Modules::run('database/find', 'mst_category_stuff', ['isDeleted' => 'N'])->result();
        $this->app_data['list_transport'] = Modules::run('database/find', 'mst_transportation', ['isDeleted' => 'N'])->result();


        $this->app_data['list_status'] =  json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'voyage_status'])->row()->value, TRUE);
        $this->app_data['list_status_icon'] =  json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'voyage_status_icon'])->row()->value, TRUE);
        $this->app_data['page_title'] = "TRANSAKSI BOOKING SLOT " . $get_data->code;
        $this->app_data['view_file'] = 'view_transaction';
        echo Modules::run('template/horizontal_layout', $this->app_data);
    }

    public function validate_add_item_countainer()
    {
        Modules::run('security/is_ajax');
        $data = array();

        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        // this validate if there is same file to be uploaded
        $id = $this->input->post('id');
        if ($this->encrypt->decode($this->input->post('teus')) == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'teus';
            $data['status'] = FALSE;
        }
        if ($this->encrypt->decode($this->input->post('container_type')) == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'container_type';
            $data['status'] = FALSE;
        }
        if ($this->input->post('qty') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'qty';
            $data['status'] = FALSE;
        }
        if ($this->encrypt->decode($this->input->post('stuffing_take')) == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'stuffing_take';
            $data['status'] = FALSE;
        }
        if ($this->encrypt->decode($this->input->post('stuffing_open')) == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'stuffing_open';
            $data['status'] = FALSE;
        }
        if ($this->encrypt->decode($this->input->post('category_load')) == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'category_load';
            $data['status'] = FALSE;
        }
        if ($this->encrypt->decode($this->input->post('category_stuff')) == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'category_stuff';
            $data['status'] = FALSE;
        }

        if ($data['status'] == FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    public function add_item_countainer()
    {
        Modules::run('security/is_ajax');
        $this->validate_add_item_countainer();

        $teus = $this->encrypt->decode($this->input->post('teus'));
        $container_type = $this->encrypt->decode($this->input->post('container_type'));
        $qty = $this->input->post('qty');
        $stuffing_take = $this->encrypt->decode($this->input->post('stuffing_take'));
        $stuffing_open = $this->encrypt->decode($this->input->post('stuffing_open'));
        $address_stuffing_take = $this->input->post('address_stuffing_take');
        $address_stuffing_open = $this->input->post('address_stuffing_open');
        $array_category_load = json_decode($this->encrypt->decode($this->input->post('category_load')), TRUE);
        $array_category_stuff = json_decode($this->encrypt->decode($this->input->post('category_stuff')), TRUE);
        $id_depo_from = $this->input->post('id_depo_from');
        $service = $this->input->post('service');
        $id_member = $this->input->post('id_member');

        //freight
        $array_where = [
            'id_depo' => $id_depo_from,
            'category_countainer' => $container_type,
            'category_teus' => $teus,
            'category_stuffing_take' => $stuffing_take,
            'type' => 1,
            'is_default' => 1,
            'id_customer' => $id_member
        ];
        $get_price = Modules::run('database/find', 'tb_countainer_price', $array_where)->row();
        $price_freight = !empty($get_price) ? $get_price->price : 0;

        //THC
        $array_where = [
            'id_depo' => $id_depo_from,
            'category_countainer' => $container_type,
            'category_teus' => $teus,
            'category_stuffing_take' => $stuffing_take,
            'type' => 2,
            'is_default' => 1,
            'id_customer' => $id_member
        ];
        $get_price_thc = Modules::run('database/find', 'tb_countainer_price', $array_where)->row();
        $price_thc = !empty($get_price_thc) ? $get_price_thc->price : 0;

        $total_price = $qty * ($price_freight + $price_thc);

        $category_countainer  = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'countainer_category'])->row()->value, TRUE);
        $category_stuffing    = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_stuffing'])->row()->value, TRUE);
        $category_teus        = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_teus'])->row()->value, TRUE);
        $category_service     = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_service'])->row()->value, TRUE);

        $category_countainer_text       = isset($category_countainer[$container_type]) ? $category_countainer[$container_type] : '';
        $category_stuffing_take_text    = isset($category_stuffing[$stuffing_take]) ? $category_stuffing[$stuffing_take] : '';
        $category_stuffing_open_text    = isset($category_stuffing[$stuffing_open]) ? $category_stuffing[$stuffing_open] : '';
        $teus_text                      = isset($category_teus[$teus]) ? $category_teus[$teus] : '';
        $service_text                   = isset($category_service[$service]) ? $category_service[$service] : '';

        $arrange_class = $container_type . $teus . $array_category_load['id'] . $array_category_stuff['id'];
        // $arrange_class_1 = '';
        $html_response = '
            <tr class="item_detail item_container countainer_' . $arrange_class . '">
                <input type="hidden" name="type[]" value="1">
                <input type="hidden" name="countainer_type[]" value="' . $container_type . '">
                <input type="hidden" name="teus[]" value="' . $teus . '">
                <input type="hidden" name="stuffing_take[]" value="' . $stuffing_take . '">
                <input type="hidden" name="stuffing_open[]" value="' . $stuffing_open . '">
                <input type="hidden" name="address_stuffing_take[]" value="' . $address_stuffing_take . '">
                <input type="hidden" name="address_stuffing_open[]" value="' . $address_stuffing_open . '">
                <input type="hidden" name="array_category_load[]" value="' . $array_category_load['id'] . '">
                <input type="hidden" name="array_category_stuff[]" value="' . $array_category_stuff['id'] . '">
                <input type="hidden" name="array_category_service[]" value="' . $service . '">
                <input type="hidden" name="price[]" value="' . $price_freight . '">
                <input type="hidden" name="price_thc[]" value="' . $price_thc . '">

                <input type="hidden" name="transport[]" value="">
                <input type="hidden" name="detail_transport[]" value="">
                <input type="hidden" name="description[]" value="">

                <td>
                    <a href="javascript:void(0)" class="custom chip border-dashed">
                        <span class="avatar cover-image bg-primary-gradient"><i class="fa fa-box"></i></span> Kontainer
                    </a>
                </td>
                <td>
                    <small for="" class="d-block text-muted">Kategori Kontainer :</small>
                    <label for=""> ' . strtoupper($category_countainer_text) . '</label>
                    <small for="" class="d-block text-muted">Teus :</small>
                    <label for=""> ' . strtoupper($teus_text) . ' TEUS</label>
                    <small for="" class="d-block text-muted">Service :</small>
                    <label for=""> ' . strtoupper($service_text) . '    </label>
                </td>
                <td>
                    <small for="" class="d-block text-muted">Stuffing (Pengisian) :</small>
                    <label for="" class="m-0"> ' . strtoupper($category_stuffing_take_text) . '</label>
                    <p class="border-dashed tx-13 p-1">
                        Alamat :<br> 
                        ' . $address_stuffing_take . '
                    </p>
                    <small for="" class="d-block text-muted">Stuffing (Pengambilan) :</small>
                    <label for="" class="m-0"> ' . strtoupper($category_stuffing_open_text) . '</label>
                    <p class="border-dashed tx-13 p-1">
                        Alamat :<br> 
                        ' . $address_stuffing_open . '
                    </p>
                </td>
                <td>
                    <small class="d-block text-muted">Kategori Barang Muatan :</small>
                    <label for="" class="d-block p-2 border-dashed">' . strtoupper($array_category_load['value']) . '</label>
                    <small class="d-block text-muted">Barang Muatan:</small>
                    <label for="" class="d-block p-2 border-dashed">' . strtoupper($array_category_stuff['value']) . '</label>
                </td>
                <td  style="width:165px;">
                    <div class="input-group group-plus-minus">
                        <div class="input-group-prepend btn_custom_minus btn_act_qty" data-price="' . ($price_freight + $price_thc) . '">
                            <span class="input-group-text">
                                <i class="fa fa-minus"></i>
                            </span>
                        </div>
                        <input data-teus="' . $teus_text . '" value="' . $qty . '" name="qty[]" class="form-control value" min="1" type="number">
                        <div class="input-group-append btn_custom_plus btn_act_qty" data-price="' . ($price_freight + $price_thc) . '">
                            <span class="input-group-text">
                                <i class="fa fa-plus"></i>
                            </span>
                        </div>
                    </div>
                </td>
                <td style="width:250px;">
                    <small class="d-block text-muted"> Harga Freight :</small>
                    <label for="" class="p-1 border-dashed d-block tx-15">
                        <span class="text-qty">' . $qty . '</span> x <span class="text-price"  data-price="' . $price_freight . '">' . number_format($price_freight, 0, '.', '.') . '</span>
                    </label>
                    <small class="d-block text-muted"> Harga THC :</small>
                    <label for="" class="p-1 border-dashed d-block tx-15">
                        <span class="text-qty">' . $qty . '</span> x <span class="text-price"  data-price="' . $price_thc . '">' . number_format($price_thc, 0, '.', '.') . '</span>
                    </label>
                    <small class="d-block text-muted">Total Harga :</small>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text font-weight-bold">
                                Rp.
                            </div>
                        </div>
                        <input  value="' . number_format($total_price, 0, '.', '.') . '" class="font-weight-bold form-control border-dashed money_only text-total-price bg-white" readonly=""  type="text">
                    </div>
                    <small class="text-muted d-block mb-3"><i class="fa fa-info-circle"></i> Perkiraan total biaya.</small>
                </td>
                <td>
                    <a href="javascript:void(0)" class="btn btn-sm btn-danger btn_del_item"><i class="fa fa-trash"></i></a>
                </td>

            </tr>
        ';

        $array_respon = [
            'status' => TRUE,
            'html_item' => $html_response,
            'class' => $arrange_class
        ];
        echo json_encode($array_respon);
    }


    public function validate_add_item_lc()
    {
        Modules::run('security/is_ajax');
        $data = array();

        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        // this validate if there is same file to be uploaded
        $id = $this->input->post('id');
        if ($this->encrypt->decode($this->input->post('transport')) == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'transport';
            $data['status'] = FALSE;
        }

        if ($this->encrypt->decode($this->input->post('category_stuff')) == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'category_stuff';
            $data['status'] = FALSE;
        }

        if ($data['status'] == FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    public function add_item_lc()
    {
        Modules::run('security/is_ajax');
        $this->validate_add_item_lc();

        $transport = json_decode($this->encrypt->decode($this->input->post('transport')), TRUE);
        $detail_transport = $this->input->post('detail_transport');
        $qty = count($detail_transport);
        $description = $this->input->post('description');
        $array_category_stuff = json_decode($this->encrypt->decode($this->input->post('category_stuff')), TRUE);
        $id_depo_from = $this->input->post('id_depo_from');
        $array_where = [
            'id_depo' => $id_depo_from,
            'id_transportation' => $transport['id']
        ];
        $get_price = Modules::run('database/find', 'tb_loss_cargo_price', $array_where)->row();
        $price_use = !empty($get_price) ? $get_price->price : 0;
        $total_price = $qty * $price_use;

        $html_detail_transport = '';
        foreach ($detail_transport as $item_detail) {
            $html_detail_transport .= '
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-truck"></i></span>
                    </div>
                    <input class="form-control bg-white border-dashed" readonly value="' . $item_detail . '" type="text">
                </div>
            ';
        }

        // $category_countainer_text       = isset($category_countainer[$container_type]) ? $category_countainer[$container_type] : '';
        // $category_stuffing_take_text    = isset($category_stuffing[$stuffing_take]) ? $category_stuffing[$stuffing_take] : '';
        // $category_stuffing_open_text    = isset($category_stuffing[$stuffing_open]) ? $category_stuffing[$stuffing_open] : '';
        // $teus_text                      = isset($category_teus[$teus]) ? $category_teus[$teus] : '';
        // $service_text                   = isset($category_service[$service]) ? $category_service[$service] : '';

        $arrange_class = $transport['id'] . $array_category_stuff['id'];
        // $arrange_class_1 = '';
        $html_response = '
            <tr class="item_detail item_container countainer_' . $arrange_class . '">
                <input type="hidden" name="type[]" value="2">
                <input type="hidden" name="transport[]" value="' . $transport['id'] . '">
                <input type="hidden" name="detail_transport[]" value="' . $this->encrypt->encode(json_encode($detail_transport)) . '">
                <input type="hidden" name="qty[]" value="' . $qty . '">
                <input type="hidden" name="description[]" value="' . $description . '">
                <input type="hidden" name="array_category_stuff[]" value="' . $array_category_stuff['id'] . '">
                <input type="hidden" name="price[]" value="' . $price_use . '">
                <input type="hidden" name="price_thc[]" value="">

                <input type="hidden" name="countainer_type[]" value="">
                <input type="hidden" name="teus[]" value="">
                <input type="hidden" name="stuffing_take[]" value="">
                <input type="hidden" name="stuffing_open[]" value="">
                <input type="hidden" name="address_stuffing_take[]" value="">
                <input type="hidden" name="address_stuffing_open[]" value="">
                <input type="hidden" name="array_category_load[]" value="">
                <input type="hidden" name="array_category_service[]" value="">

                <td>
                    <a href="javascript:void(0)" class="custom chip border-dashed">
                        <span class="avatar cover-image bg-primary-gradient"><i class="fa fa-truck"></i></span> Loss Cargo
                    </a>
                </td>
                <td colspan="2">
                    <small for="" class="d-block text-muted">Jenis Transportasi :</small>
                    <label class="mb-2 p-2 border-dashed d-block" for=""> ' . strtoupper($transport['value']) . '</label>
                    <small for="" class="d-block text-muted">Detail Transportasi :</small>
                    ' . $html_detail_transport . '
                </td>
                
                <td>
                    <small class="d-block text-muted">Barang Muatan:</small>
                    <label for="" class="d-block p-2 border-dashed">' . strtoupper($array_category_stuff['value']) . '</label>
                    <small for="" class="d-block text-muted">Keterangan :</small>
                    <p for="" class="m-0 p-2 border-dashed"> ' . nl2br(strtoupper($description)) . '</p>
                </td>
                <td  style="width:165px;">
                    <small class="d-block text-muted">Jumlah Kendaraan:</small>
                    <h3 class="mb-1 p-2 border-dashed text-center value_lc" data-qty="' . $qty . '">' . $qty . '</h3>
                </td>
                <td style="width:250px;">
                    <small class="d-block text-muted">Rincian Harga :</small>
                    <label for="" class="p-1 border-dashed d-block tx-15">
                        <span class="text-qty">' . $qty . '</span> x <span class="text-price"  data-price="' . $price_use . '">' . number_format($price_use, 0, '.', '.') . '</span>
                    </label>
                    <small class="d-block text-muted">Total Harga :</small>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text font-weight-bold">
                                Rp.
                            </div>
                        </div>
                        <input  value="' . number_format($total_price, 0, '.', '.') . '" class="font-weight-bold form-control border-dashed money_only text-total-price bg-white" readonly=""  type="text">
                    </div>
                    <small class="text-muted d-block mb-3"><i class="fa fa-info-circle"></i> Perkiraan total biaya.</small>
                </td>
                <td>
                    <a href="javascript:void(0)" class="btn btn-sm btn-danger btn_del_item"><i class="fa fa-trash"></i></a>
                </td>

            </tr>
        ';

        $array_respon = [
            'status' => TRUE,
            'html_item' => $html_response,
            'class' => $arrange_class
        ];
        echo json_encode($array_respon);
    }

    private function get_code($voyage)
    {
        $number_text = 0;
        $array_query = [
            'select' => '
                depo_from.code AS depo_from,
                depo_to.code AS depo_to
            ',
            'from' => 'tb_voyage',
            'join' => [
                'mst_depo AS depo_from, tb_voyage.id_depo_from = depo_from.id, left',
                'mst_depo AS depo_to, tb_voyage.id_depo_to = depo_to.id, left'
            ],
            'where' => [
                'tb_voyage.id' => $voyage
            ]
        ];
        $get_data_voyage = Modules::run('database/get', $array_query)->row();


        $simbol = 'BL.LPL/' . $get_data_voyage->depo_from . '/' . $get_data_voyage->depo_to . '/';
        $first_number = 1;
        $code_pattern = substr(date('Y'), 2) . date('md');
        $code_pattern_like = $simbol . $code_pattern;
        // $get_data_exist = $this->db->query("select max(code) as max_code from tb_credit")->row_array();
        $get_data_exist = $this->db->query("select code AS max_code  from tb_booking WHERE id IN(SELECT MAX(id) FROM tb_booking Where code like '" . $simbol . "%')")->row_array();
        if (!empty($get_data_exist['max_code'])) {
            $explode_code = explode('/', $get_data_exist['max_code']);
            $clean_simbol = (int)end($explode_code);
            $code = $clean_simbol + 1;
        } else {
            $code = $first_number;
        }
        $code = sprintf("%05s", $code);
        $code_return = $simbol . $code;
        return $code_return;
    }

    public function save_transaction()
    {
        Modules::run('security/is_ajax');

        $id_member = $this->input->post('id_member');
        $receiver = $this->input->post('receiver');
        $address = $this->input->post('address');

        $materai_status = $this->input->post('materai_status');
        $price_materai = $materai_status ? Modules::run('database/find', 'app_module_setting', ['field' => 'price_materai'])->row()->value : 0;
        $note = $this->input->post('note');
        $tax_value = $this->input->post('tax_value');
        $tax_status = $this->input->post('tax_status');
        $tax = $tax_status ? $tax_value : 0;
        $id_voyage = $this->input->post('id_voyage');
        $arr_countainer_type = $this->input->post('countainer_type');
        $arr_teus = $this->input->post('teus');
        $arr_stuffing_take = $this->input->post('stuffing_take');
        $arr_stuffing_open = $this->input->post('stuffing_open');
        $arr_address_stuffing_take = $this->input->post('address_stuffing_take');
        $arr_address_stuffing_open = $this->input->post('address_stuffing_open');
        $arr_category_load = $this->input->post('array_category_load');
        $arr_category_stuff = $this->input->post('array_category_stuff');
        $arr_category_service = $this->input->post('array_category_service');
        $arr_price = $this->input->post('price');
        $arr_price_thc = $this->input->post('price_thc');

        $array_type = $this->input->post('type');
        $array_transport = $this->input->post('transport');
        $array_detail_transport = $this->input->post('detail_transport');
        $array_description = $this->input->post('description');

        $arr_qty = $this->input->post('qty');

        $code = $this->get_code($id_voyage);

        $array_insert = [
            'code' => $code,
            'id_customer' => $id_member,
            'id_voyage' => $id_voyage,
            'receiver' => $receiver,
            'receiver_address' => $address,
            'ppn' => $tax,
            'status' => 1,
            'include_materai' => $materai_status,
            'price_materai' => $price_materai,
            'date' => date('Y-m-d'),
            'note' => $note,
            'is_confirm' => false
        ];
        Modules::run('database/insert', 'tb_booking', $array_insert);

        //detail BS
        $get_data_bs = Modules::run('database/find', 'tb_booking', ['code' => $code])->row();
        $category_teus        = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_teus'])->row()->value, TRUE);
        $total_teus = 0;
        foreach ($array_type as $key => $item) {
            if ($array_type[$key] == 1) {
                //countainer
                $grand_total_price = ($arr_price[$key] * $arr_qty[$key]) + ($arr_price_thc[$key] * $arr_qty[$key]);
                $array_insert = [
                    'type' => $array_type[$key],
                    'id_booking' => $get_data_bs->id,
                    'id_category_load' => $arr_category_load[$key],
                    'id_category_stuff' => $arr_category_stuff[$key],
                    'category_countainer' => $arr_countainer_type[$key],
                    'category_teus' => $arr_teus[$key],
                    'stuffing_take' => $arr_stuffing_take[$key],
                    'stuffing_take_address' => $arr_address_stuffing_take[$key],
                    'stuffing_open' => $arr_stuffing_open[$key],
                    'stuffing_open_address' => $arr_address_stuffing_open[$key],
                    'category_service' => $arr_category_service[$key],
                    'qty' => $arr_qty[$key],
                    'price' => $arr_price[$key],
                    'total_price' => ($arr_price[$key] * $arr_qty[$key]),
                    'price_thc' => $arr_price_thc[$key],
                    'total_price_thc' => ($arr_price_thc[$key] * $arr_qty[$key]),
                    'grand_total_price' => $grand_total_price
                ];
                Modules::run('database/insert', 'tb_booking_has_detail', $array_insert);
                $total_teus += ($category_teus[$arr_teus[$key]] *  $arr_qty[$key]);
                //detail countainer
                $get_data_detail = $this->db->select('MAX(id) AS id_detail')->where(['id_booking' => $get_data_bs->id])->get('tb_booking_has_detail')->row();
                for ($i = 0; $i < $arr_qty[$key]; $i++) {
                    $array_countainer = [
                        'id_voyage' => $id_voyage,
                        'id_booking' => $get_data_bs->id,
                        'id_booking_detail' => $get_data_detail->id_detail,
                    ];
                    Modules::run('database/insert', 'tb_booking_has_countainer', $array_countainer);
                }
            } else {
                //loss cargo
                $array_insert = [
                    'type' => $array_type[$key],
                    'id_booking' => $get_data_bs->id,
                    'id_category_stuff' => $arr_category_stuff[$key],
                    'qty' => $arr_qty[$key],
                    'transport_description' => $array_description[$key],
                    'id_transportation' => $array_transport[$key],
                    'price' => $arr_price[$key],
                    'total_price' => ($arr_price[$key] * $arr_qty[$key]),
                    'grand_total_price' => ($arr_price[$key] * $arr_qty[$key])
                ];
                Modules::run('database/insert', 'tb_booking_has_detail', $array_insert);
                $get_data_detail = $this->db->select('MAX(id) AS id_detail')->where(['id_booking' => $get_data_bs->id])->get('tb_booking_has_detail')->row();
                //detail LC
                $detail_transport = json_decode($this->encrypt->decode($array_detail_transport[$key]));
                foreach ($detail_transport as $item_transport) {
                    $array_insert_lc  = [
                        'id_voyage' => $id_voyage,
                        'id_booking' => $get_data_bs->id,
                        'id_booking_detail' => $get_data_detail->id_detail,
                        'transport_name' => $item_transport
                    ];
                    Modules::run('database/insert', 'tb_booking_has_lc', $array_insert_lc);
                }
            }
        }

        Modules::run('database/update', 'tb_booking', ['code' => $code], ['total_teus' => $total_teus]);
        Modules::run('booking/insert_status_booking', 2, $get_data_bs->id);

        //add notification
        $array_notification = [
            'code' => $code
        ];
        Modules::run('notification/notification_create_order', $array_notification);

        $array_respon = [
            'status' => TRUE,
            'code' => urlencode($this->encrypt->encode($code))
        ];
        echo json_encode($array_respon);
    }

    public function detail()
    {
        Modules::run('security/is_axist_data', ['name' => 'data', 'method' => 'GET', 'encrypt' => TRUE]);
        $code = $this->encrypt->decode($this->input->get('data'));

        $array_query_bs = [
            'select' => '
                tb_booking.*,
                mst_customer.name AS customer_name,
                mst_customer.address AS customer_address
            ',
            'from' => 'tb_booking',
            'where' => [
                'code' => $code
            ],
            'join' => [
                'mst_customer, tb_booking.id_customer = mst_customer.id , left'
            ]
        ];
        $get_bs = Modules::run('database/get', $array_query_bs)->row();
        $this->app_data['data_bs'] = $get_bs;

        $array_query_detail_bs = [
            'select' => '
                tb_booking_has_detail.*,
                mst_category_load.name AS category_load_name,
                mst_category_stuff.name AS category_stuff_name,
                mst_transportation.name AS transport_name
            ',
            'from' => 'tb_booking_has_detail',
            'where' => [
                'id_booking' =>  $get_bs->id
            ],
            'join' => [
                'mst_category_load, tb_booking_has_detail.id_category_load = mst_category_load.id , left',
                'mst_category_stuff, tb_booking_has_detail.id_category_stuff = mst_category_stuff.id , left',
                'mst_transportation, tb_booking_has_detail.id_transportation = mst_transportation.id , left',
            ]
        ];

        $this->app_data['data_detail_bs'] = Modules::run('database/get', $array_query_detail_bs)->result();

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
                'tb_voyage.id' => $get_bs->id_voyage
            ]
        ];
        $get_data_voyage = Modules::run('database/get', $array_query)->row();
        $this->app_data['data_voyage'] = $get_data_voyage;

        $this->app_data['category_countainer']  = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'countainer_category'])->row()->value, TRUE);
        $this->app_data['category_stuffing']    = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_stuffing'])->row()->value, TRUE);
        $this->app_data['category_teus']        = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_teus'])->row()->value, TRUE);
        $this->app_data['category_service']     = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_service'])->row()->value, TRUE);

        $this->app_data['ppn_tax'] = Modules::run('database/find', 'app_module_setting', ['field' => 'ppn_tax'])->row()->value;

        $this->app_data['category_load'] = Modules::run('database/find', 'mst_category_load', ['isDeleted' => 'N'])->result();
        $this->app_data['category_stuff'] = Modules::run('database/find', 'mst_category_stuff', ['isDeleted' => 'N'])->result();
        $this->app_data['get_list_status'] = $this->get_list_status($get_data_voyage->id);

        $this->app_data['list_status'] =  json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'voyage_status'])->row()->value, TRUE);
        $this->app_data['list_status_icon'] =  json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'voyage_status_icon'])->row()->value, TRUE);
        $this->app_data['page_title'] = "DETAIL BOOKING SLOT " . $code;
        $this->app_data['view_file'] = 'view_detail_transaction';
        echo Modules::run('template/horizontal_layout', $this->app_data);
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

    public function reject_order()
    {
        Modules::run('security/is_ajax');
        $status = 10;
        $id = $this->input->post('id');
        $reject_note = $this->input->post('note');
        $get_bs = Modules::run('database/find', 'tb_booking', ['id' => $id])->row();


        $array_update = [
            'status' => $status,
            'is_confirm' => 2,
            'reject_note' => $reject_note
        ];
        Modules::run('database/update', 'tb_booking', ['id' => $id], $array_update);
        Modules::run('booking/insert_status_booking', $status, $id);

        //add notification
        $array_notification = [
            'id_transaction' => $get_bs->id,
            'code' => $get_bs->code
        ];
        Modules::run('notification/notification_reject_order', $array_notification);

        echo json_encode(['status' => TRUE]);
    }

    public function insert_status_booking($status, $id_booking)
    {
        $booking_status = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'booking_status'])->row()->value, TRUE);
        $description = $booking_status[$status] . ' , petugas ' . $this->session->userdata('us_name');
        $array_insert = [
            'id_booking' => $id_booking,
            'status' => $status,
            'description' => $description
        ];
        Modules::run('database/insert', 'tb_booking_has_tracking', $array_insert);
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
