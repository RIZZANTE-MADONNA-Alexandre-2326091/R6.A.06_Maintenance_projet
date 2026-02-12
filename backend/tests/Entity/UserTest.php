<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * Tests unitaires de l'entité User.
 */
class UserTest extends TestCase
{
    /**
     * Teste que l'id est null par défaut.
     */
    public function testIdIsNullByDefault(): void
    {
        $user = new User();
        $this->assertNull($user->getId());
    }

    /**
     * Teste le getter et setter de l'email.
     */
    public function testGetSetEmail(): void
    {
        $user = new User();
        $result = $user->setEmail('test@example.com');

        $this->assertSame('test@example.com', $user->getEmail());
        $this->assertSame($user, $result, 'setEmail doit retourner $this pour le chaînage');
    }

    /**
     * Teste que getUserIdentifier retourne l'email.
     */
    public function testGetUserIdentifierReturnsEmail(): void
    {
        $user = new User();
        $user->setEmail('prof@ecole.fr');

        $this->assertSame('prof@ecole.fr', $user->getUserIdentifier());
    }

    /**
     * Teste que getUserIdentifier retourne une chaîne vide quand l'email est null.
     */
    public function testGetUserIdentifierWithNullEmail(): void
    {
        $user = new User();

        $this->assertSame('', $user->getUserIdentifier());
    }

    /**
     * Teste le getter et setter du mot de passe.
     */
    public function testGetSetPassword(): void
    {
        $user = new User();
        $result = $user->setPassword('hashed_password_123');

        $this->assertSame('hashed_password_123', $user->getPassword());
        $this->assertSame($user, $result, 'setPassword doit retourner $this pour le chaînage');
    }

    /**
     * Teste que ROLE_USER est toujours présent dans les rôles.
     */
    public function testRolesAlwaysContainRoleUser(): void
    {
        $user = new User();

        $roles = $user->getRoles();
        $this->assertContains('ROLE_USER', $roles);
    }

    /**
     * Teste le setter des rôles avec un rôle supplémentaire.
     */
    public function testGetSetRoles(): void
    {
        $user = new User();
        $result = $user->setRoles(['ROLE_TEACHER']);

        $roles = $user->getRoles();
        $this->assertContains('ROLE_TEACHER', $roles);
        $this->assertContains('ROLE_USER', $roles, 'ROLE_USER doit toujours être présent');
        $this->assertSame($user, $result, 'setRoles doit retourner $this pour le chaînage');
    }

    /**
     * Teste que les rôles sont uniques (pas de doublons).
     */
    public function testRolesAreUnique(): void
    {
        $user = new User();
        $user->setRoles(['ROLE_USER', 'ROLE_USER', 'ROLE_TEACHER']);

        $roles = $user->getRoles();
        $this->assertCount(2, $roles, 'Les rôles ne doivent pas contenir de doublons');
    }

    /**
     * Teste que eraseCredentials ne lève pas d'exception.
     */
    public function testEraseCredentials(): void
    {
        $user = new User();
        $user->eraseCredentials();

        // La méthode ne fait rien, on vérifie juste qu'elle ne plante pas
        $this->assertTrue(true);
    }
}
