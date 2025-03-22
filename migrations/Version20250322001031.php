<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250322001031 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE matiere (id INT AUTO_INCREMENT NOT NULL, denomination VARCHAR(255) NOT NULL, abreviation VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matiere_niveau (id INT AUTO_INCREMENT NOT NULL, niveau_id INT NOT NULL, matiere_id INT NOT NULL, coeficient DOUBLE PRECISION NOT NULL, INDEX IDX_6B3CD676B3E9C81 (niveau_id), INDEX IDX_6B3CD676F46CD258 (matiere_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE matiere_niveau ADD CONSTRAINT FK_6B3CD676B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)');
        $this->addSql('ALTER TABLE matiere_niveau ADD CONSTRAINT FK_6B3CD676F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id)');
        $this->addSql('ALTER TABLE matier_niveau DROP FOREIGN KEY FK_41544B9E695CF4DA');
        $this->addSql('ALTER TABLE matier_niveau DROP FOREIGN KEY FK_41544B9EB3E9C81');
        $this->addSql('DROP TABLE matier');
        $this->addSql('DROP TABLE matier_niveau');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE matier (id INT AUTO_INCREMENT NOT NULL, denomination VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, abreviation VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE matier_niveau (id INT AUTO_INCREMENT NOT NULL, niveau_id INT NOT NULL, matier_id INT NOT NULL, coeficient DOUBLE PRECISION NOT NULL, INDEX IDX_41544B9EB3E9C81 (niveau_id), INDEX IDX_41544B9E695CF4DA (matier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE matier_niveau ADD CONSTRAINT FK_41544B9E695CF4DA FOREIGN KEY (matier_id) REFERENCES matier (id)');
        $this->addSql('ALTER TABLE matier_niveau ADD CONSTRAINT FK_41544B9EB3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)');
        $this->addSql('ALTER TABLE matiere_niveau DROP FOREIGN KEY FK_6B3CD676B3E9C81');
        $this->addSql('ALTER TABLE matiere_niveau DROP FOREIGN KEY FK_6B3CD676F46CD258');
        $this->addSql('DROP TABLE matiere');
        $this->addSql('DROP TABLE matiere_niveau');
    }
}
