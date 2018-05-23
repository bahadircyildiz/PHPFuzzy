<?php

namespace PHPFuzzy;
use PHPFuzzy\Models\Alternative;

class WolframAlphaHelper{

    private static $appid = "5HH797-6YXTVV6TJJ";
    private static $home = "http://api.wolframalpha.com/v2/";
    private static $output = "JSON";
    private static $format = "plaintext";

    public static function request($endpoint, $params){
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, self::$home.$endpoint.self::convertParams($params)); 
            var_export(self::convertParams($params));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($ch);
            if($response == false){
                throw new \Exception(curl_error($ch), curl_errno($ch));
            }
            $response = json_decode($response);
        } catch (\Exception $e) {
            //Handling CURL errors
            $response = array("status"=>"ERROR", "error_code"=> $e->getCode(), "error_description"=>$e->getMessage());
        }
        return $response;
    }

    public static function convertParams(&$params){
        $params["appid"] = self::$appid;
        $params["output"] = self::$output;
        $params["format"] = self::$format;
        return "?".implode("&", array_map(function($e, $i)
                                {   $e = urlencode($e);
                                    return "{$i}={$e}"; }, 
                            $params, array_keys($params)));
    }

    public static function query($query){
        return self::request("query", ["input" => $query]);
    }

    public static function convertMatrix($matrix){
        $rows = implode(",", array_map(function($e){
            $stringRow = implode(",", $e);
            return "{{$stringRow}}";
        }, $matrix));
        return "{{$rows}}";
    }
}

?>