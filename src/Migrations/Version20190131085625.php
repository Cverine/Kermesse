<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190131085625 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE participation ADD manual TINYINT(1) DEFAULT TRUE');
        $this->addSql('ALTER TABLE volunteer ADD grade VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE stall CHANGE grade grade VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F8EFAB6B1');
        $this->addSql('DROP INDEX IDX_AB55E24F8EFAB6B1 ON participation');
        $this->addSql('ALTER TABLE participation DROP volunteer_id, CHANGE slot slot INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE participation ADD volunteer_id INT DEFAULT NULL, CHANGE slot slot VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F8EFAB6B1 FOREIGN KEY (volunteer_id) REFERENCES volunteer (id)');
        $this->addSql('CREATE INDEX IDX_AB55E24F8EFAB6B1 ON participation (volunteer_id)');
        $this->addSql('ALTER TABLE stall CHANGE grade grade VARCHAR(255) DEFAULT \'GRADE_PRIMAIRE\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE volunteer DROP grade');
        $this->addSql('ALTER TABLE participation DROP manual');
    }
}
