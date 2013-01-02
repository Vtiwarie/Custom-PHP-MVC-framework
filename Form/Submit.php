<?php

class Form_Submit extends Form_Element {

    public function __toString() {

        return $this->displayElement(parent::FORM_SUBMIT);
    }

}

?>
