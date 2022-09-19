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
        $view_file = 'empty_dashboard';

        $this->app_data['page_title']   = 'dashboard';
        $this->app_data['view_file']    = $view_file;
        echo Modules::run('template/horizontal_layout', $this->app_data);
    }

    public function show_resume_invoice()
    {
        Modules::run('security/is_ajax');
        $array_month = [
            1 => 'januari',
            2 => 'februari',
            3 => 'maret',
            4 => 'april',
            5 => 'mei',
            6 => 'juni',
            7 => 'juli',
            8 => 'agustus',
            9 => 'september',
            10 => 'oktober',
            11 => 'november',
            12 => 'december'
        ];

        $array_customer = $this->input->post('customer');
        $year_period_from = $this->input->post('year_period_from');
        $month_period_from = $this->input->post('month_period_from');
        $year_period_to = $this->input->post('year_period_to');
        $month_period_to = $this->input->post('month_period_to');

        //diff year
        $diff_year = $year_period_to - $year_period_from;
        $count_month = 0;
        if ($diff_year > 1) {
            $count_month = 12 * ($diff_year - 1);
        }
        if ($year_period_from < $year_period_to) {
            $count_month += ((12 - (int) $month_period_from) + (int) $month_period_to) + 1;
        } else {
            $count_month =  ((int) $month_period_to - (int) $month_period_from) + 1;
        }

        $date_to = date("Y-m-t", strtotime($year_period_to . '-' . $month_period_to . '-01'));
        $date_from = $year_period_from . '-' . $month_period_from . '-01';

        $array_query = [
            'from' => 'tb_invoice',
            'where' => [
                'tb_invoice.invoice_date >=' => $date_from,
                'tb_invoice.invoice_date<=' => $date_to
            ]
        ];
        if (!empty($array_customer)) {
            $array_query['where_in'] = [
                'tb_invoice.id_customer' => $array_customer
            ];
        }


        $get_data = Modules::run('database/get', $array_query)->result();

        //create key
        $array_freight = [];
        $array_thc = [];
        $array_lc = [];
        $array_activity = [];

        $array_label = [];

        $starting_year = $year_period_from;
        $starting_month = (int) $month_period_from;
        for ($i = 0; $i < $count_month; $i++) {
            $text_month = isset($array_month[$starting_month]) ? $array_month[$starting_month] : '';
            $array_label[] = strtoupper($text_month) . ' - ' . $starting_year;
            $array_freight[$starting_month . '-' . $starting_year] = 0;
            $array_thc[$starting_month . '-' . $starting_year] = 0;
            $array_lc[$starting_month . '-' . $starting_year] = 0;
            $array_activity[$starting_month . '-' . $starting_year] = 0;

            $starting_month++;
            if ($starting_month > 12) {
                $starting_year++;
                $starting_month = 1;
            }
        }
        $total_freight = 0;
        $total_thc = 0;
        $total_lc = 0;
        $total_activity = 0;

        foreach ($get_data as $item_data) {
            $key = (int)date("m", strtotime($item_data->invoice_date)) . '-' . date("Y", strtotime($item_data->invoice_date));

            if ($item_data->type == 1) {
                $total_freight += $item_data->total_invoice;
                if (isset($array_freight[$key])) {
                    $array_freight[$key] += $item_data->total_invoice;
                }
            }
            if ($item_data->type == 2) {
                $total_thc += $item_data->total_invoice;
                if (isset($array_thc[$key])) {
                    $array_thc[$key] += $item_data->total_invoice;
                }
            }
            if ($item_data->type == 3) {
                $total_lc += $item_data->total_invoice;
                if (isset($array_lc[$key])) {
                    $array_lc[$key] += $item_data->total_invoice;
                }
            }
            if ($item_data->type == 4) {
                $total_activity += $item_data->total_invoice;
                if (isset($array_activity[$key])) {
                    $array_activity[$key] += $item_data->total_invoice;
                }
            }
        }

        $counter = 0;
        $data_chart = [
            [
                'name' => 'FREIGHT',
                'data' => []
            ],
            [
                'name' => 'THC',
                'data' => []
            ],
            [
                'name' => 'LOSS CARGO',
                'data' => []
            ],
            [
                'name' => 'ACTIVITY',
                'data' => []
            ]
        ];
        foreach ($array_activity as $key => $value) {

            $data_chart[0]['data'][] = $array_freight[$key];
            $data_chart[1]['data'][] = $array_thc[$key];
            $data_chart[2]['data'][] = $array_lc[$key];
            $data_chart[3]['data'][] = $array_activity[$key];
        }

        $array_respon = [
            'resume' => [
                'freight' => $total_freight,
                'thc' => $total_thc,
                'lc' => $total_lc,
                'activity' => $total_activity
            ],
            'label' => $array_label,
            'data_chart' => $data_chart,
            'status' => TRUE
        ];

        echo json_encode($array_respon);
    }

    public function show_resume_cost()
    {
        Modules::run('security/is_ajax');
        $array_month = [
            1 => 'januari',
            2 => 'februari',
            3 => 'maret',
            4 => 'april',
            5 => 'mei',
            6 => 'juni',
            7 => 'juli',
            8 => 'agustus',
            9 => 'september',
            10 => 'oktober',
            11 => 'november',
            12 => 'december'
        ];

        $date_from  = Modules::run('helper/change_date', $this->input->post('date_from'), '-');
        $date_to    = Modules::run('helper/change_date', $this->input->post('date_to'), '-');
        $cost       = $this->input->post('cost');


        $year_period_from   = date('Y', strtotime($date_from));
        $month_period_from  = date('m', strtotime($date_from));
        $year_period_to     = date('Y', strtotime($date_to));
        $month_period_to    =  date('m', strtotime($date_to));

        $diff_year = $year_period_to - $year_period_from;
        $count_month = 0;
        if ($diff_year > 1) {
            $count_month = 12 * ($diff_year - 1);
        }
        if ($year_period_from < $year_period_to) {
            $count_month += ((12 - (int) $month_period_from) + (int) $month_period_to) + 1;
        } else {
            $count_month =  ((int) $month_period_to - (int) $month_period_from) + 1;
        }

        $array_label = [];
        $starting_year  = $year_period_from;
        $starting_month = (int) $month_period_from;
        $array_value = [];
        for ($i = 0; $i < $count_month; $i++) {
            $text_month = isset($array_month[$starting_month]) ? $array_month[$starting_month] : '';
            $array_label[] = strtoupper($text_month) . ' - ' . $starting_year;

            $array_value[$starting_month . '-' . $starting_year] = 0;

            $starting_month++;
            if ($starting_month > 12) {
                $starting_year++;
                $starting_month = 1;
            }
        }

        $get_cost_account = Modules::run('database/find', 'tb_book_account', ['isDeleted' => 'N', 'type_account' => 5, 'id_parent >' => 0])->result();
        $array_cost = [];
        foreach ($get_cost_account as $item_data) {
            $array_cost[] = $item_data->id;
        }
        if (!empty($cost)) {
            $array_cost = $cost;
        }

        $array_query = [
            'select' => '
                tb_book_account_has_detail.credit,
                tb_book_account_has_detail.date
            ',
            'from' => 'tb_book_account_has_detail',
            'where' => [
                'credit > ' => 0,
                'tb_book_account_has_detail.date >=' => $date_from,
                'tb_book_account_has_detail.date <=' => $date_to
            ],
            'where_in' => [
                'tb_book_account_has_detail.id_book_account ' => $array_cost
            ]
        ];
        $get_data_cost = Modules::run('database/get', $array_query)->result();

        foreach ($get_data_cost as $item_data) {
            $key = (int)date("m", strtotime($item_data->date)) . '-' . date("Y", strtotime($item_data->date));
            $array_value[$key] += $item_data->credit;
        }


        $array_value_chart = [];
        foreach ($array_value as $key => $value) {
            $array_value_chart[] = $value;
        }


        $array_respon = [
            'label' => $array_label,
            'data_chart' => $array_value_chart,
            'status' => TRUE
        ];

        echo json_encode($array_respon);
    }
}
