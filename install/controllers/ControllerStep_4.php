<?php
class ControllerStep_4 extends Controller {
    
    public function __construct() {
        
        $this->model = new ModelStep_4('step_4.php');
        parent::__construct();
    }
    
    public function action_index() {
        if(isset($_POST['dbconfig'])) {
            foreach($this->model->dbconfig() as $key_result=>$result) {
                $this->design_vars->$key_result = $result;
            }
        }
        
        $this->design->fetch('step_4.php');
    }
}