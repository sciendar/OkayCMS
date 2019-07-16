<?php
class ControllerStep_2 extends Controller {
    
    public function __construct() {
        $this->model = new ModelStep_2('step_2.php');
        parent::__construct();
    }
    
    public function action_index() {
        $this->design_vars->test_server = $this->model->test_server();
        $this->design->fetch('step_2.php');
    }
}