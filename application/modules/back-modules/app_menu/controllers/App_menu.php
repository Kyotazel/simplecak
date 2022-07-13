<?php
defined('BASEPATH') or exit('No direct script access allowed');

class App_menu extends BackendController
{
    var $module_name = 'app_menu';
    var $module_directory = 'app_menu';
    var $module_js = ['app_menu'];
    var $app_data = [];

    public function __construct()
    {
        parent::__construct();
        Modules::run('security/common_security');
        $this->_init();
    }

    private function _init()
    {
        $this->app_data['module_js']  = $this->module_js;
        $this->app_data['module_name']  = $this->module_name;
        $this->app_data['module_directory']  = $this->module_directory;
    }

    public function index()
    {
        $type = $this->input->get('type');
        $group = $this->input->get('group');
        $status_menu = 1;
        if ($type == 2) {
            $status_menu = 2;
        }

        $this->app_data['data_list_menu'] = Modules::run('database/find', 'app_menu', ['type' => 1, 'status' => $status_menu])->result();
        $this->app_data['page_title']     = "app menu";
        $this->app_data['view_file']     = 'main_view';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    private function validate_save_group()
    {
        Modules::run('security/is_ajax');
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        // this validate if there is same file to be uploaded
        $id = $this->input->post('id');
        if ($this->input->post('name') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'name';
            $data['status'] = FALSE;
        }
        if ($this->input->post('description') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'description';
            $data['status'] = FALSE;
        }
        if ($data['status'] == FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    public function save_group()
    {
        $this->validate_save_group();
        $name = $this->input->post('name');
        $status = $this->input->post('status');
        $description = $this->input->post('description');
        // $name = $this->input->post('name');

        $array_insert =  [
            'name' => $name,
            'description' => $description,
            'type' => 1,
            'status' => $status
        ];
        Modules::run('database/insert', 'app_menu', $array_insert);
        echo json_encode(array('status' => TRUE));
    }

    public function update_group()
    {
        $this->validate_save_group();
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $description = $this->input->post('description');

        $array_update =  [
            'name' => $name,
            'description' => $description
        ];
        Modules::run('database/update', 'app_menu', ['id' => $id], $array_update);

        echo json_encode(array('status' => TRUE));
    }

    public function duplicate_group()
    {
        Modules::run('security/is_ajax');
        $id = $this->input->post('id');
        $get_group = Modules::run('database/find', 'app_menu', ['id' => $id])->row_array();
        $get_group_menu = Modules::run('database/find', 'app_menu', ['id_menu' => $id])->result_array();

        unset($get_group['id']);
        $get_group['name'] = $get_group['name'] . ' - copy';
        Modules::run('database/insert', 'app_menu', $get_group);

        //get max id 
        $get_max_id = Modules::run('database/get', ['select' => 'MAX(id) AS max_id', 'from' => 'app_menu', 'where' => ['type' => 1]])->row();
        foreach ($get_group_menu as $item_menu) {
            unset($item_menu['id']);
            $item_menu['id_menu'] = $get_max_id->max_id;
            Modules::run('database/insert', 'app_menu', $item_menu);
        }
        echo json_encode(array('status' => TRUE));
    }

    public function delete_group()
    {
        Modules::run('security/is_ajax');
        $id = $this->input->post('id');
        Modules::run('database/delete', 'app_menu', ['id' => $id]);
        Modules::run('database/delete', 'app_menu', ['id_menu' => $id]);
        echo json_encode(array('status' => TRUE));
    }
    private function validate_save_main_menu()
    {
        Modules::run('security/is_ajax');
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        // this validate if there is same file to be uploaded
        $id = $this->input->post('id');
        if ($this->input->post('name') == '') {
            $data['error_string'][] = 'Harus Diisi';
            $data['inputerror'][] = 'name';
            $data['status'] = FALSE;
        }
        if (!$this->input->post('devider_status')) {
            if ($this->input->post('link') == '') {
                $data['error_string'][] = 'Harus Diisi';
                $data['inputerror'][] = 'link';
                $data['status'] = FALSE;
            }
        }
        if ($data['status'] == FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    private function get_sort_number($id_menu, $id_parent)
    {
        $array_get = [
            'select' => 'max(sort) AS max_sort',
            'from' => 'app_menu',
            'where' => [
                'id_parent' => $id_parent,
                'id_menu' => $id_menu
            ]
        ];
        $get_data = Modules::run('database/get', $array_get)->row();

        $result = empty($get_data->max_sort) ? 1 : $get_data->max_sort + 1;
        return $result;
    }

    public function save_main_menu()
    {
        $this->validate_save_main_menu();

        $id_parent = $this->input->post('id_parent');
        $id_group = $this->input->post('group');
        $name   = $this->input->post('name');
        $link   = $_POST['link'];
        $css   = $this->input->post('css');
        $icon   = $_POST['icon'];
        $devider_status   = $this->input->post('devider_status');
        $sort = $this->get_sort_number($id_group, $id_parent);

        $array_insert = [
            'id_parent' => $id_parent,
            'id_menu' => $id_group,
            'name' => $name,
            'link' => $link,
            'css_class' => $css,
            'is_devider' => $devider_status,
            'icon' => $icon,
            'type' => 2,
            'sort' => $sort
        ];
        Modules::run('database/insert', 'app_menu', $array_insert);
        echo json_encode(['status' => true]);
    }

    public function update_main_menu()
    {
        $this->validate_save_main_menu();
        $id = $this->input->post('id');
        $id_group = $this->input->post('group');
        $name   = $this->input->post('name');
        $link   = $_POST['link'];
        $css   = $this->input->post('css');
        $icon   = $_POST['icon'];
        $devider_status   = $this->input->post('devider_status');

        $array_update = [
            'name' => $name,
            'link' => $link,
            'css_class' => $css,
            'is_devider' => $devider_status,
            'icon' => $icon
        ];
        Modules::run('database/update', 'app_menu', ['id' => $id], $array_update);
        echo json_encode(['status' => true]);
    }

    public function show_menu()
    {
        $group = $this->input->post('group');
        $array_query = [
            'from' => 'app_menu',
            'where' => ['id_menu' => $group],
            'order_by' => 'sort'
        ];
        $get_menu = Modules::run('database/get', $array_query)->result();
        $treeview_folder = '';
        foreach ($get_menu as $data_table) {
            if ($data_table->id_parent == 0) {
                $child_data = $this->create_sub($get_menu, $data_table->id);
                $class_devider = '';
                if ($data_table->is_devider) {
                    $class_devider = '
                        text-muted
                    ';
                }

                $active_sidebar = $data_table->is_sidebar_menu ? 'on' : '';
                $active_horizontal = $data_table->is_horizontal_menu ? 'on' : '';

                //device class
                $treeview_folder .= '
                                    <li class="main-menu usd_item_drag" data-id="' . $data_table->id . '">
                                        <div class="menu-container row ">
                                            <div for="" class="col-md-3 slide mb-0" >
                                                <a href="' . Modules::run('helper/create_url', $data_table->link) . '" class="side-menu__item text-capitalize ' . $class_devider . '">' . $data_table->icon  . '&nbsp;' . $data_table->name . '</a>
                                            </div>
                                            <div class="col-md-3">
                                                <small class=""> <i class="fa fa-link"></i> Link :</small>
                                                <p for="" class="">' . $data_table->link . '</p>
                                            </div>
                                            <div class="col-md-3 d-flex">
                                                <div class="" style="width:50%;">
                                                    <small>Sidebar Menu :</small>
                                                    <div data-menu="sidebar" data-id="' . $data_table->id . '" class="main-toggle main-toggle-dark change_status ' . $active_sidebar . '"><span></span></div>
                                                </div>
                                                <div class="" style="width:50%;">
                                                    <small>Horizontal Menu</small>
                                                    <div data-menu="horizontal" data-id="' . $data_table->id . '" class="main-toggle main-toggle-dark change_status ' . $active_horizontal . '"><span></span></div>
                                                </div>
                                            </div>
                                            <nav class="contact-info col-md-3 text-right">
                                                <a href="javascript:void(0)" class="contact-icon border tx-inverse btn_add_sub" data-toggle="tooltip" data-id="' . $data_table->id . '"><i class="fe fe-plus"></i></a>
                                                <a href="javascript:void(0)" class="contact-icon border tx-inverse btn_edit_menu" data-toggle="tooltip" data-id="' . $data_table->id . '"><i class="fe fe-edit"></i></a>
                                                <a href="javascript:void(0)" class="contact-icon border tx-inverse btn_delete_menu" data-toggle="tooltip" data-id="' . $data_table->id . '"><i class="fe fe-trash"></i></a>
                                            </nav>
                                        </div>
                                        ' . $child_data . '
                                    </li>
								';
            }
        }
        $data['treeview'] = $treeview_folder;
        $html_respon = $this->load->view('view_list_menu', $data, TRUE);

        $array_respon = ['status' => TRUE, 'html_respon' => $html_respon];
        echo json_encode($array_respon);
    }

    // dunction treeview
    private function create_sub($results, $parent_request)
    {
        $menu = '<ul class="ul_' . $parent_request . ' usd_list" data-position="sub_menu">';
        for ($i = 0; $i < sizeof($results); $i++) {
            if ($results[$i]->id_parent == $parent_request) {
                $class_devider = '';
                if ($results[$i]->is_devider) {
                    $class_devider = '
                        text-muted
                    ';
                }

                $active_sidebar = $results[$i]->is_sidebar_menu ? 'on' : '';
                $active_horizontal = $results[$i]->is_horizontal_menu ? 'on' : '';

                if ($this->has_child($results, $results[$i]->id)) {
                    $sub_menu = $this->create_sub($results, $results[$i]->id);
                    $menu .= '
                            <li class="main-menu usd_item_drag" data-id="' . $results[$i]->id . '">
                                <div class="menu-container row  ">
                                    <div for="" class="col-md-3 slide mb-0" >
                                        <a href="' . Modules::run('helper/create_url', $results[$i]->link) . '" class="side-menu__item text-capitalize  ' . $class_devider . '">' . $results[$i]->icon . ' ' . $results[$i]->name . '</a>
                                    </div>
                                    <div class="col-md-3">
                                        <small class="d-block"><i class="fa fa-link"></i> Link :</small>
                                        <p class="d-block">' . $results[$i]->link . '</p>
                                    </div>
                                    <div class="col-md-3 d-flex">
                                        <div class="" style="width:50%;">
                                            <small>Sidebar Menu :</small>
                                            <div data-menu="sidebar" data-id="' . $results[$i]->id . '" class="main-toggle main-toggle-dark change_status ' . $active_sidebar . '"><span></span></div>
                                        </div>
                                        <div class="" style="width:50%;">
                                            <small>Horizontal Menu</small>
                                            <div data-menu="horizontal" data-id="' . $results[$i]->id . '" class="main-toggle main-toggle-dark change_status ' . $active_horizontal . '"><span></span></div>
                                        </div>
                                    </div>
                                    <nav class="contact-info col-md-3 text-right">
                                        <a href="javascript:void(0)" class="contact-icon border tx-inverse btn_add_sub" data-toggle="tooltip" data-id="' . $results[$i]->id . '"><i class="fe fe-plus"></i></a>
                                        <a href="javascript:void(0)" class="contact-icon border tx-inverse btn_edit_menu" data-toggle="tooltip" data-id="' . $results[$i]->id . '"><i class="fe fe-edit"></i></a>
                                        <a href="javascript:void(0)" class="contact-icon border tx-inverse btn_delete_menu" data-toggle="tooltip" data-id="' . $results[$i]->id . '"><i class="fe fe-trash"></i></a>
                                    </nav>
                                </div>
                                ' . $sub_menu . '
                            </li>
                            ';
                } else {
                    $menu .= '
                            <li class="main-menu usd_item_drag" data-id="' . $results[$i]->id . '">
                                <div class="menu-container row ' . $class_devider . '">
                                    <div for="" class="col-md-3 slide mb-0" >
                                        <a href="' . $results[$i]->link . '" class="side-menu__item text-capitalize  ' . $class_devider . '">' . $results[$i]->icon  . ' ' . $results[$i]->name . '</a>
                                    </div>
                                    <div class="col-md-3">
                                        <small class="d-block"><i class="fa fa-link"></i> Link :</small>
                                        <p class="d-block">' . $results[$i]->link . '</p>
                                    </div>
                                    <div class="col-md-3 d-flex">
                                        <div class="" style="width:50%;">
                                            <small>Sidebar Menu :</small>
                                            <div data-menu="sidebar" data-id="' . $results[$i]->id . '" class="main-toggle main-toggle-dark change_status ' . $active_sidebar . '"><span></span></div>
                                        </div>
                                        <div class="" style="width:50%;">
                                            <small>Horizontal Menu</small>
                                            <div data-menu="horizontal" data-id="' . $results[$i]->id . '" class="main-toggle main-toggle-dark change_status ' . $active_horizontal . '"><span></span></div>
                                        </div>
                                    </div>
                                    <nav class="contact-info col-md-3 text-right">
                                        <a href="javascript:void(0)" class="contact-icon border tx-inverse btn_add_sub" data-toggle="tooltip" data-id="' . $results[$i]->id . '"><i class="fe fe-plus"></i></a>
                                        <a href="javascript:void(0)" class="contact-icon border tx-inverse btn_edit_menu" data-toggle="tooltip" data-id="' . $results[$i]->id . '"><i class="fe fe-edit"></i></a>
                                        <a href="javascript:void(0)" class="contact-icon border tx-inverse btn_delete_menu" data-toggle="tooltip" data-id="' . $results[$i]->id . '"><i class="fe fe-trash"></i></a>
                                    </nav>
                                </div>
                            </li>
                            ';
                }
            }
        }
        $menu .= '</ul>';
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

    public function get_menu()
    {
        Modules::run('security/is_ajax');
        $id = $this->input->post('id');
        $get_data = Modules::run('database/find', 'app_menu', ['id' => $id])->row();

        $array_respon = [
            'name' => $get_data->name,
            'link' => $get_data->link,
            'css' => $get_data->css_class,
            'is_devider' => $get_data->is_devider,
            'icon' => $get_data->icon,
            'description' => $get_data->description,
            'status' => TRUE
        ];
        echo json_encode($array_respon);
    }

    public function delete_menu()
    {
        Modules::run('security/is_ajax');
        $id = $this->input->post('id');

        Modules::run('database/delete', 'app_menu', ['id' => $id]);
        Modules::run('database/update', 'app_menu', ['id_parent' => $id], ['id_parent' => 0]);
        $array_respon = ['status' => TRUE];
        echo json_encode($array_respon);
    }

    public function update_sort()
    {
        $list_id = $this->input->post('list_id');
        $id_parent = $this->input->post('id_parent');

        $sort = 0;
        foreach ($list_id as $id) {
            $sort++;
            $array_update = [
                'sort' => $sort,
                'id_parent' => $id_parent
            ];
            Modules::run('database/update', 'app_menu', ['id' => $id], $array_update);
        }
        $array_respon = ['status' => TRUE];
        echo json_encode($array_respon);
    }

    public function update_status_menu()
    {
        Modules::run('security/is_ajax');
        $id_menu    = $this->input->post('id_menu');
        $menu       = $this->input->post('menu');
        $status     = $this->input->post('status');

        if ($menu == 'sidebar') {
            $field = 'is_sidebar_menu';
        } else {
            $field = 'is_horizontal_menu';
        }

        $array_update = [$field => $status];
        Modules::run('database/update', 'app_menu', ['id' => $id_menu], $array_update);
        echo json_encode(['status' => TRUE]);
    }

    public function update_status_group_front_menu()
    {
        Modules::run('security/is_ajax');
        $id_menu = $this->input->post('id_menu');
        $type = $this->input->post('type');
        $status = $this->input->post('status');

        if ($type == 1) {
            //front menu
            Modules::run('database/update', 'app_menu', ['type' => 1, 'status' => 2, 'is_front_menu' => 1], ['is_front_menu' => 0]);
            Modules::run('database/update', 'app_menu', ['id' => $id_menu], ['is_front_menu' => 1]);
        } else {
            Modules::run('database/update', 'app_menu', ['type' => 1, 'status' => 2, 'is_member_menu' => 1], ['is_member_menu' => 0]);
            Modules::run('database/update', 'app_menu', ['id' => $id_menu], ['is_member_menu' => 1]);
        }
        echo json_encode(['status' => TRUE]);
    }
}
