<div class="">
    <ul class="list-group usd_list" data-position="main_menu" id="">
        <?php
        if (!empty($treeview)) {
            echo $treeview;
        } else {
            echo '
                    <li>
                        <div class="main-contact-body text-muted text-center mt-3">
                            <h4 class="">TIDAK ADA MENU</h4>
                            <p class>Silhakan tambah data menu</p>
                        </div>
                    </li>
                ';
        }
        ?>
    </ul>
</div>