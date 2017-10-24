<?php

namespace AppBundle\CommandBus;

/**
 * Class RegisterUser.
 *
 * @author MDH <mark.dehaan@webstores.nl>
 */
class RegisterUser
{
    private $name;
    private $email;

    public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}