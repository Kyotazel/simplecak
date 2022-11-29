<html>
<style>
    p,
    h3,
    h5 {
        padding: 0;
        margin: 0;
    }
</style>

<body>
    <div style="text-align: center;">
        <img src="<?= base_url('upload/') ?>member/<?= $account->image ?>" style="height: 150px;">
        <h3 style="text-transform: uppercase; margin-top: 8px; margin-bottom: 4px">[<?= $account->name ?>]</h3>
        <p><?= $account->address_current ?> | +<?= $account->phone_number ?> | <?= $account->email ?></p>
        <a style="text-decoration: none;" href="<?= $intern_cv->link_portfolio ?>"><?= $intern_cv->link_portfolio ?></a>
    </div>
    <hr style="margin-top: 20px; margin-bottom: 4px">
    <div>
        <h3 style="margin-bottom: 6px;">Tentang Saya</h3>
        <p><?= $intern_cv->about_me ?></p>
    </div>
    <hr style="margin-top: 20px; margin-bottom: 4px">
    <div>
        <h3 style="margin-bottom: 2px;">Kemampuan & Kompetensi</h3>
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%;">
                    <ul>
                        <?php foreach (Modules::run('database/find', 'tb_cv_intern_has_skill', ['id_cv_intern' => $intern_cv->id])->result() as $key => $value) : ?>
                            <?php if ($key % 2 == 0) : ?>
                                <li><?= $value->skill ?></li>
                            <?php endif ?>
                        <?php endforeach ?>
                    </ul>
                </td>
                <td style="width: 50%;">
                    <ul>
                    <?php foreach (Modules::run('database/find', 'tb_cv_intern_has_skill', ['id_cv_intern' => $intern_cv->id])->result() as $key => $value) : ?>
                            <?php if ($key % 2 == 1) : ?>
                                <li><?= $value->skill ?></li>
                            <?php endif ?>
                        <?php endforeach ?>
                    </ul>
                </td>
            </tr>
        </table>
    </div>
    <hr style="margin-top: 20px; margin-bottom: 4px">
    <div>
        <h3 style="margin-bottom: 6px;">Pengalaman</h3>
        <?php foreach (Modules::run('database/find', 'tb_cv_intern_has_experience', ['id_cv_intern' => $intern_cv->id])->result() as $key => $value) : ?>
        <div style="margin-bottom: 8px;">
            <h5><?= $value->company_name ?></h5>
            <p><?= $value->position ?> (<?= Modules::run('helper/month_indo', $value->started_date, '-') ?> - <?= Modules::run('helper/month_indo', $value->end_date, '-') ?>)</p>
            <div style="margin-left: 16px;">
                <?= $value->description ?>
            </div>
        </div>
        <?php endforeach ?>
    </div>
    <hr style="margin-top: 12px; margin-bottom: 4px">
    <div>
        <h3 style="margin-bottom: 6px;">Pendidikan</h3>
        <?php foreach (Modules::run('database/find', 'tb_cv_intern_has_education', ['id_cv_intern' => $intern_cv->id])->result() as $key => $value) : ?>
        <div style="margin-bottom: 8px;">
            <h5><?= $value->school_name ?></h5>
            <p><?= $value->study_program ?> (<?= $value->started_date . ' - ' . $value->end_date ?>)</p>
            <div style="margin-left: 16px;">
            <?= $value->description ?>
            </div>
        </div>
        <?php endforeach ?>
    </div>
</body>

</html>