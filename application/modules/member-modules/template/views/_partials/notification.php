<div class="dropdown main-header-notification">
    <a class="nav-link icon" href="#">
        <i class="fe fe-bell header-icons"></i>
        <span class="badge badge-danger nav-link-badge">4</span>
    </a>
    <div class="dropdown-menu">
        <div class="header-navheading">
            <p class="main-notification-text">Kamu memiliki <span class="count-notification"></span> pesan belum dibaca <span class="badge badge-pill badge-primary ml-3 mark-notification">Tandai telah dibaca</span></p>
        </div>
        <div class="main-notification-list">
        </div>
        <div class="dropdown-footer">
            <a href="<?= Modules::run('helper/create_url', 'notification') ?>">Lihat Semua</a>
        </div>
    </div>
</div>