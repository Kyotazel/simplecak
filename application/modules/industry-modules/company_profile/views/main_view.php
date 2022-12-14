<div class="container">
    <div class="row row-sm">
        <div class="col-sm-12 text-right m-0 mb-2">
            <a class="btn btn-outline-primary btn-rounded" href="<?= base_url('industry-area/company_profile/edit') ?>"><i class="mdi mdi-wrench mr-2"></i>Edit</a>
        </div>
        <div class="col-12">
            <div class="card">
                <img src="<?= base_url('upload/cover/') . $company_profile->cover ?>" class="img-fluid ht-250" style="border-top-left-radius: 10px; border-top-right-radius: 10px;" alt="image cover">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-3 ht-100">
                            <img src="<?= base_url('upload/company/') . $company_profile->image ?>" alt="img profile" class="img-rounded-circle border-3 rounded-circle" style="position: absolute; top: -90px;width: 200px;height: 200px;">
                        </div>
                        <div class="col-sm-12 col-md-9">
                            <h3><?= $company_profile->company ?></h3>
                            <p><?= $company_profile->sector_name ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row row-sm mt-3">
        <div class="col-md-3 col-lg-3 col-sm-12">
            <div class="row">
                <div class="col-12">
                        <div class="card">
                        <div class="card-header mb-0">
                            <h4>Info Perusahaan</h4>
                        </div>
                        <div class="card-body">
                            <div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <i class="zmdi zmdi-email mr-2"></i>
                                        <?= $company_profile->email ?>
                                    </li>
                                    <li class="list-group-item">
                                        <i class="icon ion-ios-call mr-2"></i>
                                        <?= Modules::run('helper/format_phone', $company_profile->phone_number) ?>
                                    </li>
                                    <li class="list-group-item">
                                        <i class="icon ion-md-globe mr-2"></i>
                                        <a href="<?= $company_profile->website ?>" target="_blank" rel="external"><?= str_replace('http://', '', $company_profile->website) ?></a>
                                    </li>
                                    <li class="list-group-item">
                                        <i class="zmdi zmdi-pin mr-2"></i>
                                        <?= $company_profile->address ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <div class="card">
                        <div class="card-header mb-0">
                            <h4>Testimoni ke BLK Surabaya</h4>
                        </div>
                        <div class="card-body">
                            <blockquote class="blockquote">
                                <em>"<?= $company_profile->testimony ?>"</em>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-9 col-lg-9">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header mb-0">
                            <h4>Profil Perusahaan</h4>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                <?= $company_profile->description ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <div class="card">
                        <div class="card-header mb-0">
                            <h5>Lowongan Kerja di <?= $company_profile->name ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php foreach ($company_vacancy as $value) : ?>
                                <div class="col-md-3 text-center">
                                    <a class="card text-dark shadow-lg text-decoration-none" href="#">
                                        <div class="card-body pb-0">
                                            <h6><?= $value->job_name ?></h6>
                                            <p class="text-muted mb-1"><?= $company_profile->name ?></p>
                                            <p class="text-muted">
                                                <i class="zmdi zmdi-pin mr-2"></i>
                                                <?= $value->job_address ?>
                                            </p>
                                            <p class="text-card">
                                                <i class="si si-wallet"></i>
                                                <?= 'Rp ' . number_format((float) $value->minimum_salary, 0, '', '.') . ' - ' . number_format((float) $value->maximum_salary, 0, '', '.') ?> 
                                            </p>
                                        </div>
                                        <div class="card-footer text-right">
                                            <p class="text-muted">
                                                <i class="mdi mdi-update"></i>
                                                <?php $date = date_diff(date_create($value->created_date), date_create(date('Y-m-d'))); 
                                                echo $date->format("%a Hari yang lalu") ?>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                                <?php endforeach; ?>
                                <div class="col-md-3 text-center">
                                    <a class="card text-dark shadow-lg mx-auto text-decoration-none" href="#">
                                        <div class="card-body">
                                            <h6>Lowongan lainya di <?= $company_profile->name ?></h6>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

