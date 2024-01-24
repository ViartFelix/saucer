<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240124110052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE instructions ADD id_recipe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE instructions ADD CONSTRAINT FK_997D812BD9ED1E33 FOREIGN KEY (id_recipe_id) REFERENCES recipe (id)');
        $this->addSql('CREATE INDEX IDX_997D812BD9ED1E33 ON instructions (id_recipe_id)');
        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B1375E75C823');
        $this->addSql('DROP INDEX IDX_DA88B1375E75C823 ON recipe');
        $this->addSql('ALTER TABLE recipe DROP instructions_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE instructions DROP FOREIGN KEY FK_997D812BD9ED1E33');
        $this->addSql('DROP INDEX IDX_997D812BD9ED1E33 ON instructions');
        $this->addSql('ALTER TABLE instructions DROP id_recipe_id');
        $this->addSql('ALTER TABLE recipe ADD instructions_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B1375E75C823 FOREIGN KEY (instructions_id) REFERENCES instructions (id)');
        $this->addSql('CREATE INDEX IDX_DA88B1375E75C823 ON recipe (instructions_id)');
    }
}
