<?php

use Sandbox\Entity\User;

require_once __DIR__ . '/../bootstrap.php';

// $user = new User('Aken');
//
// $entityManager->persist($user);
// $entityManager->flush();
//
// dd($user);

/** @var User $user */
$user = $entityManager->find(User::class, 5);
$user->changeNameTo('Aken Roberts Jr.');

$entityManager->persist($user);
$entityManager->flush();

dd($user);
