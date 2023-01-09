<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230109131625 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE author (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, country_id INTEGER DEFAULT NULL, nom VARCHAR(20) NOT NULL, prenom VARCHAR(20) NOT NULL, date_naissance DATE DEFAULT NULL, CONSTRAINT FK_BDAFD8C8F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BDAFD8C8F92F3E70 ON author (country_id)');
        $this->addSql('CREATE TABLE country (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(30) NOT NULL)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__bookj AS SELECT id, etat FROM bookj');
        $this->addSql('DROP TABLE bookj');
        $this->addSql('CREATE TABLE bookj (id INTEGER NOT NULL, etat VARCHAR(20) NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_2E708252BF396750 FOREIGN KEY (id) REFERENCES documentj (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO bookj (id, etat) SELECT id, etat FROM __temp__bookj');
        $this->addSql('DROP TABLE __temp__bookj');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE country');
        $this->addSql('CREATE TEMPORARY TABLE __temp__bookj AS SELECT id, etat FROM bookj');
        $this->addSql('DROP TABLE bookj');
        $this->addSql('CREATE TABLE bookj (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, etat VARCHAR(20) NOT NULL, CONSTRAINT FK_2E708252BF396750 FOREIGN KEY (id) REFERENCES documentj (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO bookj (id, etat) SELECT id, etat FROM __temp__bookj');
        $this->addSql('DROP TABLE __temp__bookj');
    }
}
