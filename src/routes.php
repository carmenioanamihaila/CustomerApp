<?php
  function call($controller, $action) {
    require_once('controllers/' . $controller . 'Controller.php');

    if ($controller == 'customer') {
        $controller = new CustomerController();
    }

    $controller->{ $action }();
  }

  // adding an entry for the new controller and its actions
  $controllers = array('customer' => ['index', 'add']);

  if (array_key_exists($controller, $controllers)) {
    if (in_array($action, $controllers[$controller])) {
      call($controller, $action);
    } else {
      call('customer', 'error');
    }
  } else {
    call('customer', 'error');
  }
?>

