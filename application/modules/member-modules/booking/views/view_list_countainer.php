<div class="col-md-12">
    <h3>Daftar Kontainer & Loss Cargo</h3>
    <div class="panel panel-primary tabs-style-2">
        <div class=" tab-menu-heading position-sticky ">
            <div class="tabs-menu1">
                <!-- Tabs -->
                <ul class="nav panel-tabs main-nav-line">
                    <li><a href="#tab4" class="nav-link active" data-toggle="tab"><i class="fa fa-cube"></i> Kontainer</a></li>
                    <li><a href="#tab5" class="nav-link" data-toggle="tab"><i class="fa fa-truck"></i> Loss Cargo</a></li>
                </ul>
            </div>
        </div>
        <div class="panel-body tabs-menu-body main-content-body-right border">
            <div class="tab-content">
                <div class="tab-pane active" id="tab4">
                    <?php
                    $data['data_bs'] = $data_bs;
                    $this->load->view('_partials_detail_countainer_lc/view_detail_countainer', $data);
                    ?>
                </div>
                <div class="tab-pane" id="tab5">
                    <?php
                    $data['data_bs'] = $data_bs;
                    $this->load->view('_partials_detail_countainer_lc/view_detail_lc', $data);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>