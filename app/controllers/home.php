<?php

class Home extends Controller
{
  public function index($name = '', $other = '')
  {
    $user = $this->model('User');
    $user->name = $name;
    $this->view('home/index', ['name'=>$user->name]);
  }
}

?>