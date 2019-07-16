<?php
class ControllerStep_3 extends Controller {
    
    public function __construct() {
        $this->model = new ModelStep_3('step_3.php');
        parent::__construct();
    }
    
    public function action_index() {
        
        if(!file_exists(dirname(__DIR__) . '/source/okaycms.zip')) {
            $this->design_vars->error = $this->model->get_translation('zip_file_not_found');
        } else {
            if(!$this->model->unzip()) {
                $this->design_vars->error = $this->model->get_translation('can_not_unzip');
            } else {
                $this->design_vars->success = strtr($this->model->get_translation('zip_unzipped'), array('{$dir}'=>dirname(dirname(__DIR__ ))));
            }
        }
        
        $this->design->fetch('step_3.php');
    }
}