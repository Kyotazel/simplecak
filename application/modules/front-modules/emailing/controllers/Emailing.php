<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Emailing extends BackendController
{
    var $module_name        = 'emailing';
    var $module_directory   = 'emailing';
    var $module_js          = ['emailing'];
    var $app_data           = [];


    public function __construct()
    {
        parent::__construct();
        $this->load->library('email');
    }

    private function _init()
    {
        Modules::run('security/common_security');
        $this->app_data['module_js']    = $this->module_js;
        $this->app_data['module_name']  = $this->module_name;
        $this->app_data['module_directory']  = $this->module_directory;
    }


    public function forgot_password($email, $encrypt_key)
    {
        $data['encrypt_key'] = $encrypt_key;
        $html_content = $this->load->view('_partials/content_forget_password', $data, TRUE);

        $subject        = 'RESET PASSWORD';
        $get_template   = Modules::run('database/find', 'tb_email_template', ['keyword' => 'forgot_password'])->row();
        $email          = $email;
        $content        = $get_template->template;
        $content        = str_replace('{content}', $html_content, $content);
        $content        = str_replace('{username}', $email, $content);

        $this->send_email($subject, $content, $email);
    }

    private function send_email($subject, $content, $email)
    {
        $get_email = Modules::run('database/find', 'app_setting', ['field' => 'email_configuration'])->row();
        $array_email = json_decode($get_email->value, TRUE);
        //get data
        $data['data'] = '';
        // $this->load->library('email');
        $config = array(
            'charset' => 'utf-8',
            'wordwrap' => TRUE,
            'mailtype' => 'html',
            'send_multipart' => FALSE
        );
        $this->email->initialize($config);
        // $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        $this->email->from($array_email['email'], $array_email['subject']);
        $list = array($email);
        $this->email->to($list);
        $this->email->subject($subject);
        $this->email->message($content);

        $fp = fsockopen($array_email['smtp'], 465, $errno, $errstr, 10);
        if (!$fp) {
            echo $array_email['smtp'] . " -  $errstr   ($errno)<br>\n";
        }

        $array_insert_log = [
            'email' => $email,
            'message' => $content
        ];

        if ($this->email->send()) {
            $array_insert_log['status_send'] = 1;
            $this->save_log($array_insert_log);

            return TRUE;
        } else {
            $array_insert_log['status_send'] = 0;
            $this->save_log($array_insert_log);

            return FALSE;
        }
    }

    private function save_log($data)
    {
        Modules::run('database/insert', 'tb_email_log', $data);
    }
}
