<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180810071656 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939823912FED');
        $this->addSql('DROP INDEX UNIQ_F529939823912FED ON `order`');
        $this->addSql('ALTER TABLE `order` CHANGE orderuser userOrder INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398134C804E FOREIGN KEY (userOrder) REFERENCES user_order (id)');
        $this->addSql('CREATE INDEX IDX_F5299398134C804E ON `order` (userOrder)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398134C804E');
        $this->addSql('DROP INDEX IDX_F5299398134C804E ON `order`');
        $this->addSql('ALTER TABLE `order` CHANGE userorder orderUser INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939823912FED FOREIGN KEY (orderUser) REFERENCES fos_user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F529939823912FED ON `order` (orderUser)');
    }
}
