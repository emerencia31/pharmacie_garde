<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211227015430 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commune (id INT AUTO_INCREMENT NOT NULL, ville_id INT DEFAULT NULL, nom_com VARCHAR(255) NOT NULL, INDEX IDX_E2E2D1EEA73F0036 (ville_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE detail_garde (id INT AUTO_INCREMENT NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, heure_debut TIME NOT NULL, heure_fin TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE detail_respo (id INT AUTO_INCREMENT NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, clause VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE garde (id INT AUTO_INCREMENT NOT NULL, detail_garde_id INT NOT NULL, pharmacie_id INT NOT NULL, nom_garde VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5964B6CDBB3BE15 (detail_garde_id), INDEX IDX_5964B6CBC6D351B (pharmacie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE localisation (id INT AUTO_INCREMENT NOT NULL, commune_id INT DEFAULT NULL, pharmacie_id INT DEFAULT NULL, longitude VARCHAR(255) NOT NULL, latitude VARCHAR(255) NOT NULL, INDEX IDX_BFD3CE8F131A4F72 (commune_id), INDEX IDX_BFD3CE8FBC6D351B (pharmacie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pharmacie (id INT AUTO_INCREMENT NOT NULL, nom_pharma VARCHAR(255) NOT NULL, telephone INT NOT NULL, adresse VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pharmacie_responsable (pharmacie_id INT NOT NULL, responsable_id INT NOT NULL, INDEX IDX_4898DB6CBC6D351B (pharmacie_id), INDEX IDX_4898DB6C53C59D72 (responsable_id), PRIMARY KEY(pharmacie_id, responsable_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, nom_reg VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE responsable (id INT AUTO_INCREMENT NOT NULL, detail_respo_id INT NOT NULL, user_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_52520D072A26A7CA (detail_respo_id), INDEX IDX_52520D07A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ville (id INT AUTO_INCREMENT NOT NULL, region_id INT NOT NULL, nom_ville VARCHAR(255) NOT NULL, INDEX IDX_43C3D9C398260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commune ADD CONSTRAINT FK_E2E2D1EEA73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id)');
        $this->addSql('ALTER TABLE garde ADD CONSTRAINT FK_5964B6CDBB3BE15 FOREIGN KEY (detail_garde_id) REFERENCES detail_garde (id)');
        $this->addSql('ALTER TABLE garde ADD CONSTRAINT FK_5964B6CBC6D351B FOREIGN KEY (pharmacie_id) REFERENCES pharmacie (id)');
        $this->addSql('ALTER TABLE localisation ADD CONSTRAINT FK_BFD3CE8F131A4F72 FOREIGN KEY (commune_id) REFERENCES commune (id)');
        $this->addSql('ALTER TABLE localisation ADD CONSTRAINT FK_BFD3CE8FBC6D351B FOREIGN KEY (pharmacie_id) REFERENCES pharmacie (id)');
        $this->addSql('ALTER TABLE pharmacie_responsable ADD CONSTRAINT FK_4898DB6CBC6D351B FOREIGN KEY (pharmacie_id) REFERENCES pharmacie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pharmacie_responsable ADD CONSTRAINT FK_4898DB6C53C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE responsable ADD CONSTRAINT FK_52520D072A26A7CA FOREIGN KEY (detail_respo_id) REFERENCES detail_respo (id)');
        $this->addSql('ALTER TABLE responsable ADD CONSTRAINT FK_52520D07A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ville ADD CONSTRAINT FK_43C3D9C398260155 FOREIGN KEY (region_id) REFERENCES region (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE localisation DROP FOREIGN KEY FK_BFD3CE8F131A4F72');
        $this->addSql('ALTER TABLE garde DROP FOREIGN KEY FK_5964B6CDBB3BE15');
        $this->addSql('ALTER TABLE responsable DROP FOREIGN KEY FK_52520D072A26A7CA');
        $this->addSql('ALTER TABLE garde DROP FOREIGN KEY FK_5964B6CBC6D351B');
        $this->addSql('ALTER TABLE localisation DROP FOREIGN KEY FK_BFD3CE8FBC6D351B');
        $this->addSql('ALTER TABLE pharmacie_responsable DROP FOREIGN KEY FK_4898DB6CBC6D351B');
        $this->addSql('ALTER TABLE ville DROP FOREIGN KEY FK_43C3D9C398260155');
        $this->addSql('ALTER TABLE pharmacie_responsable DROP FOREIGN KEY FK_4898DB6C53C59D72');
        $this->addSql('ALTER TABLE responsable DROP FOREIGN KEY FK_52520D07A76ED395');
        $this->addSql('ALTER TABLE commune DROP FOREIGN KEY FK_E2E2D1EEA73F0036');
        $this->addSql('DROP TABLE commune');
        $this->addSql('DROP TABLE detail_garde');
        $this->addSql('DROP TABLE detail_respo');
        $this->addSql('DROP TABLE garde');
        $this->addSql('DROP TABLE localisation');
        $this->addSql('DROP TABLE pharmacie');
        $this->addSql('DROP TABLE pharmacie_responsable');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE responsable');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE ville');
    }
}
