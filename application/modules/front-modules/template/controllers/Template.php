<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Template extends FrontendController
{
    var  $module = 'template';
    public function __construct()
    {
        parent::__construct();
        Modules::run('security/banned_url', $this->module);
    }

    public function main_layout($data)
    {
        $data['company_name'] = Modules::run('database/find', 'app_setting', ['field' => 'company_name'])->row()->value;
        $data['company_tagline'] = Modules::run('database/find', 'app_setting', ['field' => 'company_tagline'])->row()->value;
        $data['company_email'] = Modules::run('database/find', 'app_setting', ['field' => 'company_email'])->row()->value;
        $data['company_number_phone'] = Modules::run('database/find', 'app_setting', ['field' => 'company_number_phone'])->row()->value;
        $data['company_instagram'] = Modules::run('database/find', 'app_setting', ['field' => 'company_instagram'])->row()->value;
        $data['company_facebook'] = Modules::run('database/find', 'app_setting', ['field' => 'company_facebook'])->row()->value;
        $data['company_address'] = Modules::run('database/find', 'app_setting', ['field' => 'company_address'])->row()->value;

        $data['whatsapp_message'] = $this->config->item('whatsapp_message');
        $data['link_blog'] = $this->config->item('link_blog');

        $get_group_menu = Modules::run('database/find', 'app_menu', ['is_front_menu' => 1])->row();
        $menu = $this->create_menu($get_group_menu->id, 'sidebar');
        $data['html_main_menu'] = $menu;

        $this->load->view('main_layout_cms', $data);
    }

    public function main_layout_extern($data)
    {
        $data['company_name'] = Modules::run('database/find', 'app_setting', ['field' => 'company_name'])->row()->value;
        $data['company_tagline'] = Modules::run('database/find', 'app_setting', ['field' => 'company_tagline'])->row()->value;
        $data['company_email'] = Modules::run('database/find', 'app_setting', ['field' => 'company_email'])->row()->value;
        $data['company_number_phone'] = Modules::run('database/find', 'app_setting', ['field' => 'company_number_phone'])->row()->value;
        $data['company_instagram'] = Modules::run('database/find', 'app_setting', ['field' => 'company_instagram'])->row()->value;
        $data['company_facebook'] = Modules::run('database/find', 'app_setting', ['field' => 'company_facebook'])->row()->value;
        $data['company_address'] = Modules::run('database/find', 'app_setting', ['field' => 'company_address'])->row()->value;

        $data['whatsapp_message'] = $this->config->item('whatsapp_message');
        $data['link_blog'] = $this->config->item('link_blog');

        $get_group_menu = Modules::run('database/find', 'app_menu', ['is_front_menu' => 1])->row();
        $menu = $this->create_menu($get_group_menu->id, 'sidebar');
        $data['html_main_menu'] = $menu;

        $this->load->view('main_layout_extern', $data);
    }

    public function horizontal_layout($data)
    {
        $this->load->view('horizontal_layout', $data);
    }

    //media for login
    public function login_layout($data)
    {
        $this->load->view('login_layout', $data);
    }

    public function error_token($data)
    {
        $this->load->view('errors/view_error_token', $data);
    }
    public function view_404()
    {
        $this->load->view('errors/view_404');
    }
    public function forbidden_module($data)
    {
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
                $additional_class_link = '';
                if (!empty($child_data)) {
                    $additional_class_parent = 'dropdown';
                    $additional_class_link = 'dropdown-toggle';
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
                                    <li class="nav-item main-parent-menu ' . $additional_class_parent . ' slide ' . $data_table->css_class . '" data-id="' . $data_table->id . '">
                                        <a class="nav-link ' . $additional_class_link . '"  href="' . $url . '" data-url="' . $data_url . '">
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
        $menu = '<ul class="ul_' . $parent_request . ' dropdown-menu" data-position="sub_menu">';
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
                            <li class="' . $results[$i]->css_class . '" data-id="' . $results[$i]->id . '">
                                <a class="dropdown-item with-sub" data-toggle="slide" href="' . $url . '" data-url="' . $data_url . '">
                                    ' . $results[$i]->name . '
                                </a>
                                ' . $sub_menu . '
                            </li>
                            ';
                    } else {
                        $url = Modules::run('helper/create_url', $results[$i]->link);
                        $menu .= '
                        <li class=" ' . $results[$i]->css_class . '" data-id="' . $results[$i]->id . '">
                            <a class="dropdown-item href="' . $url . '" data-url="' . $data_url . '">
                                ' . $results[$i]->name . '
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
}
