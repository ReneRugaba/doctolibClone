<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201216194250 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE patient_practicien (patient_id INT NOT NULL, practicien_id INT NOT NULL, INDEX IDX_3CD771B6B899279 (patient_id), INDEX IDX_3CD771B321E966A (practicien_id), PRIMARY KEY(patient_id, practicien_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE praticien (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE patient_practicien ADD CONSTRAINT FK_3CD771B6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE patient_practicien ADD CONSTRAINT FK_3CD771B321E966A FOREIGN KEY (practicien_id) REFERENCES practicien (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE consultation ADD practicien_id INT DEFAULT NULL, ADD patient_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A6321E966A FOREIGN KEY (practicien_id) REFERENCES practicien (id)');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A66B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('CREATE INDEX IDX_964685A6321E966A ON consultation (practicien_id)');
        $this->addSql('CREATE INDEX IDX_964685A66B899279 ON consultation (patient_id)');
        $this->addSql('ALTER TABLE patient ADD adresse_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EB4DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('CREATE INDEX IDX_1ADAD7EB4DE7DC5C ON patient (adresse_id)');
        $this->addSql('ALTER TABLE practicien ADD adresse_id INT NOT NULL, ADD specialite_id INT NOT NULL');
        $this->addSql('ALTER TABLE practicien ADD CONSTRAINT FK_B50DD1F44DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE practicien ADD CONSTRAINT FK_B50DD1F42195E0F0 FOREIGN KEY (specialite_id) REFERENCES specialite (id)');
        $this->addSql('CREATE INDEX IDX_B50DD1F44DE7DC5C ON practicien (adresse_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B50DD1F42195E0F0 ON practicien (specialite_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE patient_practicien');
        $this->addSql('DROP TABLE praticien');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A6321E966A');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A66B899279');
        $this->addSql('DROP INDEX IDX_964685A6321E966A ON consultation');
        $this->addSql('DROP INDEX IDX_964685A66B899279 ON consultation');
        $this->addSql('ALTER TABLE consultation DROP practicien_id, DROP patient_id');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EB4DE7DC5C');
        $this->addSql('DROP INDEX IDX_1ADAD7EB4DE7DC5C ON patient');
        $this->addSql('ALTER TABLE patient DROP adresse_id');
        $this->addSql('ALTER TABLE practicien DROP FOREIGN KEY FK_B50DD1F44DE7DC5C');
        $this->addSql('ALTER TABLE practicien DROP FOREIGN KEY FK_B50DD1F42195E0F0');
        $this->addSql('DROP INDEX IDX_B50DD1F44DE7DC5C ON practicien');
        $this->addSql('DROP INDEX UNIQ_B50DD1F42195E0F0 ON practicien');
        $this->addSql('ALTER TABLE practicien DROP adresse_id, DROP specialite_id');
    }
}
