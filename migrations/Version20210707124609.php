<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210707124609 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clear (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_game_category (game_id INT NOT NULL, game_category_id INT NOT NULL, INDEX IDX_7EC7A8CE48FD905 (game_id), INDEX IDX_7EC7A8CCC13DFE0 (game_category_id), PRIMARY KEY(game_id, game_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_device (game_id INT NOT NULL, device_id INT NOT NULL, INDEX IDX_741A1B46E48FD905 (game_id), INDEX IDX_741A1B4694A4C7D4 (device_id), PRIMARY KEY(game_id, device_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game_game_category ADD CONSTRAINT FK_7EC7A8CE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_game_category ADD CONSTRAINT FK_7EC7A8CCC13DFE0 FOREIGN KEY (game_category_id) REFERENCES game_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_device ADD CONSTRAINT FK_741A1B46E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_device ADD CONSTRAINT FK_741A1B4694A4C7D4 FOREIGN KEY (device_id) REFERENCES device (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE forum ADD game_id INT NOT NULL');
        $this->addSql('ALTER TABLE forum ADD CONSTRAINT FK_852BBECDE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_852BBECDE48FD905 ON forum (game_id)');
        $this->addSql('ALTER TABLE message ADD topic_id INT NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F1F55203D FOREIGN KEY (topic_id) REFERENCES topic (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F1F55203D ON message (topic_id)');
        $this->addSql('ALTER TABLE post ADD post_category_id INT NOT NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DFE0617CD FOREIGN KEY (post_category_id) REFERENCES post_category (id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DFE0617CD ON post (post_category_id)');
        $this->addSql('ALTER TABLE topic ADD forum_id INT NOT NULL');
        $this->addSql('ALTER TABLE topic ADD CONSTRAINT FK_9D40DE1B29CCBAD0 FOREIGN KEY (forum_id) REFERENCES forum (id)');
        $this->addSql('CREATE INDEX IDX_9D40DE1B29CCBAD0 ON topic (forum_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE clear');
        $this->addSql('DROP TABLE game_game_category');
        $this->addSql('DROP TABLE game_device');
        $this->addSql('ALTER TABLE forum DROP FOREIGN KEY FK_852BBECDE48FD905');
        $this->addSql('DROP INDEX UNIQ_852BBECDE48FD905 ON forum');
        $this->addSql('ALTER TABLE forum DROP game_id');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F1F55203D');
        $this->addSql('DROP INDEX IDX_B6BD307F1F55203D ON message');
        $this->addSql('ALTER TABLE message DROP topic_id');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DFE0617CD');
        $this->addSql('DROP INDEX IDX_5A8A6C8DFE0617CD ON post');
        $this->addSql('ALTER TABLE post DROP post_category_id');
        $this->addSql('ALTER TABLE topic DROP FOREIGN KEY FK_9D40DE1B29CCBAD0');
        $this->addSql('DROP INDEX IDX_9D40DE1B29CCBAD0 ON topic');
        $this->addSql('ALTER TABLE topic DROP forum_id');
    }
}
