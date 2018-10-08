<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180711201403 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE participations (id INT AUTO_INCREMENT NOT NULL, volunteer_id INT DEFAULT NULL, stall_id INT DEFAULT NULL, slot VARCHAR(255) NOT NULL, INDEX IDX_FDC6C6E88EFAB6B1 (volunteer_id), INDEX IDX_FDC6C6E82840AF08 (stall_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE volunteer (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) NOT NULL, first_slot TINYINT(1) DEFAULT NULL, second_slot TINYINT(1) DEFAULT NULL, third_slot TINYINT(1) DEFAULT NULL, prepare TINYINT(1) DEFAULT NULL, tidy TINYINT(1) DEFAULT NULL, ok_sensitive TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stall (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, grade VARCHAR(255) DEFAULT NULL, nb_volunteer SMALLINT NOT NULL, first_slot TINYINT(1) DEFAULT NULL, second_slot TINYINT(1) DEFAULT NULL, third_slot TINYINT(1) DEFAULT NULL, prepare TINYINT(1) NOT NULL, tidy TINYINT(1) NOT NULL, is_sensitive TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE participations ADD CONSTRAINT FK_FDC6C6E88EFAB6B1 FOREIGN KEY (volunteer_id) REFERENCES volunteer (id)');
        $this->addSql('ALTER TABLE participations ADD CONSTRAINT FK_FDC6C6E82840AF08 FOREIGN KEY (stall_id) REFERENCES stall (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE participations DROP FOREIGN KEY FK_FDC6C6E88EFAB6B1');
        $this->addSql('ALTER TABLE participations DROP FOREIGN KEY FK_FDC6C6E82840AF08');
        $this->addSql('DROP TABLE participations');
        $this->addSql('DROP TABLE volunteer');
        $this->addSql('DROP TABLE stall');
    }
}
