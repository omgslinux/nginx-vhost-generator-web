<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250823130024 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE defaults (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, ssl_mode VARCHAR(50) NOT NULL, domain_suffix VARCHAR(64) DEFAULT NULL, log_dir_format VARCHAR(255) NOT NULL, ssl_certificate VARCHAR(255) DEFAULT NULL, ssl_certificate_key VARCHAR(255) DEFAULT NULL, well_known_dir VARCHAR(255) NOT NULL, client_max_body_size VARCHAR(10) NOT NULL, client_body_timeout VARCHAR(10) NOT NULL, fastcgi_buffers VARCHAR(20) NOT NULL, http_port INTEGER NOT NULL, https_port INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE vhost_types (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(16) NOT NULL, description VARCHAR(255) NOT NULL, template CLOB NOT NULL, parameters CLOB DEFAULT NULL --(DC2Type:json)
        , copy CLOB DEFAULT NULL --(DC2Type:json)
        )');
        $this->addSql('CREATE TABLE vhosts (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, vhost_type_id INTEGER NOT NULL, name VARCHAR(32) NOT NULL, parameters CLOB NOT NULL --(DC2Type:json)
        , CONSTRAINT FK_7256DEDB9C008316 FOREIGN KEY (vhost_type_id) REFERENCES vhost_types (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_7256DEDB9C008316 ON vhosts (vhost_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE defaults');
        $this->addSql('DROP TABLE vhost_types');
        $this->addSql('DROP TABLE vhosts');
    }
}
