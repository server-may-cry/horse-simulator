<?php declare(strict_types=1);
namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190720193942 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE horse (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, race_id INTEGER NOT NULL, speed float NOT NULL --(DC2Type:speed)
        , strength float NOT NULL --(DC2Type:strength)
        , endurance float NOT NULL --(DC2Type:endurance)
        , progress float NOT NULL --(DC2Type:progress)
        , time float NOT NULL --(DC2Type:time)
        )');
        $this->addSql('CREATE INDEX IDX_629A2F186E59D40D ON horse (race_id)');
        $this->addSql('CREATE INDEX search_fastest ON horse (progress, time)');
        $this->addSql('CREATE TABLE race (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, is_finished BOOLEAN NOT NULL)');
        $this->addSql('CREATE INDEX check_active_limits ON race (is_finished)');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE horse');
        $this->addSql('DROP TABLE race');
    }
}
