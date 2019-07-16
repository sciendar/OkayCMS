<?php
class ControllerStep_1 extends Controller {
    
    public function __construct() {
        $this->model = new ModelStep_1('step_1.php');
        parent::__construct();
    }
    
    function action_index() {
        $this->design->fetch('step_1.php');
    }
}