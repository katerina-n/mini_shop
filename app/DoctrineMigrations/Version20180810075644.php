<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180810075644 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_order ADD order_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_order ADD CONSTRAINT FK_17EB68C08D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_17EB68C08D9F6D38 ON user_order (order_id)');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398134C804E');
        $this->addSql('DROP INDEX IDX_F5299398134C804E ON `order`');
        $this->addSql('ALTER TABLE `order` DROP userOrder');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `order` ADD userOrder INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398134C804E FOREIGN KEY (userOrder) REFERENCES user_order (id)');
        $this->addSql('CREATE INDEX IDX_F5299398134C804E ON `order` (userOrder)');
        $this->addSql('ALTER TABLE user_order DROP FOREIGN KEY FK_17EB68C08D9F6D38');
        $this->addSql('DROP INDEX UNIQ_17EB68C08D9F6D38 ON user_order');
        $this->addSql('ALTER TABLE user_order DROP order_id');
    }
}
