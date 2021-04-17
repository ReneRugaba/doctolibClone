<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210415181636 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adresse (id INT AUTO_INCREMENT NOT NULL, num_rue INT NOT NULL, rue VARCHAR(100) NOT NULL, code_postal INT NOT NULL, ville VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consultation (id INT AUTO_INCREMENT NOT NULL, practicien_id INT DEFAULT NULL, patient_id INT DEFAULT NULL, date_rdv DATETIME NOT NULL, INDEX IDX_964685A6321E966A (practicien_id), INDEX IDX_964685A66B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, name VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, INDEX IDX_E01FBE6A6B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images_praticien (id INT AUTO_INCREMENT NOT NULL, praticien_id INT NOT NULL, name VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, INDEX IDX_A05E8CE82391866B (praticien_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, adresse_id INT DEFAULT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, date_naissance DATETIME NOT NULL, email VARCHAR(100) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, INDEX IDX_1ADAD7EB4DE7DC5C (adresse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient_practicien (patient_id INT NOT NULL, practicien_id INT NOT NULL, INDEX IDX_3CD771B6B899279 (patient_id), INDEX IDX_3CD771B321E966A (practicien_id), PRIMARY KEY(patient_id, practicien_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE practicien (id INT AUTO_INCREMENT NOT NULL, adresse_id INT NOT NULL, specialite_id INT NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, INDEX IDX_B50DD1F44DE7DC5C (adresse_id), INDEX IDX_B50DD1F42195E0F0 (specialite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE specialite (id INT AUTO_INCREMENT NOT NULL, specialite VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A6321E966A FOREIGN KEY (practicien_id) REFERENCES practicien (id)');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A66B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE images_praticien ADD CONSTRAINT FK_A05E8CE82391866B FOREIGN KEY (praticien_id) REFERENCES practicien (id)');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EB4DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE patient_practicien ADD CONSTRAINT FK_3CD771B6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE patient_practicien ADD CONSTRAINT FK_3CD771B321E966A FOREIGN KEY (practicien_id) REFERENCES practicien (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE practicien ADD CONSTRAINT FK_B50DD1F44DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE practicien ADD CONSTRAINT FK_B50DD1F42195E0F0 FOREIGN KEY (specialite_id) REFERENCES specialite (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EB4DE7DC5C');
        $this->addSql('ALTER TABLE practicien DROP FOREIGN KEY FK_B50DD1F44DE7DC5C');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A66B899279');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A6B899279');
        $this->addSql('ALTER TABLE patient_practicien DROP FOREIGN KEY FK_3CD771B6B899279');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A6321E966A');
        $this->addSql('ALTER TABLE images_praticien DROP FOREIGN KEY FK_A05E8CE82391866B');
        $this->addSql('ALTER TABLE patient_practicien DROP FOREIGN KEY FK_3CD771B321E966A');
        $this->addSql('ALTER TABLE practicien DROP FOREIGN KEY FK_B50DD1F42195E0F0');
        $this->addSql('DROP TABLE adresse');
        $this->addSql('DROP TABLE consultation');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE images_praticien');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE patient_practicien');
        $this->addSql('DROP TABLE practicien');
        $this->addSql('DROP TABLE specialite');
    }
}
