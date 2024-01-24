<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240123153514 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE favorites (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, id_recipe_id INT NOT NULL, INDEX IDX_E46960F579F37AE5 (id_user_id), UNIQUE INDEX UNIQ_E46960F5D9ED1E33 (id_recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredients (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredients_recipe (ingredients_id INT NOT NULL, recipe_id INT NOT NULL, INDEX IDX_8C552A6B3EC4DCE (ingredients_id), INDEX IDX_8C552A6B59D8A214 (recipe_id), PRIMARY KEY(ingredients_id, recipe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE instructions (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, instructions_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, prep_time INT NOT NULL, cook_time INT DEFAULT NULL, thumbnail VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_DA88B13779F37AE5 (id_user_id), INDEX IDX_DA88B1375E75C823 (instructions_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ustensil (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ustensil_recipe (ustensil_id INT NOT NULL, recipe_id INT NOT NULL, INDEX IDX_68357430E62544B2 (ustensil_id), INDEX IDX_6835743059D8A214 (recipe_id), PRIMARY KEY(ustensil_id, recipe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE favorites ADD CONSTRAINT FK_E46960F579F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE favorites ADD CONSTRAINT FK_E46960F5D9ED1E33 FOREIGN KEY (id_recipe_id) REFERENCES recipe (id)');
        $this->addSql('ALTER TABLE ingredients_recipe ADD CONSTRAINT FK_8C552A6B3EC4DCE FOREIGN KEY (ingredients_id) REFERENCES ingredients (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ingredients_recipe ADD CONSTRAINT FK_8C552A6B59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B13779F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B1375E75C823 FOREIGN KEY (instructions_id) REFERENCES instructions (id)');
        $this->addSql('ALTER TABLE ustensil_recipe ADD CONSTRAINT FK_68357430E62544B2 FOREIGN KEY (ustensil_id) REFERENCES ustensil (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ustensil_recipe ADD CONSTRAINT FK_6835743059D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favorites DROP FOREIGN KEY FK_E46960F579F37AE5');
        $this->addSql('ALTER TABLE favorites DROP FOREIGN KEY FK_E46960F5D9ED1E33');
        $this->addSql('ALTER TABLE ingredients_recipe DROP FOREIGN KEY FK_8C552A6B3EC4DCE');
        $this->addSql('ALTER TABLE ingredients_recipe DROP FOREIGN KEY FK_8C552A6B59D8A214');
        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B13779F37AE5');
        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B1375E75C823');
        $this->addSql('ALTER TABLE ustensil_recipe DROP FOREIGN KEY FK_68357430E62544B2');
        $this->addSql('ALTER TABLE ustensil_recipe DROP FOREIGN KEY FK_6835743059D8A214');
        $this->addSql('DROP TABLE favorites');
        $this->addSql('DROP TABLE ingredients');
        $this->addSql('DROP TABLE ingredients_recipe');
        $this->addSql('DROP TABLE instructions');
        $this->addSql('DROP TABLE recipe');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE ustensil');
        $this->addSql('DROP TABLE ustensil_recipe');
    }
}
