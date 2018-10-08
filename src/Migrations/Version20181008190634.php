<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181008190634 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE participation (id INT AUTO_INCREMENT NOT NULL, volunteer_id INT DEFAULT NULL, stall_id INT DEFAULT NULL, slot VARCHAR(255) NOT NULL, INDEX IDX_AB55E24F8EFAB6B1 (volunteer_id), INDEX IDX_AB55E24F2840AF08 (stall_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F8EFAB6B1 FOREIGN KEY (volunteer_id) REFERENCES volunteer (id)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F2840AF08 FOREIGN KEY (stall_id) REFERENCES stall (id)');
        $this->addSql('DROP TABLE participations');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE participations (id INT AUTO_INCREMENT NOT NULL, volunteer_id INT DEFAULT NULL, stall_id INT DEFAULT NULL, slot VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, INDEX IDX_FDC6C6E88EFAB6B1 (volunteer_id), INDEX IDX_FDC6C6E82840AF08 (stall_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE participations ADD CONSTRAINT FK_FDC6C6E82840AF08 FOREIGN KEY (stall_id) REFERENCES stall (id)');
        $this->addSql('ALTER TABLE participations ADD CONSTRAINT FK_FDC6C6E88EFAB6B1 FOREIGN KEY (volunteer_id) REFERENCES volunteer (id)');
        $this->addSql('DROP TABLE participation');
    }
}
