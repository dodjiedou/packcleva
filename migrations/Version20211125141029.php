<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211125141029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE beneficiaire_contracter (beneficiaire_id INT NOT NULL, contracter_id INT NOT NULL, INDEX IDX_ABB695F5AF81F68 (beneficiaire_id), INDEX IDX_ABB695FFA964566 (contracter_id), PRIMARY KEY(beneficiaire_id, contracter_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE beneficiaire_contracter ADD CONSTRAINT FK_ABB695F5AF81F68 FOREIGN KEY (beneficiaire_id) REFERENCES beneficiaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE beneficiaire_contracter ADD CONSTRAINT FK_ABB695FFA964566 FOREIGN KEY (contracter_id) REFERENCES contracter (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE beneficiaire_contracter');
    }
}
