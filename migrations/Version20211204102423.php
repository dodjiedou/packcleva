<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211204102423 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE beneficiaire (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(30) NOT NULL, telephone VARCHAR(20) NOT NULL, email VARCHAR(50) DEFAULT NULL, description VARCHAR(50) DEFAULT NULL, numero VARCHAR(50) NOT NULL, date_naissance VARCHAR(20) NOT NULL, sexe VARCHAR(15) NOT NULL, classe VARCHAR(30) NOT NULL, religion VARCHAR(50) NOT NULL, nom_tuteur VARCHAR(30) DEFAULT NULL, village VARCHAR(50) NOT NULL, rue VARCHAR(50) DEFAULT NULL, rang_occupe VARCHAR(20) DEFAULT NULL, classe_cde VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contracter DROP FOREIGN KEY FK_B9943A655AF81F68');
        $this->addSql('ALTER TABLE prendre DROP FOREIGN KEY FK_D2CA36CD5AF81F68');
        $this->addSql('DROP TABLE beneficiaire');
    }
}
