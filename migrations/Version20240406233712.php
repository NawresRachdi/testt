<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240406233712 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE piece ADD qualite VARCHAR(255) NOT NULL, ADD reference VARCHAR(255) NOT NULL, DROP qualit, DROP r??f??rence, CHANGE quantit quantite INT NOT NULL');
        $this->addSql('ALTER TABLE voiture CHANGE mod??le modele VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE piece ADD qualit VARCHAR(255) NOT NULL, ADD r??f??rence VARCHAR(255) NOT NULL, DROP qualite, DROP reference, CHANGE quantite quantit INT NOT NULL');
        $this->addSql('ALTER TABLE voiture CHANGE modele mod??le VARCHAR(255) NOT NULL');
    }
}
