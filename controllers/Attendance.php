<?php 

require_once 'misc/Helper.php';

require_once 'models/Attendance.php';

class AttendanceController extends Attendance
{
    public function inherited()
    {
        $this->overriden();
    }

    public function __construct()
    {
        parent::__construct();
    }

    public function get($request, $response, $args) 
    {
        if(!isset($args['student_id']))
            return $response->withJson(array('response' => 'Missing parameter student_id'), 400);

        $secondValidation = Helper::validate([
            $args['student_id'] => FILTER_SANITIZE_STRING
        ]);

        if($secondValidation != True)
            return $response->withJson(Array('response'=>'Harmful code detected on '.(string)$secondValidation),400);

        $attendance = $this->get_attendance_by($args['student_id']);
    
        return $response->withJson(array('response' => 'Success', 'attendance' => $attendance), 200);
   }

   private function validation($body,$res)
   {
    if(!isset($body['student_id']) || !isset($body['building_name']) || !isset($body['room_id']))
            return $response->withJson(array('response' => 'Missing parameters'), 400);

         $secondValidation = Helper::validate([
            $body['student_id'] => FILTER_SANITIZE_STRING,
            $body['building_name'] => FILTER_SANITIZE_STRING,
            $body['room_id'] => FILTER_SANITIZE_STRING,
        ]);

        if($secondValidation != True)
            return $response->withJson(Array('response'=>'Harmful code detected on '.(string)$secondValidation),400);
   }

   public function create($request, $response, $args)
   {
        $body = $request->getParsedBody();
        $this->validation($body,$response);
        
        $attendance = $this->create_attendance($body['building_name'], $body['room_id'],$body['student_id']);

        if($attendance)
            return $response->withJson(Array('response'=>'Attendance registered with success.'),200);

        return $response->withJson(Array('response'=>'There was an error and your attendance could not be created.'),400);
   }

   

}

?>