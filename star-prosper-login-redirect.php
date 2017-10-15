<?php

/*
Plugin Name:  Star Prosper Login Redirect
Description:  Redirect login for Star Prosper member site depending on subscription
Version:      0.1
Author:       Matt Wills
Author URI:   https://github.com/mattwills8
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/

include_once(ABSPATH . 'wp-includes/pluggable.php');

require_once( plugin_dir_path( __FILE__ ) . 'Config.php' );
require_once( plugin_dir_path( __FILE__ ) . 'Requests.php' );
require_once( plugin_dir_path( __FILE__ ) . 'Subscriptions.php');
require_once( plugin_dir_path( __FILE__ ) . 'RedirectFactory.php');


if(!class_exists('StarProsperLoginRedirect')){

  class StarProsperLoginRedirect {

    public $user;
    public $member;

    public function __construct() {

      $this->user = wp_get_current_user();
    }


    public function login_redirect(){

    	if ( ! isset( $this->user->ID ) ) {
        echo 'Couldnt get user ID...<br>';
        if(wp_redirect( home_url() )) {
            exit;
        }
      }

      $this->member = new StarMember($this->user->ID);

    	$subscription_ids = $this->member->get_subscription_ids();

      if(empty($subscription_ids)){
        if(wp_redirect( home_url() )) {
            exit;
        }
      }

      $redirects = new RedirectFactory();
      $redirect_url = $redirects->get_redirect_url_from_arr( $subscription_ids );

      wp_redirect( $redirect_url  );
      die;

    }


  }
}

function StarProsperLoginRedirect_init() {


  $star_config = new StarConfig();

  if(is_page( $star_config->show_on_pages )){
    $star_redirect = new StarProsperLoginRedirect();
    $star_redirect->login_redirect();
  }

}
add_action( 'template_redirect', 'StarProsperLoginRedirect_init' );

?>
