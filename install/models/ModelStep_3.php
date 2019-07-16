<?php
class ModelStep_3 extends Model {
    
    private $zip;
    
    public function __construct($lang_file) {
        parent::__construct($lang_file);
        $this->zip = new ZipArchive();
    }
    
    public function unzip() {
        $res = false;
        
        if($this->zip->open(dirname(__DIR__) . '/source/okaycms.zip') === true) {
            $res = @$this->zip->extractTo(dirname(dirname(__DIR__ )));
            $this->zip->close();
        }
        
        $this->set_access(dirname(dirname(__DIR__)));
        if($res) {
            return true;
        } else {
            return false;
        }
    }
    
    private function set_access($dir, $level = 0) {
        if(is_dir($dir)) {
            $objects = scandir($dir);
            foreach($objects as $object) {
                if($object != "." && $object != ".." && $object != "install" && !is_link($dir . "/" . $object)) {
                    if(is_dir($dir."/".$object)) {
                        chmod($dir . "/" . $object, 0755);
                        $this->set_access($dir . "/" . $object, $level+1);
                    } else {
                        chmod($dir . "/" . $object, 0644);
                    }
                }
            }
        }
    }
}