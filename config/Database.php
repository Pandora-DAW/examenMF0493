<?php
define('HOST','localhost');
define('PORT', '3306'); // por defeceto es el 3306
define('DBNAME', 'tienda_web');
define('USER', 'root');
define('PASSWORD', '');

class Database {

    private static $instanciaBD =null;
    private $bd;

    private function __construct() {
        // mysql:localhost:3306;dbname=NOMBREBD
        // mysql:host=127.0.0.1;port=3307;dbname=users_web
        //echo 'mysql:host='.HOST.';port='.PORT.';dbname='.DBNAME;

        $this->bd = new PDO(
            'mysql:host='.HOST.';port='.PORT.';dbname='.DBNAME, 
            USER, PASSWORD
        );
    }
    public static function getInstancia() {
        if (self::$instanciaBD=== null) {
            self::$instanciaBD = new Database();
        }
        return self::$instanciaBD->bd;
    } 
    
}

?>
