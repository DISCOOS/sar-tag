<?php
    
    require "config.php";
    
    use Symfony\Component\HttpFoundation\Response;

    $app = new Silex\Application();

    $app['debug'] = true;
    
    Symfony\Component\Debug\ErrorHandler::register();
    Symfony\Component\Debug\ExceptionHandler::register($app['debug']);
    
    $app->register(new Silex\Provider\DoctrineServiceProvider(), array(
        'db.options' => array(
            'driver'    => 'pdo_mysql',
            'host'      => _DB_HOST,
            'dbname'    => _DB_NAME,
            'user'      => _DB_USERNAME,
            'password'  => _DB_PASSWORD,
            'charset'   => _DB_CHARSET,
        ),
    ));    

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

    $app->match('/{action}/{tag}', function ($action, $tag) use($app) {
        
        $action = $app->escape($action);
        
        //return $tag;
        
        switch($action) {
            
            case 'enter':
                
                $sql = "SELECT * FROM tag WHERE id = ?";
                $post = $app['db']->fetchAssoc($sql, array($tag));
                if($post === false)
                {
                    $response = implode(".",array("Unknown ID","Register $tag at http://sar-tag.org/register."));
                }
                else
                {
                    $response = "OK";
                    
                    switch($post['type'])
                    {
                        case 'person':
                            $state = $post['state'];
                            $sql = "SELECT * FROM person WHERE id = ?";
                            $post = $app['db']->fetchAssoc($sql, array($post['key']));
                            if($state === 1)
                            {
                                $response = "{$post['firstname']} {$post['lastname']} registered already.";
                            }
                            else
                            {
                                $response = "{$post['firstname']} {$post['lastname']} is registered.";
                                //$sql = "UPDATE tag SET state = 1 WHERE id = ?";
                                //$app['db']->executeUpdate($sql, array($tag));                                
                            }
                            break;
                        case 'equipment':
                            $sql = "SELECT * FROM equipment WHERE id = ?";
                            $post = $app['db']->fetchAssoc($sql, array((int) $post['key']));
                            $response = "{$post['name']} is registered.";
                            break;
                        default:
                            $app->abort("400", "{$post['type']} not found");
                    }
                }
                
                // TODO: Implement DB lookup using doctrine and state logic
                break;
            case 'leave':
                
                $response = implode(".",array("Unknown ID","Register $tag at http://sar-tag.org/register."));
                
                // TODO: Implement DB lookup using doctrine and state logic
                break;
            default:
                $app->abort(400);
        }

        return $app->json(array($action => $response));

    })->assert('action', "enter|leave");

    $app->run();

?>
