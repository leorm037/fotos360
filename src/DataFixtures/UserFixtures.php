<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const ADMIN_USER_REFERENCE = 'admin-user';
    
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {

        $user = new User();

        $user->setEmail('admin@admin.com');
        $user->setUpdatedAt(new DateTimeImmutable());
        $user->setRoles(array('ROLE_ADMIN', 'ROLE_ALLOWED_TO_SWITCH', 'ROLE_USER'));

        $password = $this->hasher->hashPassword($user, 'admin');

        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();
        
        $this->addReference(self::ADMIN_USER_REFERENCE, $user);
    }

}
