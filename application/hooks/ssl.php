<?php
function redirect_ssl() {
    $CI =& get_instance();
    $class = $CI->router->fetch_class();
    $exclude =  array();  // included pages
    if(!in_array($class,$exclude)) {
      // redirecting to ssl.
      $CI->config->config['base_url'] = str_replace('http://', 'https://', "http://fundronline.com");
      if ($_SERVER['SERVER_PORT'] != 443) ciredirect($CI->uri->uri_string());
    } 
    else {
      // redirecting with no ssl.
      $CI->config->config['base_url'] = str_replace('https://', 'http://', "http://fundronline.com");
      if ($_SERVER['SERVER_PORT'] == 443) ciredirect($CI->uri->uri_string());
    }
}
?>