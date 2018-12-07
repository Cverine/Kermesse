<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181109171519 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE participation_volunteer (participation_id INT NOT NULL, volunteer_id INT NOT NULL, INDEX IDX_3FC7F0B06ACE3B73 (participation_id), INDEX IDX_3FC7F0B08EFAB6B1 (volunteer_id), PRIMARY KEY(participation_id, volunteer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE participation_volunteer ADD CONSTRAINT FK_3FC7F0B06ACE3B73 FOREIGN KEY (participation_id) REFERENCES participation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participation_volunteer ADD CONSTRAINT FK_3FC7F0B08EFAB6B1 FOREIGN KEY (volunteer_id) REFERENCES volunteer (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE participation_volunteer');
    }
}
