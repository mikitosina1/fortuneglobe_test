<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260223120707 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, total_amount NUMERIC(10, 2) NOT NULL, created_at DATETIME NOT NULL, point_of_sale_id INT NOT NULL, INDEX IDX_E52FFDEE6B7E9A73 (point_of_sale_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE point_of_sale (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, is_active TINYINT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE6B7E9A73 FOREIGN KEY (point_of_sale_id) REFERENCES point_of_sale (id)');
        $this->addSql('CREATE INDEX idx_order_pos_date ON orders (point_of_sale_id, created_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE6B7E9A73');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE point_of_sale');
    }
}
