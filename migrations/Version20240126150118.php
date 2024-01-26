<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240126150118 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ingredients_recipe (ingredients_id INT NOT NULL, recipe_id INT NOT NULL, INDEX IDX_8C552A6B3EC4DCE (ingredients_id), INDEX IDX_8C552A6B59D8A214 (recipe_id), PRIMARY KEY(ingredients_id, recipe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ingredients_recipe ADD CONSTRAINT FK_8C552A6B3EC4DCE FOREIGN KEY (ingredients_id) REFERENCES ingredients (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ingredients_recipe ADD CONSTRAINT FK_8C552A6B59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ingredients_recipe DROP FOREIGN KEY FK_8C552A6B3EC4DCE');
        $this->addSql('ALTER TABLE ingredients_recipe DROP FOREIGN KEY FK_8C552A6B59D8A214');
        $this->addSql('DROP TABLE ingredients_recipe');
    }
}
