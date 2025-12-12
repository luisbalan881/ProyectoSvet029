<?php




if (!isset($_SERVER['HTTP_REFERER'])){

echo "<script type='text/javascript'> window.location='index.php'; </script>";
exit();


}

else {
class Database
{
   
    
     //private static $dbName = 'bd_svet_nueva';
    //private static $dbName = 'bd_svet2020';
     private static $dbName = 'svet_029';
    private static $dbHost = 'localhost' ;
    private static $dbUsername = 'root';
    private static $dbUserPassword = '';
    private static $cont  = null;
    
    

    public function __construct() {
        die('Init function is not allowed');
    }

    public static function connect()
    {
        // One connection through whole application
        if ( null == self::$cont )
        {
            try
            {
                self::$cont =  new PDO( "mysql:host=".self::$dbHost.";charset=utf8;"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword);
            }
            catch(PDOException $e)
            {
                die($e->getMessage());
            }
        }
        return self::$cont;
    }

    public static function disconnect()
    {
        self::$cont = null;
    }

}
}
