<?php
$array_get_all_conf = [
    'select' => '
        app_module_setting.field
    ',
    'from' => 'app_module_setting',
    'where' => [
        'data_type' => 'json'
    ],
    'group_by' => 'field',
    'order_by' => 'field'
];
$get_data = Modules::run('database/get', $array_get_all_conf)->result();

foreach ($get_data as $item_data) {

    $html_tr_content = '';
    $counter = 0;

    $get_contents = Modules::run('database/find', 'app_module_setting', ['field' => $item_data->field, 'data_type' => 'json'])->result();

    foreach ($get_contents as $item_content) {
        $counter++;
        $html_tr_content .= '
            <tr>
                <td>' . $counter . '</td>
                <td style="width:30%;">' . $item_content->label . '</td>
                <td style="width:30%;">' . $item_content->params . '</td>
                <td>
                    <div>
                        <pre>
                            <code>
                            ' . $item_content->value . '
                            </code>
                        </pre>
                    </div>
                </td>
                <td style="width:200px;">
                    <a href="javascript:void(0)" data-id="' . $item_content->id . '" class="btn btn-warning-gradient btn-sm"><i class="fa fa-edit"></i> Edit</a>
                    <a href="javascript:void(0)" data-id="' . $item_content->id . '" class="btn btn-danger-gradient btn-sm"><i class="fa fa-trash"></i> hapus</a>
                </td>
            </tr>
        ';
    }



    echo '
        <div class="p-3 row shadow-2 mb-2">
            <div class="col-3 border-right text-center">
                <span for="" class="badge badge-light tx-18 badge-pill">' . $item_data->field . '</span>
                <div class="text-center mt-2">
                    <a href="javascript:void(0)" data-field="' . $item_data->field . '" class="btn btn-primary-gradient btn-rounded font-weight-bold"><i class="fa fa-plus-circle"></i> Tambah Data</a>
                    <small class="d-block text-muted">(* klik untuk tambah data)</small>
                </div>
            </div>
            <div class="col-9">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width:10px;">No</th>
                            <th>Label</th>
                            <th>Params</th>
                            <th>Value</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>' . $html_tr_content . '</tbody>
                </table>
            </div>
        </div>
    ';
}
