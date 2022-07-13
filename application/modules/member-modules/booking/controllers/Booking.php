<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Booking extends BackendController
{
    var $module_name        = 'booking';
    var $module_directory   = 'booking';
    var $module_js          = ['booking'];
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
        $this->app_data['page_title'] = "DATA TRANSAKSI    ";
        $this->app_data['view_file'] = 'main_view';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function waiting()
    {
        $id_customer = $this->session->userdata('member_id');
        $array_where['tb_booking.id_customer'] = $id_customer;
        $array_where['tb_booking.is_confirm'] = 0;

        $array_query_bs = [
            'select' => '
                tb_booking.*,
                mst_customer.name AS customer_name,
                mst_customer.address AS customer_address,
                depo_from.name AS depo_from,
                depo_to.name AS depo_to,
                mst_ship.name AS ship_name,
                tb_voyage.status AS status_voyage
            ',
            'from' => 'tb_booking',
            'where' => $array_where,
            'join' => [
                'mst_customer, tb_booking.id_customer = mst_customer.id , left',
                'tb_voyage, tb_booking.id_voyage = tb_voyage.id, left',
                'mst_depo AS depo_from, tb_voyage.id_depo_from = depo_from.id, left',
                'mst_depo AS depo_to, tb_voyage.id_depo_to = depo_to.id, left',
                'mst_ship, tb_voyage.id_ship = mst_ship.id, left'
            ],
            'order_by' => 'tb_booking.id , DESC'
        ];

        $get_data = Modules::run('database/get', $array_query_bs)->result();
        $this->app_data['get_data'] = $get_data;
        $this->app_data['category_teus']   = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_teus'])->row()->value, TRUE);
        $this->app_data['category_countainer']  = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'countainer_category'])->row()->value, TRUE);
        $this->app_data['booking_status']  = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'booking_status'])->row()->value, TRUE);
        $this->app_data['category_service']     = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_service'])->row()->value, TRUE);
        $this->app_data['category_unit_lc']     = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_unit_lc'])->row()->value, TRUE);
        $this->app_data['status_voyage'] =  json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'voyage_status'])->row()->value, TRUE);

        $this->app_data['data_status_voyage'] =  json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'voyage_status'])->row()->value, TRUE);
        $this->app_data['data_ship'] = Modules::run('database/find', 'mst_ship', ['isDeleted' => 'N'])->result();
        $this->app_data['data_depo'] = Modules::run('database/find', 'mst_depo', ['isDeleted' => 'N'])->result();
        $this->app_data['page_title'] = "Transaksi menunggu konfirmasi";
        $this->app_data['view_file'] = 'view_waiting';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function list_data()
    {
        Modules::run('security/is_ajax');
        $date_from = $this->input->post('date_from') ? Modules::run('helper/change_date', $this->input->post('date_from'), '-') : '';
        $date_to = $this->input->post('date_to') ? Modules::run('helper/change_date', $this->input->post('date_to'), '-') : '';
        $depo_from = $this->input->post('depo_from');
        $depo_to = $this->input->post('depo_to');
        $status_voyage = $this->encrypt->decode($this->input->post('status_voyage'));
        $status_filter = $this->input->post('status_filter');


        $code = $this->input->post('code');
        $status_search = $this->input->post('status_search');
        $array_where = [];
        $or_array_where = [];
        $where_not_in = [];
        $array_status =  json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'voyage_status'])->row()->value, TRUE);

        $id_customer = $this->session->userdata('member_id');
        $array_where['tb_booking.id_customer'] = $id_customer;
        if ($status_voyage) {
            $array_where['tb_voyage.status'] = $status_voyage;
        }

        if ($date_from) {
            $array_where['tb_booking.date >='] = $date_from;
        }
        if ($date_to) {
            $array_where['tb_booking.date <='] = $date_to;
        }
        if ($depo_from) {
            $array_where['tb_voyage.id_depo_from'] = $depo_from;
        }
        if ($depo_to) {
            $array_where['tb_voyage.id_depo_to'] = $depo_to;
        }

        $array_search = [];

        if ($status_filter > 1) {
            $array_where['tb_voyage.status'] = $status_filter;
            $array_where['tb_booking.is_confirm'] = 1;
        } else {
            if ($status_filter == 'proceed') {
                $array_where['tb_voyage.status >='] = 2;
                $array_where['tb_voyage.status <='] = 7;
                $array_where['tb_booking.is_confirm'] = 1;
            }
            if ($status_filter == 'finish') {
                $array_where['tb_voyage.status ='] = 8;
                $array_where['tb_booking.is_confirm'] = 1;
            }
            if ($status_filter == 'cancel') {
                $array_where['tb_booking.is_confirm'] = 2;
            }
        }

        $array_query_bs = [
            'select' => '
                tb_booking.*,
                mst_customer.name AS customer_name,
                mst_customer.address AS customer_address,
                depo_from.name AS depo_from,
                depo_to.name AS depo_to,
                mst_ship.name AS ship_name,
                tb_voyage.status AS status_voyage
            ',
            'from' => 'tb_booking',
            'where' => $array_where,
            'join' => [
                'mst_customer, tb_booking.id_customer = mst_customer.id , left',
                'tb_voyage, tb_booking.id_voyage = tb_voyage.id, left',
                'mst_depo AS depo_from, tb_voyage.id_depo_from = depo_from.id, left',
                'mst_depo AS depo_to, tb_voyage.id_depo_to = depo_to.id, left',
                'mst_ship, tb_voyage.id_ship = mst_ship.id, left'
            ],
            'order_by' => 'tb_booking.id , DESC'
        ];
        $get_data = Modules::run('database/get', $array_query_bs)->result();

        $data['category_teus']   = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_teus'])->row()->value, TRUE);
        $data['category_countainer']  = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'countainer_category'])->row()->value, TRUE);
        $data['booking_status']  = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'booking_status'])->row()->value, TRUE);
        $data['category_service']     = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_service'])->row()->value, TRUE);
        $data['category_unit_lc']     = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_unit_lc'])->row()->value, TRUE);
        $data['status_voyage'] =  json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'voyage_status'])->row()->value, TRUE);
        $no = 0;
        $html_respon = '';
        foreach ($get_data as $data_table) {
            $id_encrypt = $this->encrypt->encode($data_table->id);
            $data['data_bs'] = $data_table;
            $html_respon .= $this->load->view('_partials/component_order', $data, TRUE);
        }

        if (empty($get_data)) {
            $html_respon = '
                <div class="col-12 text-center shadow-3 p-3">
                    <div class="plan-card text-center">
                        <i class="fas fa-file plan-icon text-primary"></i>
                        <h6 class="text-drak text-uppercase mt-2">Data Kosong</h6>
                        <small class="text-muted">Tidak ada hasil pencarian.</small>
                    </div>
                </div>
            ';
        }

        $array_respon = ['status' => true, 'html_respon' => $html_respon];
        echo json_encode($array_respon);
    }

    public function reject_order()
    {
        Modules::run('security/is_ajax');
        $status = 10;
        $id = $this->input->post('id');
        $reject_note = $this->input->post('note');

        $array_update = [
            'status' => $status,
            'is_confirm' => 2,
            'reject_note' => $reject_note
        ];
        Modules::run('database/update', 'tb_booking', ['id' => $id], $array_update);
        Modules::run('booking/insert_status_booking', $status, $id);

        $get_bs = Modules::run('database/find', 'tb_booking', ['id' => $id])->row();
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
        $description = $booking_status[$status] . ' , Member ' . $this->session->userdata('member_name');
        $array_insert = [
            'id_booking' => $id_booking,
            'status' => $status,
            'description' => $description
        ];
        Modules::run('database/insert', 'tb_booking_has_tracking', $array_insert);
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

    public function detail()
    {
        Modules::run('security/is_axist_data', ['name' => 'data', 'method' => 'GET', 'encrypt' => TRUE]);
        $id = $this->encrypt->decode($this->input->get('data'));

        $array_query = [
            'select' => '
                tb_booking.*,
                mst_customer.name AS customer_name,
                mst_customer.address AS customer_address,
                depo_from.name AS depo_from,
                depo_to.name AS depo_to,
                mst_ship.name AS ship_name,
                mst_ship.name AS ship_name,
                mst_ship.image AS ship_image,
                tb_voyage.manifest_number,
                tb_voyage.status AS status_voyage,
                tb_voyage.code AS voyage_code,
                tb_voyage.date_from AS voyage_date_from,
                tb_voyage.date_to AS voyage_date_to
            ',
            'from' => 'tb_booking',
            'where' => [
                'tb_booking.id' => $id
            ],
            'join' => [
                'mst_customer, tb_booking.id_customer = mst_customer.id , left',
                'tb_voyage, tb_booking.id_voyage = tb_voyage.id, left',
                'mst_depo AS depo_from, tb_voyage.id_depo_from = depo_from.id, left',
                'mst_depo AS depo_to, tb_voyage.id_depo_to = depo_to.id, left',
                'mst_ship, tb_voyage.id_ship = mst_ship.id, left'
            ],
            'order_by' => 'tb_booking.id , DESC'
        ];
        $get_data = Modules::run('database/get', $array_query)->row();
        $this->app_data['data_bs'] = $get_data;

        $this->app_data['list_status'] =  json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'voyage_status'])->row()->value, TRUE);
        $this->app_data['list_status_icon'] =  json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'voyage_status_icon'])->row()->value, TRUE);
        $this->app_data['get_list_status'] = $this->get_list_status($get_data->id_voyage);
        $this->app_data['status_voyage'] =  json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'voyage_status'])->row()->value, TRUE);

        $this->app_data['page_title'] = "DETAIL Transaksi " . $get_data->code;
        $this->app_data['view_file'] = 'view_detail';
        echo Modules::run('template/horizontal_layout', $this->app_data);
    }



    public function generate_barcode($code, $width = 1, $height = 30)
    {
        require '../assets/vendor/autoload.php';
        // This will output the barcode as HTML output to display in the browser
        $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
        $barcode =  $generator->getBarcode($code, $generator::TYPE_CODE_128, $width, $height,);
        // $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        // $redColor = [255, 0, 0];
        // file_put_contents('barcode.png', $generator->getBarcode('081231723897', $generator::TYPE_CODE_128, 3, 50, $redColor));
        return  $barcode;
    }

    public function create_qr_code($code)
    {
        $this->load->library('ciqrcode'); //pemanggilan library QR CODE
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = '../upload/'; //string, the default is application/cache/
        $config['errorlog']     = '../upload/'; //string, the default is application/logs/
        $config['imagedir']     = '../upload/barcode/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
        $config['white']        = array(70, 130, 180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
        $image_name = $code . '.png'; //buat name dari qr code sesuai dengan nim
        $params['data'] = $code; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH . $config['imagedir']  . $image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
        return $image_name;
    }

    //============================================== unloading countainer =======================================================
    public function container_unloading()
    {
        $this->app_data['data_status_voyage'] =  json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'voyage_status'])->row()->value, TRUE);
        $this->app_data['data_ship'] = Modules::run('database/find', 'mst_ship', ['isDeleted' => 'N'])->result();
        $this->app_data['data_depo'] = Modules::run('database/find', 'mst_depo', ['isDeleted' => 'N'])->result();
        $this->app_data['page_title'] = "Pembongkaran Kontainer";
        $this->app_data['view_file'] = 'view_unloading_countainer';
        echo Modules::run('template/horizontal_layout', $this->app_data);
    }

    public function list_data_unloading()
    {
        Modules::run('security/is_ajax');
        $id_customer = $this->session->userdata('member_id');
        $date_from = $this->input->post('date_from') ? Modules::run('helper/change_date', $this->input->post('date_from'), '-') : '';
        // $date_to = $this->input->post('date_to') ? Modules::run('helper/change_date', $this->input->post('date_to'), '-') : '';
        $depo_to = $this->input->post('depo_to');
        $status_overtime = $this->input->post('status_overtime');
        // $status_voyage = $this->encrypt->decode($this->input->post('status_voyage'));
        $countainer = $this->input->post('countainer');
        $status_search = $this->input->post('status_search');
        $code_bs = $this->input->post('code_bs');

        $array_where = [
            'tb_booking.is_confirm' => 1,
            'tb_booking_has_countainer.status' => 5,
            'tb_booking.id_customer' => $id_customer
        ];

        if ($date_from) {
            $array_where['tb_booking_has_countainer.schedule_release_date'] = $date_from;
        }

        if ($depo_to) {
            $array_where['tb_voyage.id_depo_to'] = $depo_to;
        }
        if ($countainer) {
            $array_where['mst_countainer.code'] = $countainer;
        }
        if ($code_bs) {
            $array_where['tb_booking.code'] = $code_bs;
        }
        if ($status_overtime) {
            if ($status_overtime == 1) {
                $array_where['tb_booking_has_countainer.schedule_release_date >'] = date('Y-m-d');
            }
            if ($status_overtime == 2) {
                $array_where['tb_booking_has_countainer.schedule_release_date <'] = date('Y-m-d');
            }
        }

        $array_search = [];
        $array_query  = [
            'select' => '
                tb_booking_has_countainer.*,
                tb_booking.code AS booking_code,
                tb_booking.date AS booking_date,
                tb_booking_has_detail.id_category_load,
                tb_booking_has_detail.id_category_stuff,
                tb_booking_has_detail.category_countainer,
                tb_booking_has_detail.category_teus,
                tb_booking_has_detail.category_service,
                tb_booking_has_detail.stuffing_take,
                tb_booking_has_detail.stuffing_open,
                tb_booking_has_detail.stuffing_take_address,
                tb_booking_has_detail.stuffing_open_address,
                mst_category_load.name AS category_load_name,
                mst_category_stuff.name AS category_stuff_name,
                mst_countainer.code AS countainer_code,
                mst_countainer.barcode AS countainer_barcode,
                mst_customer.name AS customer_name,
                mst_customer.address AS customer_address,
                tb_voyage.code AS voyage_code,
                depo_from.name AS depo_from_name,
                depo_to.name AS depo_to_name,
                depo_to.id AS depo_position

            ',
            'from' => 'tb_booking_has_countainer',
            'join' => [
                'mst_countainer , tb_booking_has_countainer.id_countainer = mst_countainer.id , left',
                'tb_booking , tb_booking_has_countainer.id_booking = tb_booking.id , left',
                'tb_booking_has_detail , tb_booking_has_countainer.id_booking_detail = tb_booking_has_detail.id , left',
                'mst_category_load, tb_booking_has_detail.id_category_load = mst_category_load.id , left',
                'mst_category_stuff, tb_booking_has_detail.id_category_stuff = mst_category_stuff.id , left',
                'mst_customer, tb_booking.id_customer = mst_customer.id , left',
                'tb_voyage, tb_booking.id_voyage = tb_voyage.id,left',
                'mst_depo AS depo_from, tb_voyage.id_depo_from = depo_from.id, left',
                'mst_depo AS depo_to, tb_voyage.id_depo_to = depo_to.id, left',
            ],
            'where' => $array_where
        ];

        $get_data_countainer = Modules::run('database/get', $array_query)->result();

        $no = 0;
        $data = [];

        $category_teus   = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_teus'])->row()->value, TRUE);
        $category_countainer  = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'countainer_category'])->row()->value, TRUE);
        $booking_status  = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'booking_status'])->row()->value, TRUE);
        $category_service     = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_service'])->row()->value, TRUE);
        $category_unit_lc     = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_unit_lc'])->row()->value, TRUE);
        $category_stuffing    = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_stuffing'])->row()->value, TRUE);

        foreach ($get_data_countainer as $item_countainer) {
            // $id_encrypt = $this->encrypt->encode($data_table->id);
            // $btn_delete     = $data_table->status == 1 ||  $data_table->status == 2 ?  Modules::run('security/delete_access', ' <a href="javascript:void(0)" data-id="' . $id_encrypt . '" class="dropdown-item"><i class="fas fa-window-close"></i> Batalkan Voyage</a>') : '';

            $countiner_type = isset($category_countainer[$item_countainer->category_countainer]) ? $category_countainer[$item_countainer->category_countainer] : '';
            $countainer_teus = isset($category_teus[$item_countainer->category_teus]) ? $category_teus[$item_countainer->category_teus] : 0;
            $service_type = isset($category_service[$item_countainer->category_service]) ? $category_service[$item_countainer->category_service] : '';
            $stuffing_take = isset($category_stuffing[$item_countainer->stuffing_take]) ? $category_stuffing[$item_countainer->stuffing_take] : 0;
            $stuffing_open = isset($category_stuffing[$item_countainer->stuffing_open]) ? $category_stuffing[$item_countainer->stuffing_open] : 0;


            $html_countainer = '';
            if (!empty($item_countainer->countainer_barcode)) {
                $html_countainer = '
                        <div class="text-center col-6 border-dashed">
                            <img style="width:55px;" src="' . base_url('upload/barcode/' . $item_countainer->countainer_barcode) . '" alt="">
                            <small class="d-block font-weight-bold tx-12">' . $item_countainer->countainer_code . '</small>
                            <small class="text-mdi-tab-unselected"><i class="fa fa-info-circle"></i> ID kontainer</small>
                        </div>
                    ';
            }

            $html_seal = '';
            if (!empty($item_countainer->seal_code)) {
                $barcode = $item_countainer->seal_code . '.png';
                $html_seal = '
                        <div class="text-center col-6 border-dashed" >
                            <img style="width:55px;" src="' . base_url('upload/barcode/' . $barcode) . '" alt="">
                            <small class="d-block font-weight-bold tx-12">' . $item_countainer->seal_code . '</small>
                            <small class="text-mdi-tab-unselected text-uppercase tx-10"><i class="fa fa-info-circle"></i> Segel</small>
                        </div>
                        ';
            }

            $class_text = '';
            $text_time = '';
            $class_counttime  = '';
            if (strtotime(date('Y-m-d')) < strtotime($item_countainer->schedule_release_date)) {
                $class_text = 'text-primary';
                $text_time = 'On Schedule';
                $class_counttime  = 'countdown_unloading';
            } else {
                $class_text = 'text-danger';
                $text_time = 'Overtime';
                $class_counttime  = 'countup_unloading';
            }


            $html_countainer_seal = '
                <div class="row">
                    <div class="col-12 p-2 border-dashed text-center ">
                        <small class="text-muted"><i class="fa fa-calendar"></i> ' . $text_time . ' :</small>
                        <span class="font-weight-bold ' . $class_text . '">' . Modules::run('helper/date_indo', $item_countainer->schedule_release_date, '-') . '</span>
                    </div>
                    ' . $html_countainer . $html_seal . '
                        <div class="row col-12 mb-1 ' . $class_counttime . '" data-date-now="' . date('Y-m-d') . '" data-date-to="' . $item_countainer->schedule_release_date . '">
                            <div class="col-3 p-1 border rounded text-center">
                                <h5 for="" class="p-0 m-0 text-danger text_day">--</h5>
                                <small for="" class="d-block font-weight-bold">Hari</small>
                            </div>
                            <div class="col-3 p-1 border rounded text-center">
                                <h5 for="" class="p-0 m-0 text-danger text_hour">--</h5>
                                <small for="" class="d-block font-weight-bold">Jam</small>
                            </div>
                            <div class="col-3 p-1 border rounded text-center">
                                <h5 for="" class="p-0 m-0 text-danger text_minute">--</h5>
                                <small for="" class="d-block font-weight-bold">Menit</small>
                            </div>
                            <div class="col-3 p-1 border rounded text-center">
                                <h5 for="" class="p-0 m-0 text-danger text_second">--</h5>
                                <small for="" class="d-block font-weight-bold">Detik</small>
                            </div>
                        </div>
                    </div>
                </div>
            ';

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '
                <h3 class="text-center"><span class="badge badge-light">' . $item_countainer->booking_code . '</span></h3>
                <small class="d-block p-2 border-dashed text-muted text-center"><i class="fa fa-calendar"></i> ' . Modules::run('helper/date_indo', $item_countainer->booking_date, '-') . '</small>
                <div class="row col-12 border-dashed" >
                    <div class="col">
                        <div class=" mt-2 mb-2 text-primary"><b>' . $item_countainer->customer_name . '</b></div>
                        <p class="tx-12" style="white-space: break-spaces;">' . $item_countainer->customer_address . '</p>
                    </div>
                    <div class="col-auto align-self-center ">
                        <div class="feature mt-0 mb-0">
                            <i class="fe fe-user project bg-primary-transparent text-primary "></i>
                        </div>
                    </div>
                </div>
            
                ';
            $row[] = '
                <h3 class="text-center  font-weight-bold mb-2"><span class="badge badge-light">' . $item_countainer->voyage_code . '</span></h3>
                <div class="text-center p-2 border-dashed">
                    <small class="text-muted"><i class="fa fa-map"></i> Depo Awal : </small>
                    <label for="" class="d-block m-0"> <b>' . $item_countainer->depo_from_name . '</b></label>
                    <small class="text-muted"><i class="fa fa-map"></i> Depo Tujuan :</small>
                    <label for="" class="d-block m-0"><b> ' . $item_countainer->depo_to_name . '</b></label>
                    </b>
                </div>
            ';
            $row[] = '
                <small for="" class="d-block text-muted">Kategori Kontainer :</small>
                <label  class="d-block p-2 border-dashed"> ' . strtoupper($countiner_type) . '</label>
                <small for="" class="d-block text-muted">Feet :</small>
                <label  class="d-block p-2 border-dashed"> ' . strtoupper($countainer_teus) . ' FEET</label>
                <small for="" class="d-block text-muted">Service :</small>
                <label  class="d-block p-2 border-dashed"> ' . strtoupper($service_type) . ' </label>
            ';
            $row[] = '
                <small class="d-block text-muted">Kategori Barang Muatan :</small>
                <label for="" class="d-block p-2 border-dashed">' . strtoupper($item_countainer->category_load_name) . '</label>
                <small class="d-block text-muted">Barang Muatan:</small>
                <label for="" class="d-block p-2 border-dashed">' . strtoupper($item_countainer->category_stuff_name) . '</label>
            ';
            $row[] = $html_countainer_seal;
            $data[] = $row;
        }

        $ouput = array(
            "data" => $data
        );

        $array_respon = ['search' => $this->encrypt->encode(json_encode($array_search)), 'list' => $ouput];

        echo json_encode($array_respon);
    }



    //============================================== return countainer =======================================================
    public function container_return()
    {
        $this->app_data['data_status_voyage'] =  json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'voyage_status'])->row()->value, TRUE);
        $this->app_data['data_ship'] = Modules::run('database/find', 'mst_ship', ['isDeleted' => 'N'])->result();
        $this->app_data['data_depo'] = Modules::run('database/find', 'mst_depo', ['isDeleted' => 'N'])->result();
        $this->app_data['page_title'] = "Pengembalian Kontainer";
        $this->app_data['view_file'] = 'view_return_countainer';
        echo Modules::run('template/horizontal_layout', $this->app_data);
    }

    public function list_data_return()
    {
        Modules::run('security/is_ajax');
        $id_customer = $this->session->userdata('member_id');
        $date_from = $this->input->post('date_from') ? Modules::run('helper/change_date', $this->input->post('date_from'), '-') : '';
        // $date_to = $this->input->post('date_to') ? Modules::run('helper/change_date', $this->input->post('date_to'), '-') : '';
        $depo_to = $this->input->post('depo_to');
        $status_overtime = $this->input->post('status_overtime');
        // $status_voyage = $this->encrypt->decode($this->input->post('status_voyage'));
        $countainer = $this->input->post('countainer');
        $status_search = $this->input->post('status_search');
        $code_bs = $this->input->post('code_bs');

        $array_where = [
            'tb_booking.is_confirm' => 1,
            'tb_booking_has_countainer.status' => 6,
            'tb_booking.id_customer' => $id_customer
        ];

        if ($date_from) {
            $array_where['tb_booking_has_countainer.schedule_release_date'] = $date_from;
        }

        if ($depo_to) {
            $array_where['tb_voyage.id_depo_to'] = $depo_to;
        }
        if ($countainer) {
            $array_where['mst_countainer.code'] = $countainer;
        }
        if ($code_bs) {
            $array_where['tb_booking.code'] = $code_bs;
        }
        if ($status_overtime) {
            if ($status_overtime == 1) {
                $array_where['tb_booking_has_countainer.schedule_release_date >'] = date('Y-m-d');
            }
            if ($status_overtime == 2) {
                $array_where['tb_booking_has_countainer.schedule_release_date <'] = date('Y-m-d');
            }
        }

        $array_search = [];
        $array_query  = [
            'select' => '
                tb_booking_has_countainer.*,
                tb_booking.code AS booking_code,
                tb_booking.date AS booking_date,
                tb_booking_has_detail.id_category_load,
                tb_booking_has_detail.id_category_stuff,
                tb_booking_has_detail.category_countainer,
                tb_booking_has_detail.category_teus,
                tb_booking_has_detail.category_service,
                tb_booking_has_detail.stuffing_take,
                tb_booking_has_detail.stuffing_open,
                tb_booking_has_detail.stuffing_take_address,
                tb_booking_has_detail.stuffing_open_address,
                mst_category_load.name AS category_load_name,
                mst_category_stuff.name AS category_stuff_name,
                mst_countainer.code AS countainer_code,
                mst_countainer.barcode AS countainer_barcode,
                mst_customer.name AS customer_name,
                mst_customer.address AS customer_address,
                tb_voyage.code AS voyage_code,
                depo_from.name AS depo_from_name,
                depo_to.name AS depo_to_name,
                depo_to.id AS depo_position
            ',
            'from' => 'tb_booking_has_countainer',
            'join' => [
                'mst_countainer , tb_booking_has_countainer.id_countainer = mst_countainer.id , left',
                'tb_booking , tb_booking_has_countainer.id_booking = tb_booking.id , left',
                'tb_booking_has_detail , tb_booking_has_countainer.id_booking_detail = tb_booking_has_detail.id , left',
                'mst_category_load, tb_booking_has_detail.id_category_load = mst_category_load.id , left',
                'mst_category_stuff, tb_booking_has_detail.id_category_stuff = mst_category_stuff.id , left',
                'mst_customer, tb_booking.id_customer = mst_customer.id , left',
                'tb_voyage, tb_booking.id_voyage = tb_voyage.id,left',
                'mst_depo AS depo_from, tb_voyage.id_depo_from = depo_from.id, left',
                'mst_depo AS depo_to, tb_voyage.id_depo_to = depo_to.id, left',
            ],
            'where' => $array_where
        ];
        $get_data_countainer = Modules::run('database/get', $array_query)->result();

        $no = 0;
        $data = [];

        $category_teus   = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_teus'])->row()->value, TRUE);
        $category_countainer  = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'countainer_category'])->row()->value, TRUE);
        $booking_status  = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'booking_status'])->row()->value, TRUE);
        $category_service     = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_service'])->row()->value, TRUE);
        $category_unit_lc     = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_unit_lc'])->row()->value, TRUE);
        $category_stuffing    = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'category_stuffing'])->row()->value, TRUE);

        foreach ($get_data_countainer as $item_countainer) {
            // $id_encrypt = $this->encrypt->encode($data_table->id);
            // $btn_delete     = $data_table->status == 1 ||  $data_table->status == 2 ?  Modules::run('security/delete_access', ' <a href="javascript:void(0)" data-id="' . $id_encrypt . '" class="dropdown-item"><i class="fas fa-window-close"></i> Batalkan Voyage</a>') : '';

            $countiner_type = isset($category_countainer[$item_countainer->category_countainer]) ? $category_countainer[$item_countainer->category_countainer] : '';
            $countainer_teus = isset($category_teus[$item_countainer->category_teus]) ? $category_teus[$item_countainer->category_teus] : 0;
            $service_type = isset($category_service[$item_countainer->category_service]) ? $category_service[$item_countainer->category_service] : '';
            $stuffing_take = isset($category_stuffing[$item_countainer->stuffing_take]) ? $category_stuffing[$item_countainer->stuffing_take] : 0;
            $stuffing_open = isset($category_stuffing[$item_countainer->stuffing_open]) ? $category_stuffing[$item_countainer->stuffing_open] : 0;


            $html_countainer = '';
            if (!empty($item_countainer->countainer_barcode)) {
                $html_countainer = '
                    <div class="text-center col-6 border-dashed">
                        <img style="width:55px;" src="' . base_url('upload/barcode/' . $item_countainer->countainer_barcode) . '" alt="">
                        <small class="d-block font-weight-bold tx-12">' . $item_countainer->countainer_code . '</small>
                        <small class="text-mdi-tab-unselected"><i class="fa fa-info-circle"></i> ID kontainer</small>
                    </div>
                ';
            }

            $html_seal = '';
            if (!empty($item_countainer->seal_code)) {
                $barcode = $item_countainer->seal_code . '.png';
                $html_seal = '
                        <div class="text-center col-6 border-dashed" >
                            <img style="width:55px;" src="' . base_url('upload/barcode/' . $barcode) . '" alt="">
                            <small class="d-block font-weight-bold tx-12">' . $item_countainer->seal_code . '</small>
                            <small class="text-mdi-tab-unselected text-uppercase tx-10"><i class="fa fa-info-circle"></i> Segel</small>
                        </div>
                    ';
            }

            $class_text = '';
            $text_time = '';
            $class_text = 'text-primary';
            $text_time = 'Tanggal Bongkar';


            $html_countainer_seal = '
                <div class="row">
                    <div class="col-12 p-2 border-dashed text-center ">
                        <small class="text-muted"><i class="fa fa-calendar"></i> ' . $text_time . ' :</small>
                        <span class="font-weight-bold ' . $class_text . '">' . Modules::run('helper/date_indo', $item_countainer->release_date, '-') . '</span>
                    </div>
                    ' . $html_countainer . $html_seal . '
                    </div>
                </div>
            ';

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '
                    <h3 class="text-center"><span class="badge badge-light">' . $item_countainer->booking_code . '</span></h3>
                    <small class="d-block p-2 border-dashed text-muted text-center"><i class="fa fa-calendar"></i> ' . Modules::run('helper/date_indo', $item_countainer->booking_date, '-') . '</small>
                    <div class="row col-12 border-dashed" >
                        <div class="col">
                            <div class=" mt-2 mb-2 text-primary"><b>' . $item_countainer->customer_name . '</b></div>
                            <p class="tx-12" style="white-space: break-spaces;">' . $item_countainer->customer_address . '</p>
                        </div>
                        <div class="col-auto align-self-center ">
                            <div class="feature mt-0 mb-0">
                                <i class="fe fe-user project bg-primary-transparent text-primary "></i>
                            </div>
                        </div>
                    </div>
                    ';
            $row[] = '
                    <h3 class="text-center  font-weight-bold mb-2"><span class="badge badge-light">' . $item_countainer->voyage_code . '</span></h3>
                    <div class="text-center p-2 border-dashed">
                        <small class="text-muted"><i class="fa fa-map"></i> Depo Awal : </small>
                        <label for="" class="d-block m-0"> <b>' . $item_countainer->depo_from_name . '</b></label>
                        <small class="text-muted"><i class="fa fa-map"></i> Depo Tujuan :</small>
                        <label for="" class="d-block m-0"><b> ' . $item_countainer->depo_to_name . '</b></label>
                    </div>
            ';
            $row[] = '
                    <small for="" class="d-block text-muted">Kategori Kontainer :</small>
                    <label  class="d-block p-2 border-dashed"> ' . strtoupper($countiner_type) . '</label>
                    <small for="" class="d-block text-muted">Feet :</small>
                    <label  class="d-block p-2 border-dashed"> ' . strtoupper($countainer_teus) . ' FEET</label>
                    <small for="" class="d-block text-muted">Service :</small>
                    <label  class="d-block p-2 border-dashed"> ' . strtoupper($service_type) . ' </label>
                ';
            $row[] = '
                    <small class="d-block text-muted">Kategori Barang Muatan :</small>
                    <label for="" class="d-block p-2 border-dashed">' . strtoupper($item_countainer->category_load_name) . '</label>
                    <small class="d-block text-muted">Barang Muatan:</small>
                    <label for="" class="d-block p-2 border-dashed">' . strtoupper($item_countainer->category_stuff_name) . '</label>
                ';
            $row[] = $html_countainer_seal;
            $data[] = $row;
        }

        $ouput = array(
            "data" => $data
        );

        $array_respon = ['search' => $this->encrypt->encode(json_encode($array_search)), 'list' => $ouput];

        echo json_encode($array_respon);
    }

    public function get_form_update_return()
    {
        Modules::run('security/is_ajax');
        $depo   = $this->input->post('depo');
        $id     = $this->input->post('id');

        $array_query  = [
            'select' => '
                tb_booking_has_countainer.*,
                tb_booking.code AS booking_code,
                tb_booking.date AS booking_date,
                tb_booking_has_detail.id_category_load,
                tb_booking_has_detail.id_category_stuff,
                tb_booking_has_detail.category_countainer,
                tb_booking_has_detail.category_teus,
                tb_booking_has_detail.category_service,
                tb_booking_has_detail.stuffing_take,
                tb_booking_has_detail.stuffing_open,
                tb_booking_has_detail.stuffing_take_address,
                tb_booking_has_detail.stuffing_open_address,
                mst_category_load.name AS category_load_name,
                mst_category_stuff.name AS category_stuff_name,
                mst_countainer.code AS countainer_code,
                mst_countainer.barcode AS countainer_barcode,
                mst_customer.name AS customer_name,
                mst_customer.address AS customer_address,
                tb_voyage.code AS voyage_code,
                tb_voyage.id_depo_to,
                depo_from.name AS depo_from_name,
                depo_to.name AS depo_to_name,
                depo_to.id AS depo_position
            ',
            'from' => 'tb_booking_has_countainer',
            'join' => [
                'mst_countainer , tb_booking_has_countainer.id_countainer = mst_countainer.id , left',
                'tb_booking , tb_booking_has_countainer.id_booking = tb_booking.id , left',
                'tb_booking_has_detail , tb_booking_has_countainer.id_booking_detail = tb_booking_has_detail.id , left',
                'mst_category_load, tb_booking_has_detail.id_category_load = mst_category_load.id , left',
                'mst_category_stuff, tb_booking_has_detail.id_category_stuff = mst_category_stuff.id , left',
                'mst_customer, tb_booking.id_customer = mst_customer.id , left',
                'tb_voyage, tb_booking.id_voyage = tb_voyage.id,left',
                'mst_depo AS depo_from, tb_voyage.id_depo_from = depo_from.id, left',
                'mst_depo AS depo_to, tb_voyage.id_depo_to = depo_to.id, left',
            ],
            'where' => [
                'tb_booking_has_countainer.id' => $id
            ]
        ];
        $get_data_countainer = Modules::run('database/get', $array_query)->row();
        $data['data_countainer'] = $get_data_countainer;
        $data['data_depo'] = Modules::run('database/find', 'mst_depo', ['isDeleted' => 'N'])->result();
        $data['data_maintenance_category'] = Modules::run('database/find', ' tb_maintenance_category', ['isDeleted' => 'N'])->result();
        $html_respon = $this->load->view('_partials/form_return', $data, true);
        echo json_encode(['status' => TRUE, 'html_respon' => $html_respon]);
    }

    public function update_return_countainer()
    {
        Modules::run('security/is_ajax');
        $id_depo        = $this->input->post('depo');
        $maintenance    = $this->input->post('maintenance');
        $description    = $this->input->post('description');
        $maintenance_status = $this->input->post('maintenance_status');
        $status_av      = $this->input->post('status_av');
        $status_rp      = $this->input->post('status_rp');
        $status_dl      = $this->input->post('status_dl');
        $id_countainer  = $this->input->post('id_countainer');
        $id_bs_countainer = $this->input->post('id_bs_countainer');

        //update countainer
        $array_countainer = [
            'av' => $status_av ? 1 : 0,
            'isAvailable' => $status_av ? 'N' : 'Y',
            'rp' => $status_rp ? 1 : 0,
            'dl' => $status_dl ? 1 : 0,
            'id_depo_from' => $id_depo
        ];
        Modules::run('database/update', 'mst_countainer', ['id' => $id_countainer], $array_countainer);

        //update status countainer bs
        $update_status_countainer  = [
            'id_countainer' => $id_countainer,
            'id_booking_countainer' => $id_bs_countainer,
            'status' => 7
        ];
        Modules::run('transaction/update_status_countainer', $update_status_countainer);

        //insert maintenance
        if ($maintenance_status) {
            $array_insert_maintenance = [
                'type' => 1,
                'id_countainer' => $id_countainer,
                'id_booking_countainer' => $id_bs_countainer,
                'id_category_maintenance' => $maintenance,
                'description' => $description,
                'date' => date('Y-m-d'),
                'created_by' => $this->session->userdata('us_id')
            ];
            Modules::run('database/insert', 'tb_maintenance_queue', $array_insert_maintenance);
        }
        echo json_encode(['status' => TRUE]);
    }

    //======================================== ACTIVITY ==========================================================
    public function get_detail_activity()
    {
        Modules::run('security/is_ajax');
        $id_bs = $this->input->post('id_bs');
        $id_countainer = $this->input->post('id_countainer');
        $array_query  = [
            'select' => '
                tb_booking_has_countainer.*,
                tb_booking.code AS booking_code,
                tb_booking.date AS booking_date,
                tb_booking_has_detail.id_category_load,
                tb_booking_has_detail.id_category_stuff,
                tb_booking_has_detail.category_countainer,
                tb_booking_has_detail.category_teus,
                tb_booking_has_detail.category_service,
                tb_booking_has_detail.stuffing_take,
                tb_booking_has_detail.stuffing_open,
                tb_booking_has_detail.stuffing_take_address,
                tb_booking_has_detail.stuffing_open_address,
                mst_category_load.name AS category_load_name,
                mst_category_stuff.name AS category_stuff_name,
                mst_countainer.code AS countainer_code,
                mst_countainer.barcode AS countainer_barcode,
                mst_customer.name AS customer_name,
                mst_customer.address AS customer_address
            ',
            'from' => 'tb_booking_has_countainer',
            'join' => [
                'mst_countainer , tb_booking_has_countainer.id_countainer = mst_countainer.id , left',
                'tb_booking , tb_booking_has_countainer.id_booking = tb_booking.id , left',
                'tb_booking_has_detail , tb_booking_has_countainer.id_booking_detail = tb_booking_has_detail.id , left',
                'mst_category_load, tb_booking_has_detail.id_category_load = mst_category_load.id , left',
                'mst_category_stuff, tb_booking_has_detail.id_category_stuff = mst_category_stuff.id , left',
                'mst_customer, tb_booking.id_customer = mst_customer.id , left'
            ],
            'where' => [
                'tb_booking_has_countainer.id' => $id_countainer
            ]
        ];
        $get_data_countainer = Modules::run('database/get', $array_query)->row();
        $data['data_countainer'] = $get_data_countainer;

        $array_query = [
            'from' => 'tb_category_activity',
            'where' => [
                'tb_category_activity.isDeleted' => 'N'
            ],
            'order_by' => 'tb_category_activity.name'
        ];

        $data['data_activity'] = Modules::run('database/get', $array_query)->result();

        $html_respon = $this->load->view('_partials/activity', $data, TRUE);
        echo json_encode(['status' => TRUE, 'html_respon' => $html_respon]);
    }

    private function validate_save_activity()
    {
        Modules::run('security/is_ajax');
        $data = array();

        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        // this validate if there is same file to be uploaded
        $id = $this->input->post('id');
        if ($this->input->post('activity') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'activity';
            $data['status'] = FALSE;
        }

        if ($this->input->post('price') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'price';
            $data['status'] = FALSE;
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
        if ($this->input->post('qty') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'qty';
            $data['status'] = FALSE;
        }
        if ($this->input->post('price') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'price';
            $data['status'] = FALSE;
        }

        if ($data['status'] == FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    public function save_activity()
    {
        Modules::run('security/is_ajax');
        $this->validate_save_activity();

        $id_bs    = $this->input->post('id_bs');
        $booking_countainer = $this->input->post('countainer');
        $activity    = $this->input->post('activity');
        $status      = $this->input->post('status');
        $date_from   = Modules::run('helper/change_date', $this->input->post('date_from'), '-');
        $date_to     = Modules::run('helper/change_date', $this->input->post('date_to'), '-');
        $qty         = str_replace('.', '', $this->input->post('qty'));
        $price       = str_replace('.', '', $this->input->post('price'));

        $array_insert = [
            'id_booking' => $id_bs,
            'id_booking_countainer' => $booking_countainer,
            'id_activity_booking' => $activity,
            'status' => $status,
            'qty' => $qty,
            'price' => $price,
            'total_price' => ($qty * $price),
            'date_from' => $date_from,
            'date_to' => $date_to,
            'created_by' => $this->session->userdata('us_id')
        ];
        Modules::run('database/insert', 'tb_booking_has_countainer_activity', $array_insert);
        echo json_encode(['status' => TRUE]);
    }

    public function get_transaction_activity()
    {
        Modules::run('security/is_ajax');
        $id_countainer = $this->input->post('id_countainer');
        $array_query = [
            'select' => '
                tb_booking_has_countainer_activity.*,
                tb_category_activity.name AS activity_name
            ',
            'from' => 'tb_booking_has_countainer_activity',
            'join' => [
                'tb_category_activity, tb_booking_has_countainer_activity.id_activity_booking = tb_category_activity.id , left'
            ],
            'where' => [
                'tb_booking_has_countainer_activity.id_booking_countainer' => $id_countainer
            ]
        ];
        $get_data = Modules::run('database/get', $array_query)->result();
        $status_activity_transaction     = json_decode(Modules::run('database/find', 'app_module_setting', ['field' => 'status_activity_transaction'])->row()->value, TRUE);

        $html_item  = '';
        $counter = 0;
        $grand_total_price  = 0;
        foreach ($get_data as $item_data) {
            $label_status = isset($status_activity_transaction[$item_data->status]) ? $status_activity_transaction[$item_data->status] : '-';
            $counter++;
            $btn_act = '';
            if ($item_data->id_invoice == 0) {
                $btn_act = Modules::run('security/delete_access', '<a href="javascript:void(0)" class="btn btn-danger btn_delete_activity" data-countainer="' . $id_countainer . '" data-id="' . $item_data->id . '"><i class="fa fa-trash"></i></a>');
            }
            $grand_total_price += $item_data->total_price;
            $html_item .= '
                <tr>
                    <td>' . $counter . '</td>
                    <td>
                        <label for="" class="m-0 font-weight-bold">' . $item_data->activity_name . '</label>
                        <p class="tx-10">
                            ' . Modules::run('helper/date_indo', $item_data->date_from, '-') . ' s/d ' . Modules::run('helper/date_indo', $item_data->date_to, '-') . '
                        </p>
                    </td>
                    <td><span class="badge badge-light tx-14 text-uppercase">' . $label_status . '</span></td>
                    <td class="text-center">
                        <label for="" class="m-0 font-weight-bold p-2 border-dashed">' . $item_data->qty . '</label>
                    </td>
                    <td>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text font-weight-bold">
                                    Rp.
                                </div>
                            </div>
                            <input value="' . number_format($item_data->price, 0, '.', '.') . '"  class="form-control border-dashed  font-weight-bold bg-white" type="text">
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text font-weight-bold">
                                    Rp.
                                </div>
                            </div>
                            <input value="' . number_format($item_data->total_price, 0, '.', '.') . '"  class="form-control border-dashed  font-weight-bold bg-white" type="text">
                        </div>
                    </td>
                    <td>
                        ' . $btn_act . '
                    </td>
                </tr>
            ';
        }

        $html_item .= '
            <tr>
                <td colspan="5" class="text-right">
                    <h3 for="" class="font-weight-bold">Total</h3>
                </td>
                <td colspan="2">
                    <h3 class="text-primary font-weight-bold">Rp.' . number_format($grand_total_price, 0, '.', '.') . '</h3>
                </td>
            </tr>
        ';
        if (empty($get_data)) {
            $html_item = '
                <tr>
                    <td colspan="7">
                        <div class="col-12 text-center">
                            <div class="plan-card text-center">
                                <i class="fas fa-file plan-icon text-primary"></i>
                                <h6 class="text-drak text-uppercase mt-2">Data Kosong</h6>
                                <small class="text-muted">Tidak ada item activity.</small>
                            </div>
                        </div>
                    </td>
                </tr>
            ';
        }
        echo json_encode(['status' => TRUE, 'html_respon' => $html_item]);
    }


    public function show_preview_detail_activity()
    {
        Modules::run('security/is_ajax');
        // print_r($_POST);
        $id = $this->input->post('id');
        $data['id_booking'] = $id;
        $html_respon = $this->load->view('_partials/list_preview_activity', $data, TRUE);
        echo json_encode(['status' => TRUE, 'html_respon' => $html_respon]);
    }

    public function show_preview_invoice_activity()
    {
        Modules::run('security/is_ajax');
        $id_bs = $this->input->post('id');
        $get_invoice_activity = Modules::run('database/find', ' tb_invoice', ['id_booking' => $id_bs, 'type' => 4])->result();
        $data['list_invoice'] = $get_invoice_activity;

        $data['company'] = [
            'name' => Modules::run('database/find', 'app_setting', ['field' => 'company_name'])->row()->value,
            'company_tagline' => Modules::run('database/find', 'app_setting', ['field' => 'company_tagline'])->row()->value,
            'company_email' => Modules::run('database/find', 'app_setting', ['field' => 'company_email'])->row()->value,
            'company_number_phone' => Modules::run('database/find', 'app_setting', ['field' => 'company_number_phone'])->row()->value,
            'company_address' => Modules::run('database/find', 'app_setting', ['field' => 'company_address'])->row()->value,
            'company_logo' => Modules::run('database/find', 'app_setting', ['field' => 'company_logo'])->row()->value
        ];

        $array_query_bs = [
            'select' => '
                tb_booking.*,
                mst_customer.name AS customer_name,
                mst_customer.address AS customer_address,
                mst_customer.expired_limit,
                tb_voyage.code AS voyage_code
            ',
            'from' => 'tb_booking',
            'where' => [
                'tb_booking.id' => $id_bs
            ],
            'join' => [
                'mst_customer, tb_booking.id_customer = mst_customer.id , left',
                'tb_voyage, tb_booking.id_voyage = tb_voyage.id , left'
            ]
        ];
        $get_bs = Modules::run('database/get', $array_query_bs)->row();
        $data['data_bs'] = $get_bs;

        $html_respon = $this->load->view('_partials/list_invoice_activity', $data, TRUE);
        echo json_encode(['status' => TRUE, 'html_respon' => $html_respon, 'id' => $id_bs]);
    }


    // ======================================= API public function ===============================================
    public function count_transaction()
    {
        Modules::run('security/is_ajax');
        $count_voyage_transaction   = Modules::run('database/find', 'tb_voyage', ['status >' => 1, 'status <' => 8])->num_rows();
        $count_unloading_countainer = Modules::run('database/find', 'tb_booking_has_countainer', ['status' => 5, 'is_empty' => 0])->num_rows();
        $count_return_countainer = Modules::run('database/find', 'tb_booking_has_countainer', ['status' => 6, 'is_empty' => 0])->num_rows();

        $array_respon = [
            'count_proceed_voyage' => $count_voyage_transaction,
            'count_unloading_countainer' => $count_unloading_countainer,
            'count_return_countainer' => $count_return_countainer,
            'status' => TRUE
        ];
        echo json_encode($array_respon);
    }
}
