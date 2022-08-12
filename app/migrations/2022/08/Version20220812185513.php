<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\Notification;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220812185513 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'INSERT INTO notifications (id, description, is_sms, is_email, is_telegram, template_sms, template_email, template_telegram) VALUES ('
            .Notification::REGISTRATION
            .', \'Registration. \', true, true, false, \'Code: {{ code }}\', \'Code: {{ code }}\', null)'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM notifications WHERE id = :id', ['id' => Notification::REGISTRATION]);
    }
}
