<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250612122402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE contact ADD categorie_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contact ADD CONSTRAINT FK_4C62E638BCF5E72D FOREIGN KEY (categorie_id) REFERENCES category (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_4C62E638BCF5E72D ON contact (categorie_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638BCF5E72D
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_4C62E638BCF5E72D ON contact
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contact DROP categorie_id
        SQL);
    }
}
