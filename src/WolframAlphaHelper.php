<?php

namespace PHPFuzzy;

/**
 * Class WolframAlphaHelper
 * @package PHPFuzzy
 *
 */
class WolframAlphaHelper
{

    private static $appid = "5HH797-6YXTVV6TJJ";
    private static $home = "http://api.wolframalpha.com/v2/";
    private static $output = "JSON";
    private static $format = "plaintext";

    /**
     * @param $endpoint
     * @param $params
     * @return array|bool|mixed|string
     */
    public static function request($endpoint, $params)
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, self::$home . $endpoint . self::convertParams($params));
            var_export($params);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($ch);
            if ($response == false) {
                throw new \Exception(curl_error($ch), curl_errno($ch));
            }
            $response = json_decode($response);
        } catch (\Exception $e) {
            //Handling CURL errors
            $response = array(
                "status" => "ERROR",
                "error_code" => $e->getCode(),
                "error_description" => $e->getMessage()
            );
        }
        return $response;
    }

    /**
     * @param $params
     * @return string
     */
    public static function convertParams(&$params)
    {
        $params["appid"] = self::$appid;
        $params["output"] = self::$output;
        $params["format"] = self::$format;
        return "?" . implode("&", array_map(function ($e, $i) {
                $e = urlencode($e);
                return "{$i}={$e}";
            },
                $params, array_keys($params)));
    }

    /**
     * @param $query
     * @return array|bool|mixed|string
     */
    public static function query($query)
    {
        return self::request("query", ["input" => $query]);
    }

    /**
     * @param $matrix
     * @return string
     */
    public static function convertMatrix($matrix)
    {
        $rows = implode(",", array_map(function ($e) {
            $stringRow = implode(",", $e);
            return "{{$stringRow}}";
        }, $matrix));
        return "{{$rows}}";
    }
}

?>