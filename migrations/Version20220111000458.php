<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220111000458 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE beneficiaire ADD CONSTRAINT FK_B140D802BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_B140D802BCF5E72D ON beneficiaire (categorie_id)');
        $this->addSql('ALTER TABLE classe ADD categorie_id INT NOT NULL');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF96BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_8F87BF96BCF5E72D ON classe (categorie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE beneficiaire DROP FOREIGN KEY FK_B140D802BCF5E72D');
        $this->addSql('DROP INDEX IDX_B140D802BCF5E72D ON beneficiaire');
        $this->addSql('ALTER TABLE classe DROP FOREIGN KEY FK_8F87BF96BCF5E72D');
        $this->addSql('DROP INDEX IDX_8F87BF96BCF5E72D ON classe');
        $this->addSql('ALTER TABLE classe DROP categorie_id');
    }
}
