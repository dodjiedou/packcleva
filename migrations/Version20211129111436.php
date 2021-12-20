<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211129111436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE beneficiaire_contracter');
        $this->addSql('ALTER TABLE beneficiaire CHANGE date_naissance date_naissance DATE NOT NULL');
        $this->addSql('ALTER TABLE prendre ADD beneficiaire_id INT NOT NULL, ADD vaccin_id INT NOT NULL');
        $this->addSql('ALTER TABLE prendre ADD CONSTRAINT FK_D2CA36CD5AF81F68 FOREIGN KEY (beneficiaire_id) REFERENCES beneficiaire (id)');
        $this->addSql('ALTER TABLE prendre ADD CONSTRAINT FK_D2CA36CD9B14AC76 FOREIGN KEY (vaccin_id) REFERENCES vaccin (id)');
        $this->addSql('CREATE INDEX IDX_D2CA36CD5AF81F68 ON prendre (beneficiaire_id)');
        $this->addSql('CREATE INDEX IDX_D2CA36CD9B14AC76 ON prendre (vaccin_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE beneficiaire_contracter (beneficiaire_id INT NOT NULL, contracter_id INT NOT NULL, INDEX IDX_ABB695F5AF81F68 (beneficiaire_id), INDEX IDX_ABB695FFA964566 (contracter_id), PRIMARY KEY(beneficiaire_id, contracter_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE beneficiaire_contracter ADD CONSTRAINT FK_ABB695FFA964566 FOREIGN KEY (contracter_id) REFERENCES contracter (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE beneficiaire_contracter ADD CONSTRAINT FK_ABB695F5AF81F68 FOREIGN KEY (beneficiaire_id) REFERENCES beneficiaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE beneficiaire CHANGE date_naissance date_naissance VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE prendre DROP FOREIGN KEY FK_D2CA36CD5AF81F68');
        $this->addSql('ALTER TABLE prendre DROP FOREIGN KEY FK_D2CA36CD9B14AC76');
        $this->addSql('DROP INDEX IDX_D2CA36CD5AF81F68 ON prendre');
        $this->addSql('DROP INDEX IDX_D2CA36CD9B14AC76 ON prendre');
        $this->addSql('ALTER TABLE prendre DROP beneficiaire_id, DROP vaccin_id');
    }
}
