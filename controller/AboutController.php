<?php

include_once("view/AboutView.php");

class AboutController {
    public function index() {
        
        $view = new AboutView();
        $view->render();
      }
}