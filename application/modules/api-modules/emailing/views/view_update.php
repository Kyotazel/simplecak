<form id="form-data">
    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <h5>Template Email : <b class="bg-primary text-white rounded-50 p-2"><?= $data_detail->name; ?></b></h5>
                    </div>
                    <div class="form-group">
                        <textarea id="content" class="form-control ckeditor_form" cols="30" rows="10"><?= $data_detail->template; ?></textarea>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <h5>Parameter Email :</h5>
                    </div>
                    <div class="form-group border-dashed p-2">
                        <table class="table">
                            <tr>
                                <td style="width: 100px;"><b>{username}</b></td>
                                <td style="width: 10px;">:</td>
                                <td>
                                    <p class="m-0 p-0 tx-12">
                                        Parameter untuk nama customer.
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td><b>{content}</b></td>
                                <td>:</td>
                                <td>
                                    <p class="m-0 p-0 tx-12">
                                        Parameter untuk nama konten email.
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="form-group text-right">
                        <a href="<?= Modules::run('helper/create_url', 'emailing'); ?>" class="btn btn-rounded btn-light font-weight-bold">Kembali</a>
                        <button class="btn btn-rounded btn-warning-gradient font-weight-bold btn_update_email" data-id="<?= $data_detail->id; ?>">Simpan Data <i class="fa fa-paper-plane"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>