<?php

require_once( plugin_dir_path( __FILE__ ) . 'Config.php');
require_once( plugin_dir_path( __FILE__ ) . 'Requests.php');

if(!class_exists('StarMember')) {

  class StarMember {

    private $config;
    private $get_member_id_url;
    private $username;
    private $pwd;
    private $member_email;
    private $member_id;
    private $member_response;
    private $member;

    public function __construct($user_id) {

      $this->config = new StarConfig();

      $this->get_member_id_url = $this->config->get_member_id_url;
      $this->username = $this->config->username;
      $this->pwd = $this->config->password;

      $this->member_email = get_userdata( $user_id )->user_email;

      $this->request_args = array(
        'url' => $this->get_member_id_url . urlencode($this->member_email),
        'method' => 'GET',
        'headers' => array(
            'Authorization' => 'Basic ' . base64_encode( $this->username.':'.$this->pwd )
          )
      );

      $member_request = new StarRequests( $this->request_args );

      try {
        $this->member_response = $member_request->send();

        if($this->member_response['response']['code'] === 200){
          $this->member = json_decode(substr($this->member_response['body'],1,-1));
        }
        else{
          echo 'Bad Request...Returned '.$this->member_response['status']['code'].'<br>';
          $this->member = [];
        }
      }
      catch (Exception $e) {
          echo 'Caught exception: ',  $e->getMessage(), "\n";
      }
    }

    public function get_subscription_ids() {

      $subscriptions_arr = $this->get_property('active_memberships');
      $subscription_ids = [];

      if(!$subscriptions_arr){
        echo 'Member had no subscriptions';
        return [];
      }

      foreach( $subscriptions_arr as $subscription ){
        $subscription_ids[] = $subscription->id;
      }

      return $subscription_ids;
    }


    public function get_id() {

      return $this->get_property('id');
    }


    public function get_property($property_name) {

      if(empty($this->member)){
        echo 'Couldnt get property, member object was empty<br>';
        return 0;
      }
      if(!property_exists($this->member, $property_name)){
        echo 'Couldnt get property, property didnt exist<br>';
        return 0;
      }

      return $this->member->$property_name;
    }

  }
}
