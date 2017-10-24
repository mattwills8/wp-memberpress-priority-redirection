<?php

if(!class_exists('StarConfig')){

  class StarConfig {

    private $username;
    private $password;
    public $get_member_id_url;
    private $redirect_arr;


    public function __construct() {

      $this->username = 'wp-username';
      $this->password = 'wp-password';
      $this->get_member_id_url = 'http://yourdomain.com/wp-json/mp/v1/members?search=';

      //in order of priority
      $this->redirect_arr = array(
        1 => array( 'id' =>1234, 'url' => 'http://yourdomain.com/upgraded/'),
        2 => array( 'id' => 1235, 'url' => 'http://yourdomain.com/membership/'),
        3 => array( 'id' => 1236, 'url' => 'http://yourdomain.com/basic/'),
      );

      $this->show_on_pages = [
        //ids of pages to attempt redirect on
      ];

      $this->special_case = [
        'include' => '',
        'exclude' => '',
        'url' => '',
      ];
    }
  }
}

?>
