<?php

namespace AppBundle\CommandBus;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class RegisterUserHandler.
 *
 * @author MDH <mark.dehaan@webstores.nl>
 */
class RegisterUserHandler
{
    private $em;
    private $mailer;

    /**
     * RegisterUserHandler constructor.
     *
     * @param $em
     * @param $mailer
     */
    public function __construct(EntityManagerInterface $em, $mailer)
    {
        $this->em = $em;
        $this->mailer = $mailer;
    }

    public function handle(RegisterUser $command)
    {
        $user = User::register($command->getName(), $command->getEmail());
        $this->em->persist($user);
        $this->em->flush();

        $message = new \Swift_Message('Welkom');
        $message->setFrom('no_reply@pizza-avond.webstores');
        $message->setTo($user->getEmail());
        $message->setBody(sprintf('Hallo %s, ook zin in een pizza?', $user->getName()));
        $this->mailer->send($message);
    }
}