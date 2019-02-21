<?php 

require_once 'misc/Helper.php';

class AuthController
{
    private function validation($body, $response)
    {
        if(!isset($body['email']) || !isset($body['password']))
            return $response->withJson(Array('response'=>'Missing email or password'),400);

        if(!Helper::check_email($body['email']))
            return $response->withJson(Array('response'=>'Invalid email address.'),400);
        
        return true;
    }

    public function login($request, $response, $args) 
    {
        $body = $request->getParsedBody();

        $this->validation($body,$response);
        
        $password = Helper::encrypt($body['password']);
        
        $user_id = 'Get user id by email address and password';

        if(!isset($user_id))
            return $response->withJson(Array('response'=>'User does not exist.'),400);
        
        $token = Helper::sign_token($user_id);
        
        return $response->withJson(Array('response'=> 'Success', 'token' => $token),200);
    }

    public function register($request, $response, $args) 
    {
        $body = $request->getParsedBody();

        $this->validation($body,$response);
        
        $password = Helper::encrypt($body['password']);

        $userExist = False;
        
        if($userExist)
            return $response->withJson(Array('response'=>'An User with this email address already exists.'),400);

        $user_id = 'Get user id by email address and password';
        
        $token = Helper::sign_token($user_id);

        return $response->withJson(Array('response'=> 'Success', 'token' => $token),200);
    }
}

?>