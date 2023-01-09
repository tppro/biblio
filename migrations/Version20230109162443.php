<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230109162443 extends AbstractMigration
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
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, email, roles, password, nom, prenom, date_naissance, rue, codepostal, ville, tel_fix, tel_mobile, is_verified FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, nom VARCHAR(20) DEFAULT NULL, prenom VARCHAR(20) DEFAULT NULL, date_naissance DATE DEFAULT NULL, rue VARCHAR(255) DEFAULT NULL, codepostal VARCHAR(5) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, tel_fix VARCHAR(15) DEFAULT NULL, tel_mobile VARCHAR(15) DEFAULT NULL, is_verified BOOLEAN )');
        $this->addSql('INSERT INTO user (id, email, roles, password, nom, prenom, date_naissance, rue, codepostal, ville, tel_fix, tel_mobile, is_verified) SELECT id, email, roles, password, nom, prenom, date_naissance, rue, codepostal, ville, tel_fix, tel_mobile, is_verified FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__bookj AS SELECT id, etat FROM bookj');
        $this->addSql('DROP TABLE bookj');
        $this->addSql('CREATE TABLE bookj (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, etat VARCHAR(20) NOT NULL, CONSTRAINT FK_2E708252BF396750 FOREIGN KEY (id) REFERENCES documentj (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO bookj (id, etat) SELECT id, etat FROM __temp__bookj');
        $this->addSql('DROP TABLE __temp__bookj');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, email, roles, password, nom, prenom, date_naissance, rue, codepostal, ville, tel_fix, tel_mobile, is_verified FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, nom VARCHAR(20) NOT NULL, prenom VARCHAR(20) NOT NULL, date_naissance DATE DEFAULT NULL, rue VARCHAR(255) DEFAULT NULL, codepostal VARCHAR(5) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, tel_fix VARCHAR(15) DEFAULT NULL, tel_mobile VARCHAR(15) DEFAULT NULL, is_verified BOOLEAN DEFAULT NULL)');
        $this->addSql('INSERT INTO user (id, email, roles, password, nom, prenom, date_naissance, rue, codepostal, ville, tel_fix, tel_mobile, is_verified) SELECT id, email, roles, password, nom, prenom, date_naissance, rue, codepostal, ville, tel_fix, tel_mobile, is_verified FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }
}
