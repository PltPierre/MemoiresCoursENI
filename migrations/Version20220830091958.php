<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220830091958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE memoire_tableau (memoire_id INT NOT NULL, tableau_id INT NOT NULL, INDEX IDX_6A4BD643DE665C15 (memoire_id), INDEX IDX_6A4BD643B062D5BC (tableau_id), PRIMARY KEY(memoire_id, tableau_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tableau (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, url LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE memoire_tableau ADD CONSTRAINT FK_6A4BD643DE665C15 FOREIGN KEY (memoire_id) REFERENCES memoire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE memoire_tableau ADD CONSTRAINT FK_6A4BD643B062D5BC FOREIGN KEY (tableau_id) REFERENCES tableau (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE memoire_tableau DROP FOREIGN KEY FK_6A4BD643DE665C15');
        $this->addSql('ALTER TABLE memoire_tableau DROP FOREIGN KEY FK_6A4BD643B062D5BC');
        $this->addSql('DROP TABLE memoire_tableau');
        $this->addSql('DROP TABLE tableau');
    }
}
