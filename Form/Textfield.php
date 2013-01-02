<?php



class Form_TextField extends Form_Element{

      
        public function __toString() {
        
            return $this->displayElement(parent::FORM_TEXT);
    }

    
}

?>
