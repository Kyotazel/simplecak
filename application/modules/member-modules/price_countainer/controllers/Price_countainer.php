<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Price_countainer extends BackendController
{
    var $module_name        = 'price_countainer';
    var $module_directory   = 'price_countainer';
    var $module_js          = ['price_countainer'];
    var $app_data           = [];
    var $type = 1;

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
            $row[] = '<a href="' . Modules::run('helper/create_url', $this->module_name . '/detail?data=' . urlencode($this->encrypt->encode($data_table->id))) . '"   class="btn btn-warning-gradient btn-rounded  btn-lg btn-block"> Detail Harga Freight <i class="fa fa-arrow-circle-right"></i></a>';
            $data[] = $row;
        }

        $ouput = array(
            "data" => $data
        );

        $array_respon = ['search' => $this->encrypt->encode(json_encode($array_search)), 'list' => $ouput];

        echo json_encode($array_respon);
    }
}
