<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210427145022 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE private_person ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE private_person ADD CONSTRAINT FK_19F277A7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_19F277A7A76ED395 ON private_person (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE private_person DROP FOREIGN KEY FK_19F277A7A76ED395');
        $this->addSql('DROP INDEX UNIQ_19F277A7A76ED395 ON private_person');
        $this->addSql('ALTER TABLE private_person DROP user_id');
    }
}
