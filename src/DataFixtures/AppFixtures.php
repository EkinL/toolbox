<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Toolbox;
use App\Enum\ToolboxStatusEnum;
use App\Entity\Team;

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
            $statuses = ['active', 'inactive', 'maintenance', 'archived'];
            $randomStatus = $statuses[array_rand($statuses)];
            $toolbox->setStatus(ToolboxStatusEnum::from($randomStatus));
            $manager->persist($toolbox);
        }

        $teams = [
            'Pôle Sécurité' => 'Responsable de la sécurité des systèmes d’information.',
            'Pôle Développement SaaS' => 'Développement et maintenance des applications SaaS.',
            'Pôle Infrastructure' => 'Gestion des serveurs, réseaux et infrastructures cloud.',
            'Pôle Support Client' => 'Assistance technique et relation client.',
            'Pôle Ressources Humaines et Administration' => 'Gestion RH, administrative et juridique.'
        ];
        
        foreach ($teams as $teamName => $description) {
            $team = new Team();
            $team->setName($teamName);
            $team->setDescription($description);
            $team->setCreatedAt(new \DateTimeImmutable());
            $team->setUpdatedAt(new \DateTimeImmutable());
            $manager->persist($team);
        }

        $manager->flush();

    }
}
