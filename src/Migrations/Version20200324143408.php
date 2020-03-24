<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200324143408 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tennis_tournoi_tennis_utilisateur (tennis_tournoi_id INT NOT NULL, tennis_utilisateur_id INT NOT NULL, INDEX IDX_D8A0E9E251397A83 (tennis_tournoi_id), INDEX IDX_D8A0E9E26A76A69B (tennis_utilisateur_id), PRIMARY KEY(tennis_tournoi_id, tennis_utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tennis_tournoi_tennis_utilisateur ADD CONSTRAINT FK_D8A0E9E251397A83 FOREIGN KEY (tennis_tournoi_id) REFERENCES tennis_tournoi (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tennis_tournoi_tennis_utilisateur ADD CONSTRAINT FK_D8A0E9E26A76A69B FOREIGN KEY (tennis_utilisateur_id) REFERENCES tennis_utilisateur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE tennis_tournoi_tennis_utilisateur');
    }
}
