<?php
    require_once __DIR__.'/../vendor/autoload.php';
    require_once __DIR__.'/../src/Contact.php';

    session_start();
    if(empty($_SESSION['list_of_contacts'])) {
        $_SESSION['list_of_contacts'] = array();
    }

    $app = new Silex\Application();

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'
    ));

    $app->get('/', function() use ($app) {
        return $app['twig']->render('home.html.twig', array('contacts' => Contact::getAll()));
    });

    $app->post('/added_contact', function() use ($app) {
        $contact = new Contact($_POST['contact_name'], $_POST['contact_phone_number'], $_POST['contact_address']);
        $contact->save();
        return $app['twig']->render('added_contact.html.twig', array('newcontact' => $contact));
    });

    return $app;
?>
