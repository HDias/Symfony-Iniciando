<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

$loader = require_once __DIR__.'/../app/bootstrap.php.cache';
Debug::enable();

require_once __DIR__.'/../app/AppKernel.php';

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$kernel->boot();

$request = Request::createFromGlobals();

$container = $kernel->getContainer();
$container->enterEscope("request");
$container->set("request", $request);


//Agora posso trabalhar com o container;