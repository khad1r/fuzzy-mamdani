<?php

class Error extends Controller
{
    public function index()
    {
        $this->view('templates/header', array('title' => 'Login'));
        $this->view('error');
        $this->view('templates/footer');
    }
}
