<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211125152534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contracter ADD maladie_id INT NOT NULL');
        $this->addSql('ALTER TABLE contracter ADD CONSTRAINT FK_B9943A65B4B1C397 FOREIGN KEY (maladie_id) REFERENCES maladie (id)');
        $this->addSql('CREATE INDEX IDX_B9943A65B4B1C397 ON contracter (maladie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contracter DROP FOREIGN KEY FK_B9943A65B4B1C397');
        $this->addSql('DROP INDEX IDX_B9943A65B4B1C397 ON contracter');
        $this->addSql('ALTER TABLE contracter DROP maladie_id');
    }
}
