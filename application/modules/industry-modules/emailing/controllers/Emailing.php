<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Emailing extends CommonController
{
    var $module_name        = 'emailing';
    var $module_directory   = 'emailing';
    var $module_js          = ['emailing'];
    var $app_data           = [];


    public function __construct()
    {
        parent::__construct();
        $this->load->library('email');
    }

    private function _init()
    {
        Modules::run('security/common_security');
        $this->app_data['module_js']    = $this->module_js;
        $this->app_data['module_name']  = $this->module_name;
        $this->app_data['module_directory']  = $this->module_directory;
    }

    // public function index()
    // {
    //     $this->_init();
    //     $this->app_data['page_title'] = "Emailing";
    //     $this->app_data['view_file'] = 'main_view';
    //     echo Modules::run('template/main_layout', $this->app_data);
    // }

    public function load_data()
    {
        $this->_init();
        Modules::run('security/is_ajax');
        $get_all = Modules::run('database/find', ' tb_email_template', ['id >' => 0])->result();
        $html_respon = '';
        $counter = 0;
        foreach ($get_all as $item_data) {
            $counter++;
            $html_respon .= '
                <div class="col-12 shadow-3 row align-items-center p-2 mb-2" >
                    <div class="col-10 border-right">
                        <h5> ' . $item_data->name . '</h5>
                        <p class="tx-12 text-muted">' . $item_data->description . '</p>
                    </div>
                    <div class="col-2 text-center">
                        <a href="' . Modules::run('helper/create_url', 'emailing/update?data=' . urlencode($this->encrypt->encode($item_data->id))) . '" class="btn btn-rounded btn-warning-gradient btn-block">
                            <i class="fa fa-tv"></i> Update
                        </a>
                        <a class="d-block mt-1" data-toggle="collapse" href="#view_' . $counter . '" role="button" aria-expanded="false" aria-controls="collapseExample">
                            Lihat Detail <i class="fas fa-angle-down"></i>
                        </a>
                    </div>
                    <div class="col-12 p-2 border collapse" id="view_' . $counter . '">' . $item_data->template . '</div>
                </div>
            ';
        }

        if (empty($get_all)) {
            $html_respon = '
                <div class="row justify-content-center align-items-center" >
                    <div class="col-12 text-center">
                        <div class="card">
                                <div class="card-body">
                                    <div class="plan-card text-center">
                                    <i class="fas fa-file plan-icon text-primary"></i>
                                    <h6 class="text-drak text-uppercase mt-2">Data Kosong</h6>
                                    <small class="text-muted">Tidak ada Data.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        }

        echo json_encode(['status' => TRUE, 'html_respon' => $html_respon]);
    }

    public function update()
    {
        $this->_init();
        $id = $this->encrypt->decode($this->input->get('data'));
        $this->app_data['data_detail'] = Modules::run('database/find', 'tb_email_template', ['id' => $id])->row();

        $this->app_data['page_title'] = "Update Email";
        $this->app_data['view_file'] = 'view_update';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function save()
    {
        $this->_init();
        Modules::run('security/is_ajax');
        $content = $_POST['content'];
        $id = $this->input->post('id');

        $array_update = [
            'template' => $content
        ];
        Modules::run('database/update', 'tb_email_template', ['id' => $id], $array_update);
        echo json_encode(['status' => TRUE]);
    }

    //send email
    public function new_order($id_bs)
    {
        $array_query = [
            'select' => '
                tb_booking.*,
                mst_customer.name AS customer_name,
                mst_customer.email AS customer_email,
                mst_customer.address AS customer_address
            ',
            'from' => 'tb_booking',
            'where' => [
                'tb_booking.id' => $id_bs
            ],
            'join' => [
                'mst_customer, tb_booking.id_customer = mst_customer.id , left'
            ],
            'order_by' => 'tb_booking.id , DESC'
        ];
        $get_data = Modules::run('database/get', $array_query)->row();
        $data['data_bs'] = $get_data;

        $html_content = $this->load->view('_partials/content_new_order', $data, TRUE);

        $subject        = 'PEMESANAN KONTAINER / LC #' . $get_data->code;
        $get_template   = Modules::run('database/find', 'tb_email_template', ['keyword' => 'new_order'])->row();
        $email          = $get_data->customer_email;
        $content        = $get_template->template;
        $content        = str_replace('{content}', $html_content, $content);
        $content        = str_replace('{username}', $get_data->customer_name, $content);

        $this->send_email($subject, $content, $email);
    }

    public function confirm_order($id_bs)
    {
        $array_query = [
            'select' => '
                tb_booking.*,
                mst_customer.name AS customer_name,
                mst_customer.email AS customer_email,
                mst_customer.address AS customer_address
            ',
            'from' => 'tb_booking',
            'where' => [
                'tb_booking.id' => $id_bs
            ],
            'join' => [
                'mst_customer, tb_booking.id_customer = mst_customer.id , left'
            ],
            'order_by' => 'tb_booking.id , DESC'
        ];
        $get_data = Modules::run('database/get', $array_query)->row();
        $data['data_bs'] = $get_data;

        $html_content = $this->load->view('_partials/content_confirm_order', $data, TRUE);


        $subject        = 'PEMESANAN  #' . $get_data->code . ' TELAH DIKONFIRMASI';
        $get_template   = Modules::run('database/find', 'tb_email_template', ['keyword' => 'confirm_order'])->row();
        $email          = $get_data->customer_email;
        $content        = $get_template->template;
        $content        = str_replace('{content}', $html_content, $content);
        $content        = str_replace('{username}', $get_data->customer_name, $content);

        $this->send_email($subject, $content, $email);
    }

    public function reject_order($id_bs)
    {
        $array_query = [
            'select' => '
                tb_booking.*,
                mst_customer.name AS customer_name,
                mst_customer.email AS customer_email,
                mst_customer.address AS customer_address
            ',
            'from' => 'tb_booking',
            'where' => [
                'tb_booking.id' => $id_bs
            ],
            'join' => [
                'mst_customer, tb_booking.id_customer = mst_customer.id , left'
            ],
            'order_by' => 'tb_booking.id , DESC'
        ];
        $get_data = Modules::run('database/get', $array_query)->row();
        $data['data_bs'] = $get_data;

        $html_content = $this->load->view('_partials/content_reject_order', $data, TRUE);

        $subject        = 'PEMESANAN  #' . $get_data->code . ' TELAH DIBATALKAN';
        $get_template   = Modules::run('database/find', 'tb_email_template', ['keyword' => 'reject_order'])->row();
        $email          = $get_data->customer_email;
        $content        = $get_template->template;
        $content        = str_replace('{content}', $html_content, $content);
        $content        = str_replace('{username}', $get_data->customer_name, $content);

        $this->send_email($subject, $content, $email);
    }


    public function invoice($id_invoice)
    {
        $query = [
            'select' => '
                tb_invoice.*,
                mst_customer.name AS customer_name,
                mst_customer.email AS customer_email,
                tb_booking.code AS booking_code,
                tb_booking.id AS booking_id
            ',
            'from' => 'tb_invoice',
            'join' => [
                'mst_customer, tb_invoice.id_customer = mst_customer.id , left',
                'tb_booking, tb_invoice.id_booking = tb_booking.id , left'
            ],
            'where' => [
                'tb_invoice.id' => $id_invoice
            ]
        ];
        $get_data = Modules::run('database/get', $query)->row();
        $data['data_invoice'] = $get_data;

        $html_content = $this->load->view('_partials/content_invoice', $data, TRUE);
        // echo $html_content;

        $subject        = 'Invoice  #' . $get_data->code;
        $get_template   = Modules::run('database/find', 'tb_email_template', ['keyword' => 'invoice'])->row();
        $email          = $get_data->customer_email;
        $content        = $get_template->template;
        $content        = str_replace('{content}', $html_content, $content);
        $content        = str_replace('{username}', $get_data->customer_name, $content);

        $this->send_email($subject, $content, $email);
    }

    public function payment($id_payment)
    {
        $query = [
            'select' => '
                tb_credit_has_payment.*,
                tb_credit.invoice_code,
                mst_customer.name AS customer_name,
                mst_customer.email AS customer_email
            ',
            'from' => 'tb_credit_has_payment',
            'join' => [
                'tb_credit, tb_credit_has_payment.id_credit = tb_credit.id , left',
                'mst_customer, tb_credit.id_customer = mst_customer.id , left',
            ],
            'where' => [
                'tb_credit_has_payment.id' => $id_payment
            ]
        ];
        $get_data = Modules::run('database/get', $query)->row();


        $data['data_payment'] = $get_data;

        $html_content = $this->load->view('_partials/content_payment', $data, TRUE);

        $subject        = 'Pembayaran Invoice  #' . $get_data->invoice_code;
        $get_template   = Modules::run('database/find', 'tb_email_template', ['keyword' => 'payment'])->row();
        $email          = $get_data->customer_email;
        $content        = $get_template->template;
        $content        = str_replace('{content}', $html_content, $content);
        $content        = str_replace('{username}', $get_data->customer_name, $content);

        $this->send_email($subject, $content, $email);
    }

    public function update_status_order($id_bs, $status_description)
    {
        $array_query = [
            'select' => '
                tb_booking.*,
                mst_customer.name AS customer_name,
                mst_customer.email AS customer_email,
                mst_customer.address AS customer_address
            ',
            'from' => 'tb_booking',
            'where' => [
                'tb_booking.id' => $id_bs
            ],
            'join' => [
                'mst_customer, tb_booking.id_customer = mst_customer.id , left'
            ],
            'order_by' => 'tb_booking.id , DESC'
        ];
        $get_data = Modules::run('database/get', $array_query)->row();
        $data['data_bs'] = $get_data;
        $data['status_description'] = $status_description;
        $html_content = $this->load->view('_partials/content_update_status_order', $data, TRUE);

        $subject        = 'STATUS PEMESANAN  #' . $get_data->code . ' TELAH DIUPDATE';
        $get_template   = Modules::run('database/find', 'tb_email_template', ['keyword' => 'update_voyage'])->row();
        $email          = $get_data->customer_email;
        $content        = $get_template->template;
        $content        = str_replace('{content}', $html_content, $content);
        $content        = str_replace('{username}', $get_data->customer_name, $content);

        $this->send_email($subject, $content, $email);
    }

    public function confirm_email($email, $encrypt_key, $username, $password) {
        $data["encrypt_key"] = $encrypt_key;
        $data["username"] = $username;
        $data["password"] = $password;
        $html_content = $this->load->view('_partials/content_confirm_email', $data, TRUE);

        // echo ($email); return;

        $subject = "KONFIRMASI EMAIL";
        $get_template = Modules::run("database/find", 'tb_email_template', ['keyword' => 'email_confirm'])->row();
        $email = $email;
        $content        = $get_template->template;
        $content        = str_replace('{content}', $html_content, $content);
        $content        = str_replace('{username}', $email, $content);

        $this->send_email($subject, $content, $email);
    }

    public function forgot_password($email, $encrypt_key, $to = "admin")
    {
        $data['encrypt_key'] = $encrypt_key;
        $data['modules'] = $to;
        $html_content = $this->load->view('_partials/content_forget_password', $data, TRUE);

        $subject        = 'RESET PASSWORD';
        $get_template   = Modules::run('database/find', 'tb_email_template', ['keyword' => 'forgot_password'])->row();
        $email          = $email;
        $content        = $get_template->template;
        $content        = str_replace('{content}', $html_content, $content);
        $content        = str_replace('{username}', $email, $content);

        $this->send_email($subject, $content, $email);
    }

    private function send_email($subject, $content, $email)
    {
        $get_email = Modules::run('database/find', 'app_setting', ['field' => 'email_configuration'])->row();
        $array_email = json_decode($get_email->value, TRUE);
        //get data
        $data['data'] = '';
        // $this->load->library('email');
        $config = array(
            'charset' => 'utf-8',
            'wordwrap' => TRUE,
            'mailtype' => 'html',
            'send_multipart' => FALSE
        );
        $this->email->initialize($config);
        // $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        $this->email->from($array_email['email'], $array_email['subject']);
        $list = array($email);
        $this->email->to($list);
        $this->email->subject($subject);
        $this->email->message($content);

        $fp = fsockopen($array_email['smtp'], 465, $errno, $errstr, 10);
        if (!$fp) {
            echo $array_email['smtp'] . " -  $errstr   ($errno)<br>\n";
        }

        $array_insert_log = [
            'email' => $email,
            'message' => $content
        ];

        if ($this->email->send()) {
            $array_insert_log['status_send'] = 1;
            $this->save_log($array_insert_log);

            return TRUE;
        } else {
            $array_insert_log['status_send'] = 0;
            $this->save_log($array_insert_log);

            return FALSE;
        }
    }

    private function save_log($data)
    {
        Modules::run('database/insert', 'tb_email_log', $data);
    }
}
