<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250314131250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE matier (id INT AUTO_INCREMENT NOT NULL, denomination VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matier_niveau (matier_id INT NOT NULL, niveau_id INT NOT NULL, INDEX IDX_41544B9E695CF4DA (matier_id), INDEX IDX_41544B9EB3E9C81 (niveau_id), PRIMARY KEY(matier_id, niveau_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE matier_niveau ADD CONSTRAINT FK_41544B9E695CF4DA FOREIGN KEY (matier_id) REFERENCES matier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matier_niveau ADD CONSTRAINT FK_41544B9EB3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE matier_niveau DROP FOREIGN KEY FK_41544B9E695CF4DA');
        $this->addSql('ALTER TABLE matier_niveau DROP FOREIGN KEY FK_41544B9EB3E9C81');
        $this->addSql('DROP TABLE matier');
        $this->addSql('DROP TABLE matier_niveau');
    }
}
