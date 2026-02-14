<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260214153430 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE water_meter ADD location_id INT NOT NULL');
        $this->addSql('ALTER TABLE water_meter DROP location');
        $this->addSql('ALTER TABLE water_meter ADD CONSTRAINT FK_A9F3254764D218E FOREIGN KEY (location_id) REFERENCES location (id) NOT DEFERRABLE');
        $this->addSql('CREATE INDEX IDX_A9F3254764D218E ON water_meter (location_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE water_meter DROP CONSTRAINT FK_A9F3254764D218E');
        $this->addSql('DROP INDEX IDX_A9F3254764D218E');
        $this->addSql('ALTER TABLE water_meter ADD location VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE water_meter DROP location_id');
    }
}
