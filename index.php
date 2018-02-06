<?php

session_start();

//Require the autoload file
require_once('vendor/autoload.php');

//Create an instance of the Base class
$f3 = Base::instance();

$f3->route('GET /',
    function() {
        echo "<link rel='stylesheet' type='text/css' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css'>";
        echo "<h2>My Pets</h2>";
        echo "<a href='./order'>Order a pet</a>";
    });

$f3->route('GET /order',
    function() {
        $view = new View;
        echo $view->render('views/form1.html');
    });

$f3->route('POST /form2',
    function() {

        $_SESSION['animal'] = $_POST['animal'];
        //echo "animal: ".$_SESSION['animal'];

        $view = new View;
        echo $view->render('views/form2.html');
    });

$f3->route('POST /results/@type',
    function($f3) {

        $_SESSION['color'] = $_POST['color'];

        //Create global variables
        $f3->set('animal', $_SESSION['animal']);
        $f3->set('color', $_SESSION['color']);

        //load a page using a Template
        $template = new Template();
        echo $template->render('views/results.html');
    });


//Run fat free
$f3->run();
