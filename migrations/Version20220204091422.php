<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220204091422 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cadeau_age ADD id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE cadeau_classe_cde ADD id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE cadeau_localite ADD id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE cadeau_niveau_etude ADD id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE cadeau_rang_occupe ADD id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cadeau_age MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE cadeau_age DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE cadeau_age DROP id');
        $this->addSql('ALTER TABLE cadeau_classe_cde MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE cadeau_classe_cde DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE cadeau_classe_cde DROP id');
        $this->addSql('ALTER TABLE cadeau_localite MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE cadeau_localite DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE cadeau_localite DROP id');
        $this->addSql('ALTER TABLE cadeau_niveau_etude MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE cadeau_niveau_etude DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE cadeau_niveau_etude DROP id');
        $this->addSql('ALTER TABLE cadeau_rang_occupe MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE cadeau_rang_occupe DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE cadeau_rang_occupe DROP id');
    }
}
