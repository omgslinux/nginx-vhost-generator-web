<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250813163408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__vhosts AS SELECT id, vhost_type_id, parameters, name FROM vhosts');
        $this->addSql('DROP TABLE vhosts');
        $this->addSql('CREATE TABLE vhosts (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, vhost_type_id INTEGER NOT NULL, parameters CLOB NOT NULL --(DC2Type:json)
        , name VARCHAR(32) NOT NULL, CONSTRAINT FK_7256DEDB9C008316 FOREIGN KEY (vhost_type_id) REFERENCES vhost_types (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO vhosts (id, vhost_type_id, parameters, name) SELECT id, vhost_type_id, parameters, name FROM __temp__vhosts');
        $this->addSql('DROP TABLE __temp__vhosts');
        $this->addSql('CREATE INDEX IDX_7256DEDB9C008316 ON vhosts (vhost_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vhosts ADD COLUMN http BOOLEAN DEFAULT NULL');
        $this->addSql('ALTER TABLE vhosts ADD COLUMN http_port INTEGER DEFAULT NULL');
        $this->addSql('ALTER TABLE vhosts ADD COLUMN https BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE vhosts ADD COLUMN https_port INTEGER DEFAULT NULL');
        $this->addSql('ALTER TABLE vhosts ADD COLUMN http_redirect BOOLEAN DEFAULT NULL');
        $this->addSql('ALTER TABLE vhosts ADD COLUMN document_root VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE vhosts ADD COLUMN ssl_certificate VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE vhosts ADD COLUMN ssl_certificate_key VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE vhosts ADD COLUMN ssl_client_certificate VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE vhosts ADD COLUMN ssl_verify_client VARCHAR(16) DEFAULT NULL');
        $this->addSql('ALTER TABLE vhosts ADD COLUMN extra_block CLOB DEFAULT NULL');
        $this->addSql('ALTER TABLE vhosts ADD COLUMN server_name VARCHAR(255) NOT NULL');
    }
}
