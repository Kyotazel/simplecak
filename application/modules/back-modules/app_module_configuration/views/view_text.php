<?php
$array_get_all_conf = [
    'select' => '
        app_module_setting.field,
        app_module_setting.data_type
    ',
    'from' => 'app_module_setting',
    'where' => [
        'data_type' => 'text'
    ],
    'group_by' => 'field',
    'order_by' => 'field'
];
$get_data = Modules::run('database/get', $array_get_all_conf)->result();

foreach ($get_data as $item_data) {

    $html_tr_content = '';
    $counter = 0;

    $get_contents = Modules::run('database/find', 'app_module_setting', ['field' => $item_data->field, 'data_type' => 'text'])->result();

    foreach ($get_contents as $item_content) {
        $counter++;
        $html_tr_content .= '
            <tr>
                <td>' . $counter . '</td>
                <td style="width:30%;"><input type="text" class="form-control label_' . $item_content->id . '" value="' . $item_content->label . '"> </td>
                <td style="width:30%;"><input type="text" class="form-control param_' . $item_content->id . '" value="' . $item_content->params . '"></td>
                <td><input type="text" class="form-control value_' . $item_content->id . '" value="' . $item_content->value . '"></td>
                <td style="width:200px;">
                    <a href="javascript:void(0)" data-id="' . $item_content->id . '" class="btn btn-warning-gradient btn-sm btn_update_content"><i class="fa fa-edit"></i> Update</a>
                    <a href="javascript:void(0)" data-id="' . $item_content->id . '" class="btn btn-danger-gradient btn-sm btn_delete_content"><i class="fa fa-trash"></i> hapus</a>
                </td>
            </tr>
        ';
    }

    echo '
        <div class="p-3 row shadow-2 mb-2">
            <div class="col-3 border-right text-center">
                <span for="" class="badge badge-light tx-18 badge-pill">' . $item_data->field . '</span>
                <div class="text-center mt-2">
                    <a href="javascript:void(0)" data-type="' . $item_data->data_type . '" data-field="' . $item_data->field . '" class="btn btn-primary-gradient btn-rounded font-weight-bold btn_add_content"><i class="fa fa-plus-circle"></i> Tambah Data</a>
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
?>


<div class="modal fade" tabindex="-1" id="modal_form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Input Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </div>
            <div class="modal-body">
                <form id="form-data">
                    <input type="hidden" name="id" id="id" />
                    <div class="form-group">
                        <label>Label</label>
                        <input type="text" class="form-control" name="label" />
                        <span class="help-block notif_name text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label>Params</label>
                        <input type="text" class="form-control" name="params" />
                        <span class="help-block notif_name text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label>Value</label>
                        <input type="text" class="form-control" name="value" />
                        <span class="help-block notif_name text-danger"></span>
                    </div>
                    <div class="form-group text-right">
                        <button class="btn btn-primary-gradient btn-rounded btn_save_content" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>