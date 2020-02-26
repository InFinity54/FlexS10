<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200225094747 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE champion (name VARCHAR(255) NOT NULL, display_name VARCHAR(255) NOT NULL, PRIMARY KEY(name)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `match` (id VARCHAR(255) NOT NULL, date DATE NOT NULL, result VARCHAR(255) NOT NULL, duration VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE match_comp (match_id VARCHAR(255) NOT NULL, player VARCHAR(255) NOT NULL, champion VARCHAR(255) NOT NULL, INDEX IDX_AA65DE482ABEACD6 (match_id), INDEX IDX_AA65DE4898197A65 (player), INDEX IDX_AA65DE4845437EB4 (champion), PRIMARY KEY(match_id, player, champion)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE match_stats (match_id VARCHAR(255) NOT NULL, player VARCHAR(255) NOT NULL, kills INT NOT NULL, deaths INT NOT NULL, assists INT NOT NULL, creeps INT NOT NULL, total_damage INT NOT NULL, phys_damage INT NOT NULL, magic_damage INT NOT NULL, raw_damage INT NOT NULL, INDEX IDX_E92D180B2ABEACD6 (match_id), INDEX IDX_E92D180B98197A65 (player), PRIMARY KEY(match_id, player)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player (nickname VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(nickname)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE match_comp ADD CONSTRAINT FK_AA65DE482ABEACD6 FOREIGN KEY (match_id) REFERENCES `match` (id)');
        $this->addSql('ALTER TABLE match_comp ADD CONSTRAINT FK_AA65DE4898197A65 FOREIGN KEY (player) REFERENCES player (nickname)');
        $this->addSql('ALTER TABLE match_comp ADD CONSTRAINT FK_AA65DE4845437EB4 FOREIGN KEY (champion) REFERENCES champion (name)');
        $this->addSql('ALTER TABLE match_stats ADD CONSTRAINT FK_E92D180B2ABEACD6 FOREIGN KEY (match_id) REFERENCES `match` (id)');
        $this->addSql('ALTER TABLE match_stats ADD CONSTRAINT FK_E92D180B98197A65 FOREIGN KEY (player) REFERENCES player (nickname)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE match_comp DROP FOREIGN KEY FK_AA65DE4845437EB4');
        $this->addSql('ALTER TABLE match_comp DROP FOREIGN KEY FK_AA65DE482ABEACD6');
        $this->addSql('ALTER TABLE match_stats DROP FOREIGN KEY FK_E92D180B2ABEACD6');
        $this->addSql('ALTER TABLE match_comp DROP FOREIGN KEY FK_AA65DE4898197A65');
        $this->addSql('ALTER TABLE match_stats DROP FOREIGN KEY FK_E92D180B98197A65');
        $this->addSql('DROP TABLE champion');
        $this->addSql('DROP TABLE `match`');
        $this->addSql('DROP TABLE match_comp');
        $this->addSql('DROP TABLE match_stats');
        $this->addSql('DROP TABLE player');
    }
}
