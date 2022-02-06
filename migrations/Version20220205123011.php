<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220205123011 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lettre (id INT AUTO_INCREMENT NOT NULL, beneficiaire_id INT NOT NULL, correspondant VARCHAR(150) NOT NULL, envoi_reception VARCHAR(20) NOT NULL, date_expedition DATE NOT NULL, date_reception DATE NOT NULL, INDEX IDX_852EF5B5AF81F68 (beneficiaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lettre ADD CONSTRAINT FK_852EF5B5AF81F68 FOREIGN KEY (beneficiaire_id) REFERENCES beneficiaire (id)');
        $this->addSql('ALTER TABLE question ADD lettre_id INT NOT NULL');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E5A2BDB92 FOREIGN KEY (lettre_id) REFERENCES lettre (id)');
        $this->addSql('CREATE INDEX IDX_B6F7494E5A2BDB92 ON question (lettre_id)');
        $this->addSql('ALTER TABLE reponse ADD question_id INT NOT NULL');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC71E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5FB6DEC71E27F6BF ON reponse (question_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E5A2BDB92');
        $this->addSql('DROP TABLE lettre');
        $this->addSql('DROP INDEX IDX_B6F7494E5A2BDB92 ON question');
        $this->addSql('ALTER TABLE question DROP lettre_id');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC71E27F6BF');
        $this->addSql('DROP INDEX UNIQ_5FB6DEC71E27F6BF ON reponse');
        $this->addSql('ALTER TABLE reponse DROP question_id');
    }
}
