<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250813092644 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vhost_types (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(16) NOT NULL, description VARCHAR(255) NOT NULL, template CLOB NOT NULL, parameters CLOB DEFAULT NULL --(DC2Type:json)
        )');
        $this->addSql('CREATE TABLE vhosts (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, vhost_type_id INTEGER NOT NULL, http BOOLEAN DEFAULT NULL, http_port INTEGER DEFAULT NULL, https BOOLEAN NOT NULL, https_port INTEGER DEFAULT NULL, http_redirect BOOLEAN DEFAULT NULL, document_root VARCHAR(255) NOT NULL, ssl_certificate VARCHAR(255) DEFAULT NULL, ssl_certificate_key VARCHAR(255) DEFAULT NULL, ssl_client_certificate VARCHAR(255) DEFAULT NULL, ssl_verify_client VARCHAR(16) DEFAULT NULL, extra_block CLOB DEFAULT NULL, server_name VARCHAR(255) NOT NULL, parameters CLOB NOT NULL --(DC2Type:json)
        , name VARCHAR(32) NOT NULL, CONSTRAINT FK_7256DEDB9C008316 FOREIGN KEY (vhost_type_id) REFERENCES vhost_types (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_7256DEDB9C008316 ON vhosts (vhost_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE vhost_types');
        $this->addSql('DROP TABLE vhosts');
    }
}
