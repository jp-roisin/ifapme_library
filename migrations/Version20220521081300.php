<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220521081300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_FB1AD96AA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__books_and_rents AS SELECT id, user_id, isbn, author, publisher, title, sub_title, category, description, cover, language, relase_date, rent_started_at, rent_ended_at, is_rented, rent_price FROM books_and_rents');
        $this->addSql('DROP TABLE books_and_rents');
        $this->addSql('CREATE TABLE books_and_rents (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, isbn VARCHAR(255) NOT NULL, author VARCHAR(255) DEFAULT NULL, publisher VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, sub_title VARCHAR(255) DEFAULT NULL, category VARCHAR(255) DEFAULT NULL, description VARCHAR(1300) DEFAULT NULL, cover VARCHAR(1000) DEFAULT NULL, language VARCHAR(255) DEFAULT NULL, relase_date VARCHAR(255) DEFAULT NULL, rent_started_at DATETIME DEFAULT NULL, rent_ended_at DATETIME DEFAULT NULL, is_rented SMALLINT DEFAULT NULL, rent_price DOUBLE PRECISION DEFAULT NULL, CONSTRAINT FK_FB1AD96AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO books_and_rents (id, user_id, isbn, author, publisher, title, sub_title, category, description, cover, language, relase_date, rent_started_at, rent_ended_at, is_rented, rent_price) SELECT id, user_id, isbn, author, publisher, title, sub_title, category, description, cover, language, relase_date, rent_started_at, rent_ended_at, is_rented, rent_price FROM __temp__books_and_rents');
        $this->addSql('DROP TABLE __temp__books_and_rents');
        $this->addSql('CREATE INDEX IDX_FB1AD96AA76ED395 ON books_and_rents (user_id)');
        $this->addSql('DROP INDEX UNIQ_1483A5E9E7927C74');
        $this->addSql('CREATE TEMPORARY TABLE __temp__users AS SELECT id, last_name, first_name, email, password, is_actif, is_deleted, created_at, updated_at FROM users');
        $this->addSql('DROP TABLE users');
        $this->addSql('CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, last_name VARCHAR(60) NOT NULL, first_name VARCHAR(60) NOT NULL, email VARCHAR(60) NOT NULL, password VARCHAR(1000) NOT NULL, is_actif SMALLINT NOT NULL, is_deleted SMALLINT NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL, salt VARCHAR(1000) NOT NULL)');
        $this->addSql('INSERT INTO users (id, last_name, first_name, email, password, is_actif, is_deleted, created_at, updated_at) SELECT id, last_name, first_name, email, password, is_actif, is_deleted, created_at, updated_at FROM __temp__users');
        $this->addSql('DROP TABLE __temp__users');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E98FFBE0F7 ON users (salt)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_FB1AD96AA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__books_and_rents AS SELECT id, user_id, isbn, author, publisher, title, sub_title, category, description, cover, language, relase_date, rent_started_at, rent_ended_at, is_rented, rent_price FROM books_and_rents');
        $this->addSql('DROP TABLE books_and_rents');
        $this->addSql('CREATE TABLE books_and_rents (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, isbn VARCHAR(255) NOT NULL, author VARCHAR(255) DEFAULT NULL, publisher VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, sub_title VARCHAR(255) DEFAULT NULL, category VARCHAR(255) DEFAULT NULL, description VARCHAR(1300) DEFAULT NULL, cover VARCHAR(1000) DEFAULT NULL, language VARCHAR(255) DEFAULT NULL, relase_date VARCHAR(255) DEFAULT NULL, rent_started_at DATETIME DEFAULT NULL, rent_ended_at DATETIME DEFAULT NULL, is_rented BOOLEAN DEFAULT NULL, rent_price DOUBLE PRECISION DEFAULT NULL)');
        $this->addSql('INSERT INTO books_and_rents (id, user_id, isbn, author, publisher, title, sub_title, category, description, cover, language, relase_date, rent_started_at, rent_ended_at, is_rented, rent_price) SELECT id, user_id, isbn, author, publisher, title, sub_title, category, description, cover, language, relase_date, rent_started_at, rent_ended_at, is_rented, rent_price FROM __temp__books_and_rents');
        $this->addSql('DROP TABLE __temp__books_and_rents');
        $this->addSql('CREATE INDEX IDX_FB1AD96AA76ED395 ON books_and_rents (user_id)');
        $this->addSql('DROP INDEX UNIQ_1483A5E9E7927C74');
        $this->addSql('DROP INDEX UNIQ_1483A5E98FFBE0F7');
        $this->addSql('CREATE TEMPORARY TABLE __temp__users AS SELECT id, last_name, first_name, email, password, is_actif, is_deleted, created_at, updated_at FROM users');
        $this->addSql('DROP TABLE users');
        $this->addSql('CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, last_name VARCHAR(60) NOT NULL, first_name VARCHAR(60) NOT NULL, email VARCHAR(60) NOT NULL, password VARCHAR(1000) NOT NULL, is_actif BOOLEAN NOT NULL, is_deleted BOOLEAN NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO users (id, last_name, first_name, email, password, is_actif, is_deleted, created_at, updated_at) SELECT id, last_name, first_name, email, password, is_actif, is_deleted, created_at, updated_at FROM __temp__users');
        $this->addSql('DROP TABLE __temp__users');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
    }
}
