<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240208022731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, street VARCHAR(255) DEFAULT NULL, number VARCHAR(20) DEFAULT NULL, zip_code VARCHAR(30) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, state VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE phone (id INT AUTO_INCREMENT NOT NULL, phone_number VARCHAR(255) NOT NULL, mobile TINYINT(1) NOT NULL, user_id INT DEFAULT NULL, INDEX IDX_444F97DDA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, full_name VARCHAR(255) NOT NULL, date_of_birth DATE DEFAULT NULL, address_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE phone ADD CONSTRAINT FK_444F97DDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE phone DROP FOREIGN KEY FK_444F97DDA76ED395');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F5B7AF75');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE phone');
        $this->addSql('DROP TABLE user');
    }
}
