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
        $id_credential_menu = $this->session->userdata('member_credential_menu');
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
        $data['login_background']   = Modules::run('database/find', 'app_setting', ['field' => 'member_login_background'])->row()->value;
        $data['login_image']        = Modules::run('database/find', 'app_setting', ['field' => 'member_login_image'])->row()->value;

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
    public function forbidden_module($data)
    {
        $this->_init();
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

            if ($data_table->id_parent == 0) {
                $child_data         = $this->create_sub($get_menu, $data_table->id);
                $status_has_child   = $this->has_child($get_menu, $data_table->id);

                $toggle_property = '';
                $additional_span = '';
                if (!empty($child_data)) {
                    $toggle_property = 'data-toggle="slide"';
                    $additional_span = '<i class="angle fe fe-chevron-down"></i>';
                }
                if ($data_table->is_devider) {
                    //devider
                    $treeview_menu .= '
                        <li class="side-item side-item-category ' . $data_table->css_class . '">
                            ' . $data_table->name . '
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
                                    <li class="li-item-menu main-parent-menu slide ' . $data_table->css_class . '" data-id="' . $data_table->id . '">
                                        <a class="side-menu__item" ' . $toggle_property . ' href="' . $url . '" data-url="' . $data_url . '">
                                        ' . $data_table->icon  . '
                                            <span class="side-menu__label">' . $data_table->name . '</span>
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
        $menu = '<ul class="ul_' . $parent_request . ' slide-menu" data-position="sub_menu">';
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
                            <li class="li-item-menu slide ' . $results[$i]->css_class . '" data-id="' . $results[$i]->id . '">
                                <a class="side-menu__item" data-toggle="slide" href="' . $url . '" data-url="' . $data_url . '">
                                ' . $results[$i]->icon  . '
                                    <span class="side-menu__label">' . $results[$i]->name . '</span>
                                    <i class="angle fe fe-chevron-down"></i>
                                </a>
                                ' . $sub_menu . '
                            </li>
                            ';
                    } else {
                        $url = Modules::run('helper/create_url', $results[$i]->link);
                        $menu .= '
                        <li class="li-item-menu ' . $results[$i]->css_class . '" data-id="' . $results[$i]->id . '">
                            <a class="slide-item" href="' . $url . '" data-url="' . $data_url . '">
                            ' . $results[$i]->icon  . '
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

            if ($data_table->id_parent == 0) {
                $child_data         = $this->create_sub_horizontal($get_menu, $data_table->id);
                $status_has_child   = $this->has_child($get_menu, $data_table->id);

                $toggle_property = '';
                $additional_span = '';
                $sub_icon = '';
                if (!empty($child_data)) {
                    $toggle_property = 'data-toggle="slide"';
                    $additional_span = '<i class="angle fe fe-chevron-down"></i>';
                    $sub_icon = 'sub-icon';
                }
                if ($data_table->is_devider) {
                    //devider
                    $treeview_menu .= '
                        <li aria-haspopup="true" class="' . $data_table->css_class . '">
                            ' . $data_table->name . '
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
                                    <li aria-haspopup="true" class=" ' . $data_table->css_class . '" data-id="' . $data_table->id . '">
                                        <a class="' . $sub_icon . '" ' . $toggle_property . ' href="' . $url . '" data-url="' . $data_url . '">
                                        ' . $data_table->icon . $data_table->name  . $additional_span . '
                                        </a>
                                        ' . $child_data . '
                                    </li>
								';
                }
            }
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
            $id_menu = $this->session->userdata('member_credential_menu');
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
        $id = $this->session->userdata('member_id');

        Modules::run('database/update', 'tb_notification', ['id_customer' => $id, 'is_open' => NULL], ['is_open' => 'Y']);
        echo json_encode(['status' => TRUE]);
    }
}
