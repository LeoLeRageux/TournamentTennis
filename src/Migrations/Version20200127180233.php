<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200127180233 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tennis_tournoi (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, date_debut_tournoi DATE NOT NULL, date_fin_tournoi DATE NOT NULL, est_visible TINYINT(1) NOT NULL, surface VARCHAR(30) NOT NULL, categorie_age VARCHAR(10) NOT NULL, genre_homme TINYINT(1) NOT NULL, description VARCHAR(255) DEFAULT NULL, date_debut_inscriptions DATE NOT NULL, date_fin_inscriptions DATE NOT NULL, inscriptions_manuelles TINYINT(1) NOT NULL, nb_places INT NOT NULL, mot_de_passe VARCHAR(255) DEFAULT NULL, validation_inscriptions TINYINT(1) NOT NULL, nb_sets_gagnants INT NOT NULL, statut VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tennis_match (id INT AUTO_INCREMENT NOT NULL, tennis_tour_id INT DEFAULT NULL, etat VARCHAR(30) NOT NULL, INDEX IDX_7510D177123E4D01 (tennis_tour_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tennis_tour (id INT AUTO_INCREMENT NOT NULL, tennis_tournoi_id INT DEFAULT NULL, type VARCHAR(30) NOT NULL, date_fin_tour DATE NOT NULL, statut VARCHAR(30) NOT NULL, numero INT NOT NULL, INDEX IDX_213CBF2051397A83 (tennis_tournoi_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tennis_set (id INT AUTO_INCREMENT NOT NULL, tennis_match_id INT DEFAULT NULL, nb_jeux_du_gagnant INT NOT NULL, nb_jeux_du_perdant INT NOT NULL, INDEX IDX_F862BF9B26B5FAA (tennis_match_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tennis_match ADD CONSTRAINT FK_7510D177123E4D01 FOREIGN KEY (tennis_tour_id) REFERENCES tennis_tour (id)');
        $this->addSql('ALTER TABLE tennis_tour ADD CONSTRAINT FK_213CBF2051397A83 FOREIGN KEY (tennis_tournoi_id) REFERENCES tennis_tournoi (id)');
        $this->addSql('ALTER TABLE tennis_set ADD CONSTRAINT FK_F862BF9B26B5FAA FOREIGN KEY (tennis_match_id) REFERENCES tennis_match (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tennis_tour DROP FOREIGN KEY FK_213CBF2051397A83');
        $this->addSql('ALTER TABLE tennis_set DROP FOREIGN KEY FK_F862BF9B26B5FAA');
        $this->addSql('ALTER TABLE tennis_match DROP FOREIGN KEY FK_7510D177123E4D01');
        $this->addSql('DROP TABLE tennis_tournoi');
        $this->addSql('DROP TABLE tennis_match');
        $this->addSql('DROP TABLE tennis_tour');
        $this->addSql('DROP TABLE tennis_set');
    }
}
