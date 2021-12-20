<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211215160328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contracter CHANGE date date VARCHAR(20) NOT NULL, CHANGE debut_hospitalisation debut_hospitalisation VARCHAR(20) NOT NULL, CHANGE fin_hospitalisation fin_hospitalisation VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE maladie CHANGE categorie categorie VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contracter CHANGE date date DATE NOT NULL, CHANGE debut_hospitalisation debut_hospitalisation DATE NOT NULL, CHANGE fin_hospitalisation fin_hospitalisation DATE NOT NULL');
        $this->addSql('ALTER TABLE maladie CHANGE categorie categorie VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
