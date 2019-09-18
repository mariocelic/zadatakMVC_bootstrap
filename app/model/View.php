<?php

class View
{
    private $layout;

    public function __construct($layout = 'layout')
    {
        $this->layout = basename($layout);
    }

    public function render($putanjaPHTMLdatoteke, $podaci = [])
    {
        ob_start();
        extract($podaci);
        include BP."app/view/$putanjaPHTMLdatoteke.phtml";
        $content = ob_get_clean();
        if ($this->layout) {
            include BP."app/view/{$this->layout}.phtml";
        } else {
            echo $content;
        }

        return $this;
    }
}
