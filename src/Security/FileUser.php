<?php

// src/Security/FileUser.php
namespace App\Security;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class FileUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    private ?string $password;
    private ?string $userIdentifier;

    public function __construct(?string $userIdentifier = null, ?string $password = null)
    {
        $this->userIdentifier = $userIdentifier;
        $this->password = $password;
    }

    public function getUserIdentifier(): string
    {
        return $this->userIdentifier ?? '';
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getRoles(): array
    {
        return ['ROLE_ADMIN'];
    }

    public function eraseCredentials(): void
    {
        // No se necesita hacer nada aquí ya que no guardamos datos sensibles
    }
}
