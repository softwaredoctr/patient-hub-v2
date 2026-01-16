<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260116174438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE account_entry (id INT AUTO_INCREMENT NOT NULL, entry_type VARCHAR(20) NOT NULL, amount NUMERIC(10, 2) NOT NULL, source_type VARCHAR(20) NOT NULL, source_id INT DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, created_by INT DEFAULT NULL, company_id INT NOT NULL, account_id INT NOT NULL, INDEX IDX_1DAE4401979B1AD6 (company_id), INDEX IDX_1DAE44019B6B5FBA (account_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, dob DATE DEFAULT NULL, gender VARCHAR(20) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, company_id INT NOT NULL, INDEX IDX_1ADAD7EB979B1AD6 (company_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE patient_account (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, patient_id INT NOT NULL, INDEX IDX_2055034F979B1AD6 (company_id), UNIQUE INDEX UNIQ_2055034F6B899279 (patient_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, method VARCHAR(20) NOT NULL, reference_number VARCHAR(100) DEFAULT NULL, received_by INT DEFAULT NULL, created_at DATETIME NOT NULL, company_id INT NOT NULL, account_entry_id INT NOT NULL, INDEX IDX_6D28840D979B1AD6 (company_id), UNIQUE INDEX UNIQ_6D28840DC2F8ABF4 (account_entry_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE visit (id INT AUTO_INCREMENT NOT NULL, visit_date DATETIME NOT NULL, status VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL, company_id INT NOT NULL, patient_id INT NOT NULL, INDEX IDX_437EE939979B1AD6 (company_id), INDEX IDX_437EE9396B899279 (patient_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE visit_item (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, amount NUMERIC(10, 2) NOT NULL, company_id INT NOT NULL, visit_id INT NOT NULL, INDEX IDX_C043D8DC979B1AD6 (company_id), INDEX IDX_C043D8DC75FA0FF2 (visit_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE account_entry ADD CONSTRAINT FK_1DAE4401979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE account_entry ADD CONSTRAINT FK_1DAE44019B6B5FBA FOREIGN KEY (account_id) REFERENCES patient_account (id)');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EB979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE patient_account ADD CONSTRAINT FK_2055034F979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE patient_account ADD CONSTRAINT FK_2055034F6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DC2F8ABF4 FOREIGN KEY (account_entry_id) REFERENCES account_entry (id)');
        $this->addSql('ALTER TABLE visit ADD CONSTRAINT FK_437EE939979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE visit ADD CONSTRAINT FK_437EE9396B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE visit_item ADD CONSTRAINT FK_C043D8DC979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE visit_item ADD CONSTRAINT FK_C043D8DC75FA0FF2 FOREIGN KEY (visit_id) REFERENCES visit (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account_entry DROP FOREIGN KEY FK_1DAE4401979B1AD6');
        $this->addSql('ALTER TABLE account_entry DROP FOREIGN KEY FK_1DAE44019B6B5FBA');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EB979B1AD6');
        $this->addSql('ALTER TABLE patient_account DROP FOREIGN KEY FK_2055034F979B1AD6');
        $this->addSql('ALTER TABLE patient_account DROP FOREIGN KEY FK_2055034F6B899279');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D979B1AD6');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DC2F8ABF4');
        $this->addSql('ALTER TABLE visit DROP FOREIGN KEY FK_437EE939979B1AD6');
        $this->addSql('ALTER TABLE visit DROP FOREIGN KEY FK_437EE9396B899279');
        $this->addSql('ALTER TABLE visit_item DROP FOREIGN KEY FK_C043D8DC979B1AD6');
        $this->addSql('ALTER TABLE visit_item DROP FOREIGN KEY FK_C043D8DC75FA0FF2');
        $this->addSql('DROP TABLE account_entry');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE patient_account');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE visit');
        $this->addSql('DROP TABLE visit_item');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
