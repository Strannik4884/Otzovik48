<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200530235041 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE comment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE comment (id INT NOT NULL, by_user_id INT NOT NULL, for_product_id INT NOT NULL, text VARCHAR(512) NOT NULL, rating INT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9474526CDC9C2434 ON comment (by_user_id)');
        $this->addSql('CREATE INDEX IDX_9474526C91E8A96 ON comment (for_product_id)');
        $this->addSql('CREATE TABLE product (id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(512) NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, photo VARCHAR(1024) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CDC9C2434 FOREIGN KEY (by_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C91E8A96 FOREIGN KEY (for_product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ALTER login TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE "user" ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE "user" ALTER name TYPE VARCHAR(255)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526C91E8A96');
        $this->addSql('DROP SEQUENCE comment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE product_id_seq CASCADE');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE product');
        $this->addSql('ALTER TABLE "user" ALTER login TYPE VARCHAR(200)');
        $this->addSql('ALTER TABLE "user" ALTER email TYPE VARCHAR(256)');
        $this->addSql('ALTER TABLE "user" ALTER name TYPE VARCHAR(200)');
    }
}
