<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200407143408 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tennis_match (id INT AUTO_INCREMENT NOT NULL, tennis_tour_id INT DEFAULT NULL, etat VARCHAR(30) NOT NULL, INDEX IDX_7510D177123E4D01 (tennis_tour_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tennis_set (id INT AUTO_INCREMENT NOT NULL, tennis_match_id INT DEFAULT NULL, tennis_joueur_un_id INT DEFAULT NULL, tennis_joueur_deux_id INT DEFAULT NULL, nb_jeux_du_joueur_un INT NOT NULL, nb_jeux_du_joueur_deux INT NOT NULL, INDEX IDX_F862BF9B26B5FAA (tennis_match_id), INDEX IDX_F862BF9F9AC4537 (tennis_joueur_un_id), INDEX IDX_F862BF9C90CE140 (tennis_joueur_deux_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tennis_tour (id INT AUTO_INCREMENT NOT NULL, tennis_tournoi_id INT DEFAULT NULL, type VARCHAR(30) NOT NULL, date_fin_tour DATE NOT NULL, statut VARCHAR(30) NOT NULL, numero INT NOT NULL, INDEX IDX_213CBF2051397A83 (tennis_tournoi_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tennis_tournoi (id INT AUTO_INCREMENT NOT NULL, tennis_utilisateur_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, date_debut_tournoi DATE NOT NULL, date_fin_tournoi DATE NOT NULL, est_visible TINYINT(1) NOT NULL, surface VARCHAR(30) NOT NULL, categorie_age VARCHAR(10) NOT NULL, genre_homme TINYINT(1) NOT NULL, description VARCHAR(255) DEFAULT NULL, date_debut_inscriptions DATE NOT NULL, date_fin_inscriptions DATE NOT NULL, inscriptions_manuelles TINYINT(1) NOT NULL, nb_places INT NOT NULL, mot_de_passe VARCHAR(255) DEFAULT NULL, validation_inscriptions TINYINT(1) NOT NULL, nb_sets_gagnants INT NOT NULL, statut VARCHAR(30) NOT NULL, INDEX IDX_1F7C199D6A76A69B (tennis_utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tennis_tournoi_tennis_utilisateur (tennis_tournoi_id INT NOT NULL, tennis_utilisateur_id INT NOT NULL, INDEX IDX_D8A0E9E251397A83 (tennis_tournoi_id), INDEX IDX_D8A0E9E26A76A69B (tennis_utilisateur_id), PRIMARY KEY(tennis_tournoi_id, tennis_utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tennis_utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, date_naissance DATE NOT NULL, telephone VARCHAR(15) NOT NULL, niveau VARCHAR(25) NOT NULL, genre_homme TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_89DF663AE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tennis_utilisateur_tennis_match (tennis_utilisateur_id INT NOT NULL, tennis_match_id INT NOT NULL, INDEX IDX_53B5CF896A76A69B (tennis_utilisateur_id), INDEX IDX_53B5CF89B26B5FAA (tennis_match_id), PRIMARY KEY(tennis_utilisateur_id, tennis_match_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tennis_utilisateur_tennis_tournoi (tennis_utilisateur_id INT NOT NULL, tennis_tournoi_id INT NOT NULL, INDEX IDX_6F4CCE686A76A69B (tennis_utilisateur_id), INDEX IDX_6F4CCE6851397A83 (tennis_tournoi_id), PRIMARY KEY(tennis_utilisateur_id, tennis_tournoi_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tennis_match ADD CONSTRAINT FK_7510D177123E4D01 FOREIGN KEY (tennis_tour_id) REFERENCES tennis_tour (id)');
        $this->addSql('ALTER TABLE tennis_set ADD CONSTRAINT FK_F862BF9B26B5FAA FOREIGN KEY (tennis_match_id) REFERENCES tennis_match (id)');
        $this->addSql('ALTER TABLE tennis_set ADD CONSTRAINT FK_F862BF9F9AC4537 FOREIGN KEY (tennis_joueur_un_id) REFERENCES tennis_utilisateur (id)');
        $this->addSql('ALTER TABLE tennis_set ADD CONSTRAINT FK_F862BF9C90CE140 FOREIGN KEY (tennis_joueur_deux_id) REFERENCES tennis_utilisateur (id)');
        $this->addSql('ALTER TABLE tennis_tour ADD CONSTRAINT FK_213CBF2051397A83 FOREIGN KEY (tennis_tournoi_id) REFERENCES tennis_tournoi (id)');
        $this->addSql('ALTER TABLE tennis_tournoi ADD CONSTRAINT FK_1F7C199D6A76A69B FOREIGN KEY (tennis_utilisateur_id) REFERENCES tennis_utilisateur (id)');
        $this->addSql('ALTER TABLE tennis_tournoi_tennis_utilisateur ADD CONSTRAINT FK_D8A0E9E251397A83 FOREIGN KEY (tennis_tournoi_id) REFERENCES tennis_tournoi (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tennis_tournoi_tennis_utilisateur ADD CONSTRAINT FK_D8A0E9E26A76A69B FOREIGN KEY (tennis_utilisateur_id) REFERENCES tennis_utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tennis_utilisateur_tennis_match ADD CONSTRAINT FK_53B5CF896A76A69B FOREIGN KEY (tennis_utilisateur_id) REFERENCES tennis_utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tennis_utilisateur_tennis_match ADD CONSTRAINT FK_53B5CF89B26B5FAA FOREIGN KEY (tennis_match_id) REFERENCES tennis_match (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tennis_utilisateur_tennis_tournoi ADD CONSTRAINT FK_6F4CCE686A76A69B FOREIGN KEY (tennis_utilisateur_id) REFERENCES tennis_utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tennis_utilisateur_tennis_tournoi ADD CONSTRAINT FK_6F4CCE6851397A83 FOREIGN KEY (tennis_tournoi_id) REFERENCES tennis_tournoi (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tennis_set DROP FOREIGN KEY FK_F862BF9B26B5FAA');
        $this->addSql('ALTER TABLE tennis_utilisateur_tennis_match DROP FOREIGN KEY FK_53B5CF89B26B5FAA');
        $this->addSql('ALTER TABLE tennis_match DROP FOREIGN KEY FK_7510D177123E4D01');
        $this->addSql('ALTER TABLE tennis_tour DROP FOREIGN KEY FK_213CBF2051397A83');
        $this->addSql('ALTER TABLE tennis_tournoi_tennis_utilisateur DROP FOREIGN KEY FK_D8A0E9E251397A83');
        $this->addSql('ALTER TABLE tennis_utilisateur_tennis_tournoi DROP FOREIGN KEY FK_6F4CCE6851397A83');
        $this->addSql('ALTER TABLE tennis_set DROP FOREIGN KEY FK_F862BF9F9AC4537');
        $this->addSql('ALTER TABLE tennis_set DROP FOREIGN KEY FK_F862BF9C90CE140');
        $this->addSql('ALTER TABLE tennis_tournoi DROP FOREIGN KEY FK_1F7C199D6A76A69B');
        $this->addSql('ALTER TABLE tennis_tournoi_tennis_utilisateur DROP FOREIGN KEY FK_D8A0E9E26A76A69B');
        $this->addSql('ALTER TABLE tennis_utilisateur_tennis_match DROP FOREIGN KEY FK_53B5CF896A76A69B');
        $this->addSql('ALTER TABLE tennis_utilisateur_tennis_tournoi DROP FOREIGN KEY FK_6F4CCE686A76A69B');
        $this->addSql('DROP TABLE tennis_match');
        $this->addSql('DROP TABLE tennis_set');
        $this->addSql('DROP TABLE tennis_tour');
        $this->addSql('DROP TABLE tennis_tournoi');
        $this->addSql('DROP TABLE tennis_tournoi_tennis_utilisateur');
        $this->addSql('DROP TABLE tennis_utilisateur');
        $this->addSql('DROP TABLE tennis_utilisateur_tennis_match');
        $this->addSql('DROP TABLE tennis_utilisateur_tennis_tournoi');
    }
}
