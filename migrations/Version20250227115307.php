<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250227115307 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__ftp_server AS SELECT id, alias, host FROM ftp_server');
        $this->addSql('DROP TABLE ftp_server');
        $this->addSql('CREATE TABLE ftp_server (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, alias VARCHAR(255) NOT NULL, host VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO ftp_server (id, alias, host) SELECT id, alias, host FROM __temp__ftp_server');
        $this->addSql('DROP TABLE __temp__ftp_server');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5EF203E16C6B94 ON ftp_server (alias)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__ftp_server AS SELECT id, alias, host FROM ftp_server');
        $this->addSql('DROP TABLE ftp_server');
        $this->addSql('CREATE TABLE ftp_server (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, alias VARCHAR(255) NOT NULL, host VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO ftp_server (id, alias, host) SELECT id, alias, host FROM __temp__ftp_server');
        $this->addSql('DROP TABLE __temp__ftp_server');
    }
}
