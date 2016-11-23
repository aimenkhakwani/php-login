<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/User.php";

    use Symfony\Component\Debug\Debug;
    Debug::enable();
    $app = new Silex\Application();
    $app['debug'] = true;

    session_start();
    if(empty($_SESSION['current_user'])) {
        $_SESSION['current_user'] = null;
    }

    $server = 'mysql:host=localhost:8889;dbname=php_login';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get('/', function() use ($app) {
        return $app['twig']->render('index.html.twig', array('current_user' => $_SESSION['current_user']));
    });

    $app->post('/sign_up', function() use ($app) {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $new_user = new User($username, $password);
        $valid = $new_user->save();
        if ($valid == true) {
            $_SESSION['current_user'] = $new_user;
            return $app['twig']->render('login.html.twig', array('current_user' => $SESSION['current_user'], 'user' => $new_user));
        } else {
            return $app['twig']->render('index.html.twig', array('current_user' => $SESSION['current_user']);
        }
    });
?>
