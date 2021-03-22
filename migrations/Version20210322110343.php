<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210322110343 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FB2A1D860');
        $this->addSql('ALTER TABLE race DROP FOREIGN KEY FK_DA6FBBAFB2A1D860');
        $this->addSql('DROP TABLE species');
        $this->addSql('DROP INDEX IDX_6AAB231FB2A1D860 ON animal');
        $this->addSql('ALTER TABLE animal DROP species_id');
        $this->addSql('DROP INDEX IDX_DA6FBBAFB2A1D860 ON race');
        $this->addSql('ALTER TABLE race DROP species_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE species (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE animal ADD species_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FB2A1D860 FOREIGN KEY (species_id) REFERENCES species (id)');
        $this->addSql('CREATE INDEX IDX_6AAB231FB2A1D860 ON animal (species_id)');
        $this->addSql('ALTER TABLE race ADD species_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE race ADD CONSTRAINT FK_DA6FBBAFB2A1D860 FOREIGN KEY (species_id) REFERENCES species (id)');
        $this->addSql('CREATE INDEX IDX_DA6FBBAFB2A1D860 ON race (species_id)');
    }
}
