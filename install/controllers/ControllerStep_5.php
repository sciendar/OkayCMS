<?php
class ControllerStep_5 extends Controller {
    
    public function __construct() {
        $this->model = new ModelStep_5('step_5.php');
        parent::__construct();
    }
    
    public function action_index() {
        foreach($this->model->get_license() as $key_result=>$result) {
            $this->design_vars->$key_result = $result;
        }
        
        $this->design->fetch('step_5.php');
    }
}