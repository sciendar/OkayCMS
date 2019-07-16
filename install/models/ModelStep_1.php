<?php
class ModelStep_1 extends Model {
    
    public function __construct($lang_file) {
        parent::__construct($lang_file);
        
    }
    
    public function get_translation($field = null) {
        return parent::get_translation($field);
    }
}