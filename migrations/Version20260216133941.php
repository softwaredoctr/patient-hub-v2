<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260216133941 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account_entry ADD CONSTRAINT FK_1DAE4401979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE account_entry ADD CONSTRAINT FK_1DAE44019B6B5FBA FOREIGN KEY (account_id) REFERENCES patient_account (id)');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EB979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE patient_account ADD CONSTRAINT FK_2055034F979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE patient_account ADD CONSTRAINT FK_2055034F6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DC2F8ABF4 FOREIGN KEY (account_entry_id) REFERENCES account_entry (id)');
        $this->addSql('ALTER TABLE user ADD password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
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
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649979B1AD6');
        $this->addSql('ALTER TABLE user DROP password');
        $this->addSql('ALTER TABLE visit DROP FOREIGN KEY FK_437EE939979B1AD6');
        $this->addSql('ALTER TABLE visit DROP FOREIGN KEY FK_437EE9396B899279');
        $this->addSql('ALTER TABLE visit_item DROP FOREIGN KEY FK_C043D8DC979B1AD6');
        $this->addSql('ALTER TABLE visit_item DROP FOREIGN KEY FK_C043D8DC75FA0FF2');
    }
}
