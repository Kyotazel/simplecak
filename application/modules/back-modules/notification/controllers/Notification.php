<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notification extends BackendController
{
    var $module_name        = 'notification';
    var $module_directory   = 'notification';
    var $module_js          = ['notification'];
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
        $this->app_data['list_notification'] = $this->load_data();
        $this->app_data['page_title'] = "Notifikasi";
        $this->app_data['view_file'] = 'main_view';
        echo Modules::run('template/main_layout', $this->app_data);
    }


    //member data
    public function notification_create_order($data)
    {
        //type 1
        $title = 'Order Baru';
        $description = 'kamu memiliki transaksi baru dengan kode booking <b>' . $data['code'] . '</b> ';
        $link = '/booking/detail?data=' . urlencode($this->encrypt->encode($data['id_transaction']));
        $data['type'] = 1;

        $array_insert = [
            'id_customer' => $data['id_customer'],
            'link' => $link,
            'title' => $title,
            'description' => $description,
            'type' => 1
        ];
        Modules::run('database/insert', 'tb_notification', $array_insert);

        //send email
        echo Modules::run('emailing/new_order', $data['id_transaction']);
    }

    public function notification_confirm_order($data)
    {
        //type 1
        $title = 'Order telah Dikonfirmasi admin';
        $description = 'yeay, transaksimu dengan kode order <b>' . $data['code'] . '</b> berhasil dikonfirmasi oleh admin. ';
        $link = '/booking/detail?data=' . urlencode($this->encrypt->encode($data['id_transaction']));
        $data['type'] = 1;

        $array_insert = [
            'id_customer' => $data['id_customer'],
            'link' => $link,
            'title' => $title,
            'description' => $description,
            'type' => 1
        ];
        Modules::run('database/insert', 'tb_notification', $array_insert);

        //send email
        Modules::run('emailing/confirm_order', $data['id_transaction']);
    }

    public function notification_reject_order($data)
    {
        //type 1
        $title = 'Transaksi Dibatalkan';
        $description = 'mohon maaf, transaksimu dengan kode order <b>' . $data['code'] . '</b> telah dibatalkan oleh admin. ';
        $link = '/booking/detail?data=' . urlencode($this->encrypt->encode($data['id_transaction']));
        $data['type'] = 1;

        $array_insert = [
            'id_customer' => $data['id_customer'],
            'link' => $link,
            'title' => $title,
            'description' => $description,
            'type' => 1
        ];
        Modules::run('database/insert', 'tb_notification', $array_insert);
        //send email
        Modules::run('emailing/reject_order', $data['id_transaction']);
    }

    public function notification_status_voyage($data)
    {
        $id_voyage          = $data['id_voyage'];
        $status_description = $data['description'];

        //get all data
        $get_all_booking = Modules::run('database/find', 'tb_booking', ['is_confirm' => 1, 'id_voyage' => $id_voyage])->result();
        foreach ($get_all_booking as $item_booking) {
            $title = 'Order <b>' . $item_booking->code . '</b> ' . $status_description;
            $description = '
                status transaksimu dengan kode order <b>' . $item_booking->code . '</b> telah diupdate oleh admin menjadi ' . $status_description . '
            ';
            $link = '/booking/detail?data=' . urlencode($this->encrypt->encode($item_booking->id));
            $array_insert = [
                'id_customer' => $item_booking->id_customer,
                'link' => $link,
                'title' => $title,
                'description' => $description,
                'type' => 1
            ];
            Modules::run('database/insert', 'tb_notification', $array_insert);

            //send email
            Modules::run('emailing/update_status_order',  $item_booking->id, $status_description);
        }
    }

    public function notification_new_invoice($data)
    {
        //type 2
        $title = 'Invoice Baru';
        $description = 'Anda memiliki invoice baru dengan kode invoice <b>#' . $data['code'] . '</b>. ';
        $link = '/credit';

        $array_insert = [
            'id_customer' => $data['id_customer'],
            'link' => $link,
            'title' => $title,
            'description' => $description,
            'type' => 2
        ];
        Modules::run('database/insert', 'tb_notification', $array_insert);
        //send email
        Modules::run('emailing/invoice', $data['id_transaction']);
    }

    public function notification_countainer()
    {
        $data_insert['type'] = 3;
        Modules::run('database/insert', 'tb_notification', $data_insert);
    }

    public function mark_item()
    {
        Modules::run('security/is_ajax');
        $id = $this->input->post('id');
        $get_data = Modules::run('database/find', 'tb_notification', ['id' => $id])->row();
        $array_update = ['is_open' => 'Y'];
        Modules::run('database/update', 'tb_notification', ['id' => $id], $array_update);
        $redirect = Modules::run('helper/create_url', $get_data->link);

        $array_respon = [
            'status' => TRUE,
            'redirect' => $redirect
        ];
        echo json_encode($array_respon);
    }

    public function mark_all()
    {
        Modules::run('security/is_ajax');
        $id = $this->session->userdata('member_id');

        Modules::run('database/update', 'tb_notification', ['id_customer' => NULL, 'is_open' => NULL], ['is_open' => 'Y']);
        echo json_encode(['status' => TRUE]);
    }

    //=============================== API DATA ============================================
    public function load_data()
    {
        $array_query = [
            'from' => 'tb_notification',
            'where' => [
                'is_open' => NULL,
                'id_customer' => NULL
            ],
            'order_by' => 'id,DESC'
        ];

        $get_data = Modules::run('database/get', $array_query)->result();
        return $get_data;
    }
}
