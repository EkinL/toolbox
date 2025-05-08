<?php

namespace App\DataFixtures;

use App\Entity\Team;
use App\Entity\Toolbox;
use App\Entity\User;
use App\Enum\ToolboxStatusEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création des teams
        $teams = [
            'Pôle Sécurité' => 'Responsable de la sécurité des systèmes d’information.',
            'Pôle Développement SaaS' => 'Développement et maintenance des applications SaaS.',
            'Pôle Infrastructure' => 'Gestion des serveurs, réseaux et infrastructures cloud.',
            'Pôle Support Client' => 'Assistance technique et relation client.',
            'Pôle Ressources Humaines et Administration' => 'Gestion RH, administrative et juridique.',
        ];

        $teamEntities = [];

        foreach ($teams as $teamName => $description) {
            $team = new Team();
            $team->setName($teamName);
            $team->setDescription($description);
            $team->setCreatedAt(new \DateTimeImmutable());
            $team->setUpdatedAt(new \DateTimeImmutable());
            $manager->persist($team);
            $teamEntities[] = $team;
        }

        // Création des utilisateurs (au moins 1 par team)
        $totalUsers = 10;
        for ($i = 0; $i < $totalUsers; ++$i) {
            $user = new User();
            $user->setEmail('user'.$i.'@example.com');
            $user->setLastName('LastName'.$i);
            $user->setFirstName('FirstName'.$i);
            $password = password_hash('password'.$i, PASSWORD_BCRYPT);
            $user->setPassword($password);
            $user->setRoles(['ROLE_USER']);
            if ($i < count($teamEntities)) {
                $user->setTeam($teamEntities[$i]);
            } else {
                $user->setTeam($teamEntities[array_rand($teamEntities)]);
            }
            if ($i === 0) {
                $user->setRoles(['ROLE_ADMIN']);
            }

            $manager->persist($user);
        }

        // Création des toolboxes
        for ($i = 0; $i < 10; ++$i) {
            $toolbox = new Toolbox();
            $toolbox->setTitle('Toolbox'.$i);
            $toolbox->setDescription('Description of Toolbox'.$i);
            $toolbox->setCreatedAt(new \DateTimeImmutable());
            $toolbox->setUpdatedAt(new \DateTimeImmutable());
            $statuses = ['active', 'inactive', 'maintenance', 'archived'];
            $randomStatus = $statuses[array_rand($statuses)];
            $toolbox->setStatus(ToolboxStatusEnum::from($randomStatus));
            $manager->persist($toolbox);
        }

        $manager->flush();
    }
}