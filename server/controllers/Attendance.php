<?php 

class AttendanceController
{

    public static function get($request, $response, $args) 
    {
        return $response;
    }

    public static function get_last_attendance_by_user_id($request, $response, $args) 
    {
        if(!isset($args['user_id']))
        {
            return $response->withJson(array('response' => 'Missing Argument'), 400);
        }

        $attendance = $args['user_id'];
    
        return $response->withJson(array('response' => 'Success', 'attendance' => $attendance), 200);
   }

   public static function post($request, $response, $args)
   {

        return $response;
   }

}

?>