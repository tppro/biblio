<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230109145352 extends AbstractMigration
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
        $this->addSql('ALTER TABLE user ADD COLUMN nom VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE user ADD COLUMN prenom VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE user ADD COLUMN date_naissance DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD COLUMN rue VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD COLUMN codepostal VARCHAR(5) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD COLUMN ville VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD COLUMN tel_fix VARCHAR(15) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD COLUMN tel_mobile VARCHAR(15) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__bookj AS SELECT id, etat FROM bookj');
        $this->addSql('DROP TABLE bookj');
        $this->addSql('CREATE TABLE bookj (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, etat VARCHAR(20) NOT NULL, CONSTRAINT FK_2E708252BF396750 FOREIGN KEY (id) REFERENCES documentj (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO bookj (id, etat) SELECT id, etat FROM __temp__bookj');
        $this->addSql('DROP TABLE __temp__bookj');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, email, roles, password FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO user (id, email, roles, password) SELECT id, email, roles, password FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }
}
