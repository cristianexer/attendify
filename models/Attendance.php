<?php

require_once 'connectors/PDO.php';


class Attendance extends DB
{
    public function inherited()
    {
        $this->overriden();
    }

    private $table = 'attendance';

    private $columns = [
        'id' => 'MEDIUMINT NOT NULL AUTO_INCREMENT',
        'building_name' => 'VARCHAR(255) NOT NULL',
        'room_id' => 'VARCHAR(100) NOT NULL',
        'student_id' => 'VARCHAR(100) NOT NULL',
        'created_at' => 'DATETIME',
        'PRIMARY KEY'  => '(id)'
    ];

    public function __construct()
    {
        parent::__construct();
        if(!$this->table_exists($this->table))
        {
            $this->migrate();
            error_log($this->table." table created.");
        }
    }

    // protected function exist($email,$password)
    // {
    //     $check =  $this->fetch("SELECT student_id FROM users WHERE email= ? AND password= ?;",[$email,$password])->rowCount();
    //     return $check > 0 ? True : False;
    // }

    protected function get_attendance_by($student_id)
    {
        $check =  $this->fetch("SELECT * FROM ".$this->table."  WHERE student_id= ? ",[$student_id])->fetchAll(PDO::FETCH_ASSOC);

        return $check;
    }

    protected function create_attendance($building_name,$room_id,$student_id)
    {
        $creation = $this->query("INSERT INTO ".$this->table." (building_name, room_id, student_id, created_at) VALUES (?,?,?,NOW());",[
            $building_name,
            $room_id,
            $student_id,
            ]);

        return $creation !== False ? True : False;
    }


    private function migrate()
    {
        return $this->create_table($this->table, $this->columns);
    }


}


?>