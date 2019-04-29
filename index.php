<?php

session_start();

//Require the autoload file
require_once('vendor/autoload.php');

//Create an instance of the Base class
$f3 = Base::instance();

//Define an array of valid colors
$f3->set('colors', array('pink', 'green', 'blue'));
//$f3->set('errors', array());

require_once('model/validation-functions.php');

$f3->route('GET /',
    function() {
        echo "<link rel='stylesheet' type='text/css' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css'>";
        echo "<h2>My Pets</h2>";
        echo "<a href='./order'>Order a pet</a>";
    });

$f3->route('GET|POST /order',

    function($f3) {

        $_SESSION = array();

        if (isset($_POST['next'])) {
            $animal = $_POST['animal'];
            if (validText($animal)) {
                $_SESSION['animal'] = $animal;
                $f3->reroute('/order2');
            } else {
                $f3->set("errors['animal']", "Please enter an animal.");
            }
        }

        $template = new Template();
        echo $template->render('views/form1.html');
    });

$f3->route('GET|POST /order2',
    function($f3) {

        if (isset($_POST['submit'])) {
            $color = $_POST['color'];
            if (validColor($color)) {
                $_SESSION['color'] = $color;
                $f3->reroute('/results');
            } else {
                $f3->set("errors['color']", "Please select a color.");
            }
        }

        $template = new Template();
        echo $template->render('views/form2.html');
    });

$f3->route('GET /results',
    function($f3) {

        //load a page using a Template
        $template = new Template();
        echo $template->render('views/results.html');
    });


//Run fat free
$f3->run();
