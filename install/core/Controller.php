<?php
class Controller {
    
    public $model;
    public $design;
    public $design_vars;
    
    function __construct() {
        
        if(isset($_GET['language']) && !empty($_GET['language'])){
            $_SESSION['lang_label'] = trim(strip_tags(htmlspecialchars($_GET['language'])));
            header('Location: '.$this->url_request(array('language'=>null)));
            die();
        }
        
        $this->design_vars = new stdClass();
        $this->design_vars->config = (object)parse_ini_file(dirname(__DIR__) . "/config/config.ini");
        $this->design_vars->current_language = (object)parse_ini_file(dirname(__DIR__) . "/language/" . $this->model->get_lang_label() . "/param.ini");
        $this->design_vars->current_language->lang_label = $this->model->get_lang_label();
        $this->design_vars->lang = $this->model->get_translation();
        foreach( array_slice(scandir(dirname(__DIR__) . "/language/"), 2) as $lang_label) {
            $this->design_vars->languages[$lang_label] = (object)parse_ini_file(dirname(__DIR__) . "/language/" . $lang_label . "/param.ini");
            $this->design_vars->languages[$lang_label]->url = $this->url_request(array('language'=>$lang_label));
        }
        $this->design = new Design($this->design_vars);
    }
    
    public function url_request($params = array()) {
        $url = parse_url($_SERVER["REQUEST_URI"]);
        $query = array();
        if (isset($url['query'])) {
            parse_str($url['query'], $query);
        }
        if(get_magic_quotes_gpc()) {
            foreach($query as &$v) {
                if(!is_array($v)) {
                    $v = stripslashes(urldecode($v));
                }
            }
        }
        
        foreach($params as $name=>$value) {
            $query[$name] = $value;
        }
        
        $query_is_empty = true;
        foreach($query as $name=>$value) {
            if($value!=='' && $value!==null) {
                $query_is_empty = false;
            }
        }
        
        if(!$query_is_empty) {
            $url['query'] = http_build_query($query);
        } else {
            $url['query'] = null;
        }
        
        $result = http_build_url(null, $url);
        return $result;
    }
}