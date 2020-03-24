<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200324090702 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tennis_utilisateur_tennis_tournoi (tennis_utilisateur_id INT NOT NULL, tennis_tournoi_id INT NOT NULL, INDEX IDX_6F4CCE686A76A69B (tennis_utilisateur_id), INDEX IDX_6F4CCE6851397A83 (tennis_tournoi_id), PRIMARY KEY(tennis_utilisateur_id, tennis_tournoi_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tennis_utilisateur_tennis_tournoi ADD CONSTRAINT FK_6F4CCE686A76A69B FOREIGN KEY (tennis_utilisateur_id) REFERENCES tennis_utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tennis_utilisateur_tennis_tournoi ADD CONSTRAINT FK_6F4CCE6851397A83 FOREIGN KEY (tennis_tournoi_id) REFERENCES tennis_tournoi (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tennis_utilisateur CHANGE nom nom VARCHAR(50) NOT NULL, CHANGE date_naissance date_naissance DATE NOT NULL, CHANGE telephone telephone VARCHAR(15) NOT NULL, CHANGE niveau niveau VARCHAR(25) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE tennis_utilisateur_tennis_tournoi');
        $this->addSql('ALTER TABLE tennis_utilisateur CHANGE nom nom VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE date_naissance date_naissance DATE DEFAULT NULL, CHANGE telephone telephone VARCHAR(15) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE niveau niveau VARCHAR(25) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
