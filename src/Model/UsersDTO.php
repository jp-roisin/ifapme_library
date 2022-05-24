<?php

namespace App\Model;

use App\Entity\Users;
use Symfony\Component\Validator\Constraints as Assert;

class UsersDTO
{

    public function __construct() {
        $this->password="test";
        $this->lastName="test";
        $this->firstName="test";
        $this->email="test@test.com";
    }
    /**
     * @var string
     * @Assert\Length(min=1, minMessage="Le nom doit avoir au moins un caractère !",max=20,maxMessage="Le nom ne peut pas dépasser 20 caractères !")
     */
    private string $lastName;

    /**
     * @return string
     */
    public function getlastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return UsersDTO
     */
    public function setlastName(string $lastName): UsersDTO
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getfirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return UsersDTO
     */
    public function setfirstName(string $firstName): UsersDTO
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return UsersDTO
     */
    public function setEmail(string $email): UsersDTO
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return UsersDTO
     */
    public function setPassword(string $password): UsersDTO
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @var string
     * @Assert\Length(min=1, minMessage="Le prénom doit avoir au moins un caractère !",max=20,maxMessage="Le prénom ne peut pas dépasser 20 caractères !")
     */
    private string $firstName;

    /**
     * @var string
     * @Assert\Email(message="L'email {{ value }} n'est pas valide.")
     */
    private string $email;

    /**
     * @var string
     * @Assert\NotBlank ()
     */
    private string $password;

    /**
     * @return Users
     */
    public function toEntity():Users
    {
        $user= new Users();
        $user->setPassword($this->password)
            ->setLastName($this->lastName)
            ->setFirstName($this->firstName)
            ->setEmail($this->email)
            ;
        return $user;
    }

}
