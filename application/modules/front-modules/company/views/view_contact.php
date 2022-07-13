<section class="section bg-light border-bottom">
    <div class="container ">
        <div class="row ">
            <div class="col-12 text-center">
                <div class="section-title mb-4 pb-2">
                    <h4 class="title mb-4">DISKUSIKAN PROJECTMU YUK</h4>
                    <p class="text-muted para-desc mb-0 mx-auto">Jangan ragu beritahu kami tentang aplikasi website yang ingin anda miliki, kami akan review pesanmu dan mengkonfirmasi melalui email dalam waktu 1x24 jam.</p>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 mt-4 mt-sm-0 pt-2 pt-sm-0 order-2 order-md-1">
                <div class="card custom-form rounded border-0 shadow p-4">
                    <form method="post" class="form-contact">
                        <p id="error-msg" class="mb-0"></p>
                        <div id="simple-msg"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <div class="form-icon position-relative">
                                        <i data-feather="user" class="fea icon-sm icons"></i>
                                        <input name="name" type="text" class="form-control ps-5" placeholder="Nama Lengkap :">
                                        <span class="help-block text-danger"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <div class="form-icon position-relative">
                                        <i data-feather="mail" class="fea icon-sm icons"></i>
                                        <input name="email" id="email" type="email" class="form-control ps-5" placeholder="Email :">
                                        <span class="help-block text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <!--end col-->

                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">No.telp / WA</label>
                                    <div class="form-icon position-relative">
                                        <i data-feather="book" class="fea icon-sm icons"></i>
                                        <input name="number_phone" class="form-control ps-5" placeholder="No.telp / WA :">
                                        <span class="help-block text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Nama Perusahaan / instansi</label>
                                    <div class="form-icon position-relative">
                                        <i data-feather="book" class="fea icon-sm icons"></i>
                                        <input name="company" class="form-control ps-5" placeholder="nama perusahaan / instansi :">
                                        <span class="help-block text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Alamat Instansi </label>
                                    <div class="form-icon position-relative">
                                        <i data-feather="map" class="fea icon-sm icons clearfix"></i>
                                        <textarea name="address" rows="4" class="form-control ps-5" placeholder="alamat instansi :"></textarea>
                                        <span class="help-block text-danger"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Catatan Untuk kami : <span class="text-danger">*</span></label>
                                    <div class="form-icon position-relative">
                                        <i data-feather="message-circle" class="fea icon-sm icons clearfix"></i>
                                        <textarea name="comments" rows="10" class="form-control ps-5" placeholder="catatan untuk kami :"></textarea>
                                        <span class="help-block text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-grid">
                                    <button type="submit" id="submit" name="send" class="btn btn-primary btn_send">Kirim Pesan</button>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>
                <!--end custom-form-->
            </div>
            <!--end col-->

            <div class="col-lg-4 col-md-4 order-1 order-md-2">
                <div class="title-heading ms-lg-4">
                    <h4 class="mb-4">Kontak Kami</h4>
                    <p class="text-muted">Silahkan hubungi kami melalui kontak dibawah ini.</p>
                    <div class="d-flex contact-detail align-items-center mt-3">
                        <div class="icon">
                            <i data-feather="mail" class="fea icon-m-md text-dark me-3"></i>
                        </div>
                        <div class="flex-1 content">
                            <h6 class="title fw-bold mb-0">Email</h6>
                            <a href="mailto:contact@example.com" class="text-primary"><?= $company_email; ?></a>
                        </div>
                    </div>

                    <div class="d-flex contact-detail align-items-center mt-3">
                        <div class="icon">
                            <i data-feather="phone" class="fea icon-m-md text-dark me-3"></i>
                        </div>
                        <div class="flex-1 content">
                            <h6 class="title fw-bold mb-0">Phone</h6>
                            <a href="tel:+152534-468-854" class="text-primary"><?= $company_number_phone; ?></a>
                        </div>
                    </div>

                    <!-- <div class="d-flex contact-detail align-items-center mt-3">
                        <div class="icon">
                            <i data-feather="map-pin" class="fea icon-m-md text-dark me-3"></i>
                        </div>
                        <div class="flex-1 content">
                            <h6 class="title fw-bold mb-0">Location</h6>
                            <a href="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d39206.002432144705!2d-95.4973981212445!3d29.709510002925988!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8640c16de81f3ca5%3A0xf43e0b60ae539ac9!2sGerald+D.+Hines+Waterwall+Park!5e0!3m2!1sen!2sin!4v1566305861440!5m2!1sen!2sin" data-type="iframe" class="video-play-icon text-primary lightbox">View on Google map</a>
                        </div>
                    </div> -->
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
    <!--end container-->
</section>
<!--end section-->
<!-- End contact -->