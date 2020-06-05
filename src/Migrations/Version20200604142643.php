<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200604142643 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE comment RENAME COLUMN date TO created_date');
        $this->addSql('ALTER TABLE product ALTER name TYPE VARCHAR(100)');
        $this->addSql('DROP INDEX uniq_8d93d649aa08cb10');
        $this->addSql('ALTER TABLE "user" DROP login');
        $this->addSql('ALTER TABLE "user" DROP user_photo');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" ADD login VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD user_photo VARCHAR(1024) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX uniq_8d93d649aa08cb10 ON "user" (login)');
        $this->addSql('ALTER TABLE comment RENAME COLUMN created_date TO date');
        $this->addSql('ALTER TABLE product ALTER name TYPE VARCHAR(255)');
    }
}
