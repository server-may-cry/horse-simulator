<?php declare(strict_types=1);

use App\Kernel;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

require \dirname(__DIR__) . '/config/bootstrap.php';
$kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);
$kernel->boot();
$container = $kernel->getContainer();

if (!$container instanceof ContainerInterface) {
    throw new RuntimeException();
}

$doctrine = $container->get('doctrine');

if (!$doctrine instanceof RegistryInterface) {
    throw new RuntimeException();
}

return $doctrine->getManager();
