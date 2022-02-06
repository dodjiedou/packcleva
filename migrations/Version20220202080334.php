<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220202080334 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cadeau (id INT AUTO_INCREMENT NOT NULL, nom_article VARCHAR(100) NOT NULL, mesure_article VARCHAR(255) NOT NULL, nombre_fille INT NOT NULL, nombre_garcon INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cadeau_age (id INT AUTO_INCREMENT NOT NULL, nom_article VARCHAR(100) NOT NULL, mesure_article VARCHAR(255) NOT NULL, nombre_fille INT NOT NULL, nombre_garcon INT NOT NULL, age INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cadeau_classe_cde (id INT AUTO_INCREMENT NOT NULL, nom_article VARCHAR(100) NOT NULL, mesure_article VARCHAR(255) NOT NULL, nombre_fille INT NOT NULL, nombre_garcon INT NOT NULL, nom_classe VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cadeau_localite (id INT AUTO_INCREMENT NOT NULL, nom_article VARCHAR(100) NOT NULL, mesure_article VARCHAR(255) NOT NULL, nombre_fille INT NOT NULL, nombre_garcon INT NOT NULL, nom_localite VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cadeau_niveau_etude (id INT AUTO_INCREMENT NOT NULL, nom_article VARCHAR(100) NOT NULL, mesure_article VARCHAR(255) NOT NULL, nombre_fille INT NOT NULL, nombre_garcon INT NOT NULL, niveau_etude VARCHAR(150) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cadeau_rang_occupe (id INT AUTO_INCREMENT NOT NULL, nom_article VARCHAR(100) NOT NULL, mesure_article VARCHAR(255) NOT NULL, nombre_fille INT NOT NULL, nombre_garcon INT NOT NULL, rang VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE cadeau');
        $this->addSql('DROP TABLE cadeau_age');
        $this->addSql('DROP TABLE cadeau_classe_cde');
        $this->addSql('DROP TABLE cadeau_localite');
        $this->addSql('DROP TABLE cadeau_niveau_etude');
        $this->addSql('DROP TABLE cadeau_rang_occupe');
    }
}
