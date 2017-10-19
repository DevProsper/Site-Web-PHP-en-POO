<?php 

class Form{

	public $controller;
	public $errors;

	public function __construct($controller){
		$this->controller = $controller;
	}

	public function input($name,$label,$options = array()){
		$error = false;
		$classError = '';
		if (isset($this->errors['name'])) {
			$error = $this->errors['name'];
			$classError = 'danger';
		}
		if (!isset($this->controller->request->data->$name)) {
			$value = '';
		}else{
			$value = $this->controller->request->data->$name;
		}
		if ($label == 'hidden') {
			return '<input type="hidden" value="'.$value.'" 
			    	 id="input'.$name.'" name="'.$name.'">';
		}
		$html =  '<label for="input'.$name.'">'.$label.'</label>';
			    $attr = ' ';
			    	foreach ($options as $k => $v) {if($k != 'type'){
			    		$attr .= " $k=\"$v\"";
			    	}}
			    if (!isset($options['type'])) {
			    	$html . '<div class="form-group '.$classError.'">';
			    	$html .= '<input type="text" value="'.$value.'" 
			    	 id="input'.$name.'" name="'.$name.'"'.$attr.'>';
			    	 $html . '</div>';
			    }elseif ($options['type'] == 'textarea') {
			    	$html . '<div class="form-group '.$classError.' has-feedback">';
			    	$html .= '<textarea  id="input'.$name.'" name="'.$name.'"'.$attr.'>'
			    	.$value.'</textarea>';
			    	 $html . '</div>';
			    }elseif ($options['type'] == 'checkbox') {
			    	$html .= '<input  type="hidden" name="'.$name.'" value="0">
			    	<input  type="checkbox" name="'.$name.'" value="1" '.(empty($value)?'' : 'checked').'>';
			    }
			    if ($error) {
			    	$html .= '<span id="helpBlock2" class="help-block">'.$error.'</span>';
			    }
	    return $html;
	}
}