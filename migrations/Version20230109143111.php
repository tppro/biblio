<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230109143111 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__bookj AS SELECT id, etat FROM bookj');
        $this->addSql('DROP TABLE bookj');
        $this->addSql('CREATE TABLE bookj (id INTEGER NOT NULL, etat VARCHAR(20) NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_2E708252BF396750 FOREIGN KEY (id) REFERENCES documentj (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO bookj (id, etat) SELECT id, etat FROM __temp__bookj');
        $this->addSql('DROP TABLE __temp__bookj');
        $this->addSql('CREATE TEMPORARY TABLE __temp__country AS SELECT id, nom FROM country');
        $this->addSql('DROP TABLE country');
        $this->addSql('CREATE TABLE country (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER DEFAULT NULL, nom VARCHAR(30) NOT NULL, CONSTRAINT FK_5373C966F675F31B FOREIGN KEY (author_id) REFERENCES author (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO country (id, nom) SELECT id, nom FROM __temp__country');
        $this->addSql('DROP TABLE __temp__country');
        $this->addSql('CREATE INDEX IDX_5373C966F675F31B ON country (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__bookj AS SELECT id, etat FROM bookj');
        $this->addSql('DROP TABLE bookj');
        $this->addSql('CREATE TABLE bookj (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, etat VARCHAR(20) NOT NULL, CONSTRAINT FK_2E708252BF396750 FOREIGN KEY (id) REFERENCES documentj (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO bookj (id, etat) SELECT id, etat FROM __temp__bookj');
        $this->addSql('DROP TABLE __temp__bookj');
        $this->addSql('CREATE TEMPORARY TABLE __temp__country AS SELECT id, nom FROM country');
        $this->addSql('DROP TABLE country');
        $this->addSql('CREATE TABLE country (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(30) NOT NULL)');
        $this->addSql('INSERT INTO country (id, nom) SELECT id, nom FROM __temp__country');
        $this->addSql('DROP TABLE __temp__country');
    }
}
