<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlack;

class Contact {

    const MAIL = [
/*        'Pierre Travostion - Ostéopathe => 'travostinopierre@gmail.com',
        Bénédicte Jacquin - Infimière Libérale => 'bene.j31@gmail.com',
        Michel Cambouviles - Infirmier Libéral => 'm_camboulives@orange.fr',
        Céline Papy - Infirmière Libérale => 'celine-papy@hotmail.fr',
        Éléonor Helle - Sage-Femme => 'eleonore.helle@hotmail.fr',
        Marie Scaldaferro - Psychologue => 'm.scafont@yahoo.fr',*/
        'Aurick Bélénus - Administrateur' => 'aurickbelenus@gmail.com'
    ];

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=100)
     */
    private $firstname;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min="2", max="100")
     */
    private $lastname;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     message="Le numéro n'est pas valide",
     *     pattern="/(0|\+33)[0-9]( *[0-9]{2}){4}/"
     * )
     */
    private $phone;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min="10")
     */
    private $message;

    /**
     * @var int|null
     */
    private $user;

    /*
     * Getters & Setters
     */

    /**
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string|null $firstname
     * @return Contact
     */
    public function setFirstname(?string $firstname): Contact
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string|null $lastname
     * @return Contact
     */
    public function setLastname(?string $lastname): Contact
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     * @return Contact
     */
    public function setPhone(?string $phone): Contact
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return Contact
     */
    public function setEmail(?string $email): Contact
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     * @return Contact
     */
    public function setMessage(?string $message): Contact
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return Contact
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    public function getUserMail(): string
    {
        return self::MAIL[$this->user];
    }
}