<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220309185518 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE absence (id INT AUTO_INCREMENT NOT NULL, absent TINYINT(1) NOT NULL, commentaire LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE absence_seance (absence_id INT NOT NULL, seance_id INT NOT NULL, INDEX IDX_5578F37D2DFF238F (absence_id), INDEX IDX_5578F37DE3797A94 (seance_id), PRIMARY KEY(absence_id, seance_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE absence_beneficiaire (absence_id INT NOT NULL, beneficiaire_id INT NOT NULL, INDEX IDX_58BA77682DFF238F (absence_id), INDEX IDX_58BA77685AF81F68 (beneficiaire_id), PRIMARY KEY(absence_id, beneficiaire_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seance (id INT AUTO_INCREMENT NOT NULL, date_seance DATE NOT NULL, heure_debut_seance TIME NOT NULL, heure_fin_seance TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seance_cours (seance_id INT NOT NULL, cours_id INT NOT NULL, INDEX IDX_E2DC9FD0E3797A94 (seance_id), INDEX IDX_E2DC9FD07ECF78B0 (cours_id), PRIMARY KEY(seance_id, cours_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE absence_seance ADD CONSTRAINT FK_5578F37D2DFF238F FOREIGN KEY (absence_id) REFERENCES absence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE absence_seance ADD CONSTRAINT FK_5578F37DE3797A94 FOREIGN KEY (seance_id) REFERENCES seance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE absence_beneficiaire ADD CONSTRAINT FK_58BA77682DFF238F FOREIGN KEY (absence_id) REFERENCES absence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE absence_beneficiaire ADD CONSTRAINT FK_58BA77685AF81F68 FOREIGN KEY (beneficiaire_id) REFERENCES beneficiaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE seance_cours ADD CONSTRAINT FK_E2DC9FD0E3797A94 FOREIGN KEY (seance_id) REFERENCES seance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE seance_cours ADD CONSTRAINT FK_E2DC9FD07ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie ADD age_min DOUBLE PRECISION NOT NULL, ADD age_max DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE contracter ADD diagnostique VARCHAR(255) NOT NULL, ADD debut_traitement VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE absence_seance DROP FOREIGN KEY FK_5578F37D2DFF238F');
        $this->addSql('ALTER TABLE absence_beneficiaire DROP FOREIGN KEY FK_58BA77682DFF238F');
        $this->addSql('ALTER TABLE absence_seance DROP FOREIGN KEY FK_5578F37DE3797A94');
        $this->addSql('ALTER TABLE seance_cours DROP FOREIGN KEY FK_E2DC9FD0E3797A94');
        $this->addSql('DROP TABLE absence');
        $this->addSql('DROP TABLE absence_seance');
        $this->addSql('DROP TABLE absence_beneficiaire');
        $this->addSql('DROP TABLE seance');
        $this->addSql('DROP TABLE seance_cours');
        $this->addSql('ALTER TABLE categorie DROP age_min, DROP age_max');
        $this->addSql('ALTER TABLE contracter DROP diagnostique, DROP debut_traitement');
    }
}
