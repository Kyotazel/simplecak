<?php
// print_r($module_type);
// print_r($data_module);

foreach ($data_module as $item_module) {

    $module_name = isset($module_type[$item_module->type]) ? $module_type[$item_module->type] : '';

    $array_module = explode(',', $item_module->list_module);
    $html_tr = '';
    $counter = 0;
    $active_all = true;
    foreach ($array_module as $current_item_module) {
        $counter++;
        $module_row = explode('-', $current_item_module);

        $html_access = '';
        if ($module_row[3]) { // if module active
            $active_on = in_array($module_row[0], $array_access) ? 'on' : '';
            if ($active_on == '') {
                $active_all = false;
            }
            $html_access = '
                <div data-type="' . $item_module->type . '" data-id="' . $module_row[0] . '" class="main-toggle main-toggle-dark change_status_module ' . $active_on . '"><span></span></div>
            ';
        } else {
            $html_access = '
                    <span class="badge badge-danger" style="font-size:14px;">Non aktif</span>
            ';
        }

        $html_tr .= '
                <tr>
                    <td>' . $counter . '</td>
                    <td class="text-capitalize text-bold">' . $module_row[1] . '</td>
                    <td class="text-capitalize"><i class="fa fa-folder"></i> ' . $module_row[2] . '</td>
                    <td>' . $html_access . '</td> 
                </tr>
        ';
    }
    $html_table = '
        <table class="table card-table table-striped table-vcenter text-nowrap">
            <thead>
                <tr>
                    <th style="width:80px">No</th>
                    <th>Nama Module</th>
                    <th style="width:250px;">Folder</th>
                    <th style="width:100px;">Hak akses</th>
                </tr>
            </thead>
            <tbody>' . $html_tr . '</tbody>
        </table>
    ';

    $on = $active_all ? 'on' : '';

    echo '
        <div class="col-12 mb-5">
            <div class="row">
                <div class="col-md-8">
                    <span class="badge badge-dark text-uppercase mb-3" style="font-size:16px;color:#fff;"><i class="fa fa-tv"></i> ' . $module_name . '</span>
                </div>
                <div class="col-md-4" style="padding-right:30px;">
                    <div  data-type="' . $item_module->type . '"  class="main-toggle main-toggle-dark change_all float-right ' . $on . '"><span></span></div>
                </div>
            </div>

            ' . $html_table . '
        </div>
    ';
}
