<?php
 
namespace App\Events;
 

use App\Entity\Users;
use App\Repository\UsersRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
 
class LoginListener
{
    /**
     * @param JWTCreatedEvent $event
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $payload = $event->getData();
        $user = $event->getUser();
 
        if ($user instanceof Users) {
            $payload["id"]=$user->getId();
        }
        $event->setData($payload);
    }
}