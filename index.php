<?php

    /* 
    Plugin Name: csAlexa
    Description: Adds Alexa verification code to website
    Author: Stephan Gerlach
    Version: 1.0.1 
    Author URI: http://www.computersniffer.com
    */  
    
    // add admin menu
    add_action('admin_menu', 'csAlexa_admin_menu');
    function csAlexa_admin_menu() {
        add_menu_page('csAlexa', 'csAlexa', 'administrator', 'csAlexa_code', 'csAlexa_code');
    }
    

    // options page    
    function csAlexa_code() {
        
        global $wpdb;
        
        // check permissions
        if (!current_user_can('manage_options'))  {
    	   	wp_die( __('You do not have sufficient permissions to access this page.') );
    	}
        
        // check if update is sent
        if (isset($_POST['csalexa'])) {
            
            // try to get verification key
            $opt = get_option('csalexa_verification_code');
            
            // if verification key exists update key
            if (!(!$opt) || $opt=='') {
                update_option('csalexa_verification_code',$_POST['csalexa']);
            }
            // if no key exists (first run) insert key
            else {
                add_option('csalexa_verification_code',$_POST['csalexa']);
            }
            
        }
        
        // load verification key
        $opt = get_option('csalexa_verification_code');
        if (!$opt) {
            $opt = '';
        }
        
        // form output
    	echo '<div class="wrap">';
        echo '<h2>Alexa Verification Code</h2>';
        
        echo '<form action="" method="post">';
        echo '<label for="csalexa">Alexa Verification Code</label>: 
                <input type="text" name="csalexa" id="csalexa" value="'.$opt.'" size="50" />';
        echo '<br /><input type="submit" name="csalexa_save" value="Save" />';
        echo '</form>';
        
    }
        
    
    // add action for inserting code in <head>
    add_action('wp_head', 'csAlexa_add_code');
    
    function csAlexa_add_code() {
        
        global $wpdb;
        $opt = get_option('csalexa_verification_code');
        if (!(!$opt)) {
            echo '<meta name="alexaVerifyID" content="'.$opt.'" />'."\n";
        }
        
    }
    
    
    
    
?>