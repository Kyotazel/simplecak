<div class="dropdown nav-item main-header-message " style="display: none;">
    <a class="new nav-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail">
            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
            <polyline points="22,6 12,13 2,6"></polyline>
        </svg><span class=" pulse-danger"></span></a>
    <div class="dropdown-menu">
        <div class="menu-header-content bg-primary text-left">
            <div class="d-flex">
                <h6 class="dropdown-title mb-1 tx-15 text-white font-weight-semibold">Messages</h6>
                <span class="badge badge-pill badge-warning ml-auto my-auto float-right">Mark All Read</span>
            </div>
            <p class="dropdown-title-text subtext mb-0 text-white op-6 pb-0 tx-12 ">Kamu memiliki <span class="cout-notification"></span> pesan belum dibaca</p>
        </div>
        <div class="main-message-list chat-scroll">

        </div>
        <div class="text-center dropdown-footer">
            <a href="<?= Modules::run('helper/create_url', 'notification') ?>">Lihat Semua</a>
        </div>
    </div>
</div>
<div class="dropdown nav-item main-header-notification">
    <a class="new nav-link" href="#">
        <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
        </svg><span class=" pulse pulse-notif" style="display: none;"></span></a>
    <div class="dropdown-menu">
        <div class="menu-header-content bg-primary text-left">
            <div class="d-flex">
                <h6 class="dropdown-title mb-1 tx-15 text-white font-weight-semibold">Pemberitahuan</h6>
                <a href="javascript:void(0)" style="display: none;" class="badge badge-pill badge-warning ml-auto my-auto float-right mark-notification">Tandai telah dibaca</a>
            </div>
            <p class="dropdown-title-text subtext mb-0 text-white op-6 pb-0 tx-12 ">Kamu memiliki <span class="count-notification"></span> pesan belum dibaca</p>
        </div>
        <div class="main-notification-list Notification-scroll">
        </div>
        <div class="dropdown-footer">
            <a href="<?= Modules::run('helper/create_url', 'notification') ?>">Lihat Semua</a>
        </div>
    </div>
</div>