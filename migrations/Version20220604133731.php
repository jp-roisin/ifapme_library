<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220604133731 extends AbstractMigration
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
        $this->addSql('CREATE TABLE books_and_rents (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, isbn VARCHAR(255) NOT NULL, author VARCHAR(255) DEFAULT NULL, publisher VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, sub_title VARCHAR(255) DEFAULT NULL, category VARCHAR(255) DEFAULT NULL, description VARCHAR(1300) DEFAULT NULL, cover VARCHAR(1000) DEFAULT NULL, language VARCHAR(255) DEFAULT NULL, relase_date VARCHAR(255) DEFAULT NULL, rent_started_at DATETIME DEFAULT NULL, rent_ended_at DATETIME DEFAULT NULL, is_rented SMALLINT DEFAULT NULL, rent_price DOUBLE PRECISION DEFAULT NULL, CONSTRAINT FK_FB1AD96AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO books_and_rents (id, user_id, isbn, author, publisher, title, sub_title, category, description, cover, language, relase_date, rent_started_at, rent_ended_at, is_rented, rent_price) SELECT id, user_id, isbn, author, publisher, title, sub_title, category, description, cover, language, relase_date, rent_started_at, rent_ended_at, is_rented, rent_price FROM __temp__books_and_rents');
        $this->addSql('DROP TABLE __temp__books_and_rents');
        $this->addSql('CREATE INDEX IDX_FB1AD96AA76ED395 ON books_and_rents (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_FB1AD96AA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__books_and_rents AS SELECT id, user_id, isbn, author, publisher, title, sub_title, category, description, cover, language, relase_date, rent_started_at, rent_ended_at, is_rented, rent_price FROM books_and_rents');
        $this->addSql('DROP TABLE books_and_rents');
        $this->addSql('CREATE TABLE books_and_rents (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, isbn VARCHAR(255) NOT NULL, author VARCHAR(255) DEFAULT NULL, publisher VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, sub_title VARCHAR(255) DEFAULT NULL, category VARCHAR(255) DEFAULT NULL, description VARCHAR(1300) DEFAULT NULL, cover VARCHAR(1000) DEFAULT NULL, language VARCHAR(255) DEFAULT NULL, relase_date VARCHAR(255) DEFAULT NULL, rent_started_at DATETIME DEFAULT NULL, rent_ended_at DATETIME DEFAULT NULL, is_rented SMALLINT DEFAULT NULL, rent_price DOUBLE PRECISION DEFAULT NULL)');
        $this->addSql('INSERT INTO books_and_rents (id, user_id, isbn, author, publisher, title, sub_title, category, description, cover, language, relase_date, rent_started_at, rent_ended_at, is_rented, rent_price) SELECT id, user_id, isbn, author, publisher, title, sub_title, category, description, cover, language, relase_date, rent_started_at, rent_ended_at, is_rented, rent_price FROM __temp__books_and_rents');
        $this->addSql('DROP TABLE __temp__books_and_rents');
        $this->addSql('CREATE INDEX IDX_FB1AD96AA76ED395 ON books_and_rents (user_id)');
    }
}
