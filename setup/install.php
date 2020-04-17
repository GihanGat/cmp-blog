<?php
class Installer{
    function dbconfigure() {
        // require(ROOT . "/private/core/config/database.php");
        require(ROOT . "/mvc-app/private/core/config/database.php");
    }

    function dbinstall(){}
        if (isset($this->config["databse"])) {
            try {
                $this->db = new PDO($this->config["database"]["driver"] .
                    ":host=" . $this->config["database"]["dbhost"] .
                    ";dbname=" . $this->config["database"]["dbname"]
                    , $this->config["database"]["username"]
                    , $this->config["database"]["passord"]);

                    $sql = file_get_contents("setup/data/init.sql");
                    $this->db->exec($sql);
                    echo("Detabse has been setup");
            } catch(PDOException $ex) {
                echo($ex->getMessage);
            }
        }
    }

}

$installer = new Installer();
$installer->dbconfigure();
$installer->dbinstall();
?>