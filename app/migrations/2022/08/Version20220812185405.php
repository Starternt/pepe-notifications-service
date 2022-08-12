<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220812185405 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE notifications_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE notifications (id INT NOT NULL, description VARCHAR(1000) DEFAULT NULL, is_sms BOOLEAN NOT NULL, is_email BOOLEAN NOT NULL, is_telegram BOOLEAN NOT NULL, template_sms TEXT DEFAULT NULL, template_email TEXT DEFAULT NULL, template_telegram TEXT DEFAULT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE notifications_id_seq CASCADE');
        $this->addSql('DROP TABLE notifications');
    }
}
