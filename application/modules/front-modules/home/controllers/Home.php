<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends FrontendController
{
    var $module_name        = 'home';
    var $module_directory   = 'home';
    var $module_js          = ['home'];
    var $app_data           = [];

    public function __construct()
    {
        parent::__construct();
        Modules::run('security/common_security');
        $this->_init();
    }
    private function _init()
    {
        $this->app_data['module_js']    = $this->module_js;
        $this->app_data['module_name']  = $this->module_name;
        $this->app_data['module_directory']  = $this->module_directory;
    }

    public function index()
    {
        $courses = Modules::run('database/get_all', 'tb_course')->result();
        $this->app_data['courses'] = $courses;
        $this->app_data['page_title'] = "Home";
        $this->app_data['view_file'] = 'main_view';
        echo Modules::run('template/main_layout', $this->app_data);
    }

    public function courses() 
    {
        $id = $this->input->get('data');
        if (!empty($id)) {
            $id = str_replace(' ', '+', $id);
            $id = $this->encrypt->decode($id);
            $data = Modules::run('database/find', 'tb_course', [
                'id' => $id
            ])->row();
            $this->app_data['course'] = $data;
            $this->app_data['page_title'] = "Kursus " . ucwords($data->name);
            $this->app_data['view_file'] = '_partials/course_detail';
            echo Modules::run('template/main_layout', $this->app_data);
        } else {
            $temp_skill = $this->input->post('skill') ? $this->input->post('skill') : [];
            $category = $this->input->post('category');
            if ($temp_skill || $category) {
                $card = '';
                if ($category == 'ALL') {
                    $courses = Modules::run('database/get_all', 'tb_course')->result();
                } else {
                    $category = $this->encrypt->decode($category);
                    $skill = [];
                    foreach ($temp_skill as $value) {
                        $skill []= $this->encrypt->decode($value);
                    }
                    $q_course = [
                        'select' => 'a.*',
                        'from' => 'tb_course a',
                        'join' => [
                            'tb_course_category b, b.id = a.id_category_course, left',
                            'tb_course_has_skill c, c.id_course = a.id'
                        ],
                        'where' => [
                            'b.id' => $category,
                        ],
                        'where_in' => [
                            'c.id_skill' => $skill
                        ]
                    ];
                    $courses = Modules::run('database/get', $q_course)->result();
                }
                foreach ($courses as $course) {
                    $card .= '<div class="col-md-6 mb-grid-gutter">
                            <a href="'.base_url('kursus-pelatihan-kerja?data=') . $this->encrypt->encode($course->id) .'" class="card card-horizontal card-hover shadow heading-highlight">
                                <div class="card-img-top bg-position-center-top" style="background-image: url('.base_url('upload/courses/') . $course->image .');"></div>
                                <div class="card-body">
                                    <span class="badge bg-success mb-3 fs-sm">'. Modules::run('database/find', 'tb_course_category', ['id' => $course->id_category_course])->row()->name .'</span>
                                    <h5 class="card-title mb-3 py-1">'. $course->name .'</h5>
                                    <div class="text-muted">';
                    $q_skill = [
                        "select" => "c.name skill",
                        "from" => "tb_course a",
                        "join" => [
                            "tb_course_has_skill b, b.id_course = a.id, left",
                            "tb_skill c, c.id = b.id_skill, left"
                        ],
                        "where" => [
                            'a.id' => $course->id
                        ]
                    ];
                    $skills = Modules::run('database/get', $q_skill)->result();
                    $i = 0;
                    foreach ($skills as $skill) {
                        $card .= '<span class="fw-bold text-primary">' . $skill->skill . '</span>';
                        $card .= $i > 0 ? '<span class="text-border px-1">|</span>' : '';
                        $i++;
                    }
                    $card .= '</div>
                            </div>
                        </a>
                    </div>';
                }
                if (empty($courses)) {
                    $card = '<div class="row sidemenu-height mx-auto"> 
                                <div class="col-lg-12"> 
                                    <div class="card custom-card"> 
                                        <div class="card-body mx-auto text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 500"><g id="freepik--background-complete--inject-18"><rect y="382.4" width="500" height="0.25" style="fill:#e0e0e0"></rect><rect x="376.32" y="390" width="16.86" height="0.25" style="fill:#e0e0e0"></rect><rect x="404" y="389.88" width="44.56" height="0.25" style="fill:#e0e0e0"></rect><rect x="265.26" y="391.56" width="55.47" height="0.25" style="fill:#e0e0e0"></rect><rect x="238.78" y="391.56" width="20.72" height="0.25" style="fill:#e0e0e0"></rect><rect x="142.46" y="389.63" width="9.1" height="0.25" style="fill:#e0e0e0"></rect><rect x="157.11" y="389.63" width="15.04" height="0.25" style="fill:#e0e0e0"></rect><rect x="66.89" y="394.14" width="66.56" height="0.25" style="fill:#e0e0e0"></rect><path d="M237,337.8H43.91a5.71,5.71,0,0,1-5.7-5.71V60.66A5.71,5.71,0,0,1,43.91,55H237a5.71,5.71,0,0,1,5.71,5.71V332.09A5.71,5.71,0,0,1,237,337.8ZM43.91,55.2a5.46,5.46,0,0,0-5.45,5.46V332.09a5.46,5.46,0,0,0,5.45,5.46H237a5.47,5.47,0,0,0,5.46-5.46V60.66A5.47,5.47,0,0,0,237,55.2Z" style="fill:#e0e0e0"></path><path d="M453.31,337.8H260.21a5.72,5.72,0,0,1-5.71-5.71V60.66A5.72,5.72,0,0,1,260.21,55h193.1A5.71,5.71,0,0,1,459,60.66V332.09A5.71,5.71,0,0,1,453.31,337.8ZM260.21,55.2a5.47,5.47,0,0,0-5.46,5.46V332.09a5.47,5.47,0,0,0,5.46,5.46h193.1a5.47,5.47,0,0,0,5.46-5.46V60.66a5.47,5.47,0,0,0-5.46-5.46Z" style="fill:#e0e0e0"></path><rect x="270.43" y="260.54" width="47.36" height="121.86" style="fill:#e0e0e0"></rect><polygon points="308.79 382.4 317.79 382.4 317.79 356.81 299.36 356.81 308.79 382.4" style="fill:#f0f0f0"></polygon><rect x="93.43" y="260.54" width="47.36" height="121.86" style="fill:#e0e0e0"></rect><rect x="132.94" y="260.54" width="184.84" height="106.16" style="fill:#f0f0f0"></rect><rect x="236.37" y="260.27" width="66.46" height="82.43" transform="translate(-31.89 571.08) rotate(-90)" style="fill:#e0e0e0"></rect><rect x="147.9" y="260.27" width="66.46" height="82.43" transform="translate(-120.35 482.62) rotate(-90)" style="fill:#e0e0e0"></rect><rect x="267.15" y="313.15" width="4.89" height="82.43" transform="translate(623.96 84.77) rotate(90)" style="fill:#e0e0e0"></rect><rect x="178.69" y="313.15" width="4.89" height="82.43" transform="translate(535.5 173.23) rotate(90)" style="fill:#e0e0e0"></rect><rect x="267.15" y="303.71" width="4.89" height="82.43" transform="translate(614.51 75.32) rotate(90)" style="fill:#e0e0e0"></rect><rect x="178.69" y="303.71" width="4.89" height="82.43" transform="translate(526.05 163.79) rotate(90)" style="fill:#e0e0e0"></rect><path d="M189.29,275.41H173a25.81,25.81,0,0,1-18.73-8.05H208A25.79,25.79,0,0,1,189.29,275.41Z" style="fill:#f0f0f0"></path><path d="M278.58,275.41h-16.3a25.79,25.79,0,0,1-18.73-8.05h53.76A25.79,25.79,0,0,1,278.58,275.41Z" style="fill:#f0f0f0"></path><polygon points="141.94 382.4 132.94 382.4 132.94 356.81 151.37 356.81 141.94 382.4" style="fill:#f0f0f0"></polygon><rect x="68.35" y="73.99" width="248.42" height="141.9" style="fill:#e0e0e0"></rect><path d="M330.51,69.61H60a1.27,1.27,0,0,0-1.27,1.27h0A1.27,1.27,0,0,0,60,72.16H330.51a1.27,1.27,0,0,0,1.27-1.28h0A1.27,1.27,0,0,0,330.51,69.61Z" style="fill:#e0e0e0"></path><rect x="70.89" y="73.99" width="251.32" height="141.9" style="fill:#e6e6e6"></rect><rect x="68.35" y="215.89" width="248.42" height="10.11" style="fill:#e0e0e0"></rect><rect x="79.95" y="215.89" width="251.32" height="10.11" style="fill:#e6e6e6"></rect><rect x="133.22" y="26.9" width="126.66" height="236.08" transform="translate(341.48 -51.61) rotate(90)" style="fill:#f5f5f5"></rect><polygon points="195.34 208.27 240.05 81.61 261.15 81.61 216.44 208.27 195.34 208.27" style="fill:#fafafa"></polygon><polygon points="220.98 208.27 265.69 81.61 273.91 81.61 229.21 208.27 220.98 208.27" style="fill:#fafafa"></polygon><rect x="250.77" y="144.46" width="126.66" height="0.97" transform="translate(459.04 -169.16) rotate(90)" style="fill:#e0e0e0"></rect><rect x="65.48" y="67.33" width="13.11" height="122.22" style="fill:#ebebeb"></rect><rect x="73.49" y="67.33" width="10.21" height="122.22" style="fill:#e0e0e0"></rect><rect x="78.59" y="67.33" width="13.11" height="122.22" style="fill:#ebebeb"></rect><rect x="86.6" y="67.33" width="10.21" height="122.22" style="fill:#e0e0e0"></rect><rect x="91.7" y="67.33" width="13.11" height="122.22" style="fill:#ebebeb"></rect><rect x="302.15" y="67.33" width="7.55" height="122.22" style="fill:#ebebeb"></rect><rect x="306.77" y="67.33" width="5.89" height="122.22" style="fill:#e0e0e0"></rect><rect x="309.71" y="67.33" width="7.55" height="122.22" style="fill:#ebebeb"></rect><rect x="314.32" y="67.33" width="5.89" height="122.22" style="fill:#e0e0e0"></rect><rect x="317.26" y="67.33" width="7.55" height="122.22" style="fill:#ebebeb"></rect><rect x="376.77" y="120.35" width="16.76" height="45.73" style="fill:#e6e6e6"></rect><polygon points="370.4 173.71 366.52 184.28 370.4 184.28 394.13 173.71 370.4 173.71" style="fill:#f0f0f0"></polygon><polygon points="366.52 173.71 366.52 184.28 390.26 173.71 366.52 173.71" style="fill:#e0e0e0"></polygon><polygon points="410.99 173.71 407.11 184.28 410.99 184.28 434.72 173.71 410.99 173.71" style="fill:#f0f0f0"></polygon><polygon points="407.11 173.71 407.11 184.28 430.85 173.71 407.11 173.71" style="fill:#e0e0e0"></polygon><rect x="349.1" y="166.15" width="25.81" height="8.05" transform="translate(724.02 340.35) rotate(180)" style="fill:#e0e0e0"></rect><rect x="374.91" y="166.15" width="73.65" height="8.05" style="fill:#f0f0f0"></rect><polygon points="421.45 166.08 380.66 166.08 375.61 110.67 416.4 110.67 421.45 166.08" style="fill:#e0e0e0"></polygon><polygon points="423.56 166.08 382.77 166.08 377.73 110.67 418.52 110.67 423.56 166.08" style="fill:#f0f0f0"></polygon><polygon points="388.35 159.95 384.42 116.8 412.94 116.8 416.87 159.95 388.35 159.95" style="fill:#fafafa"></polygon><path d="M157.41,242.75s-17.59-30.31,6.81-54.44c0,0,6.37,4.15,6.27,9.73s-6.82,7-5.37,11.64,7.79,9.23,3.62,13.08.67,7.27.39,12S157.41,242.75,157.41,242.75Z" style="fill:#e0e0e0"></path><path d="M158.74,245.52s7.13-34.31-23.63-49.52c0,0-4.73,5.95-2.88,11.21s8.67,4.49,8.77,9.36-4.48,11.21.68,13.55,1.66,7.12,3.42,11.5S158.74,245.52,158.74,245.52Z" style="fill:#e0e0e0"></path><path d="M131.8,237.92s.58,22.62,23,22.62,23-22.62,23-22.62Z" style="fill:#f0f0f0"></path><path d="M396.35,382.4h2.29l6.52-32.16,1.15-5.63,7.11-35h27.29L455.5,382.4h2.29l-15.07-74.18a1.12,1.12,0,0,0-1.1-.89H412.51a1.1,1.1,0,0,0-1.09.89L405.17,339,404,344.63Z" style="fill:#ebebeb"></path><path d="M352.54,382.4h2.29l14.79-72.83h27.29L404,344.63l1.14,5.61,6.53,32.16H414l-7.67-37.79L405.17,339l-6.25-30.78a1.12,1.12,0,0,0-1.1-.89H368.71a1.12,1.12,0,0,0-1.1.89Z" style="fill:#ebebeb"></path><path d="M419.81,308.45H369.67a17.59,17.59,0,0,1-17.58-17.23L350.22,215A12.81,12.81,0,0,1,363,202h31.43a12.81,12.81,0,0,1,12.73,11.36Z" style="fill:#e6e6e6"></path><path d="M392.46,298.84h49.07a6.87,6.87,0,0,1,6.87,6.87v.24a2.5,2.5,0,0,1-2.5,2.5H392.46a0,0,0,0,1,0,0v-9.61A0,0,0,0,1,392.46,298.84Z" style="fill:#e6e6e6"></path></g><g id="freepik--Shadow--inject-18"><ellipse cx="250" cy="416.24" rx="193.89" ry="11.32" style="fill:#f5f5f5"></ellipse></g><g id="freepik--Graphics--inject-18"><path d="M186.55,128.28v0s0,0,0,0a33.71,33.71,0,0,0-.45-5.56,35,35,0,0,0-34.17-29.3h-.3a34.83,34.83,0,0,0-28.26,14.5c-.53.73-1,1.48-1.48,2.23a.86.86,0,0,0-.1.16,34.66,34.66,0,0,0-5,18v.07A34.88,34.88,0,0,0,180,148.63c.52-.73,1-1.47,1.47-2.23a.86.86,0,0,0,.1-.16A34.45,34.45,0,0,0,186.55,128.28Zm-68.27-.79a33,33,0,0,1,4.63-16.2h10.91a55.08,55.08,0,0,0-2.59,16.2Zm17.07-16.2h15.56v16.2H132.73A53.38,53.38,0,0,1,135.35,111.29Zm17.06-1.5V94.87a12.2,12.2,0,0,1,6,2.23c3.71,2.54,6.82,7,9,12.69Zm15.54,1.5a51.81,51.81,0,0,1,2.4,11.55c.15,1.56.22,3.11.24,4.65H152.41v-16.2Zm-19.24-16a10.57,10.57,0,0,1,2.2-.38v14.91h-15C138.71,102.28,143.25,96.8,148.71,95.26Zm2.2,33.73v16.2H135.38A51.25,51.25,0,0,1,133,133.64q-.21-2.34-.24-4.65Zm0,17.7v14.92a12.23,12.23,0,0,1-6-2.23c-3.7-2.54-6.81-7-9-12.69Zm3.7,14.53a10.45,10.45,0,0,1-2.2.38V146.69h15C164.61,154.2,160.07,159.69,154.61,161.22Zm-2.2-16V129h18.18a53.08,53.08,0,0,1-2.62,16.2ZM172.09,129h13a33.12,33.12,0,0,1-4.63,16.2H169.5A55.08,55.08,0,0,0,172.09,129Zm13-1.5h-13c0-1.58-.1-3.18-.25-4.79a52.89,52.89,0,0,0-2.29-11.41h10.89a33.41,33.41,0,0,1,4.19,11.6A35.91,35.91,0,0,1,185.05,127.49Zm-13.87-26.33a33.58,33.58,0,0,1,8.32,8.63H169c-2.24-6.19-5.61-11.09-9.74-13.93l-.32-.21A33.44,33.44,0,0,1,171.18,101.16Zm-26.87-5.49c-4.21,2.77-7.67,7.81-10,14.12H123.85l.73-1.07A33.19,33.19,0,0,1,144.31,95.67Zm-26,33.32h12.95c0,1.58.1,3.18.25,4.79a53.5,53.5,0,0,0,2.29,11.41H122.89a33.21,33.21,0,0,1-4.19-11.6A32.5,32.5,0,0,1,118.28,129Zm5.54,17.7h10.46c2.24,6.19,5.61,11.09,9.74,13.93l.33.21a33.62,33.62,0,0,1-20.53-14.14ZM159,160.81c4.2-2.76,7.66-7.81,10-14.12h10.48c-.24.36-.48.72-.73,1.07A33.15,33.15,0,0,1,159,160.81Z" style="fill:#407BFF"></path><path d="M186.55,128.28v0s0,0,0,0a33.71,33.71,0,0,0-.45-5.56,35,35,0,0,0-34.17-29.3h-.3a34.83,34.83,0,0,0-28.26,14.5c-.53.73-1,1.48-1.48,2.23a.86.86,0,0,0-.1.16,34.66,34.66,0,0,0-5,18v.07A34.88,34.88,0,0,0,180,148.63c.52-.73,1-1.47,1.47-2.23a.86.86,0,0,0,.1-.16A34.45,34.45,0,0,0,186.55,128.28Zm-68.27-.79a33,33,0,0,1,4.63-16.2h10.91a55.08,55.08,0,0,0-2.59,16.2Zm17.07-16.2h15.56v16.2H132.73A53.38,53.38,0,0,1,135.35,111.29Zm17.06-1.5V94.87a12.2,12.2,0,0,1,6,2.23c3.71,2.54,6.82,7,9,12.69Zm15.54,1.5a51.81,51.81,0,0,1,2.4,11.55c.15,1.56.22,3.11.24,4.65H152.41v-16.2Zm-19.24-16a10.57,10.57,0,0,1,2.2-.38v14.91h-15C138.71,102.28,143.25,96.8,148.71,95.26Zm2.2,33.73v16.2H135.38A51.25,51.25,0,0,1,133,133.64q-.21-2.34-.24-4.65Zm0,17.7v14.92a12.23,12.23,0,0,1-6-2.23c-3.7-2.54-6.81-7-9-12.69Zm3.7,14.53a10.45,10.45,0,0,1-2.2.38V146.69h15C164.61,154.2,160.07,159.69,154.61,161.22Zm-2.2-16V129h18.18a53.08,53.08,0,0,1-2.62,16.2ZM172.09,129h13a33.12,33.12,0,0,1-4.63,16.2H169.5A55.08,55.08,0,0,0,172.09,129Zm13-1.5h-13c0-1.58-.1-3.18-.25-4.79a52.89,52.89,0,0,0-2.29-11.41h10.89a33.41,33.41,0,0,1,4.19,11.6A35.91,35.91,0,0,1,185.05,127.49Zm-13.87-26.33a33.58,33.58,0,0,1,8.32,8.63H169c-2.24-6.19-5.61-11.09-9.74-13.93l-.32-.21A33.44,33.44,0,0,1,171.18,101.16Zm-26.87-5.49c-4.21,2.77-7.67,7.81-10,14.12H123.85l.73-1.07A33.19,33.19,0,0,1,144.31,95.67Zm-26,33.32h12.95c0,1.58.1,3.18.25,4.79a53.5,53.5,0,0,0,2.29,11.41H122.89a33.21,33.21,0,0,1-4.19-11.6A32.5,32.5,0,0,1,118.28,129Zm5.54,17.7h10.46c2.24,6.19,5.61,11.09,9.74,13.93l.33.21a33.62,33.62,0,0,1-20.53-14.14ZM159,160.81c4.2-2.76,7.66-7.81,10-14.12h10.48c-.24.36-.48.72-.73,1.07A33.15,33.15,0,0,1,159,160.81Z" style="fill:#fafafa;opacity:0.8"></path><rect x="99.89" y="144.9" width="314.4" height="76.18" style="fill:#407BFF"></rect><rect x="99.89" y="144.9" width="314.4" height="76.18" style="fill:#fafafa;opacity:0.6000000000000001"></rect><rect x="92.8" y="151.99" width="314.4" height="76.18" style="fill:#407BFF"></rect><rect x="92.8" y="151.99" width="314.4" height="76.18" style="opacity:0.30000000000000004"></rect><rect x="85.71" y="159.08" width="314.4" height="76.18" style="fill:#407BFF"></rect><rect x="85.71" y="159.08" width="314.4" height="76.18" style="fill:#fafafa;opacity:0.1"></rect><rect x="219.83" y="54.97" width="46.18" height="284.4" transform="translate(440.08 -45.75) rotate(90)" style="fill:#407BFF"></rect><rect x="219.83" y="54.97" width="46.18" height="284.4" transform="translate(440.08 -45.75) rotate(90)" style="fill:#fafafa;opacity:0.9"></rect><rect x="315.01" y="196.33" width="46.18" height="1.67" transform="translate(140.94 535.27) rotate(-90)" style="fill:#407BFF"></rect><rect x="315.01" y="196.33" width="46.18" height="1.67" transform="translate(140.94 535.27) rotate(-90)" style="fill:#fafafa;opacity:0.6000000000000001"></rect><rect x="91.91" y="196.33" width="33.44" height="1.67" transform="translate(-88.53 305.8) rotate(-90)" style="fill:#407BFF"></rect><rect x="91.91" y="196.33" width="33.44" height="1.67" transform="translate(-88.53 305.8) rotate(-90)" style="fill:#fafafa;opacity:0.6000000000000001"></rect><path d="M360.43,203a7.38,7.38,0,1,1,5.22-12.6h0a7.38,7.38,0,0,1-5.22,12.6Zm0-12.75a5.38,5.38,0,1,0,3.8,1.57h0A5.33,5.33,0,0,0,360.43,190.2Z" style="fill:#407BFF"></path><path d="M370,206.14a1,1,0,0,1-.71-.3l-5.05-5.05a1,1,0,1,1,1.41-1.41l5.05,5.05a1,1,0,0,1,0,1.41A1,1,0,0,1,370,206.14Z" style="fill:#407BFF"></path><g style="opacity:0.6000000000000001"><path d="M360.43,203a7.38,7.38,0,1,1,5.22-12.6h0a7.38,7.38,0,0,1-5.22,12.6Zm0-12.75a5.38,5.38,0,1,0,3.8,1.57h0A5.33,5.33,0,0,0,360.43,190.2Z" style="fill:#fafafa"></path><path d="M370,206.14a1,1,0,0,1-.71-.3l-5.05-5.05a1,1,0,1,1,1.41-1.41l5.05,5.05a1,1,0,0,1,0,1.41A1,1,0,0,1,370,206.14Z" style="fill:#fafafa"></path></g><rect x="261.15" y="98.85" width="31.44" height="0.78" style="fill:#407BFF"></rect><rect x="261.15" y="102.16" width="31.44" height="0.78" style="fill:#407BFF"></rect><rect x="261.15" y="105.48" width="31.44" height="0.78" style="fill:#407BFF"></rect><rect x="261.15" y="108.79" width="31.44" height="0.78" style="fill:#407BFF"></rect><rect x="261.15" y="112.1" width="31.44" height="0.78" style="fill:#407BFF"></rect><rect x="261.15" y="115.42" width="20.5" height="0.78" style="fill:#407BFF"></rect><g style="opacity:0.5"><rect x="261.15" y="98.85" width="31.44" height="0.78" style="fill:#fafafa"></rect><rect x="261.15" y="102.16" width="31.44" height="0.78" style="fill:#fafafa"></rect><rect x="261.15" y="105.48" width="31.44" height="0.78" style="fill:#fafafa"></rect><rect x="261.15" y="108.79" width="31.44" height="0.78" style="fill:#fafafa"></rect><rect x="261.15" y="112.1" width="31.44" height="0.78" style="fill:#fafafa"></rect><rect x="261.15" y="115.42" width="20.5" height="0.78" style="fill:#fafafa"></rect></g><rect x="69.85" y="241.84" width="33.5" height="0.5" style="fill:#407BFF"></rect><rect x="69.85" y="243.96" width="33.5" height="0.5" style="fill:#407BFF"></rect><rect x="69.85" y="246.08" width="33.5" height="0.5" style="fill:#407BFF"></rect><rect x="69.85" y="248.2" width="33.5" height="0.5" style="fill:#407BFF"></rect><rect x="69.85" y="250.32" width="33.5" height="0.5" style="fill:#407BFF"></rect><rect x="69.85" y="252.45" width="21.06" height="0.5" style="fill:#407BFF"></rect><g style="opacity:0.4"><rect x="69.85" y="241.84" width="33.5" height="0.5" style="fill:#fafafa"></rect><rect x="69.85" y="243.96" width="33.5" height="0.5" style="fill:#fafafa"></rect><rect x="69.85" y="246.08" width="33.5" height="0.5" style="fill:#fafafa"></rect><rect x="69.85" y="248.2" width="33.5" height="0.5" style="fill:#fafafa"></rect><rect x="69.85" y="250.32" width="33.5" height="0.5" style="fill:#fafafa"></rect><rect x="69.85" y="252.45" width="21.06" height="0.5" style="fill:#fafafa"></rect></g><path d="M213.45,103.76h0a6.32,6.32,0,0,0-6.32,6.32v20.85a6.32,6.32,0,0,0,6.32,6.32h0a6.32,6.32,0,0,0,6.32-6.32V110.08A6.32,6.32,0,0,0,213.45,103.76Z" style="fill:#407BFF"></path><path d="M213.45,103.76h0a6.32,6.32,0,0,0-6.32,6.32v20.85a6.32,6.32,0,0,0,6.32,6.32h0a6.32,6.32,0,0,0,6.32-6.32V110.08A6.32,6.32,0,0,0,213.45,103.76Z" style="fill:#fafafa;opacity:0.2"></path><path d="M229.29,91.33h0A6.32,6.32,0,0,0,223,97.65v33.28a6.32,6.32,0,0,0,6.32,6.32h0a6.32,6.32,0,0,0,6.32-6.32V97.65A6.32,6.32,0,0,0,229.29,91.33Z" style="fill:#407BFF"></path><path d="M229.29,91.33h0A6.32,6.32,0,0,0,223,97.65v33.28a6.32,6.32,0,0,0,6.32,6.32h0a6.32,6.32,0,0,0,6.32-6.32V97.65A6.32,6.32,0,0,0,229.29,91.33Z" style="opacity:0.30000000000000004"></path><path d="M245.12,116.19h0a6.32,6.32,0,0,0-6.32,6.32v8.42a6.32,6.32,0,0,0,6.32,6.32h0a6.32,6.32,0,0,0,6.33-6.32v-8.42A6.32,6.32,0,0,0,245.12,116.19Z" style="fill:#407BFF"></path><path d="M245.12,116.19h0a6.32,6.32,0,0,0-6.32,6.32v8.42a6.32,6.32,0,0,0,6.32,6.32h0a6.32,6.32,0,0,0,6.33-6.32v-8.42A6.32,6.32,0,0,0,245.12,116.19Z" style="fill:#fafafa;opacity:0.6000000000000001"></path><polyline points="378.61 259.13 404.16 259.13 360.54 213.89 360.54 213.89 378.61 259.13" style="fill:#407BFF"></polyline><g style="opacity:0.1"><polyline points="378.61 259.13 404.16 259.13 360.54 213.89 360.54 213.89 378.61 259.13"></polyline></g><polygon points="354.05 235.25 360.54 213.89 364.22 235.25 354.05 235.25" style="fill:#407BFF;mix-blend-mode:multiply"></polygon><polygon points="360.54 213.89 360.54 277.19 365.06 272.68 378.61 259.13 360.54 213.89" style="fill:#407BFF"></polygon><polygon points="360.54 213.89 360.54 277.19 365.06 272.68 378.61 259.13 360.54 213.89" style="fill:#fafafa;opacity:0.30000000000000004"></polygon><path d="M405.72,78.11h-56A10.76,10.76,0,0,0,339,88.82v28.92a10.76,10.76,0,0,0,10.71,10.71h41.09l-.3,10.11,10.37-10.11h4.83a10.76,10.76,0,0,0,10.72-10.71V88.82A10.76,10.76,0,0,0,405.72,78.11ZM348.46,90.43a3,3,0,0,1,3-3h12.89a3,3,0,0,1,0,6H351.45A3,3,0,0,1,348.46,90.43Zm54.08,28H380.26a3,3,0,1,1,0-5.91h22.28a3,3,0,1,1,0,5.91Zm0-12.51H354.45a3,3,0,1,1,0-5.91h48.09a3,3,0,1,1,0,5.91Zm0-12.51H374.07a3,3,0,0,1,0-6h28.47a3,3,0,0,1,0,6Z" style="fill:#407BFF"></path></g><g id="freepik--Character--inject-18"><path d="M318.14,169.78A53.7,53.7,0,0,0,307.39,152H227.88a53.7,53.7,0,0,0-10.75,17.78l11,54.76a53.73,53.73,0,0,0,90-54.76Z" style="fill:#407BFF"></path><path d="M318.14,169.78A53.7,53.7,0,0,0,307.39,152H227.88a53.7,53.7,0,0,0-10.75,17.78l11,54.76a53.73,53.73,0,0,0,90-54.76Z" style="fill:#fafafa;opacity:0.1"></path><path d="M321.31,190.61a53.55,53.55,0,0,1-14.16,33.93h-79a53.81,53.81,0,0,1-11-54.76h101A53.42,53.42,0,0,1,321.31,190.61Z" style="fill:#407BFF"></path><path d="M321.31,190.61a53.55,53.55,0,0,1-14.16,33.93h-79a53.81,53.81,0,0,1-11-54.76h101A53.42,53.42,0,0,1,321.31,190.61Z" style="fill:#fafafa;opacity:0.9"></path><path d="M321.31,190.61a53.61,53.61,0,1,1-3.17-20.83A53.55,53.55,0,0,1,321.31,190.61Z" style="fill:#fff;opacity:0.30000000000000004"></path><path d="M297.92,143.76l-77.26,70.46q-.58-1.07-1.14-2.16a53,53,0,0,1-4.87-15h0l66.73-60.86A53.42,53.42,0,0,1,297.92,143.76Z" style="fill:#fff;opacity:0.4"></path><path d="M318.59,171.07,246,237.31a53.68,53.68,0,0,1-19.48-14.64l79.32-72.34A53.75,53.75,0,0,1,318.59,171.07Z" style="fill:#fff;opacity:0.4"></path><path d="M321.29,157.15a62,62,0,1,0-22.66,84.64A62,62,0,0,0,321.29,157.15Zm-96,55.44a48.89,48.89,0,1,1,66.79,17.89A48.88,48.88,0,0,1,225.3,212.59Z" style="fill:#407BFF"></path><path d="M321.29,157.15a62,62,0,1,0-22.66,84.64A62,62,0,0,0,321.29,157.15Zm-96,55.44a48.89,48.89,0,1,1,66.79,17.89A48.88,48.88,0,0,1,225.3,212.59Z" style="opacity:0.1"></path><path d="M125.06,251.89l7.66,1.78-6.35,4.74s-4.55-2.06-4.76-5.29Z" style="fill:#e4897b"></path><polygon points="136.82 258.77 131.3 262.45 126.37 258.41 132.72 253.68 136.82 258.77" style="fill:#e4897b"></polygon><path d="M223.47,220.78c-8.14,6-16.49,11.7-24.88,17.27s-16.89,11-25.43,16.33S156,264.93,147.35,270c-4.32,2.58-8.68,5.08-13,7.62a25.32,25.32,0,0,1-6.94,3.07,21.75,21.75,0,0,1-4,.67,17,17,0,0,1-4.49-.23,8.2,8.2,0,0,1-6.45-9.65,7,7,0,0,1,.28-1,16.56,16.56,0,0,1,2-4,21.22,21.22,0,0,1,2.56-3.1,25.52,25.52,0,0,1,6.13-4.48c4.37-2.49,8.71-5,13.11-7.47,8.76-4.95,17.6-9.77,26.46-14.53s17.83-9.37,26.85-13.87,18.11-8.88,27.39-12.92a6.21,6.21,0,0,1,6.18,10.69Z" style="fill:#407BFF"></path><path d="M223.47,220.78c-8.14,6-16.49,11.7-24.88,17.27s-16.89,11-25.43,16.33S156,264.93,147.35,270c-4.32,2.58-8.68,5.08-13,7.62a25.32,25.32,0,0,1-6.94,3.07,21.75,21.75,0,0,1-4,.67,17,17,0,0,1-4.49-.23,8.2,8.2,0,0,1-6.45-9.65,7,7,0,0,1,.28-1,16.56,16.56,0,0,1,2-4,21.22,21.22,0,0,1,2.56-3.1,25.52,25.52,0,0,1,6.13-4.48c4.37-2.49,8.71-5,13.11-7.47,8.76-4.95,17.6-9.77,26.46-14.53s17.83-9.37,26.85-13.87,18.11-8.88,27.39-12.92a6.21,6.21,0,0,1,6.18,10.69Z" style="opacity:0.1"></path><path d="M136.16,204.52c-.5.81-1.07,1.79-1.61,2.71s-1.07,1.88-1.57,2.85c-1,1.91-2,3.85-3,5.82s-1.81,4-2.63,6c-.4,1-.82,2-1.19,3l-.56,1.53c-.11.29-.13.41-.2.62s-.1.41-.16.61a31.13,31.13,0,0,0-.59,6c-.05,2.15,0,4.34.12,6.55s.24,4.43.44,6.65.4,4.48.61,6.68l-3.86.79c-.68-2.23-1.21-4.45-1.74-6.7s-.93-4.51-1.32-6.81-.65-4.61-.82-7a34.78,34.78,0,0,1,.19-7.51c.06-.35.11-.68.2-1s.18-.77.26-1l.49-1.7c.32-1.13.69-2.25,1.07-3.36.77-2.23,1.61-4.42,2.55-6.58s1.94-4.27,3-6.35c.55-1,1.13-2.07,1.72-3.1s1.18-2,1.92-3.09Z" style="fill:#e4897b"></path><path d="M131.89,411a9.4,9.4,0,0,1-2-.28.17.17,0,0,1-.14-.14.19.19,0,0,1,.08-.19c.27-.18,2.63-1.7,3.54-1.29a.62.62,0,0,1,.36.52,1,1,0,0,1-.3,1A2.26,2.26,0,0,1,131.89,411Zm-1.53-.54c1.36.27,2.38.22,2.77-.14a.68.68,0,0,0,.19-.65.27.27,0,0,0-.16-.24C132.69,409.22,131.32,409.88,130.36,410.46Z" style="fill:#407BFF"></path><path d="M129.88,410.73a.16.16,0,0,1-.09,0,.17.17,0,0,1-.09-.16c0-.09,0-2.33.85-3.08a1,1,0,0,1,.78-.25.64.64,0,0,1,.62.52c.18.87-1.24,2.55-2,3A.16.16,0,0,1,129.88,410.73Zm1.33-3.16a.62.62,0,0,0-.41.16,4.18,4.18,0,0,0-.72,2.46c.74-.6,1.62-1.86,1.51-2.39,0-.09-.07-.19-.3-.22Z" style="fill:#407BFF"></path><path d="M167.31,411a12.52,12.52,0,0,1-2.45-.28.17.17,0,0,1-.15-.15.19.19,0,0,1,.1-.19c.35-.18,3.45-1.76,4.4-1.24a.59.59,0,0,1,.32.49,1,1,0,0,1-.34.89A2.9,2.9,0,0,1,167.31,411Zm-1.84-.54c1.73.29,3,.21,3.48-.21a.68.68,0,0,0,.21-.59.23.23,0,0,0-.12-.2C168.52,409.18,166.74,409.85,165.47,410.46Z" style="fill:#407BFF"></path><path d="M164.89,410.73a.13.13,0,0,1-.1,0,.15.15,0,0,1-.08-.16c0-.09.19-2.19,1.16-3a1.39,1.39,0,0,1,1-.32c.51.05.65.31.69.52.14.88-1.69,2.56-2.62,3Zm1.86-3.16a1,1,0,0,0-.64.24,4.29,4.29,0,0,0-1,2.4c.94-.57,2.19-1.89,2.1-2.42,0,0,0-.18-.36-.21Z" style="fill:#407BFF"></path><path d="M148,174.49c.61,4.67,2,14.14-1.38,17,0,0,1,4.76,9.52,5.31,9.42.61,4.8-4.38,4.8-4.38-5.06-1.56-4.68-5.37-3.55-8.89Z" style="fill:#e4897b"></path><path d="M165.47,165a.34.34,0,0,1-.17-.05.36.36,0,0,1-.15-.5,3.65,3.65,0,0,1,2.73-2,.37.37,0,0,1,.07.73h0a3,3,0,0,0-2.15,1.58A.4.4,0,0,1,165.47,165Z" style="fill:#263238"></path><path d="M168.16,169.1a16.73,16.73,0,0,0,2.6,3.78,2.7,2.7,0,0,1-2.19.63Z" style="fill:#de5753"></path><path d="M167.5,168.08c.06.63.44,1.1.84,1.06s.7-.57.64-1.2-.44-1.1-.85-1.06S167.44,167.46,167.5,168.08Z" style="fill:#263238"></path><path d="M168,166.93l1.46-.57S168.76,167.6,168,166.93Z" style="fill:#263238"></path><polygon points="156.33 410.54 164.12 410.54 164.64 392.52 156.85 392.52 156.33 410.54" style="fill:#e4897b"></polygon><polygon points="120.96 410.54 128.75 410.54 131.25 392.52 123.47 392.52 120.96 410.54" style="fill:#e4897b"></polygon><path d="M129.23,409.64h-8.75a.62.62,0,0,0-.62.53l-1,6.92a1.25,1.25,0,0,0,1.24,1.39c3-.05,4.52-.23,8.37-.23,2.36,0,5.82.24,9.09.24s3.44-3.23,2.08-3.52c-6.1-1.31-7.06-3.12-9.12-4.85A2,2,0,0,0,129.23,409.64Z" style="fill:#263238"></path><path d="M164.38,409.64h-8.74a.61.61,0,0,0-.62.53l-1,6.92a1.26,1.26,0,0,0,1.25,1.39c3-.05,4.52-.23,8.36-.23,2.37,0,7.26.24,10.53.24s3.44-3.23,2.08-3.52c-6.1-1.31-8.5-3.12-10.56-4.85A2,2,0,0,0,164.38,409.64Z" style="fill:#263238"></path><polygon points="164.63 392.52 164.37 401.81 156.58 401.81 156.85 392.52 164.63 392.52" style="fill:#ce6f64"></polygon><polygon points="123.46 392.52 131.25 392.52 129.96 401.81 122.17 401.81 123.46 392.52" style="fill:#ce6f64"></polygon><path d="M139.48,205.72a39.94,39.94,0,0,1-5.11,6.42l-.89-.59L123.62,205S129,193,133.05,192.39c3.87-.62,6.69,3.38,8,7.66C141.55,201.6,140.72,203.7,139.48,205.72Z" style="fill:#407BFF"></path><path d="M139.48,205.72a39.94,39.94,0,0,1-5.11,6.42l-.89-.59L123.62,205S129,193,133.05,192.39c3.87-.62,6.69,3.38,8,7.66C141.55,201.6,140.72,203.7,139.48,205.72Z" style="fill:#fafafa;opacity:0.6000000000000001"></path><path d="M139.48,205.72a39.94,39.94,0,0,1-5.11,6.42l-.89-.59c.44-3.6,1.84-7.17,3.44-8.3C137.9,203.35,138.77,204.39,139.48,205.72Z" style="fill:#407BFF"></path><path d="M139.48,205.72a39.94,39.94,0,0,1-5.11,6.42l-.89-.59c.44-3.6,1.84-7.17,3.44-8.3C137.9,203.35,138.77,204.39,139.48,205.72Z" style="fill:#fafafa;opacity:0.4"></path><path d="M173.21,211.71h0c-.47,3-1.08,6.53-1.9,10.72-1,5.36-2.4,11.79-4.17,19.48l-31.55-2c1.36-12.81,1.89-20.73-2.54-47.48a92.82,92.82,0,0,1,13.52-.89,100.56,100.56,0,0,1,14.32.93c6.12,1,13,2.84,13,2.84S175.65,196,173.21,211.71Z" style="fill:#407BFF"></path><path d="M173.21,211.71h0c-.47,3-1.08,6.53-1.9,10.72-1,5.36-2.4,11.79-4.17,19.48l-31.55-2c1.36-12.81,1.89-20.73-2.54-47.48a92.82,92.82,0,0,1,13.52-.89,100.56,100.56,0,0,1,14.32.93c6.12,1,13,2.84,13,2.84S175.65,196,173.21,211.71Z" style="fill:#fafafa;opacity:0.6000000000000001"></path><path d="M173.21,211.71h0c-.47,3-1.08,6.53-1.9,10.72A77.48,77.48,0,0,1,167,211h5.86Z" style="fill:#407BFF"></path><path d="M173.21,211.71h0c-.47,3-1.08,6.53-1.9,10.72A77.48,77.48,0,0,1,167,211h5.86Z" style="fill:#fafafa;opacity:0.4"></path><path d="M146.28,167.92c1.19,7.63,1.54,10.89,5.79,14.46,6.39,5.38,15.5,2.24,16.61-5.6,1-7.05-1.12-18.35-8.93-20.69A10.53,10.53,0,0,0,146.28,167.92Z" style="fill:#e4897b"></path><path d="M158.8,241.37s-.5,13.89-1.7,31.41c-1,14.7-2.51,31.94-4.62,45.68l-.06.38C148.63,343.16,131.84,400,131.84,400H121.22s8.75-54.9,10.67-79c4.87-60.87-7.33-67.76,3.7-81.18Z" style="fill:#407BFF"></path><path d="M158.8,241.37s-.5,13.89-1.7,31.41c-1,14.7-2.51,31.94-4.62,45.68l-.06.38C148.63,343.16,131.84,400,131.84,400H121.22s8.75-54.9,10.67-79c4.87-60.87-7.33-67.76,3.7-81.18Z" style="opacity:0.30000000000000004"></path><path d="M157.1,272.78c-1,14.7-2.51,31.94-4.62,45.68-3.59-17.85-9.49-43.92-1.57-61C152.8,262.31,155,267.79,157.1,272.78Z" style="fill:#407BFF"></path><path d="M157.1,272.78c-1,14.7-2.51,31.94-4.62,45.68-3.59-17.85-9.49-43.92-1.57-61C152.8,262.31,155,267.79,157.1,272.78Z" style="opacity:0.4"></path><path d="M167.14,241.92s9,53.34,8.46,77.08c-.53,24.7-9.58,81-9.58,81H155.5s1.66-54.87.73-79.12c-1-26.44-12.2-80.47-12.2-80.47Z" style="fill:#407BFF"></path><path d="M167.14,241.92s9,53.34,8.46,77.08c-.53,24.7-9.58,81-9.58,81H155.5s1.66-54.87.73-79.12c-1-26.44-12.2-80.47-12.2-80.47Z" style="opacity:0.30000000000000004"></path><polygon points="153.7 400.5 167.81 400.5 168.91 395.77 153.2 395.88 153.7 400.5" style="fill:#263238"></polygon><polygon points="119.68 400.5 133.79 400.5 134.89 395.77 119.78 395.88 119.68 400.5" style="fill:#263238"></polygon><path d="M135.23,238l-1.6,2.74c-.13.21.12.45.48.47l33.09,2.15c.28,0,.53-.1.56-.28l.47-2.81c0-.19-.21-.37-.52-.39l-32-2.08A.61.61,0,0,0,135.23,238Z" style="fill:#263238"></path><path d="M139.29,241.84l-.85-.06c-.17,0-.3-.11-.28-.21l.64-3.65c0-.1.17-.18.34-.17l.86.05c.17,0,.29.11.28.22l-.64,3.64C139.62,241.77,139.46,241.85,139.29,241.84Z" style="fill:#407BFF"></path><path d="M139.29,241.84l-.85-.06c-.17,0-.3-.11-.28-.21l.64-3.65c0-.1.17-.18.34-.17l.86.05c.17,0,.29.11.28.22l-.64,3.64C139.62,241.77,139.46,241.85,139.29,241.84Z" style="opacity:0.30000000000000004"></path><path d="M160,243.18l-.85-.05c-.17,0-.3-.11-.28-.22l.64-3.64c0-.11.17-.18.35-.17l.85.05c.17,0,.3.11.28.22l-.64,3.64C160.36,243.12,160.2,243.19,160,243.18Z" style="fill:#407BFF"></path><path d="M160,243.18l-.85-.05c-.17,0-.3-.11-.28-.22l.64-3.64c0-.11.17-.18.35-.17l.85.05c.17,0,.3.11.28.22l-.64,3.64C160.36,243.12,160.2,243.19,160,243.18Z" style="opacity:0.30000000000000004"></path><path d="M175.68,203.31c1.2,4,2.34,8.05,3.45,12.09l3.35,12.09.42,1.5.11.37.05.19,0,.1a3.56,3.56,0,0,0,.13.39,6.41,6.41,0,0,0,1,1.68,16.69,16.69,0,0,0,4.1,3.16,52.87,52.87,0,0,0,11,4.44l-.58,3.9a41.59,41.59,0,0,1-13.08-2.83,20.73,20.73,0,0,1-6.29-3.88,12.46,12.46,0,0,1-2.6-3.42,9.36,9.36,0,0,1-.47-1.07l-.11-.27-.07-.19-.13-.37-.53-1.51c-1.4-4-2.7-8-3.93-12.06s-2.44-8.06-3.54-12.14Z" style="fill:#e4897b"></path><path d="M173.89,195.27c4,1.31,8.2,14.39,8.2,14.39l-14.44,6.22s-6-14.68-3.34-18S169.3,193.77,173.89,195.27Z" style="fill:#407BFF"></path><path d="M173.89,195.27c4,1.31,8.2,14.39,8.2,14.39l-14.44,6.22s-6-14.68-3.34-18S169.3,193.77,173.89,195.27Z" style="fill:#fafafa;opacity:0.6000000000000001"></path><path d="M166.17,155.65c-2.55-3.15-22.25-5.4-23.3,3.18-7,4.9-.36,17.56.64,20.78-4.83,1.34-20.39,6.66-9,17s28.47,8.58,31.81-2.12c2.34-7.48-5.09-20-4.93-24.38S170.54,161,166.17,155.65Z" style="fill:#263238"></path><path d="M144.89,181.19a.23.23,0,0,1-.19-.09c-1.81-2.2-8.11-13.76-5.9-19.26a4.79,4.79,0,0,1,4.23-3,.24.24,0,0,1,.27.22.25.25,0,0,1-.21.28,4.32,4.32,0,0,0-3.83,2.66c-2.13,5.32,4.05,16.61,5.82,18.77a.24.24,0,0,1-.19.4Z" style="fill:#263238"></path><path d="M159.83,169.64a6.64,6.64,0,0,0,2,3.82c1.42,1.36,2.76.43,2.89-1.3.12-1.55-.48-4.12-2.16-4.84S159.62,167.91,159.83,169.64Z" style="fill:#e4897b"></path><path d="M194.39,238.24l5.68-1.93-.89,6.83s-2.24,1-5.14-1.52l-2.77-1.77,2.18-1.19A5.28,5.28,0,0,1,194.39,238.24Z" style="fill:#e4897b"></path><polygon points="204.04 236.29 202.3 242.26 199.18 243.13 200.07 236.31 204.04 236.29" style="fill:#e4897b"></polygon></g></svg>
                                            <h3 class="h2">Oops! kursus tidak ditemukan...</h3>
                                            <p class="h3 text-muted">Silahkan cari kursus yang lain</p> 
                                        </div> 
                                    </div> 
                                </div> 
                            </div>';
                }
                echo json_encode(['status' => true, 'data' => $card]);
            } else {
                $courses = Modules::run('database/get_all', 'tb_course')->result();
                $this->app_data['get_skill'] = Modules::run('database/get_all', 'tb_skill')->result();
                $this->app_data['get_course_category'] = Modules::run('database/get_all', 'tb_course_category')->result();
                $this->app_data['courses'] = $courses;
                $this->app_data['page_title'] = "Kursus Pelatihan Kerja";
                $this->app_data['view_file'] = 'courses';
                echo Modules::run('template/main_layout', $this->app_data);
            }
        }
    }
    
    public function register_courses() 
    {
        $id = $this->input->get('data');
        if (!empty($id)) {
            $id = str_replace(' ', '+', $id);
            $id = $this->encrypt->decode($id);
            $q_batch_courses = [
                'select' => 'a.id, a.title, a.description, a.target_registrant, 
                        DATE_FORMAT(a.opening_registration_date, "%d %M %Y") opening_date,
                        DATE_FORMAT(a.closing_registration_date, "%d %M %Y") closing_date,
                        a.image, a.target_registrant',
                'from' => 'tb_batch_course a',
                'order_by' => 'a.created_date DESC',
                'where' => [
                    'a.id' => $id
                ]
            ];
            $array_peserta = [
                "select" => "count(*) as total",
                "from" => "tb_batch_course_has_account",
                "where" => "id_batch_course = $id AND status = 5"
            ];
            $count_peserta = Modules::run("database/get", $array_peserta)->row();
            $data = Modules::run('database/get', $q_batch_courses)->row();
            $this->app_data['batch_course'] = $data;
            $this->app_data['count_peserta'] = $count_peserta;
            $this->app_data['page_title'] = "Penfdaftaran Pelatihan " . ucwords($data->title);
            $this->app_data['view_file'] = '_partials/batch_course_detail';
            echo Modules::run('template/main_layout', $this->app_data);
        } else {
            $open_course = $this->input->post('open_course');
            $q_batch_courses = [
                'select' => 'a.id, a.title, a.description, a.target_registrant, 
                        DATE_FORMAT(a.opening_registration_date, "%d %M %Y") opening_date,
                        DATE_FORMAT(a.closing_registration_date, "%d %M %Y") closing_date,
                        a.image, a.target_registrant',
                'from' => 'tb_batch_course a',
                'order_by' => 'a.created_date DESC'        
            ];
            if ($open_course || $open_course === '0') {
                $card = '';
                if ($open_course == 1) {
                    $q_batch_courses['where'] = 'NOW() < a.closing_registration_date';
                } elseif ($open_course === '0') {
                    $q_batch_courses['where'] = 'NOW() > a.closing_registration_date';
                } 
                    $batch_courses = Modules::run('database/get', $q_batch_courses)->result();
                foreach ($batch_courses as $batch) {
                    $date = date('Y-m-d');
                    $array_peserta = [
                        "select" => "count(*) as total",
                        "from" => "tb_batch_course_has_account",
                        "where" => "id_batch_course = $batch->id AND status = 5"
                    ];
                    $count_peserta      = Modules::run("database/get", $array_peserta)->row();
                    if ($date > $batch->closing_date) {
                        $badge_date = '<span class="badge bg-danger fw-bold">'.$batch->closing_date.' | ' . $count_peserta->total .'/'. $batch->target_registrant . ' Peserta</span>';
                    } else {
                        $badge_date = '<span class="badge bg-success fw-bold">'.$batch->closing_date.' | ' . $count_peserta->total .'/'. $batch->target_registrant . ' Peserta</span>';
                    }
                    $card .= '<div class="col-md-4">
                                <div class="card border-0 mb-4 px-sm-3 py-sm-0 py-3">
                                    <div class="card-header flex-shrink-0 ms-sm-n2 border-0">
                                        <img src="'. base_url('upload/batch/') . $batch->image .'" alt="'. $batch->image .'" class="img-thumbnail">
                                        <div class="card-floating-links text-end">
                                            '. $badge_date .'
                                        </div>
                                    </div>
                                    <div class="card-body py-sm-2 py-0 px-sm-3">
                                        <h3 class="h5 mb-sm-1 mb-2">
                                            <a href="'. base_url('pendaftaran-pelatihan?data=') . $this->encrypt->encode($batch->id) .'" class="nav-link">'. $batch->title .'</a>
                                        </h3>
                                        <span class="text-muted">'. strip_tags($batch->description) .'</span>
                                    </div>
                                    <div class="card-footer flex-shrink-0 my-sm-2 mt-5 me-sm-n2 py-sm-2 px-sm-0 border-0">
                                        <a href="'. base_url('pendaftaran-pelatihan?data=') . $this->encrypt->encode($batch->id) .'" class="btn btn-outline-primary btn-hover-shadow d-sm-inline-block d-block float-end">Detail</a>
                                    </div>
                                </div>
                            </div>';
                }
                echo json_encode(['status' => true, 'data' => $card]);
            } else {
                $batch_courses = Modules::run('database/get', $q_batch_courses)->result();
                $this->app_data['batch_courses'] = $batch_courses;
                $this->app_data['page_title'] = "Pendaftaran Pelatihan";
                $this->app_data['view_file'] = 'register';
                echo Modules::run('template/main_layout', $this->app_data);
            }
        }
    }

    public function page()
    {
        $slug = $this->input->get('data');
        $get_data = Modules::run('database/find', 'tb_cms_page', ['slug' => $slug])->row();
        if (empty($get_data)) {
            redirect(base_url());
        }

        $this->app_data['data_post'] = $get_data;
        $this->app_data['page_title'] = $get_data->title;
        $this->app_data['view_file'] = str_replace('-', '_', $slug);
        echo Modules::run('template/main_layout', $this->app_data);
    }
}
