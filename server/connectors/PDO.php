<?php 
class DB
{
     protected $pdo;

     public function __construct($file = 'pdo_config.ini')
     {

          if (!$settings = parse_ini_file($file, TRUE)) throw new exception('Unable to open ' . $file . '.');
          try
          {    
               $this->pdo = new PDO( 
                    $settings['database']['driver'].
                    ':host='. $settings['database']['host'] .
                    ';dbname='. $settings['database']['name'],
                    $settings['database']['username'],
                    $settings['database']['password']
               );

          } 
          catch (PDOException $e)
          {
               error_log("Error: ".$e);
               die();
          }
          
     }
     

     protected function fetch($query, $params=null)
     {    try
          {
               if(isset($params))
               {
                    $stmt = $this->pdo->prepare($query);
                    $stmt->execute($params);
                    return $stmt;
               }
               else
               {
                    return $this->pdo->query($query);
               }
          }
          catch(PDOException $e)
          {
               error_log("Error: ".$e);
               return False;
          }
          

     }

     protected function query($query, $params=null)
     {    try
          {
               if(isset($params))
               {
                    $stmt = $this->pdo->prepare($query);
                    
                    $result = $stmt->execute($params);
                    return $result;
               }
               else
               {
                    return $this->pdo->query($query);
               }
          }
          catch(PDOException $e)
          {
               error_log("Error: ".$e);
               return False;
          }
          

     }

     
     protected function table_exists($table)
     {
          $check = $this->pdo->query("SELECT 1 FROM `".$table."` LIMIT 1");
          return $check === False ? False : True;
     }

     protected function create_table($table, $columns)
     {
          $q = "DROP TABLE IF EXISTS ".$table."; CREATE TABLE  ".$table." (\n";
          $q_end = ");";
          $len = sizeof($columns);
          foreach($columns as $key => $value)
          {    
               $com= $len == 1 ? "\n" : ",\n";
               $q .= (string)$key." ".(string)$value.$com;
               $len--;
          }
          return $this->query($q.$q_end);

     }

     public function __destruct()
	{
		$this->pdo = null;
     }

}

?>