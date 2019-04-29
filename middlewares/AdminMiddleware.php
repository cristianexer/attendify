<?php 

require_once 'misc/Helper.php';

class AdminMiddleware
{

    public function __invoke($request, $response, $next)
    {
        
        preg_match('/Bearer\s(\S+)/', $request->getHeader('Authorization')[0], $matches);
        $auth = $matches[1];
        if(!isset($auth))
        {
            return $response->withJson(Array('response'=>'Missing authorization token'),400);
        }

        $token_meta = Helper::check_admin_token($auth);
        
        return $token_meta === True? $next($request, $response) : $response->withJson(Array('response'=> 'Invalid token'),400);
        

        
    }

}

?>