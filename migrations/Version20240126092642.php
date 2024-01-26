<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240126092642 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE instructions DROP FOREIGN KEY FK_997D812BD9ED1E33');
        $this->addSql('DROP INDEX IDX_997D812BD9ED1E33 ON instructions');
        $this->addSql('ALTER TABLE instructions CHANGE id_recipe_id recipe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE instructions ADD CONSTRAINT FK_997D812B59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
        $this->addSql('CREATE INDEX IDX_997D812B59D8A214 ON instructions (recipe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE instructions DROP FOREIGN KEY FK_997D812B59D8A214');
        $this->addSql('DROP INDEX IDX_997D812B59D8A214 ON instructions');
        $this->addSql('ALTER TABLE instructions CHANGE recipe_id id_recipe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE instructions ADD CONSTRAINT FK_997D812BD9ED1E33 FOREIGN KEY (id_recipe_id) REFERENCES recipe (id)');
        $this->addSql('CREATE INDEX IDX_997D812BD9ED1E33 ON instructions (id_recipe_id)');
    }
}
