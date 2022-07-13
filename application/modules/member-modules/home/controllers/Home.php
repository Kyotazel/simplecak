<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends BackendController
{
    var $module_name        = 'home';
    var $module_directory   = 'home';
    var $module_js          = ['home'];
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
        //count total invoice
        $id_customer = $this->session->userdata('member_id');
        $resume_invoice = $this->db->select('SUM(rest_credit) AS total_credit, COUNT(id) AS count_credit')->where(['id_customer' => $id_customer, 'status' => 0, 'rest_credit >' => 0])->get('tb_credit')->row();
        $this->app_data['resume_invoice']   = $resume_invoice;

        //count booking
        $array_query_bs = [
            'select' => '
                tb_booking.id
            ',
            'from' => 'tb_booking',
            'where' => [
                'tb_booking.is_confirm' => 1,
                'tb_voyage.status >=' => 2,
                'tb_voyage.status <=' => 7,
                'tb_booking.id_customer' => $id_customer
            ],
            'join' => [
                'tb_voyage, tb_booking.id_voyage = tb_voyage.id, left'
            ]
        ];

        $count_booking = Modules::run('database/get', $array_query_bs)->num_rows();
        $this->app_data['count_booking']   = $count_booking;
        //count unloading container
        $array_query  = [
            'select' => 'tb_booking_has_countainer.id',
            'from' => 'tb_booking_has_countainer',
            'join' => [
                'tb_booking , tb_booking_has_countainer.id_booking = tb_booking.id , left'
            ],
            'where' => [
                'tb_booking.is_confirm' => 1,
                'tb_booking_has_countainer.status' => 5,
                'tb_booking.id_customer' => $id_customer
            ]
        ];
        $count_countainer = Modules::run('database/get', $array_query)->num_rows();
        $this->app_data['unloading_countainer']   = $count_countainer;

        $count_booking = Modules::run('database/get', $array_query_bs)->num_rows();
        $this->app_data['count_booking']   = $count_booking;
        //count unloading container
        $array_query  = [
            'select' => 'tb_booking_has_countainer.id',
            'from' => 'tb_booking_has_countainer',
            'join' => [
                'tb_booking , tb_booking_has_countainer.id_booking = tb_booking.id , left'
            ],
            'where' => [
                'tb_booking.is_confirm' => 1,
                'tb_booking_has_countainer.status' => 6,
                'tb_booking.id_customer' => $id_customer
            ]
        ];
        $count_return = Modules::run('database/get', $array_query)->num_rows();
        $this->app_data['count_return']   = $count_return;



        $this->app_data['page_title']   = 'dashboard';
        $this->app_data['view_file']    = 'main_view';
        echo Modules::run('template/main_layout', $this->app_data);
    }
}
