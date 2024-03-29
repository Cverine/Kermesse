<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180927200320 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE volunteer ADD is_sitting TINYINT(1) NOT NULL, CHANGE first_slot first_slot TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE stall ADD is_sitting TINYINT(1) NOT NULL');
//        $this->addSql('RENAME TABLE participations ADD is_sitting TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE stall DROP is_sitting');
        $this->addSql('ALTER TABLE volunteer DROP is_sitting, CHANGE first_slot first_slot TINYINT(1) DEFAULT NULL');
    }
}
