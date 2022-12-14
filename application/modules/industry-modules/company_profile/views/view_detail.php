<form method="POST" class="form_input" enctype="multipart/form-data">
<div class="container">
    <div class="row row-sm">
        <div class="col-sm-12 text-right m-0 mb-2">
            <a class="btn btn-outline-danger btn-rounded" href="<?= base_url('industry-area/company_profile') ?>"><i class="si si-close mr-2"></i>Batal</a>
            <button type="submit" class="btn btn-outline-success btn-rounded btn_update" data-method="update"><i class="fa fa-save mr-2"></i>Simpan</button>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <div class="row row-sm">
                <div class="col-12">
                    <h3 class="">
                        <i class="fa fa-industry"></i>
                        Intro Perusahaan</h3>
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="row row-sm">
                <div class="col-sm-12 col-md-3">
                    <label for="logo">Logo Perusahaan</label>
                    <div class="preview-logo ht-150" style="background: center / contain no-repeat url(<?= base_url('upload/company/') . $company_profile->image ?>) ;">
                        <!-- <img src="<?= base_url('upload/company/') . $company_profile->image ?>" alt="img profile" class="img-thumbnail"> -->
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="file" name="company_logo" accept="image/*" id="logo">
                    </div>
                </div>
                <div class="col-sm-12 col-md-9">
                    <label for="cover">Background Cover</label>
                    <div class="preview-cover ht-150" style="background: center / contain no-repeat url(<?= base_url('upload/cover/') . $company_profile->cover ?>) ;">
                        <!-- <img src="<?= base_url('upload/cover/') . $company_profile->cover ?>" class="img-thumbnail" alt="image cover"> -->
                    </div>
                    <div class="form-group">
                        <input type="file" class="form-control" accept="image/*" name="company_cover" id="cover">
                    </div>
                </div>
            </div>
            <div class="row row-sm">
                <div class="col-sm-12 col-md-9">
                    <div class="form-group">
                        <label for="company_name">Nama Perusahaan</label>
                        <input type="text" id="company_name" name="company_name" class="form-control" placeholder="Perusahaan..." value="<?= isset($company_profile->name) ? $company_profile->name : '' ?>">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <label for="sector">Sektor Industri</label>
                        <select name="sector" id="sector" class="form-control">
                            <option value="">Pilih Sector Industri</option>
                            <?php foreach ($sector as $value) : ?>
                                <option value="<?= $value->id ?>" <?= $selected = ($value->id == $company_profile->sector) ? 'selected' : '' ?>><?= $value->name ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <div class="row row-sm">
                <div class="col-12">
                    <h3 class="">
                        <i class="fa fa-edit"></i>
                        Profil Perusahaan</h3>
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="">
                <textarea id="description" class="ckeditor_form" cols="30" rows="10"><?= isset($company_profile->description) ? $company_profile->description : ''; ?></textarea>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <div class="row row-sm">
                <div class="col-12">
                    <h3>
                        <i class="fa fa-info"></i>
                        Info Perusahaan</h3>
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="row row-sm">
                <div class="col-sm-12 col-md-4">
                    <div class="form-group">
                        <label for="email">Email Perusahaan</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Email Perusahaan..." value="<?= isset($company_profile->email) ? $company_profile->email : '' ?>">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="form-group">
                        <label for="phone">Telepon Perusahaan</label>
                        <input type="text" id="phone" name="phone" class="form-control" placeholder="Telepon Perusahaan..." value="<?= isset($company_profile->phone_number) ? $company_profile->phone_number : '' ?>">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="form-group">
                        <label for="website">Website Perusahaan</label>
                        <input type="text" id="website" name="website" class="form-control" placeholder="Link Web Perusahaan..." value="<?= isset($company_profile->website) ? $company_profile->website : '' ?>">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="company_address">Alamat Perusahaan</label>
                        <textarea name="company_address" class="form-control" id="company_address" cols="30" rows="3" placeholder="Alamat pekerjaan ini dikerjakan"><?= $company_profile->address ?></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <div class="row row-sm">
                <div class="col-12">
                    <h3>
                        <i class="fa fa-quote-left"></i>
                        Testimoni ke BLK Surabaya
                    </h3>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row row-sm">
                <div class="col-12">
                    <div class="form-group">
                        <label for="testimony">Testimoni</label>
                        <textarea name="testimony" class="form-control" id="testimony" cols="30" rows="3" placeholder="Testimoni ke BLK Surabaya"><?= $company_profile->testimony ?></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>