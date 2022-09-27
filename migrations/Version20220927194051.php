<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220927194051 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE photo (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, file_name VARCHAR(255) NOT NULL, file_date_time DATETIME NOT NULL, file_size INTEGER NOT NULL, file_mime_type VARCHAR(20) NOT NULL, file_width INTEGER NOT NULL, file_height INTEGER NOT NULL, ifd0_image_description VARCHAR(255) DEFAULT NULL, ifd0_make VARCHAR(255) DEFAULT NULL, ifd0_model VARCHAR(255) DEFAULT NULL, ifd0_software VARCHAR(255) DEFAULT NULL, gps_latitude VARCHAR(11) DEFAULT NULL, gps_longitude VARCHAR(11) DEFAULT NULL, gps_altitude VARCHAR(11) DEFAULT NULL)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, last_access DATETIME DEFAULT NULL, last_ip VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE user');
    }
}
