<?php
class ModelStep_5 extends Model {
    
    private $result = array();
    private $license;
    private $config_file;
    
    public function __construct($lang_file) {
        parent::__construct($lang_file);
        
        $this->config_file = dirname(dirname(__DIR__ )) . '/config/config.php';
        
        if($license = @file_get_contents("http://license.okay-cms.com/index.php?domain=".$_SERVER['HTTP_HOST'])) {
            $this->result['test_license'] = $license;
        }
        
        if(isset($_POST['license'])) {
            $this->license = $_POST['license'];
        }
        
        $this->result['license'] = $this->license;
    }
    
    public function get_license() {
        
        if(!is_writable($this->config_file)) {
            $this->result['errors'][] = $this->get_translation('error_config_file_not_writable');
        }
        
        if(!empty($_POST['license'])) {
            if(!($this->result['end_date'] = $this->check_license())) {
                $this->result['errors'][] = $this->get_translation('error_check_license');
            }
            
            if(!isset($this->result['errors'])) {
                $conf = file_get_contents($this->config_file);
                $conf = preg_replace("/license\s*=.*\n/i", "license = ".$this->license."\r\n", $conf);
                file_put_contents($this->config_file, $conf);
                $this->result['success'] = new stdCLass;
                $this->result['success']->title = $this->get_translation('thanks_for_license');
                $this->result['success']->license_date_text = $this->get_translation('license_date_text');
            }
        }
        
        return $this->result;
    }
    
    private function check_license() {
        $p=13; $g=3; $x=5; $r = ''; $s = $x;
        $bs = explode(' ', $this->license);
        foreach($bs as $bl){
            for($i=0, $m=''; $i<strlen($bl)&&isset($bl[$i+1]); $i+=2){
                $a = base_convert($bl[$i], 36, 10)-($i/2+$s)%27;
                $b = base_convert($bl[$i+1], 36, 10)-($i/2+$s)%24;
                $m .= ($b * (pow($a,$p-$x-5) )) % $p;}
            $m = base_convert($m, 10, 16); $s+=$x;
            for ($a=0; $a<strlen($m); $a+=2) $r .= @chr(hexdec($m{$a}.$m{($a+1)}));}

        @list($l->domains, $l->expiration, $l->comment) = explode('#', $r, 3);

        $l->domains = explode(',', $l->domains);

        $h = getenv("HTTP_HOST");
        if(substr($h, 0, 4) == 'www.') $h = substr($h, 4);
        if(!in_array($h, $l->domains) || (strtotime($l->expiration)<time() && $l->expiration!='*')) {
            return false;
        } else {
            return $l->expiration;
        }
    }
}