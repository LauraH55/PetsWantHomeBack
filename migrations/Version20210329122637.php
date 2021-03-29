<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210329122637 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal ADD cat_cohabitation TINYINT(1) DEFAULT NULL, ADD dog_cohabitation TINYINT(1) DEFAULT NULL, ADD nac_cohabitation TINYINT(1) DEFAULT NULL, ADD unkwnown_cohabitation TINYINT(1) DEFAULT NULL, DROP cohabitation');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal ADD cohabitation SMALLINT DEFAULT NULL, DROP cat_cohabitation, DROP dog_cohabitation, DROP nac_cohabitation, DROP unkwnown_cohabitation');
    }
}
