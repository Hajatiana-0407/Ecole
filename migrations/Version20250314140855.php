<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250314140855 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE matier_niveau DROP FOREIGN KEY FK_41544B9EB3E9C81');
        $this->addSql('ALTER TABLE matier_niveau DROP FOREIGN KEY FK_41544B9E695CF4DA');
        $this->addSql('ALTER TABLE matier_niveau ADD id INT AUTO_INCREMENT NOT NULL, ADD coeficient DOUBLE PRECISION NOT NULL, CHANGE matier_id matier_id INT DEFAULT NULL, CHANGE niveau_id niveau_id INT DEFAULT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE matier_niveau ADD CONSTRAINT FK_41544B9EB3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)');
        $this->addSql('ALTER TABLE matier_niveau ADD CONSTRAINT FK_41544B9E695CF4DA FOREIGN KEY (matier_id) REFERENCES matier (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE matier_niveau MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE matier_niveau DROP FOREIGN KEY FK_41544B9EB3E9C81');
        $this->addSql('ALTER TABLE matier_niveau DROP FOREIGN KEY FK_41544B9E695CF4DA');
        $this->addSql('DROP INDEX `PRIMARY` ON matier_niveau');
        $this->addSql('ALTER TABLE matier_niveau DROP id, DROP coeficient, CHANGE niveau_id niveau_id INT NOT NULL, CHANGE matier_id matier_id INT NOT NULL');
        $this->addSql('ALTER TABLE matier_niveau ADD CONSTRAINT FK_41544B9EB3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matier_niveau ADD CONSTRAINT FK_41544B9E695CF4DA FOREIGN KEY (matier_id) REFERENCES matier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matier_niveau ADD PRIMARY KEY (matier_id, niveau_id)');
    }
}
