<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

require_once __DIR__ . '/vendor/autoload.php';

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$paths = [
    __DIR__ . '/src/Entity',
];

$isDevMode = true;

$dbParams = [
    'driver' => 'pdo_mysql',
    'host' => 'database',
    'user' => 'lemp',
    'password' => 'lemp',
    'dbname' => 'lemp',
];

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);

$extensionMetadataRegistry = new \Sandbox\Common\Metadata\Registry();

$eventManager = new \Doctrine\Common\EventManager();
$eventManager->addEventSubscriber(new \Sandbox\Common\Metadata\Loader($extensionMetadataRegistry));
$eventManager->addEventSubscriber(new \Sandbox\Timestampable\Listener($extensionMetadataRegistry));

$entityManager = EntityManager::create($dbParams, $config, $eventManager);

\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');
