<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250815115947 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vhost_types ADD COLUMN copy CLOB DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__vhost_types AS SELECT id, name, description, template, parameters FROM vhost_types');
        $this->addSql('DROP TABLE vhost_types');
        $this->addSql('CREATE TABLE vhost_types (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(16) NOT NULL, description VARCHAR(255) NOT NULL, template CLOB NOT NULL, parameters CLOB DEFAULT NULL --(DC2Type:json)
        )');
        $this->addSql('INSERT INTO vhost_types (id, name, description, template, parameters) SELECT id, name, description, template, parameters FROM __temp__vhost_types');
        $this->addSql('DROP TABLE __temp__vhost_types');
    }
}
