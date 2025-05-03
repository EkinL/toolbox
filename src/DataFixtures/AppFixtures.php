<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Toolbox;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail('user' . $i . '@example.com');
            $user->setLastName('LastName' . $i);
            $user->setFirstName('FirstName' . $i);
            $password = password_hash('password' . $i, PASSWORD_BCRYPT);
            $user->setPassword($password);
            $user->setRoles(['ROLE_USER']);
            $manager->persist($user);
        }
        
        for ($i = 0; $i < 10; $i++) {
            $toolbox = new Toolbox();
            $toolbox->setTitle('Toolbox' . $i);
            $toolbox->setDescription('Description of Toolbox' . $i);
            $toolbox->setCreatedAt(new \DateTimeImmutable());
            $toolbox->setUpdatedAt(new \DateTimeImmutable());
            $manager->persist($toolbox);
        }

        $manager->flush();


    }
}
