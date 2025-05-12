<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250512090053 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE coordonnees (id INT AUTO_INCREMENT NOT NULL, coordonnees_id INT DEFAULT NULL, adresse VARCHAR(255) NOT NULL, longitude DOUBLE PRECISION DEFAULT NULL, latitude DOUBLE PRECISION DEFAULT NULL, code_postal VARCHAR(8) NOT NULL, INDEX IDX_BC8EC7A5853DEDF (coordonnees_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE etat_object_to_rent (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE object_to_rent (id INT AUTO_INCREMENT NOT NULL, coordonnee_id INT DEFAULT NULL, user_id INT DEFAULT NULL, type_object_to_rent_id INT DEFAULT NULL, etat_object_to_rent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description_text LONGTEXT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, surface DOUBLE PRECISION DEFAULT NULL, nbr_pieces SMALLINT DEFAULT NULL, nbr_salle_de_bain SMALLINT DEFAULT NULL, nbr_salle_deau SMALLINT DEFAULT NULL, cuisine_equipe TINYINT(1) DEFAULT NULL, terasse TINYINT(1) DEFAULT NULL, balcon TINYINT(1) DEFAULT NULL, jardin TINYINT(1) DEFAULT NULL, piscine TINYINT(1) DEFAULT NULL, accessible_fauteuils_roulants TINYINT(1) DEFAULT NULL, garage TINYINT(1) DEFAULT NULL, sous_sol TINYINT(1) DEFAULT NULL, nbr_terasse SMALLINT DEFAULT NULL, surface_balcon DOUBLE PRECISION DEFAULT NULL, nbr_chambres SMALLINT DEFAULT NULL, annee_construction INT DEFAULT NULL, surface_terrain DOUBLE PRECISION DEFAULT NULL, activated TINYINT(1) NOT NULL, INDEX IDX_E5D8DCA3F202EC33 (coordonnee_id), INDEX IDX_E5D8DCA3A76ED395 (user_id), INDEX IDX_E5D8DCA3A4CBEA82 (type_object_to_rent_id), INDEX IDX_E5D8DCA3F3C46161 (etat_object_to_rent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE quartier (id INT AUTO_INCREMENT NOT NULL, city_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_FEE8962D8BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE type_object_to_rent (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE coordonnees ADD CONSTRAINT FK_BC8EC7A5853DEDF FOREIGN KEY (coordonnees_id) REFERENCES quartier (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE object_to_rent ADD CONSTRAINT FK_E5D8DCA3F202EC33 FOREIGN KEY (coordonnee_id) REFERENCES coordonnees (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE object_to_rent ADD CONSTRAINT FK_E5D8DCA3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE object_to_rent ADD CONSTRAINT FK_E5D8DCA3A4CBEA82 FOREIGN KEY (type_object_to_rent_id) REFERENCES type_object_to_rent (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE object_to_rent ADD CONSTRAINT FK_E5D8DCA3F3C46161 FOREIGN KEY (etat_object_to_rent_id) REFERENCES etat_object_to_rent (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quartier ADD CONSTRAINT FK_FEE8962D8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE coordonnees DROP FOREIGN KEY FK_BC8EC7A5853DEDF
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE object_to_rent DROP FOREIGN KEY FK_E5D8DCA3F202EC33
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE object_to_rent DROP FOREIGN KEY FK_E5D8DCA3A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE object_to_rent DROP FOREIGN KEY FK_E5D8DCA3A4CBEA82
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE object_to_rent DROP FOREIGN KEY FK_E5D8DCA3F3C46161
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quartier DROP FOREIGN KEY FK_FEE8962D8BAC62AF
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE city
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE coordonnees
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE etat_object_to_rent
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE object_to_rent
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE quartier
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE type_object_to_rent
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
