<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220514084008 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE books_and_rents (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, isbn VARCHAR(255) NOT NULL, author VARCHAR(255) DEFAULT NULL, publisher VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, sub_title VARCHAR(255) DEFAULT NULL, category VARCHAR(255) DEFAULT NULL, description VARCHAR(1300) DEFAULT NULL, cover VARCHAR(1000) DEFAULT NULL, language VARCHAR(255) DEFAULT NULL, relase_date VARCHAR(255) DEFAULT NULL, rent_started_at DATETIME DEFAULT NULL, rent_ended_at DATETIME DEFAULT NULL, is_rented SMALLINT DEFAULT NULL, rent_price DOUBLE PRECISION DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_FB1AD96AA76ED395 ON books_and_rents (user_id)');
        $this->addSql('CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, last_name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(1000) NOT NULL, is_actif SMALLINT NOT NULL, is_deleted SMALLINT NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE books_and_rents');
        $this->addSql('DROP TABLE users');
    }
}
