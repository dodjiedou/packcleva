<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220314151849 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE absence_beneficiaire');
        $this->addSql('DROP TABLE absence_seance');
        $this->addSql('ALTER TABLE absence ADD beneficiaire_id INT NOT NULL, ADD seance_id INT NOT NULL');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C95AF81F68 FOREIGN KEY (beneficiaire_id) REFERENCES beneficiaire (id)');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C9E3797A94 FOREIGN KEY (seance_id) REFERENCES seance (id)');
        $this->addSql('CREATE INDEX IDX_765AE0C95AF81F68 ON absence (beneficiaire_id)');
        $this->addSql('CREATE INDEX IDX_765AE0C9E3797A94 ON absence (seance_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE absence_beneficiaire (absence_id INT NOT NULL, beneficiaire_id INT NOT NULL, INDEX IDX_58BA77685AF81F68 (beneficiaire_id), INDEX IDX_58BA77682DFF238F (absence_id), PRIMARY KEY(absence_id, beneficiaire_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE absence_seance (absence_id INT NOT NULL, seance_id INT NOT NULL, INDEX IDX_5578F37DE3797A94 (seance_id), INDEX IDX_5578F37D2DFF238F (absence_id), PRIMARY KEY(absence_id, seance_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE absence_beneficiaire ADD CONSTRAINT FK_58BA77682DFF238F FOREIGN KEY (absence_id) REFERENCES absence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE absence_beneficiaire ADD CONSTRAINT FK_58BA77685AF81F68 FOREIGN KEY (beneficiaire_id) REFERENCES beneficiaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE absence_seance ADD CONSTRAINT FK_5578F37D2DFF238F FOREIGN KEY (absence_id) REFERENCES absence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE absence_seance ADD CONSTRAINT FK_5578F37DE3797A94 FOREIGN KEY (seance_id) REFERENCES seance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C95AF81F68');
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C9E3797A94');
        $this->addSql('DROP INDEX IDX_765AE0C95AF81F68 ON absence');
        $this->addSql('DROP INDEX IDX_765AE0C9E3797A94 ON absence');
        $this->addSql('ALTER TABLE absence DROP beneficiaire_id, DROP seance_id');
    }
}
