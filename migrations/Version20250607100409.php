<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250607100409 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE history (id INT AUTO_INCREMENT NOT NULL, user_id_id BINARY(16) DEFAULT NULL COMMENT '(DC2Type:uuid)', created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', title VARCHAR(255) NOT NULL, INDEX IDX_27BA704B9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE team (id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid)', name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', updated_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE toolbox (id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid)', title VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', updated_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', status VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE `user` (id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid)', team_id BINARY(16) DEFAULT NULL COMMENT '(DC2Type:uuid)', email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, INDEX IDX_8D93D649296CD8AE (team_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE history ADD CONSTRAINT FK_27BA704B9D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE history DROP FOREIGN KEY FK_27BA704B9D86650F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649296CD8AE
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE history
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE team
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE toolbox
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE `user`
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
