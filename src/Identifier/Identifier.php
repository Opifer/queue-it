<?php

namespace Opifer\QueueIt\Identifier;

class Identifier
{
    /**
     * @return  string
     */
    public function guid()
    {
        mt_srand((double)microtime()*10000);
        $charid = strtolower(md5(uniqid(rand(), true)));
        $hyphen = chr(45);
        $uuid = substr($charid, 0, 8).$hyphen
        .substr($charid, 8, 4).$hyphen
        .substr($charid,12, 4).$hyphen
        .substr($charid,16, 4).$hyphen
        .substr($charid,20,12);

        return $uuid;
    }

    /**
     * @return  string
     */
    public function currentUrl()
    {
        $ssl = isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on";

        $pageURL = 'http';
        if ($ssl) {$pageURL .= "s";}
        $pageURL .= "://";
        if ((!$ssl && $_SERVER["SERVER_PORT"] != "80") || ($ssl && $_SERVER["SERVER_PORT"] != "443"))  {
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }
}
