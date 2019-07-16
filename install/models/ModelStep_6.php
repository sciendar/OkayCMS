<?php
class ModelStep_6 extends Model {
    
    private $result = array();
    private $login;
    private $password;
    private $email;
    private $phone;
    private $config;
    private $dbc;
    private $current_dir;
    
    public function __construct($lang_file) {
        parent::__construct($lang_file);
        
        $this->config_file = dirname(dirname(__DIR__ )) . '/config/config.php';
        
        if(isset($_POST['login']) && !empty($_POST['login'])) {
            $this->login = trim($_POST['login']);
        }
        if(isset($_POST['password']) && !empty($_POST['password'])) {
            $this->password = trim($_POST['password']);
        }
        if(isset($_POST['email']) && !empty($_POST['email'])) {
            $this->email = trim($_POST['email']);
        }
        if (isset($_POST['phone']) && !empty($_POST['phone'])) {
            $this->phone = trim($_POST['phone']);
        }
        
        $this->config = (object)parse_ini_file($this->config_file);
    }
    
    public function admin_conf() {
        
        $this->result['login']    = $this->login;
        $this->result['password'] = $this->password;
        $this->result['email']    = $this->email;
        $this->result['phone']    = $this->phone;
        
        $this->current_dir = dirname(dirname(__DIR__ ));
        
        if(isset($_POST['admin_conf'])) {
            if(empty($this->config)) {
                $this->result['errors'][] = $this->get_translation('error_empty_config');
            }
            if(empty($this->login)) {
                $this->result['errors'][] = $this->get_translation('error_empty_login');
            }
            if(empty($this->password)) {
                $this->result['errors'][] = $this->get_translation('error_empty_password');
            }
            if(empty($this->email)) {
                $this->result['errors'][] = $this->get_translation('error_empty_email');
            }
            if(empty($this->phone)) {
                $this->result['errors'][] = $this->get_translation('error_empty_phone');
            }
            
            if(empty($this->result['errors'])) {
                $encpassword = $this->crypt_apr1_md5();
                
                $this->dbc = mysqli_connect($this->config->db_server, $this->config->db_user, $this->config->db_password, $this->config->db_name);
                mysqli_set_charset($this->dbc, $this->config->db_charset);
                mysqli_query($this->dbc, "DELETE FROM ".$this->config->db_prefix."managers");
                
                if(mysqli_query($this->dbc, "INSERT INTO ".$this->config->db_prefix."managers SET id=1, login='".$this->login."', password='".$encpassword."'")) {
                    
                    if(!empty($this->email)) {
                        mysqli_query($this->dbc, "UPDATE `".$this->config->db_prefix."settings` SET `value`='".$this->email."' WHERE `param`='order_email' OR `param`='comment_email' OR `param`='notify_from_email' OR `param`='admin_email'");
                    }
                    if(!empty($this->phone)) {
                        mysqli_query($this->dbc, "INSERT INTO ".$this->config->db_prefix."settings SET `param`='admin_phone', `value`='".$this->phone."'");
                    }
                    
                    unset($_SESSION['admin']);
                    $this->result['success'] = new stdCLass;
                    $this->result['success']->title = $this->get_translation('settings_have_set');
                    
                } else {
                    $this->result['errors'][] = $this->get_translation('error_add_manager');
                }
            }
        }
        return $this->result;
    }
    
    private function crypt_apr1_md5() {
        $salt = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, 8);
        $len = strlen($this->password);
        $text = $this->password.'$apr1$'.$salt;
        $bin = pack("H32", md5($this->password.$salt.$this->password));
        for($i = $len; $i > 0; $i -= 16) { $text .= substr($bin, 0, min(16, $i)); }
        for($i = $len; $i > 0; $i >>= 1) { $text .= ($i & 1) ? chr(0) : $this->password{0}; }
        $bin = pack("H32", md5($text));
        for($i = 0; $i < 1000; $i++) {
            $new = ($i & 1) ? $this->password : $bin;
            if ($i % 3) $new .= $salt;
            if ($i % 7) $new .= $this->password;
            $new .= ($i & 1) ? $bin : $this->password;
            $bin = pack("H32", md5($new));
        }
        $tmp = '';
        for ($i = 0; $i < 5; $i++) {
            $k = $i + 6;
            $j = $i + 12;
            if ($j == 16) $j = 5;
            $tmp = $bin[$i].$bin[$k].$bin[$j].$tmp;
        }
        $tmp = chr(0).chr(0).$bin[11].$tmp;
        $tmp = strtr(strrev(substr(base64_encode($tmp), 2)),
        "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/",
        "./0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz");
        return "$"."apr1"."$".$salt."$".$tmp;
    }
}