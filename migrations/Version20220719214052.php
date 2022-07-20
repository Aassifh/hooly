<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220719214052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE foodtruck (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hooly (id INT AUTO_INCREMENT NOT NULL, foodtruck_id_id INT NOT NULL, description VARCHAR(255) DEFAULT NULL, available_places INT NOT NULL, date_update DATETIME NOT NULL, add_date DATETIME DEFAULT NULL, INDEX IDX_AF3F4DEAFA916F54 (foodtruck_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parking (id INT AUTO_INCREMENT NOT NULL, foodtruck_id_id INT NOT NULL, entreprise_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_B237527AFA916F54 (foodtruck_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hooly ADD CONSTRAINT FK_AF3F4DEAFA916F54 FOREIGN KEY (foodtruck_id_id) REFERENCES parking (id)');
        $this->addSql('ALTER TABLE parking ADD CONSTRAINT FK_B237527AFA916F54 FOREIGN KEY (foodtruck_id_id) REFERENCES parking (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hooly DROP FOREIGN KEY FK_AF3F4DEAFA916F54');
        $this->addSql('ALTER TABLE parking DROP FOREIGN KEY FK_B237527AFA916F54');
        $this->addSql('DROP TABLE foodtruck');
        $this->addSql('DROP TABLE hooly');
        $this->addSql('DROP TABLE parking');
    }
}
