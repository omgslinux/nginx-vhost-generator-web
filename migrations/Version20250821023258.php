<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250821023258 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE defaults (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, ssl_mode VARCHAR(50) NOT NULL, domain_suffix VARCHAR(64) DEFAULT NULL, log_dir_format VARCHAR(255) NOT NULL, ssl_certificate VARCHAR(255) DEFAULT NULL, ssl_certificate_key VARCHAR(255) DEFAULT NULL, well_known_dir VARCHAR(255) NOT NULL, client_max_body_size VARCHAR(10) NOT NULL, client_body_timeout VARCHAR(10) NOT NULL, fastcgi_buffers VARCHAR(20) NOT NULL, http_port INTEGER NOT NULL, https_port INTEGER NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE defaults');
    }
}
