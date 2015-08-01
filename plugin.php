<?php
/*
Plugin Name: AIESEC Global Host Registration 
Description: Plugin for Podio registration for Global Host program connected to Marketing Tracking Tool
Version: 0.2
Author: Krzysztof Jackowski
Author URI: https://www.linkedin.com/profile/view?id=202008277&trk=nav_responsive_tab_profile_pic
License: GPL 
*/
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

// [global-host-form]

function global_host( $atts ) {

    wp_enqueue_script('jquery');

    $a = shortcode_atts( array(
        'program' => '',
    ), $atts );
    
    echo wp_enqueue_style( 'style-name', plugins_url('style.css', __FILE__ ));
    
    $uniqid = uniqid();

    if(isset($_GET['utm_source'])){
        $utm_source = $_GET["utm_source"];
    }else{
        $utm_source = "generic";
    }
    if(isset($_GET['utm_medium'])){
        $utm_medium = $_GET["utm_medium"];
    }else{
        $utm_medium = "generic";
    }
    if(isset($_GET['utm_campaign'])){
        $utm_campaign = $_GET["utm_campaign"];
    }else{
        $utm_campaign = "generic";
    }
    if(isset($_GET['bucket'])){
        $bucket = $_GET["bucket"];
    }else{
        $bucket = "n/d";
    }

    if(isset($_GET['lc'])){
        $lc = $_GET["lc"];
    }else{
        $lc = "n/d";
    }

    $program = 'gh';

    if($bucket==""){
        $bucket = "n/d";   
    }
    //check if lead parameters where provided if not set to generic
    if($utm_source==""){
        $utm_source = "generic";   
    }
    if($utm_medium==""){
        $utm_medium = "generic";   
    }
    if($utm_campaign==""){
        $utm_campaign = "generic";   
    }

    $form = file_get_contents('form.html',TRUE);
    
    $form = str_replace("{utm_source}",$utm_source,$form);
    $form = str_replace("{utm_medium}",$utm_medium,$form);
    $form = str_replace("{utm_campaign}",$utm_campaign,$form);
    $form = str_replace("{bucket}",$bucket,$form);
    $form = str_replace("{lc}",$lc,$form);
    $form = str_replace("{uniqid}",$uniqid,$form);
    $form = str_replace("{program}",$program,$form);
    $form = str_replace("{path-manage_registration}",plugins_url('manage_registration.php', __FILE__ ),$form);
    $form = str_replace("{path-manage_leads}",plugins_url('manage_leads.php', __FILE__ ),$form);
    $form = str_replace("{path-podio_api.php}",plugins_url('podio_api.php', __FILE__ ),$form);
    $actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $form = str_replace("{website_url}",$actual_link,$form);

    if(isset($_GET["thank_you"]) && $_GET["thank_you"]==="true"){
        return "<p>Dziękujemy bardzo za rejestrację. Wkrótce się z Tobą skontaktujemy!</p>";  
    } elseif (isset($_GET["error"]) && $_GET["error"]!=""){
        
        $form = str_replace('<div id="error" class="error"><p></p></div>','<div id="error" class="error"><p>'.$_GET["error"].'</p></div>',$form);
        return $form;    
    }
    //var_dump( plugins_url('gis_reg_process.php', __FILE__ ));
    return $form;
}
add_shortcode( 'global-host-form', 'global_host' );

?>
