<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240229143313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('DROP INDEX IDX_29A5EC27F77D927C ON panier');
        // this up() migration is auto-generated, please modify it to your needs
        
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE panier ADD produits_id JSON DEFAULT NULL');
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panier DROP produits_id');
    }
}
