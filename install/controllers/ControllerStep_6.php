<?php
class ControllerStep_6 extends Controller {
    
    public function __construct() {
        $this->model = new ModelStep_6('step_6.php');
        parent::__construct();
    }
    
    public function action_index() {
        foreach($this->model->admin_conf() as $key_result=>$result) {
            $this->design_vars->$key_result = $result;
        }
        
        $this->design->fetch('step_6.php');
    }
}