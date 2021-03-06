<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210211082018 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adresse (id INT AUTO_INCREMENT NOT NULL, denomination VARCHAR(200) NOT NULL, libelle_voie VARCHAR(200) NOT NULL, ville VARCHAR(100) NOT NULL, pays VARCHAR(100) NOT NULL, code_postal VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT NOT NULL, date_naissance DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE praticien (id INT NOT NULL, adresse_id INT NOT NULL, specialite VARCHAR(100) NOT NULL, INDEX IDX_D9A27D34DE7DC5C (adresse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rendez_vous (id INT AUTO_INCREMENT NOT NULL, patient_id INT DEFAULT NULL, praticien_id INT DEFAULT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, motif VARCHAR(100) NOT NULL, INDEX IDX_65E8AA0A6B899279 (patient_id), INDEX IDX_65E8AA0A2391866B (praticien_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE suivre (id INT AUTO_INCREMENT NOT NULL, praticien_id INT DEFAULT NULL, patient_id INT DEFAULT NULL, INDEX IDX_3BC593BB2391866B (praticien_id), INDEX IDX_3BC593BB6B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, date_inscription DATETIME NOT NULL, email VARCHAR(120) NOT NULL, telephone VARCHAR(255) NOT NULL, role VARCHAR(100) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EBBF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE praticien ADD CONSTRAINT FK_D9A27D34DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE praticien ADD CONSTRAINT FK_D9A27D3BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A2391866B FOREIGN KEY (praticien_id) REFERENCES praticien (id)');
        $this->addSql('ALTER TABLE suivre ADD CONSTRAINT FK_3BC593BB2391866B FOREIGN KEY (praticien_id) REFERENCES praticien (id)');
        $this->addSql('ALTER TABLE suivre ADD CONSTRAINT FK_3BC593BB6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE praticien DROP FOREIGN KEY FK_D9A27D34DE7DC5C');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A6B899279');
        $this->addSql('ALTER TABLE suivre DROP FOREIGN KEY FK_3BC593BB6B899279');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A2391866B');
        $this->addSql('ALTER TABLE suivre DROP FOREIGN KEY FK_3BC593BB2391866B');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EBBF396750');
        $this->addSql('ALTER TABLE praticien DROP FOREIGN KEY FK_D9A27D3BF396750');
        $this->addSql('DROP TABLE adresse');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE praticien');
        $this->addSql('DROP TABLE rendez_vous');
        $this->addSql('DROP TABLE suivre');
        $this->addSql('DROP TABLE user');
    }
}
