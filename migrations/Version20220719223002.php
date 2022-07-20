<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220719223002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking_log (id INT AUTO_INCREMENT NOT NULL, status LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', foodtruck_id INT NOT NULL, entreprise_id INT NOT NULL, parking_id INT NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parking DROP FOREIGN KEY parking_fkey_entreprise_id');
        $this->addSql('DROP INDEX parking_fkey_entreprise_id ON parking');
        $this->addSql('ALTER TABLE parking DROP entreprise_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE booking_log');
        $this->addSql('ALTER TABLE parking ADD entreprise_id INT NOT NULL');
        $this->addSql('ALTER TABLE parking ADD CONSTRAINT parking_fkey_entreprise_id FOREIGN KEY (entreprise_id) REFERENCES hooly (id)');
        $this->addSql('CREATE INDEX parking_fkey_entreprise_id ON parking (entreprise_id)');
    }
}
