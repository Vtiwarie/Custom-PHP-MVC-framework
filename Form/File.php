<?php

class Form_File extends Form_Element {

    public function __toString() {

        return $this->displayElement(parent::FORM_FILE);
    }

}

?>
