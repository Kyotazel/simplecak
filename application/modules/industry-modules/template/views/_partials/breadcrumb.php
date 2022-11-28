<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= Modules::run('helper/create_url', '/'); ?>">Home</a>
    </li>
    <?php
    if ($breadcrumb['method_tag'] == '') {
        echo '
                <li class="breadcrumb-item active">' . ucwords(str_replace('_', ' ', $breadcrumb['controller'])) . '</li>
            ';

    } else {
        echo '
            <li class="breadcrumb-item">
                <a href="' . Modules::run('helper/create_url', $breadcrumb['controller']) . '">' . $breadcrumb['controller_tag'] . '</a>
            </li>
            <li class="breadcrumb-item active">' . $breadcrumb['method_tag'] . '</li>
        ';
    }

    ?>

</ol>