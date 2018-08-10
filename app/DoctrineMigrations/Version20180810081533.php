<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180810081533 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_order DROP INDEX UNIQ_17EB68C08D9F6D38, ADD INDEX IDX_17EB68C08D9F6D38 (order_id)');
        $this->addSql('ALTER TABLE user_order ADD product_id INT DEFAULT NULL, ADD price INT NOT NULL, CHANGE count_price count INT NOT NULL');
        $this->addSql('ALTER TABLE user_order ADD CONSTRAINT FK_17EB68C04584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_17EB68C04584665A ON user_order (product_id)');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398D34A04AD');
        $this->addSql('DROP INDEX IDX_F5299398D34A04AD ON `order`');
        $this->addSql('ALTER TABLE `order` ADD summa INT NOT NULL, DROP price, DROP count, CHANGE product user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_F5299398A76ED395 ON `order` (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('DROP INDEX IDX_F5299398A76ED395 ON `order`');
        $this->addSql('ALTER TABLE `order` ADD count INT NOT NULL, CHANGE user_id product INT DEFAULT NULL, CHANGE summa price INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398D34A04AD FOREIGN KEY (product) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_F5299398D34A04AD ON `order` (product)');
        $this->addSql('ALTER TABLE user_order DROP INDEX IDX_17EB68C08D9F6D38, ADD UNIQUE INDEX UNIQ_17EB68C08D9F6D38 (order_id)');
        $this->addSql('ALTER TABLE user_order DROP FOREIGN KEY FK_17EB68C04584665A');
        $this->addSql('DROP INDEX IDX_17EB68C04584665A ON user_order');
        $this->addSql('ALTER TABLE user_order ADD count_price INT NOT NULL, DROP product_id, DROP count, DROP price');
    }
}
