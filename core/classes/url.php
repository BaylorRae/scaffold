<?php !defined('IN_APP') && header('location: /');

class Url {
    public static function request($stripBase = true) {
        //  ALL IN UPPERCASE
        $current = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL);
        
        //  Strip the base path out
        if($stripBase === true) {
            $current = str_replace(PUBLIC_PATH, '', $current);
        }
        
        //  Stop any stupid amount of slashes
        //  http://your.app/index//////testing// works the same as http://your.app/index/testing now
        $current = preg_replace('/[\/]+/', '/', $current);
        
        //  Strip off the last character, if it's a slash
        if(substr($current, -1) === '/') {
            $current = substr($current, 0, strlen($current) - 1);
        }
        
        return $current;
    }
    
    public static function segment($which, $fallback = '') {
        //  Get all of the segments as an array
        $segments = explode('/', self::request());
        
        //  Return our segments
        $seg = (isset($segments[$which]) and !empty($segments[$which])) ? $segments[$which] : 'index';
        
        //  If we have a segment, and it's not an index page, give it back
        if($seg) {
            return $seg;
        }
    
        return $fallback;
    }
    
    public static function stripTags($segment) {
        return strip_tags($segment);
    }
}