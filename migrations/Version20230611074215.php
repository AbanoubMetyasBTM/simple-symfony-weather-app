<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230611074215 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE weather_day (id INT AUTO_INCREMENT NOT NULL, country_name VARCHAR(255) NOT NULL, city_name VARCHAR(255) NOT NULL, day_date DATE NOT NULL, forecast_days LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql("ALTER TABLE `weather_day` ADD INDEX(`country_name`, `city_name`, `day_date`);");
        $this->addSql("ALTER TABLE `weather_day` CHANGE `day_date` `day_key` VARCHAR(50) NOT NULL;");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE weather_day');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
