<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240106170351 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE favorite (id INT AUTO_INCREMENT NOT NULL, id_user_id INT DEFAULT NULL, id_recipe_id INT DEFAULT NULL, INDEX IDX_68C58ED979F37AE5 (id_user_id), UNIQUE INDEX UNIQ_68C58ED9D9ED1E33 (id_recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `partition` (id INT AUTO_INCREMENT NOT NULL, id_recipe_id INT NOT NULL, content LONGTEXT DEFAULT NULL, media VARCHAR(255) DEFAULT NULL, INDEX IDX_9EB910E4D9ED1E33 (id_recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, ustensil_recipe_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, prep_time TIME DEFAULT NULL, cook_time TIME DEFAULT NULL, thumbnail VARCHAR(511) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_DA88B13779F37AE5 (id_user_id), INDEX IDX_DA88B1375FCA5819 (ustensil_recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_ingredients (id INT AUTO_INCREMENT NOT NULL, id_recipe_id INT NOT NULL, id_ingredient_id INT NOT NULL, quantity DOUBLE PRECISION NOT NULL, unit INT NOT NULL, INDEX IDX_9F925F2BD9ED1E33 (id_recipe_id), UNIQUE INDEX UNIQ_9F925F2B2D1731E9 (id_ingredient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ustensil_recipe (id INT AUTO_INCREMENT NOT NULL, id_recipe_id INT NOT NULL, id_ustensil_id INT NOT NULL, INDEX IDX_68357430D9ED1E33 (id_recipe_id), UNIQUE INDEX UNIQ_68357430FE378945 (id_ustensil_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED979F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED9D9ED1E33 FOREIGN KEY (id_recipe_id) REFERENCES recipe (id)');
        $this->addSql('ALTER TABLE `partition` ADD CONSTRAINT FK_9EB910E4D9ED1E33 FOREIGN KEY (id_recipe_id) REFERENCES recipe (id)');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B13779F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B1375FCA5819 FOREIGN KEY (ustensil_recipe_id) REFERENCES ustensil_recipe (id)');
        $this->addSql('ALTER TABLE recipe_ingredients ADD CONSTRAINT FK_9F925F2BD9ED1E33 FOREIGN KEY (id_recipe_id) REFERENCES recipe (id)');
        $this->addSql('ALTER TABLE recipe_ingredients ADD CONSTRAINT FK_9F925F2B2D1731E9 FOREIGN KEY (id_ingredient_id) REFERENCES ingredients (id)');
        $this->addSql('ALTER TABLE ustensil_recipe ADD CONSTRAINT FK_68357430D9ED1E33 FOREIGN KEY (id_recipe_id) REFERENCES recipe (id)');
        $this->addSql('ALTER TABLE ustensil_recipe ADD CONSTRAINT FK_68357430FE378945 FOREIGN KEY (id_ustensil_id) REFERENCES ustensil (id)');
        $this->addSql('ALTER TABLE user CHANGE user user VARCHAR(255) NOT NULL, CHANGE password password VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE deleted_at deleted_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE role role SMALLINT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_68C58ED979F37AE5');
        $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_68C58ED9D9ED1E33');
        $this->addSql('ALTER TABLE `partition` DROP FOREIGN KEY FK_9EB910E4D9ED1E33');
        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B13779F37AE5');
        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B1375FCA5819');
        $this->addSql('ALTER TABLE recipe_ingredients DROP FOREIGN KEY FK_9F925F2BD9ED1E33');
        $this->addSql('ALTER TABLE recipe_ingredients DROP FOREIGN KEY FK_9F925F2B2D1731E9');
        $this->addSql('ALTER TABLE ustensil_recipe DROP FOREIGN KEY FK_68357430D9ED1E33');
        $this->addSql('ALTER TABLE ustensil_recipe DROP FOREIGN KEY FK_68357430FE378945');
        $this->addSql('DROP TABLE favorite');
        $this->addSql('DROP TABLE `partition`');
        $this->addSql('DROP TABLE recipe');
        $this->addSql('DROP TABLE recipe_ingredients');
        $this->addSql('DROP TABLE ustensil_recipe');
        $this->addSql('ALTER TABLE user CHANGE user user VARCHAR(127) NOT NULL, CHANGE password password LONGTEXT NOT NULL, CHANGE email email VARCHAR(511) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL, CHANGE deleted_at deleted_at DATETIME NOT NULL, CHANGE role role INT NOT NULL');
    }
}
