<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Price_thc extends BackendController
{
    var $module_name        = 'price_thc';
    var $module_directory   = 'price_thc';
    var $module_js          = ['price_thc'];
    var $app_data           = [];
    var $type = 2;

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
        $id_customer = $this->session->userdata('member_id');
        $get_customer = Modules::run('database/find', 'mst_customer', ['id' => $id_customer])->row();
        $this->app_data['data_customer'] = $get_customer;

        $this->app_data['list_depo']            = Modules::run('database/find', 'mst_depo', ['isDeleted' => 'N'])->result();
        $this->app_data['category_countainer']  = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'countainer_category'])->row()->value, TRUE);
        $this->app_data['category_stuffing']    = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_stuffing'])->row()->value, TRUE);
        $this->app_data['category_teus']        = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_teus'])->row()->value, TRUE);
        $this->app_data['page_title']           = "Harga Kontainer";
        $this->app_data['view_file']            = 'view_detail';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function list_data()
    {
        Modules::run('security/is_ajax');

        $array_where['mst_customer.isDeleted'] = 'N';

        $array_search = [];
        $array_query = [
            'select' => '
                mst_customer.*
            ',
            'from' => 'mst_customer',
            'where' => $array_where,
            'order_by' => 'mst_customer.id, DESC'
        ];

        $get_data = Modules::run('database/get', $array_query)->result();
        $no = 0;
        $data = [];
        foreach ($get_data as $data_table) {
            $id_encrypt = $this->encrypt->encode($data_table->id);
            // $btn_edit     = Modules::run('security/edit_access', ' <a href="javascript:void(0)" data-id="' . $id_encrypt . '" class="btn btn-sm btn-info btn_edit"><i class="las la-pen"></i> </a>');
            $active = $data_table->isActive == 'Y' ? ' <span class="tag tag-green">Aktif</span> ' : '<span class="tag">Non-Aktif</span>';

            $image = $data_table->image ? base_url('upload/customer/' . $data_table->image) : base_url('assets/themes/valex/img/faces/3.jpg');
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '
                    <div class="row col-12 border-dashed" style="white-space:initial;">
                        <div class="col">
                            <div class=" mt-2 mb-2 text-primary"><b>' . strtoupper($data_table->name) . '</b></div>
                            <p class="tx-11" style="white-space:initial;">' . $data_table->address . '</p>
                        </div>
                        <div class="col-auto align-self-center ">
                            <div class="feature mt-0 mb-0">
                                <i class="fe fe-user project bg-primary-transparent text-primary "></i>
                            </div>
                        </div>
                    </div>
                    
                    ';
            $row[] = '
                <label for="" class="d-block mt-1">
                    <small class="text-muted"><i class="fa fa-circle"></i> Email :</small>
                    <span>' . $data_table->email . '</span>
                </label>
                <label for="" class="d-block">
                    <small class="text-muted"><i class="fa fa-circle"></i> Telp :</small>
                    <span>' . $data_table->number_phone . '</span>
                </label>
                <label for="" class="d-flex">
                    <small class="text-muted"><i class="fa fa-circle"></i> Status :&nbsp;</small>
                    ' . $active . '
                </label>
            ';
            $row[] = $data_table->pic;
            $row[] = '<a href="' . Modules::run('helper/create_url', $this->module_name . '/detail?data=' . urlencode($this->encrypt->encode($data_table->id))) . '"   class="btn btn-warning-gradient btn-rounded  btn-lg btn-block"> Detail Harga THC <i class="fa fa-arrow-circle-right"></i></a>';
            $data[] = $row;
        }

        $ouput = array(
            "data" => $data
        );

        $array_respon = ['search' => $this->encrypt->encode(json_encode($array_search)), 'list' => $ouput];

        echo json_encode($array_respon);
    }



    private function validate_save()
    {
        Modules::run('security/is_ajax');
        $data = array();

        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        // this validate if there is same file to be uploaded
        $id = $this->input->post('id');
        if ($this->input->post('price') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'price';
            $data['status'] = FALSE;
        } else {

            $price = str_replace('.', '', $this->input->post('price'));
            $countainer = $this->input->post('countainer');
            $depo = $this->input->post('depo');
            $teus = $this->input->post('teus');
            $stuffing = $this->input->post('stuffing');
            $customer = $this->input->post('customer');

            $get_price = Modules::run(
                'database/find',
                'tb_countainer_price',
                [
                    'type' => $this->type,
                    'id_depo' => $depo,
                    'category_countainer' => $countainer,
                    'category_teus' => $teus,
                    'category_stuffing_take' => $stuffing,
                    'price' => $price,
                    'id_customer' => $customer
                ]
            )->row();
            if (!empty($get_price)) {
                $data['error_string'][] = 'Harga sudah dipakai';
                $data['inputerror'][] = 'price';
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
        $price = str_replace('.', '', $this->input->post('price'));
        $countainer = $this->input->post('countainer');
        $depo = $this->input->post('depo');
        $teus = $this->input->post('teus');
        $stuffing = $this->input->post('stuffing');
        $unique = $this->input->post('unique');
        $customer = $this->input->post('customer');

        $array_insert = [
            'type' => $this->type,
            'id_customer' => $customer,
            'id_depo' => $depo,
            'category_countainer' => $countainer,
            'category_teus' => $teus,
            'category_stuffing_take' => $stuffing,
            'price' => $price
        ];
        Modules::run('database/insert', 'tb_countainer_price', $array_insert);

        $html_respon = $this->create_html_item($depo, $countainer, $teus, $stuffing, $unique, $customer);

        echo json_encode(['status' => true, 'html_respon' => $html_respon, 'code' => $unique]);
    }

    public function create_html_item($depo, $countainer, $teus, $stuffing, $unique, $customer)
    {
        $get_price = Modules::run(
            'database/find',
            'tb_countainer_price',
            [
                'type' => $this->type,
                'id_customer' => $customer,
                'id_depo' => $depo,
                'category_countainer' => $countainer,
                'category_teus' => $teus,
                'category_stuffing_take' => $stuffing
            ]
        )->result();
        $html_item = '';
        foreach ($get_price as $item_price) {
            $status_active = $item_price->is_default ? 'on' : '';
            $btn_edit   = Modules::run('security/edit_access', ' <a href="javascript:void(0)" data-id="' . $item_price->id . '" data-depo="' . $depo . '" data-countainer="' . $countainer . '" data-teus="' . $teus . '" data-stuffing="' . $stuffing . '" data-unique="' . $unique . '" data-customer="' . $customer . '"  class="btn btn-warning-gradient btn-rounded btn_update btn-rounded btn-sm"><i class="fa fa-edit"></i> Update</a>');
            $btn_delete = Modules::run('Security/delete_access', '<a href="javascript:void(0)" data-id="' . $item_price->id . '" data-depo="' . $depo . '" data-countainer="' . $countainer . '" data-teus="' . $teus . '" data-stuffing="' . $stuffing . '" data-unique="' . $unique . '" data-customer="' . $customer . '" class="btn btn-danger-gradient btn-rounded btn_delete btn-rounded btn-sm"><i class="fa fa-trash"></i> Hapus</a>');
            $html_item .= '
                        <div class="col-md-12 row p-2 border-dashed">
                            <div class="col-6 border-right">
                                <small class="d-block mb-1">Harga :</small>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text font-weight-bold">
                                            Rp.
                                        </div>
                                    </div>
                                    <input value="' . number_format($item_price->price, 0, '.', '.') . '" class="form-control money_only border-dashed font-weight-bold  bg-white" readonly   type="text">
                                </div>
                            </div>
                            <div class="col-2 border-right d-flex flex-wrap justify-content-center">
                                <small class="d-block mb-1">Status Default :</small>
                                <div data-unique="' . $unique . '" data-id="' . $item_price->id . '" class="main-toggle main-toggle-dark change_status status_' . $unique . ' ' . $status_active . '"><span></span></div>
                            </div>
                            <div class="col-4">
                                <small class="d-block mb-1">Aksi :</small>
                                ' . $btn_edit . $btn_delete . '
                            </div>
                        </div>
                    ';
        }

        if (empty($get_price)) {
            $html_item = '
                            <div class="plan-card  col-12 d-flex justify-content-center align-items-center">
                                <div class="feature widget-2 text-center mt-0 mr-3">
                                    <i class="ti-bar-chart project bg-primary-transparent mx-auto text-primary "></i>
                                </div>
                                <div>
                                    <h6 class="text-drak text-uppercase m-0">Data Kosong</h6>
                                    <small class="text-muted">Tidak ada daftar harga.</small>
                                </div>
                            </div>
                        ';
        }

        return $html_item;
    }
}
