<?php 

require_once 'misc/Helper.php';

class AuthMiddleware
{

    public function __invoke($request, $response, $next)
    {
        
        preg_match('/Bearer\s(\S+)/', $request->getHeader('Authorization')[0], $matches);
        $auth = $matches[1];
        if(!isset($auth))
        {
            return $response->withJson(Array('response'=>'Missing authorization token'),400);
        }

        $token_meta = Helper::check_token($auth);
        
        if($token_meta)
        {
            return $next($request, $response);
        }
        else
        {
            return $response->withJson(Array('response'=>$token_meta),400);

        }
    }

}

?>