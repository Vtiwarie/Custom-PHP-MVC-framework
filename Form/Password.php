<?php

class Form_Password extends Form_Element {

    public function __toString() {

        return $this->displayElement(parent::FORM_PASSWORD);
    }

}

?>
