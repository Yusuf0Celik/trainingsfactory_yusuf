<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230111111118 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lesson_user DROP FOREIGN KEY FK_B4E2102DA76ED395');
        $this->addSql('ALTER TABLE lesson_user DROP FOREIGN KEY FK_B4E2102DCDF80196');
        $this->addSql('DROP TABLE lesson_user');
        $this->addSql('ALTER TABLE lesson DROP FOREIGN KEY FK_F87474F3AC78BCF8');
        $this->addSql('DROP INDEX IDX_F87474F3AC78BCF8 ON lesson');
        $this->addSql('ALTER TABLE lesson DROP sport_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lesson_user (lesson_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_B4E2102DCDF80196 (lesson_id), INDEX IDX_B4E2102DA76ED395 (user_id), PRIMARY KEY(lesson_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE lesson_user ADD CONSTRAINT FK_B4E2102DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lesson_user ADD CONSTRAINT FK_B4E2102DCDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lesson ADD sport_id INT NOT NULL');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F3AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id)');
        $this->addSql('CREATE INDEX IDX_F87474F3AC78BCF8 ON lesson (sport_id)');
    }
}
