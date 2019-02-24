<?php

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

    public static function sign_token($token)
    {
        return $token;
    }

    public static function check_token($token)
    {
        return $token;
    }

    public static function decrypt($token)
    {
        return $token;
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