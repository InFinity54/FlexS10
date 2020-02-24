<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200224091554 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE champions (name VARCHAR(255) NOT NULL, display_name VARCHAR(255) NOT NULL, PRIMARY KEY(name)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matchs (id VARCHAR(255) NOT NULL, date DATE NOT NULL, result VARCHAR(255) NOT NULL, duration VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matchs_comp (match_id_id VARCHAR(255) NOT NULL, player_nickname_id INT NOT NULL, championName VARCHAR(255) NOT NULL, INDEX IDX_582BA5CDC12EE1F6 (match_id_id), INDEX IDX_582BA5CD18F488D9 (player_nickname_id), INDEX IDX_582BA5CDEF8CE476 (championName), PRIMARY KEY(match_id_id, player_nickname_id, championName)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matchs_stats (match_id_id VARCHAR(255) NOT NULL, player_id_id INT NOT NULL, kills INT NOT NULL, deaths INT NOT NULL, assists INT NOT NULL, creeps INT NOT NULL, total_damage INT NOT NULL, phys_damage INT NOT NULL, magic_damage INT NOT NULL, raw_damage INT NOT NULL, INDEX IDX_740D21DFC12EE1F6 (match_id_id), INDEX IDX_740D21DFC036E511 (player_id_id), PRIMARY KEY(match_id_id, player_id_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE players (id INT AUTO_INCREMENT NOT NULL, nickname VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE matchs_comp ADD CONSTRAINT FK_582BA5CDC12EE1F6 FOREIGN KEY (match_id_id) REFERENCES matchs (id)');
        $this->addSql('ALTER TABLE matchs_comp ADD CONSTRAINT FK_582BA5CD18F488D9 FOREIGN KEY (player_nickname_id) REFERENCES players (id)');
        $this->addSql('ALTER TABLE matchs_comp ADD CONSTRAINT FK_582BA5CDEF8CE476 FOREIGN KEY (championName) REFERENCES champions (name)');
        $this->addSql('ALTER TABLE matchs_stats ADD CONSTRAINT FK_740D21DFC12EE1F6 FOREIGN KEY (match_id_id) REFERENCES matchs (id)');
        $this->addSql('ALTER TABLE matchs_stats ADD CONSTRAINT FK_740D21DFC036E511 FOREIGN KEY (player_id_id) REFERENCES players (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE matchs_comp DROP FOREIGN KEY FK_582BA5CDEF8CE476');
        $this->addSql('ALTER TABLE matchs_comp DROP FOREIGN KEY FK_582BA5CDC12EE1F6');
        $this->addSql('ALTER TABLE matchs_stats DROP FOREIGN KEY FK_740D21DFC12EE1F6');
        $this->addSql('ALTER TABLE matchs_comp DROP FOREIGN KEY FK_582BA5CD18F488D9');
        $this->addSql('ALTER TABLE matchs_stats DROP FOREIGN KEY FK_740D21DFC036E511');
        $this->addSql('DROP TABLE champions');
        $this->addSql('DROP TABLE matchs');
        $this->addSql('DROP TABLE matchs_comp');
        $this->addSql('DROP TABLE matchs_stats');
        $this->addSql('DROP TABLE players');
    }
}
