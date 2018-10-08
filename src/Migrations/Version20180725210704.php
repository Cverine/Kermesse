<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180725210704 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE volunteer CHANGE phone phone VARCHAR(255) DEFAULT NULL, CHANGE second_slot second_slot TINYINT(1) NOT NULL, CHANGE third_slot third_slot TINYINT(1) NOT NULL, CHANGE prepare prepare TINYINT(1) NOT NULL, CHANGE tidy tidy TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE stall CHANGE nb_volunteer nb_volunteer SMALLINT DEFAULT NULL, CHANGE first_slot first_slot TINYINT(1) NOT NULL, CHANGE second_slot second_slot TINYINT(1) NOT NULL, CHANGE third_slot third_slot TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE stall CHANGE nb_volunteer nb_volunteer SMALLINT NOT NULL, CHANGE first_slot first_slot TINYINT(1) DEFAULT NULL, CHANGE second_slot second_slot TINYINT(1) DEFAULT NULL, CHANGE third_slot third_slot TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE volunteer CHANGE phone phone VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE second_slot second_slot TINYINT(1) DEFAULT NULL, CHANGE third_slot third_slot TINYINT(1) DEFAULT NULL, CHANGE prepare prepare TINYINT(1) DEFAULT NULL, CHANGE tidy tidy TINYINT(1) DEFAULT NULL');
    }
}
