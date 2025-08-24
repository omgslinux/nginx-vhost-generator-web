<?php

// src/Security/FileUserProvider.php

namespace App\Security;

use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

// Implementa UserProviderInterface Y PasswordUpgraderInterface
class FileUserProvider implements UserProviderInterface, PasswordUpgraderInterface
{
    private string $userFile;

    public function __construct(string $userCredentialsFile)
    {
        $this->userFile = $userCredentialsFile;
    }

    /**
     * @return UserInterface
     */
    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        if (!file_exists($this->userFile)) {
            throw new UserNotFoundException('User file does not exist.');
        }

        $credentials = json_decode(file_get_contents($this->userFile), true);

        if ($credentials['username'] !== $identifier) {
             throw new UserNotFoundException(sprintf('User "%s" not found.', $identifier));
        }

        return new FileUser($credentials['username'], $credentials['password']);
    }

    /**
     * @param UserInterface $user
     * @return UserInterface
     * @throws UnsupportedUserException if the user is not supported
     */
    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof FileUser) {
            throw new UnsupportedUserException(sprintf('Invalid user class "%s".', get_class($user)));
        }
        // Recarga el usuario desde el archivo para refrescar la sesión.
        return $this->loadUserByIdentifier($user->getUserIdentifier());

        throw new UnsupportedUserException('FileUserProvider does not support refreshing users.');
    }

    /**
     * @param string $class
     * @return bool
     */
    public function supportsClass(string $class): bool
    {
        return $class === FileUser::class || is_subclass_of($class, FileUser::class);
    }

    /**
     * Upgrades the password of a user, typically when a new hasher is chosen.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        // No implementamos esta lógica, ya que no se necesita para este caso de uso.
        // Pero el método debe estar presente.
    }
}
