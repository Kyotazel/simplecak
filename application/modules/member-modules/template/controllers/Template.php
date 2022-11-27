<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Template extends BackendController
{
    var  $module = 'template';
    public function __construct()
    {
        parent::__construct();
    }

    private function _init()
    {
        Modules::run('security/banned_url', $this->module);
    }

    public function main_layout($data)
    {
        $this->_init();
        $id_credential_menu = $this->session->userdata('us_credential_menu');
        $menu = $this->create_menu($id_credential_menu, 'sidebar');
        $data['html_main_menu'] = $menu;
        $data['breadcrumb'] = $this->_breadcrumb($data);

        $data['company_name'] = Modules::run('database/find', 'app_setting', ['field' => 'company_name'])->row()->value;
        $data['company_tagline'] = Modules::run('database/find', 'app_setting', ['field' => 'company_tagline'])->row()->value;
        $data['company_email'] = Modules::run('database/find', 'app_setting', ['field' => 'company_email'])->row()->value;
        $data['company_number_phone'] = Modules::run('database/find', 'app_setting', ['field' => 'company_number_phone'])->row()->value;
        $data['company_instagram'] = Modules::run('database/find', 'app_setting', ['field' => 'company_instagram'])->row()->value;
        $data['company_facebook'] = Modules::run('database/find', 'app_setting', ['field' => 'company_facebook'])->row()->value;

        $this->load->view('main_layout', $data);
    }

    public function horizontal_layout($data)
    {
        $this->_init();
        $id_credential_menu = $this->session->userdata('member_credential_menu');
        $menu = $this->create_menu_horizontal($id_credential_menu, 'sidebar');
        $data['html_main_menu'] = $menu;
        $data['breadcrumb'] = $this->_breadcrumb($data);

        $data['company_name'] = Modules::run('database/find', 'app_setting', ['field' => 'company_name'])->row()->value;
        $data['company_tagline'] = Modules::run('database/find', 'app_setting', ['field' => 'company_tagline'])->row()->value;
        $data['company_email'] = Modules::run('database/find', 'app_setting', ['field' => 'company_email'])->row()->value;
        $data['company_number_phone'] = Modules::run('database/find', 'app_setting', ['field' => 'company_number_phone'])->row()->value;
        $data['company_instagram'] = Modules::run('database/find', 'app_setting', ['field' => 'company_instagram'])->row()->value;
        $data['company_facebook'] = Modules::run('database/find', 'app_setting', ['field' => 'company_facebook'])->row()->value;

        $this->load->view('horizontal_layout', $data);
    }

    //media for login
    public function login_layout($data)
    {
        $this->_init();
        $data['login_background']   = Modules::run('database/find', 'app_setting', ['field' => 'admin_login_background'])->row()->value;
        $data['login_image']        = Modules::run('database/find', 'app_setting', ['field' => 'admin_login_image'])->row()->value;

        $data['company_name'] = Modules::run('database/find', 'app_setting', ['field' => 'company_name'])->row()->value;
        $data['company_tagline'] = Modules::run('database/find', 'app_setting', ['field' => 'company_tagline'])->row()->value;
        $data['company_email'] = Modules::run('database/find', 'app_setting', ['field' => 'company_email'])->row()->value;
        $data['company_number_phone'] = Modules::run('database/find', 'app_setting', ['field' => 'company_number_phone'])->row()->value;
        $data['company_instagram'] = Modules::run('database/find', 'app_setting', ['field' => 'company_instagram'])->row()->value;
        $data['company_facebook'] = Modules::run('database/find', 'app_setting', ['field' => 'company_facebook'])->row()->value;
        $data['company_address'] = Modules::run('database/find', 'app_setting', ['field' => 'company_address'])->row()->value;

        $this->load->view('login_layout', $data);
    }

    public function error_token($data)
    {
        $this->_init();
        $this->load->view('errors/view_error_token', $data);
    }
    public function view_404()
    {
        $this->_init();
        $this->load->view('errors/view_404');
    }
    public function forbidden_module($input)
    {
        $this->_init();
        $data['data'] = $input;
        $this->load->view('errors/view_forbidden_module', $data);
    }

    private function _breadcrumb($data)
    {
        $controller_name    = $this->router->fetch_class();
        $get_module = Modules::run('database/find', 'app_module', ['directory' => $controller_name])->row();
        $controller_tag = '';
        if (!empty($get_module)) {
            $controller_tag = $get_module->name;
        } else {
            $admin_module = $this->config->item('app_admin_module');
            if (isset($admin_module[$controller_name])) {
                $controller_tag = $admin_module[$controller_name];
            }
        }
        $method_name  = $this->router->fetch_method();
        $method_tag = $data['page_title'];

        if ($method_name == 'index') {
            $method_tag = '';
        }
        $array_return = [
            'controller' => $controller_name,
            'method' => $method_name,
            'controller_tag' => $controller_tag,
            'method_tag' => $method_tag
        ];
        return $array_return;
    }

    private function create_menu($group, $type = false)
    {
        if (empty($group)) {
            return '';
        }
        $array_query = [
            'from' => 'app_menu',
            'where' => ['id_menu' => $group, 'type' => 2, 'is_sidebar_menu' => 1],
            'order_by' => 'sort'
        ];
        $get_menu = Modules::run('database/get', $array_query)->result();
        $treeview_menu = '';
        foreach ($get_menu as $data_table) {
            $icon = $data_table->icon;
            if ($data_table->id_parent == 0) {
                $child_data         = $this->create_sub($get_menu, $data_table->id);
                $status_has_child   = $this->has_child($get_menu, $data_table->id);

                $toggle_property = '';
                $additional_span = '';
                $additional_class_parent = '';
                if (!empty($child_data)) {
                    $additional_class_parent = 'with-sub';
                    $toggle_property = 'data-toggle="slide"';
                    $additional_span = '<i class="angle fe fe-chevron-right"></i>';
                }
                if ($data_table->is_devider) {
                    //devider
                    $treeview_menu .= '
                        <li class="nav-header ' . $data_table->css_class . '">
                            <span class="nav-label">' . $data_table->name . '</span>
                            ' . $child_data . '
                        </li>
                    ';
                } else {
                    $url = Modules::run('helper/create_url', $data_table->link);
                    $method = $data_table->link;
                    $clear_method = substr($method, -1) == '/' ? substr($method, 0, strlen($method) - 1) : $method;
                    if (substr($clear_method, 0, 1) != '/') {
                        $clear_method = '/' . $clear_method;
                    }
                    $data_url = base_url(PREFIX_CREDENTIAL_DIRECTORY . $clear_method);

                    //device class
                    $treeview_menu .= '
                                    <li class="nav-item main-parent-menu slide ' . $data_table->css_class . '" data-id="' . $data_table->id . '">
                                        <a class="nav-link ' . $additional_class_parent . '"  href="' . $url . '" data-url="' . $data_url . '">
                                            <span class="shape1"></span>
                                            <span class="shape2"></span>
                                            ' . $icon . '
                                            <span class="sidemenu-label">' . $data_table->name . '</span>
                                            ' . $additional_span . '
                                        </a>
                                        ' . $child_data . '
                                    </li>
								';
                }
            }
        }

        return $treeview_menu;
    }

    private function create_sub($results, $parent_request)
    {
        $child_status = 0;
        $menu = '<ul class="ul_' . $parent_request . ' nav-sub" data-position="sub_menu">';
        for ($i = 0; $i < sizeof($results); $i++) {
            if ($results[$i]->id_parent == $parent_request) {
                $class_devider = '';
                if ($results[$i]->is_devider) {
                    $menu .= '
                        <li class="nav-header ' . $results[$i]->css_class . '">
                            <span class="nav-label">' .  $results[$i]->name . '</span>
                        </li>
                    ';
                } else {
                    $child_status++;
                    $method = $results[$i]->link;
                    $clear_method = substr($method, -1) == '/' ? substr($method, 0, strlen($method) - 1) : $method;
                    if (substr($clear_method, 0, 1) != '/') {
                        $clear_method = '/' . $clear_method;
                    }
                    $data_url = base_url(PREFIX_CREDENTIAL_DIRECTORY . $clear_method);

                    $icon = $results[$i]->icon;

                    if ($this->has_child($results, $results[$i]->id)) {
                        $sub_menu = $this->create_sub($results, $results[$i]->id);
                        $url = Modules::run('helper/create_url', $results[$i]->link);

                        $menu .= '
                            <li class="nav-sub-item ' . $results[$i]->css_class . '" data-id="' . $results[$i]->id . '">
                                <a class="nav-sub-link with-sub" data-toggle="slide" href="' . $url . '" data-url="' . $data_url . '">
                                    <span class="side-menu__label">' . $results[$i]->name . '</span>
                                    <i class="angle fe fe-chevron-right"></i>
                                </a>
                                ' . $sub_menu . '
                            </li>
                            ';
                    } else {
                        $url = Modules::run('helper/create_url', $results[$i]->link);
                        $menu .= '
                        <li class="nav-sub-item ' . $results[$i]->css_class . '" data-id="' . $results[$i]->id . '">
                            <a class="nav-sub-link" href="' . $url . '" data-url="' . $data_url . '">
                                <span class="">' . $results[$i]->name . '</span>
                            </a>
                        </li>
                            ';
                    }
                }
            }
        }
        $menu .= '</ul>';
        $menu = $child_status == 0 ? '' : $menu;
        return $menu;
    }
    private function has_child($results, $id)
    {
        for ($i = 0; $i < sizeof($results); $i++) {
            if ($results[$i]->id_parent == $id) {
                return true;
            }
        }
        return false;
    }

    private function create_menu_horizontal($group, $type = false)
    {
        $id_account = $this->session->userdata('member_id');
        $alumni = Modules::run('database/find', 'tb_account', ['id' => $id_account])->row();
        if (empty($group)) {
            return '';
        }
        $array_query = [
            'from' => 'app_menu',
            'where' => ['id_menu' => $group, 'type' => 2, 'is_horizontal_menu' => 1],
            'order_by' => 'sort'
        ];
        $get_menu = Modules::run('database/get', $array_query)->result();
        $treeview_menu = '';
        foreach ($get_menu as $data_table) {
            $icon = $data_table->icon;
            if ($data_table->id_parent == 0) {
                $child_data         = $this->create_sub($get_menu, $data_table->id);
                $status_has_child   = $this->has_child($get_menu, $data_table->id);

                $toggle_property = '';
                $additional_span = '';
                $additional_class_parent = '';
                if (!empty($child_data)) {
                    $additional_class_parent = 'with-sub';
                    $toggle_property = 'data-toggle="slide"';
                    $additional_span = '';
                }
                if ($data_table->is_devider) {
                    //devider
                    $treeview_menu .= '
                        <li class="nav-header ' . $data_table->css_class . '">
                            <span class="nav-label">' . $data_table->name . '</span>
                            ' . $child_data . '
                        </li>
                    ';
                } else {
                    $url = Modules::run('helper/create_url', $data_table->link);
                    $method = $data_table->link;
                    $clear_method = substr($method, -1) == '/' ? substr($method, 0, strlen($method) - 1) : $method;
                    if (substr($clear_method, 0, 1) != '/') {
                        $clear_method = '/' . $clear_method;
                    }
                    $data_url = base_url(PREFIX_CREDENTIAL_DIRECTORY . $clear_method);

                    //device class
                    $treeview_menu .= '
                                    <li class="nav-item main-parent-menu slide ' . $data_table->css_class . '" data-id="' . $data_table->id . '">
                                        <a class="nav-link ' . $additional_class_parent . '"  href="' . $url . '" data-url="' . $data_url . '">
                                            <span class="shape1"></span>
                                            <span class="shape2"></span>
                                            ' . $icon . '
                                            <span class="sidemenu-label">' . $data_table->name . '</span>
                                            ' . $additional_span . '
                                        </a>
                                        ' . $child_data . '
                                    </li>
								';
                }
            }
        }
        if ($alumni->is_alumni == 1) {
            $treeview_menu .= '
                    <li class="nav-item main-parent-menu slide">
                        <a class="nav-link"  href="' . Modules::run('helper/create_url', '/for_alumni') . '" data-url="' . base_url(PREFIX_CREDENTIAL_DIRECTORY . substr('/for_alumni', -1) == '/' ? substr('/for_alumni', 0, strlen('/for_alumni') - 1) : '/for_alumni') . '">
                            <span class="shape1"></span>
                            <span class="shape2"></span>
                            ' . '<svg version="1.1" class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                            viewBox="0 0 60 60" style="enable-background:new 0 0 60 60;" xml:space="preserve">
                       <path d="M55.517,46.55l-9.773-4.233c-0.23-0.115-0.485-0.396-0.704-0.771l6.525-0.005c0.114,0.011,2.804,0.257,4.961-0.67
                           c0.817-0.352,1.425-1.047,1.669-1.907c0.246-0.868,0.09-1.787-0.426-2.523c-1.865-2.654-6.218-9.589-6.354-16.623
                           c-0.003-0.121-0.397-12.083-12.21-12.18c-1.739,0.014-3.347,0.309-4.81,0.853c-0.319-0.813-0.789-1.661-1.488-2.459
                           C30.854,3.688,27.521,2.5,23,2.5s-7.854,1.188-9.908,3.53c-2.368,2.701-2.148,5.976-2.092,6.525v5.319c-0.64,0.729-1,1.662-1,2.625
                           v4c0,1.217,0.553,2.352,1.497,3.109c0.916,3.627,2.833,6.36,3.503,7.237v3.309c0,0.968-0.528,1.856-1.377,2.32l-8.921,4.866
                           C1.801,46.924,0,49.958,0,53.262V57.5h44h2h14v-3.697C60,50.711,58.282,47.933,55.517,46.55z M44,55.5H2v-2.238
                           c0-2.571,1.402-4.934,3.659-6.164l8.921-4.866C16.073,41.417,17,39.854,17,38.155v-4.019l-0.233-0.278
                           c-0.024-0.029-2.475-2.994-3.41-7.065l-0.091-0.396l-0.341-0.22C12.346,25.803,12,25.176,12,24.5v-4c0-0.561,0.238-1.084,0.67-1.475
                           L13,18.728V12.5l-0.009-0.131c-0.003-0.027-0.343-2.799,1.605-5.021C16.253,5.458,19.081,4.5,23,4.5
                           c3.905,0,6.727,0.951,8.386,2.828c0.825,0.932,1.24,1.973,1.447,2.867c0.016,0.07,0.031,0.139,0.045,0.208
                           c0.014,0.071,0.029,0.142,0.04,0.21c0.013,0.078,0.024,0.152,0.035,0.226c0.008,0.053,0.016,0.107,0.022,0.158
                           c0.015,0.124,0.027,0.244,0.035,0.355c0.001,0.009,0.001,0.017,0.001,0.026c0.007,0.108,0.012,0.21,0.015,0.303
                           c0,0.018,0,0.033,0.001,0.051c0.002,0.083,0.002,0.162,0.001,0.231c0,0.01,0,0.02,0,0.03c-0.004,0.235-0.02,0.375-0.02,0.378
                           L33,18.728l0.33,0.298C33.762,19.416,34,19.939,34,20.5v4c0,0.873-0.572,1.637-1.422,1.899l-0.498,0.153l-0.16,0.495
                           c-0.669,2.081-1.622,4.003-2.834,5.713c-0.297,0.421-0.586,0.794-0.837,1.079L28,34.123v4.125c0,0.253,0.025,0.501,0.064,0.745
                           c0.008,0.052,0.022,0.102,0.032,0.154c0.039,0.201,0.091,0.398,0.155,0.59c0.015,0.045,0.031,0.088,0.048,0.133
                           c0.078,0.209,0.169,0.411,0.275,0.605c0.012,0.022,0.023,0.045,0.035,0.067c0.145,0.256,0.312,0.499,0.504,0.723l0.228,0.281h0.039
                           c0.343,0.338,0.737,0.632,1.185,0.856l9.553,4.776C42.513,48.374,44,50.78,44,53.457V55.5z M58,55.5H46v-2.043
                           c0-3.439-1.911-6.53-4.986-8.068l-6.858-3.43c0.169-0.386,0.191-0.828,0.043-1.254c-0.245-0.705-0.885-1.16-1.63-1.16h-2.217
                           c-0.046-0.081-0.076-0.17-0.113-0.256c-0.05-0.115-0.109-0.228-0.142-0.349C30.036,38.718,30,38.486,30,38.248v-3.381
                           c0.229-0.28,0.47-0.599,0.719-0.951c1.239-1.75,2.232-3.698,2.954-5.799C35.084,27.47,36,26.075,36,24.5v-4
                           c0-0.963-0.36-1.896-1-2.625v-5.319c0.026-0.25,0.082-1.069-0.084-2.139c1.288-0.506,2.731-0.767,4.29-0.78
                           c9.841,0.081,10.2,9.811,10.21,10.221c0.147,7.583,4.746,14.927,6.717,17.732c0.169,0.24,0.22,0.542,0.139,0.827
                           c-0.046,0.164-0.178,0.462-0.535,0.615c-1.68,0.723-3.959,0.518-4.076,0.513h-6.883c-0.643,0-1.229,0.327-1.568,0.874
                           c-0.338,0.545-0.37,1.211-0.086,1.783c0.313,0.631,0.866,1.474,1.775,1.927l9.747,4.222C56.715,49.396,58,51.482,58,53.803V55.5z"/>
                       
                       </svg>' . '
                            <span class="sidemenu-label">' . 'Menu Alumni' . '</span>
                        </a>
                    </li>
                ';
        }

        return $treeview_menu;
    }

    private function create_sub_horizontal($results, $parent_request)
    {
        $child_status = 0;
        $menu = '<ul class="ul_' . $parent_request . ' sub-menu" data-position="sub_menu">';
        for ($i = 0; $i < sizeof($results); $i++) {
            if ($results[$i]->id_parent == $parent_request) {
                $class_devider = '';
                if ($results[$i]->is_devider) {
                    $menu .= '
                        <li class="side-item side-item-category ' . $results[$i]->css_class . '">
                            ' .  $results[$i]->name . '
                        </li>
                    ';
                } else {
                    $child_status++;
                    $method = $results[$i]->link;
                    $clear_method = substr($method, -1) == '/' ? substr($method, 0, strlen($method) - 1) : $method;
                    if (substr($clear_method, 0, 1) != '/') {
                        $clear_method = '/' . $clear_method;
                    }
                    $data_url = base_url(PREFIX_CREDENTIAL_DIRECTORY . $clear_method);

                    if ($this->has_child($results, $results[$i]->id)) {
                        $sub_menu = $this->create_sub($results, $results[$i]->id);
                        $url = Modules::run('helper/create_url', $results[$i]->link);

                        $menu .= '
                            <li aria-haspopup="true" class=" ' . $results[$i]->css_class . '" data-id="' . $results[$i]->id . '">
                                <a class=""  href="' . $url . '" data-url="' . $data_url . '">
                                ' . $results[$i]->icon  . $results[$i]->name . '
                                    <i class="angle fe fe-chevron-down"></i>
                                </a>
                                ' . $sub_menu . '
                            </li>
                            ';
                    } else {
                        $url = Modules::run('helper/create_url', $results[$i]->link);
                        $menu .= '
                                <li aria-haspopup="true" class=" ' . $results[$i]->css_class . '" data-id="' . $results[$i]->id . '">
                                    <a class=""  href="' . $url . '" data-url="' . $data_url . '">
                                    ' . $results[$i]->icon  . $results[$i]->name . '
                                    </a>
                                </li>
                            ';
                    }
                }
            }
        }
        $menu .= '</ul>';
        $menu = $child_status == 0 ? '' : $menu;
        return $menu;
    }

    public function search_menu()
    {
        Modules::run('security/is_ajax');
        if (isset($_GET['term'])) {
            $term = $_GET['term'];
            $id_menu = $this->session->userdata('us_credential_menu');
            $get_data = $this->db->like('name', $term, 'both')->where(['id_menu' => $id_menu, 'is_devider' => 0])->order_by('name')->limit(10)->get('app_menu')->result();

            if (!empty($get_data)) {
                $array_result = [];
                foreach ($get_data as $data_menu) {
                    // if ($data_menu->link == '' || $data_menu->link == '#') {
                    //     continue;
                    // }
                    $link = Modules::run('helper/create_url', $data_menu->link);
                    $array_result[] = array(
                        'label' => $data_menu->name,
                        'link' => $link
                    );
                }
                echo json_encode($array_result);
            } else {
                echo json_encode([]);
            }
        }
    }

    //================================================== custom module function =========================================================
    public function count_transaction()
    {
        $count_data = Modules::run('database/find', 'tb_booking', ['is_confirm' => 0])->num_rows();
        echo json_encode(['status' => TRUE, 'count' => $count_data]);
    }

    public function load_data()
    {
        $load_notification = Modules::run('notification/load_data');
        $html_notification = '';
        $limit = 5;
        $counter = 0;
        foreach ($load_notification as $item_notification) {
            if ($counter >= $limit) {
                continue;
            }
            $counter++;
            $html_notification .= '
                <a class="d-flex p-3 border-bottom" href="' . Modules::run('helper/create_url', $item_notification->link) . '">
                    <div class="notifyimg">
                        <i class="la la-file-alt text-white bg-primary"></i>
                    </div>
                    <div class="ml-3">
                        <h5 class="notification-label mb-1">' . $item_notification->title . '</h5>
                        <div class="notification-subtext">' . $item_notification->description . '</div>
                    </div>
                    <div class="ml-auto">
                        <i class="las la-angle-right text-right text-muted"></i>
                    </div>
                </a>
            ';
        }
        echo json_encode(
            [
                'status' => TRUE,
                'html_notification' => $html_notification,
                'count_notification' => count($load_notification)
            ]
        );
    }

    public function mark_notification()
    {
        Modules::run('security/is_ajax');

        Modules::run('database/update', 'tb_notification', ['id_customer' => NULL, 'is_open' => NULL], ['is_open' => 'Y']);
        echo json_encode(['status' => TRUE]);
    }
}
