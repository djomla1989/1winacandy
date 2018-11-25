<?php

class Utilities {
    
    /**
     * Method will return tody in timestamp
     * 
     * Today = day beggining
     * @return type
     */
    public static function getToday() {
        return strtotime("00:00:00");
    }
    
    public static function getPrices() {
        $CI = &get_instance();
        return $CI->config->item('prices');
    }
    
    public static function getPayPalConfig() {
        $CI = &get_instance();
        return $CI->config->item('paypal');
    }
}