<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241023203811 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clients_address (ulid VARCHAR(26) NOT NULL COMMENT \'(DC2Type:ulid)\', city VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, zip VARCHAR(255) NOT NULL, PRIMARY KEY(ulid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clients_client (ulid VARCHAR(26) NOT NULL COMMENT \'(DC2Type:ulid)\', address_ulid VARCHAR(26) NOT NULL COMMENT \'(DC2Type:ulid)\', credit_info_ulid VARCHAR(26) NOT NULL COMMENT \'(DC2Type:ulid)\', first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, age INTEGER NOT NULL, email VARCHAR(255) NOT NULL, phone_number VARCHAR(20) NOT NULL, address_city VARCHAR(255) NOT NULL, address_state VARCHAR(255) NOT NULL, address_zip VARCHAR(255) NOT NULL, credit_info_fico_score INT NOT NULL, credit_info_snn VARCHAR(9) NOT NULL, credit_info_income FLOAT NOT NULL, PRIMARY KEY(ulid, address_ulid, credit_info_ulid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clients_credit_info (ulid VARCHAR(26) NOT NULL COMMENT \'(DC2Type:ulid)\', fico_score INT NOT NULL, snn VARCHAR(9) NOT NULL, income FLOAT NOT NULL, PRIMARY KEY(ulid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products_product (ulid VARCHAR(26) NOT NULL COMMENT \'(DC2Type:ulid)\', name VARCHAR(255) NOT NULL, interest_rate FLOAT NOT NULL, loan_term INTEGER NOT NULL, loan_amount FLOAT NOT NULL, PRIMARY KEY(ulid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE clients_address');
        $this->addSql('DROP TABLE clients_client');
        $this->addSql('DROP TABLE clients_credit_info');
        $this->addSql('DROP TABLE products_product');
    }
}
