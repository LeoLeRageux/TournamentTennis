<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200316195804 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tennis_utilisateur_tennis_match (tennis_utilisateur_id INT NOT NULL, tennis_match_id INT NOT NULL, INDEX IDX_53B5CF896A76A69B (tennis_utilisateur_id), INDEX IDX_53B5CF89B26B5FAA (tennis_match_id), PRIMARY KEY(tennis_utilisateur_id, tennis_match_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tennis_utilisateur_tennis_match ADD CONSTRAINT FK_53B5CF896A76A69B FOREIGN KEY (tennis_utilisateur_id) REFERENCES tennis_utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tennis_utilisateur_tennis_match ADD CONSTRAINT FK_53B5CF89B26B5FAA FOREIGN KEY (tennis_match_id) REFERENCES tennis_match (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tennis_tournoi ADD tennis_utilisateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tennis_tournoi ADD CONSTRAINT FK_1F7C199D6A76A69B FOREIGN KEY (tennis_utilisateur_id) REFERENCES tennis_utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_1F7C199D6A76A69B ON tennis_tournoi (tennis_utilisateur_id)');
        $this->addSql('ALTER TABLE tennis_set ADD tennis_utilisateur_perdant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tennis_set ADD CONSTRAINT FK_F862BF9F8F16EEA FOREIGN KEY (tennis_utilisateur_perdant_id) REFERENCES tennis_utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_F862BF9F8F16EEA ON tennis_set (tennis_utilisateur_perdant_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE tennis_utilisateur_tennis_match');
        $this->addSql('ALTER TABLE tennis_set DROP FOREIGN KEY FK_F862BF9F8F16EEA');
        $this->addSql('DROP INDEX IDX_F862BF9F8F16EEA ON tennis_set');
        $this->addSql('ALTER TABLE tennis_set DROP tennis_utilisateur_perdant_id');
        $this->addSql('ALTER TABLE tennis_tournoi DROP FOREIGN KEY FK_1F7C199D6A76A69B');
        $this->addSql('DROP INDEX IDX_1F7C199D6A76A69B ON tennis_tournoi');
        $this->addSql('ALTER TABLE tennis_tournoi DROP tennis_utilisateur_id');
    }
}
