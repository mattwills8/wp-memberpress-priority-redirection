<?php

require_once( plugin_dir_path( __FILE__ ) . 'Config.php');

if(!class_exists('RedirectFactory')){

  class RedirectFactory {

    private $config;
    public $redirect_id;
    public $redirect_url;
    public $redirect_arr;

    public function __construct() {

      $this->config = new StarConfig();

      $this->redirect_arr = $this->config->redirect_arr;
    }


    public function get_redirect_url_from_arr( $redirect_id_arr ) {

      foreach($this->redirect_arr as $page) {
        foreach($redirect_id_arr as $redirect_id){
          if($redirect_id === $page['id']) {
            return $page['url'];
          }
        }
      }
      return 0;
    }


    public function get_redirect_url_from_id( $redirect_id ) {

      if(array_key_exists($redirect_id, $this->redirect_arr)) {
        return $this->redirect_arr[$redirect_id];
      }

      echo 'Subscription ID did not exist as key in array...<br>';
      return 0;
    }

  }
}

?>
