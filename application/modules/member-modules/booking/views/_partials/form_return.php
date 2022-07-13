<div class="row">
    <div class="col-4">
        <label for="" class="text-uppercase font-weight-bold">Kontainer :</label>
        <div class="row">
            <div class="col-12 p-2 border-dashed text-center ">
                <small class="text-muted"><i class="fa fa-calendar"></i> Tanggal Bongkar :</small>
                <span class="font-weight-bold text-primary"><?= Modules::run('helper/date_indo', $data_countainer->release_date, '-'); ?></span>
            </div>
            <div class="text-center col-12 border-dashed">
                <img style="width:100px;" src="<?= base_url('upload/barcode/' . $data_countainer->countainer_barcode); ?>" alt="">
                <small class="d-block font-weight-bold tx-16"><?= $data_countainer->countainer_code; ?></small>
                <small class="text-mdi-tab-unselected"><i class="fa fa-info-circle"></i> ID kontainer</small>
            </div>
            <div class="col-6 p-2 border-dashed"></div>
            <div class="col-6 p-2 border-dashed"></div>
        </div>
    </div>
    <div class="col-8">
        <form class="form-return">
            <label for="" class="text-uppercase font-weight-bold">Kondisi pengembalian :</label>
            <div class="form-group row mb-1">
                <div class="col-3">
                    <label for="">Kondisi Kontainer</label>
                </div>
                <div class="col-9">
                    <div class="main-toggle-group-demo">
                        <div data-id="<?= $data_countainer->id_countainer; ?>" class="main-toggle main-toggle-dark change_status_condition on" data-code="av"><span>AV</span></div>
                        <div data-id="<?= $data_countainer->id_countainer; ?>" class="main-toggle main-toggle-dark change_status_condition on" data-code="rp"><span>RP</span></div>
                        <div data-id="<?= $data_countainer->id_countainer; ?>" class="main-toggle main-toggle-dark change_status_condition on" data-code="dl"><span>DL</span></div>
                    </div>
                </div>
            </div>
            <div class="form-group row mb-1">
                <div class="col-3">
                    <label for="">Depo Pengembalian</label>
                </div>
                <div class="col-9">
                    <select name="depo" class="form-control" id="">
                        <?php
                        foreach ($data_depo as $item_depo) {
                            $selected = $item_depo->id  == $data_countainer->id_depo_to ? 'selected' : '';
                            echo '
                                <option ' . $selected . ' value="' . $item_depo->id . '">' . $item_depo->name . '</option>
                            ';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <hr>
            <label for="" class="text-uppercase font-weight-bold d-flex">
                tambahkan ke antrian maintenance :
                <div class="main-toggle main-toggle-dark change_status_maintenance ml-3"><span></span></div>
            </label>
            <div class="html_form_maintenance" style="display: none;">
                <div class="form-group">
                    <label for="">Jenis Maintenance</label>
                    <select name="maintenance" class="form-control chosen" id="">
                        <?php
                        foreach ($data_maintenance_category as $item_maintenance) {
                            echo '
                                    <option value="' . $item_maintenance->id . '">' . $item_maintenance->name . '</option>
                                ';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Keterangan maintenance :</label>
                    <textarea name="description" class="form-control" rows="5"></textarea>
                </div>
            </div>
            <div class="form-group text-right">
                <small>(*klik untuk simpan)</small>
                <button class="btn btn-warning-gradient btn_save_return" data-countainer="<?= $data_countainer->id_countainer; ?>" data-bscountainer="<?= $data_countainer->id; ?>" type="submit">Simpan Data <i class="fa fa-paper-plane"></i></button>
            </div>
        </form>
    </div>
</div>