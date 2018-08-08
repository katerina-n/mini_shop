<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180808155704 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398BF396750');
        $this->addSql('ALTER TABLE `order` ADD product INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398D34A04AD FOREIGN KEY (product) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_F5299398D34A04AD ON `order` (product)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398D34A04AD');
        $this->addSql('DROP INDEX IDX_F5299398D34A04AD ON `order`');
        $this->addSql('ALTER TABLE `order` DROP product');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398BF396750 FOREIGN KEY (id) REFERENCES product (id)');
    }
}
