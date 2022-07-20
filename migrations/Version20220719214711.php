<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220719214711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hooly DROP FOREIGN KEY FK_AF3F4DEAFA916F54');
        $this->addSql('DROP INDEX IDX_AF3F4DEAFA916F54 ON hooly');
        $this->addSql('ALTER TABLE hooly DROP foodtruck_id_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hooly ADD foodtruck_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE hooly ADD CONSTRAINT FK_AF3F4DEAFA916F54 FOREIGN KEY (foodtruck_id_id) REFERENCES parking (id)');
        $this->addSql('CREATE INDEX IDX_AF3F4DEAFA916F54 ON hooly (foodtruck_id_id)');
    }
}
