<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181004183103 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE date_range (id INT AUTO_INCREMENT NOT NULL, date_start DATETIME NOT NULL, date_end DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer_package_date_range (id INT AUTO_INCREMENT NOT NULL, customer_id INT NOT NULL, date_range_id INT NOT NULL, medial_package_id INT NOT NULL, medical_packeg_id INT NOT NULL, INDEX IDX_46793A149395C3F3 (customer_id), INDEX IDX_46793A14E9B7B917 (date_range_id), INDEX IDX_46793A143D8CDE0 (medial_package_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE customer_package_date_range ADD CONSTRAINT FK_46793A149395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE customer_package_date_range ADD CONSTRAINT FK_46793A14E9B7B917 FOREIGN KEY (date_range_id) REFERENCES date_range (id)');
        $this->addSql('ALTER TABLE customer_package_date_range ADD CONSTRAINT FK_46793A143D8CDE0 FOREIGN KEY (medial_package_id) REFERENCES medical_package (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customer_package_date_range DROP FOREIGN KEY FK_46793A14E9B7B917');
        $this->addSql('DROP TABLE date_range');
        $this->addSql('DROP TABLE customer_package_date_range');
    }
}
