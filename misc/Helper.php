<?php

use \Firebase\JWT\JWT;


class Helper
{
    public static function encrypt($data)
    {
        return md5($data);
    }

    public static function check_email($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function sign_token($data)
    {
        return JWT::encode($data,getenv('APP_SECRET_KEY'));
    }

    public static function check_token($token)
    {
        try
        { 
            $decodejwt = (array) JWT::decode($token, getenv('APP_SECRET_KEY'), array('HS256'));
            return True;
        } 
        catch(\Exception $e) 
        { 
            return $e; 
        }

    }

    public static function check_admin_token($token)
    {
        try
        { 
            $decodejwt = (array) JWT::decode($token, getenv('APP_SECRET_ADMIN_KEY'), array('HS256'));
            return True;
        } 
        catch(\Exception $e) 
        { 
            return $e; 
        }

    }

    public static function decrypt($token)
    {
        try
        { 
            $decodejwt = (array) JWT::decode($token, getenv('APP_SECRET_KEY'), array('HS256'));
            return $decodejwt;
        } 
        catch(\Exception $e) 
        { 
            return $e; 
        }
    }

    public static function validate($arr)
    {
        foreach($arr as $key => $value)
        {
            if(!filter_var($key, $value))
                return $key;
        }

        return True;
    }

 
}

?>