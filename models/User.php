<?php

require_once 'connectors/PDO.php';


class User extends DB
{
    public function inherited() {
        $this->overriden();
    }

    private $table = 'users';

    private $columns = [
        'id' => 'MEDIUMINT NOT NULL AUTO_INCREMENT',
        'first_name' => 'VARCHAR(100) NOT NULL',
        'last_name' => 'VARCHAR(100) NOT NULL',
        'password' => 'VARCHAR(255) NOT NULL',
        'email' => 'VARCHAR(255) NOT NULL UNIQUE',
        'student_id' => 'VARCHAR(30) NOT NULL',
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

    protected function exist($email,$password)
    {
        $check =  $this->fetch("SELECT student_id FROM ".$this->table."  WHERE email= ? AND password= ?;",[$email,$password])->rowCount();
        return $check > 0 ? True : False;
    }

    protected function get_user_by($email,$password)
    {
        $check =  $this->fetch("SELECT student_id FROM ".$this->table."  WHERE email= ? AND password= ?;",[$email,$password])->fetch()[0];

        return $check;
    }

    protected function create_user($first_name,$last_name,$email,$password)
    {
        $student_id = strtoupper(substr($last_name, 0, 3)).(string)rand(1000,9000);
        $creation = $this->query("INSERT INTO ".$this->table." (first_name, last_name, email, password, student_id) VALUES (?,?,?,?,?);",[
            $first_name,
            $last_name,
            $email,
            $password,
            $student_id
            ]);

        return $creation !== False ? True : False;
    }

    protected function get_student_id_by($email)
    {
        $check =  $this->fetch("SELECT student_id FROM ".$this->table."  WHERE email= ?;",[$email])->fetch()[0];

        return $check;
    }

    private function migrate()
    {
        return $this->create_table($this->table, $this->columns);
    }


}


?>