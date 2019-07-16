<?php
class ModelStep_4 extends Model {
    
    private $config_file;
    private $sql_file;

    private $dbhost = 'localhost';
    private $dbname = '';
    private $dbuser = '';
    private $dbpassword = '';
    
    private $dbc = '';
    private $result = array();
    
    public function __construct($lang_file) {
        parent::__construct($lang_file);
        
        $this->config_file = dirname(dirname(__DIR__ )) . '/config/config.php';
        $this->sql_file = dirname(__DIR__ ) . '/source/okay_clean.sql';
        
        if(isset($_POST['dbhost']) && !empty($_POST['dbhost'])) {
            $this->dbhost = trim($_POST['dbhost']);
        }
        if(isset($_POST['dbname']) && !empty($_POST['dbname'])) {
            $this->dbname = trim($_POST['dbname']);
        }
        if(isset($_POST['dbuser']) && !empty($_POST['dbuser'])) {
            $this->dbuser = trim($_POST['dbuser']);
        }
        if(isset($_POST['dbpassword'])) {
            $this->dbpassword = addcslashes(html_entity_decode(trim($_POST['dbpassword'])), "\"\\");
        }
    }
    
    public function dbconfig() {
        
        $this->result['dbhost'] = $this->dbhost;
        $this->result['dbname'] = $this->dbname;
        $this->result['dbuser'] = $this->dbuser;
        $this->result['dbpassword'] = $this->dbpassword;
        
        if(empty($this->dbname)) {
            $this->result['errors'][] = $this->get_translation('error_empty_dbname');
        }
        
        if(empty($this->dbuser)) {
            $this->result['errors'][] = $this->get_translation('error_empty_dbuser');
        }
        
        if(!empty($this->dbuser) && !empty($this->dbname)) {
            if(!$this->dbc = @mysqli_connect($this->dbhost, $this->dbuser, stripcslashes($this->dbpassword))) {
                $this->result['errors'][] = $this->get_translation('error_mysql_connect');
            } else if(!mysqli_select_db($this->dbc, $this->dbname)) {
                $this->result['errors'][] = strtr($this->get_translation('error_dbname_doest_exist'), array('{$dbname}'=>$this->dbname));
            } else if(!mysqli_query($this->dbc, 'SET NAMES utf8')) {
                $this->result['errors'][] = $this->get_translation('error_mysql_connect');
            }
            
            if(!is_readable($this->sql_file)) {
                $this->result['errors'][] = $this->get_translation('error_sql_file_not_found');
            }
            
            if(!is_writable($this->config_file)) {
                $this->result['errors'][] = $this->get_translation('error_config_file_not_writable');
            }
            
            if(empty($this->result['errors'])) {
                $this->set_config();
                $this->mysql_restore_dump();
                $this->result['db_configured'] = true;
            }
        }
        
        return $this->result;
    }
    
    private function set_config() {
        $conf = file_get_contents($this->config_file);
        $conf = preg_replace("/db_name\s*=.*\n/i", "db_name = ".$this->dbname."\r\n", $conf);
        $conf = preg_replace("/db_server\s*=.*\n/i", "db_server = ".$this->dbhost."\r\n", $conf);
        $conf = preg_replace("/db_user\s*=.*\n/i", "db_user = ".$this->dbuser."\r\n", $conf);
        $conf = preg_replace("/db_password\s*=.*\n/i", "db_password = \"".$this->dbpassword."\"\r\n", $conf);

        file_put_contents($this->config_file, $conf);
    }
    
    private function mysql_restore_dump() {
        $sql_query = '';
        $fp = fopen($this->sql_file, 'r');

        if($fp) {
            while(!feof($fp)) {
                $line = fgets($fp);
                
                if (substr($line, 0, 2) != '--' && $line != '') {
                    $sql_query .= $line;
                    
                    if (substr(trim($line), -1, 1) == ';') {
                        
                        if(!@mysqli_query($this->dbc, $sql_query)) {
                            $this->result['errors'][] = mysqli_error($this->dbc);
                        }
                        $sql_query = '';
                    }
                }
            }
        }

        fclose($fp);
    }
}