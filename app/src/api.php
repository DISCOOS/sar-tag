<?php
    
    require "vendor/autoload.php";
    
    use Symfony\Component\HttpFoundation\Response;

    $app = new Silex\Application();

    $app['debug'] = false;
    
    Symfony\Component\Debug\ErrorHandler::register();
    Symfony\Component\Debug\ExceptionHandler::register($app['debug']);

    $app->error(function (\Exception $e, $code) {

        switch($code) {
            case 400:
                $message = "Bad request";
                break;
            case 404:
                $message = "Page not found";
                break;
            default:
                $message = "Internal Server Error.";
                break;
        }
        return new Response($message, $code);
    });

    $app->match('/{action}/{tag}', function ($action) use($app) {
        
        $action = $app->escape($action);
        
        switch($action) {
            case 'enter':
                // TODO: Implement DB lookup using doctrine and state logic
                break;
            case 'leave':
                // TODO: Implement DB lookup using doctrine and state logic
                break;
        }

        return $app->json(array($action => "OK"));

    })->assert('action', "enter|leave");

    $app->run();

?>
