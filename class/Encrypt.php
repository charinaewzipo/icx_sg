<?php

class Encryption {
    private static $key = "tubtim";
    public static  function encrypt($data) {
        if(!$data) return $data;
        $encodedData = base64_encode($data . self::$key);
        return $encodedData;
    }

    // Decode with a key (Base64)
    public static function decrypt($encodedData) {
        if ( base64_encode(base64_decode($encodedData, true)) !== $encodedData || !$encodedData) return $encodedData;
        $decodedData = base64_decode($encodedData);
        $data = substr($decodedData, 0, -strlen(self::$key));
        return $data;
    }
    
}
    
?>