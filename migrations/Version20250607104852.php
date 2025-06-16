<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250607104852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE toolbox_team (toolbox_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid)', team_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid)', INDEX IDX_52A80628B3FA4DFB (toolbox_id), INDEX IDX_52A80628296CD8AE (team_id), PRIMARY KEY(toolbox_id, team_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE toolbox_team ADD CONSTRAINT FK_52A80628B3FA4DFB FOREIGN KEY (toolbox_id) REFERENCES toolbox (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE toolbox_team ADD CONSTRAINT FK_52A80628296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE toolbox DROP FOREIGN KEY FK_E193AFC6B842D717
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_E193AFC6B842D717 ON toolbox
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE toolbox DROP team_id_id
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE toolbox_team DROP FOREIGN KEY FK_52A80628B3FA4DFB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE toolbox_team DROP FOREIGN KEY FK_52A80628296CD8AE
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE toolbox_team
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE toolbox ADD team_id_id BINARY(16) DEFAULT NULL COMMENT '(DC2Type:uuid)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE toolbox ADD CONSTRAINT FK_E193AFC6B842D717 FOREIGN KEY (team_id_id) REFERENCES team (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_E193AFC6B842D717 ON toolbox (team_id_id)
        SQL);
    }
}
