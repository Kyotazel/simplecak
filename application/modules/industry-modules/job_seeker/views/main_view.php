<div class="container">
    <div class="row row-sm">
        <div class="col-sm-12 col-md-3 text-center">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>Filter Pekerja</h4>
                    <button class="btn-primary btn-rounded mb-3 btn_filter">
                        <i class="mdi mdi-account-search mr-1"></i>
                        Cari
                    </button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="skill">Keahlian</label>
                                <select name="skill[]" id="skill" class="form-control" multiple="multiple">
                                    <option value="">Keahlian pekerja</option>
                                    <?php foreach ($skill as $value) : ?>
                                        <option value="<?= $value->id ?>"><?= $value->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="certificate">Bersertifikat</label>
                                <select name="certificate" id="certificate" class="form-control">
                                    <option value="">Sertifikat pekerja</option>
                                    <?php foreach ($certificate as $value) : ?>
                                        <option value="<?= $value->id ?>"><?= $value->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select name="gender[]" id="gender" class="form-control" multiple="multiple">
                                <option value="">Gender pekerja</option>
                                <?php foreach ($gender as $value) : ?>
                                    <option value="<?= $value->id ?>"><?= $value->name ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="education">Pendidikan</label>
                            <select name="education[]" id="education" class="form-control" multiple="multiple">
                                <option value="">Pendidikan pekerja</option>
                                <?php foreach ($gender as $value) : ?>
                                    <option value="<?= $value->id ?>"><?= $value->name ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <label for="min_age">Range usia pekerja</label>
                            <div class="col-6">
                                <div class="form-group">
                                    <input type="number" name="min_age" id="min_age" class="form-control" min="18">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                        <input type="number" name="max_age" id="max_age" class="form-control" min="18">
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-9">
            <input type="text" name="search_job" id="search_job" class="form-control bd bd-primary rounded-5" placeholder="Cari Lowongan">
            <button class="btn">
                <i class="fe fe-search pos-absolute r-20 t-10 text-primary"></i>
            </button>
            <div class="table-responsive border-top userlist-table">
                    <table class="table card-table table-striped table-vcenter text-nowrap mb-0" id="table_module">
                        <thead>
                            <tr>
                                <th class="wd-lg-3p"><span>No</span></th>
                                <th class="wd-lg-35p"><span>Nama</span></th>
                                <th class="wd-lg-20p"><span>Email & Telp</span></th>
                                <th class="wd-lg-20p"><span>Credential</span></th>
                                <th class="wd-lg-10p"><span>status</span></th>
                                <th>is create</th>
                                <th>is update</th>
                                <th>is delete</th>
                                <th class="wd-lg-10p">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
    <div class="row row-sm">
        <div class="col-sm-12 col-md-3"></div>
        <div class="col-sm-12 col-md-9"></div>
    </div>
</div>