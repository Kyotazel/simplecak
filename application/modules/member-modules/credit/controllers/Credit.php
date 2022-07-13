<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Credit extends CommonController
{
    public function __construct()
    {
        parent::__construct();
        Modules::run('security/common_security');
        $this->_init();
    }

    var $module_name = 'credit';
    var $module_directory = 'credit';
    var $module_js = ['credit'];
    var $app_data = [];

    private function _init()
    {
        $this->app_data['module_js']  = $this->module_js;
        $this->app_data['module_name']  = $this->module_name;
        $this->app_data['module_directory']  = $this->module_directory;
    }

    public function get_code()
    {
        $number_text = 0;
        $simbol = 'CD';
        $first_number = 1;
        $code_pattern = substr(date('Y'), 2) . date('md');
        $code_pattern_like = $simbol . $code_pattern;
        // $get_data_exist = $this->db->query("select max(code) as max_code from tb_credit")->row_array();
        $get_data_exist = $this->db->query("select code AS max_code  from tb_credit WHERE id IN(SELECT MAX(id) FROM tb_credit)")->row_array();
        if (!empty($get_data_exist['max_code'])) {
            $clean_simbol = substr($get_data_exist['max_code'], 2, strlen($get_data_exist['max_code']));
            $code = $clean_simbol + 1;
        } else {
            $code = $code_pattern . $first_number;
        }
        $code_return = $simbol . $code;
        return $code_return;
    }

    public function get_payment_code()
    {
        $number_text = 0;
        $simbol = 'PC';
        $first_number = 1;
        $code_pattern = substr(date('Y'), 2) . date('md');
        $code_pattern_like = $simbol . $code_pattern;
        $get_data_exist = $this->db->query("select max(code) as max_code from tb_credit_has_payment")->row_array();
        if (!empty($get_data_exist['max_code'])) {
            $clean_simbol = substr($get_data_exist['max_code'], 2, strlen($get_data_exist['max_code']));
            $code = $clean_simbol + 1;
        } else {
            $code = $code_pattern . $first_number;
        }
        $code_return = $simbol . $code;
        return $code_return;
    }

    public function index()
    {
        $this->app_data['page_title']     = "Data Tagihan";
        $this->app_data['view_file']     = 'main_view';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function list_data()
    {
        $date_from  = $this->input->post('date_from') ? Modules::run('helper/change_date', $this->input->post('date_from'), '-') : '';
        $date_to    = $this->input->post('date_to') ? Modules::run('helper/change_date', $this->input->post('date_to'), '-') : '';
        $invoice_code = $this->input->post('invoice-code');

        // $db_name = $this->tb_name;
        $status_payment = $this->input->post('status_payment');
        $id_customer = $this->session->userdata('member_id');

        $array_where = ['tb_credit.status' => $status_payment, 'tb_credit.id_customer' => $id_customer];
        if ($date_from != '') {
            $array_where['tb_credit.date >='] = $date_from;
        }
        if ($date_to != '') {
            $array_where['tb_credit.date <='] = $date_to;
        }
        if ($invoice_code != '') {
            $this->db->like('tb_credit.invoice_code', $invoice_code, 'both');
        }



        $this->db->select('
            tb_credit.*,
            COUNT(tb_credit_has_payment.id) AS count_paid,
            mst_customer.name AS member_name,
            mst_customer.name AS member_name,
            st_user.username AS user_name,
            tb_booking.id AS id_booking,
            tb_booking.code AS booking_code,
            tb_invoice.type  AS invoice_type,
            tb_invoice.id As id_invoice
        ');
        $this->db->from('tb_credit');
        $this->db->join('tb_invoice', 'tb_credit.invoice_code = tb_invoice.code ', 'left');
        $this->db->join('tb_booking', 'tb_invoice.id_booking = tb_booking.id ', 'left');
        $this->db->join('tb_credit_has_payment', 'tb_credit.id = tb_credit_has_payment.id_credit', 'left');
        $this->db->join('mst_customer', 'tb_credit.id_customer = mst_customer.id ', 'left');
        $this->db->join('st_user', 'tb_credit.created_by = st_user.id ', 'left');
        $this->db->where($array_where);
        $this->db->order_by('tb_credit.id', 'DESC');
        $this->db->group_by('tb_credit.id');


        $get_data = $this->db->get()->result();

        $data = array();
        $no = 0;
        $html_list_invoice = '';
        foreach ($get_data as $data_table) {

            $id_encrypt = $this->encrypt->encode($data_table->id);
            $no++;
            $tgl1 = strtotime($data_table->date);
            $tgl2 = strtotime(date('Y-m-d'));
            $jarak = $tgl2 - $tgl1;
            $hari = $jarak / 60 / 60 / 24;

            $data['data_credit'] = $data_table;
            $html_list_invoice .= $this->load->view('_partials/component_list_invoice', $data, true);
        }

        if (empty($get_data)) {
            $html_list_invoice = '
                <div class="col-12 text-center shadow-3 py-5">
                    <div class="plan-card text-center">
                        <i class="fas fa-truck plan-icon text-primary"></i>
                        <h6 class="text-drak text-uppercase mt-2">Data Kosong</h6>
                        <small class="text-muted">Tidak ada Data Tagihan.</small>
                    </div>
                </div>
            ';
        }

        echo json_encode(['status' => TRUE, 'html_respon' => $html_list_invoice]);
    }


    public function detail_payment()
    {
        Modules::run('security/is_ajax');

        $id = $this->input->post('id');
        $this->db->select('
            tb_credit.*,
            COUNT(tb_credit_has_payment.id) AS count_paid,
            mst_customer.name AS member_name,
            mst_customer.name AS member_name,
            st_user.username AS user_name
        ');
        $this->db->from('tb_credit');
        $this->db->join('tb_credit_has_payment', 'tb_credit.id = tb_credit_has_payment.id_credit', 'left');
        $this->db->join('mst_customer', 'tb_credit.id_customer = mst_customer.id ', 'left');
        $this->db->join('st_user', 'tb_credit.created_by = st_user.id ', 'left');
        $this->db->where(['tb_credit.id' => $id]);
        $this->db->order_by('tb_credit.id', 'DESC');
        $this->db->group_by('tb_credit.id');

        $get_data = $this->db->get()->row();
        $data['data_credit'] = $get_data;
        //get detail
        $this->db->select('
            tb_credit_has_payment.*,
            st_user.username AS user_name
            ');
        $this->db->from('tb_credit_has_payment');
        $this->db->join('st_user', 'tb_credit_has_payment.created_by = st_user.id', 'left');
        $this->db->where(['tb_credit_has_payment.id_credit' => $id]);
        $get_data_detail = $this->db->get()->result();

        $data['data_detail'] = $get_data_detail;
        $html_respon = $this->load->view('view_detail', $data, TRUE);
        echo json_encode(['status' => TRUE, 'html_respon' => $html_respon]);
    }
}
