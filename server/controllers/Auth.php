<?php 

require_once 'misc/Helper.php';

require_once 'models/User.php';

class AuthController extends User
{
     public function inherited() {
        $this->overriden();
    }

    public function __construct()
    {
        parent::__construct();
    }
    

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
        
        $student_id = $this->get_user_by($body['email'],$password);        

        if(!isset($student_id))
            return $response->withJson(Array('response'=>'User does not exist.'),400);
        
        $token = Helper::sign_token($student_id);
        
        return $response->withJson(Array('response'=> 'Success', 'token' => $token),200);
    }

    public function register($request, $response, $args) 
    {
        $body = $request->getParsedBody();

        $this->validation($body,$response);

        if(!isset($body['first_name']) || !isset($body['last_name']))
            return $response->withJson(Array('response'=>'Missing First Name or Last Name'),400);

        $secondValidation = Helper::validate([
            $body['first_name'] => FILTER_SANITIZE_STRING,
            $body['last_name'] => FILTER_SANITIZE_STRING,
        ]);
        if($secondValidation != True)
            return $response->withJson(Array('response'=>'Harmful code detected on '.(string)$secondValidation),400);

        $password = Helper::encrypt($body['password']);
        
        if($this->exist($body['email'],$password))
            return $response->withJson(Array('response'=>'An User with this email address already exists.'),400);
        
        
        $student_id = $this->create_user($body['first_name'],$body['last_name'],$body['email'],$password);        
        
        if(!$student_id)
            return $response->withJson(Array('response'=>'There was an error and your account could not be created.'),400);

        $token = Helper::sign_token($student_id);

        return $response->withJson(Array('response'=> 'Success', 'token' => $token),200);
    }
}

?>