<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181004201141 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customer_package_date_range DROP FOREIGN KEY FK_46793A143D8CDE0');
        $this->addSql('DROP INDEX IDX_46793A143D8CDE0 ON customer_package_date_range');
        $this->addSql('ALTER TABLE customer_package_date_range ADD medical_package_id INT NOT NULL, DROP medial_package_id, DROP medical_packeg_id');
        $this->addSql('ALTER TABLE customer_package_date_range ADD CONSTRAINT FK_46793A14DF0D8233 FOREIGN KEY (medical_package_id) REFERENCES medical_package (id)');
        $this->addSql('CREATE INDEX IDX_46793A14DF0D8233 ON customer_package_date_range (medical_package_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customer_package_date_range DROP FOREIGN KEY FK_46793A14DF0D8233');
        $this->addSql('DROP INDEX IDX_46793A14DF0D8233 ON customer_package_date_range');
        $this->addSql('ALTER TABLE customer_package_date_range ADD medical_packeg_id INT NOT NULL, CHANGE medical_package_id medial_package_id INT NOT NULL');
        $this->addSql('ALTER TABLE customer_package_date_range ADD CONSTRAINT FK_46793A143D8CDE0 FOREIGN KEY (medial_package_id) REFERENCES medical_package (id)');
        $this->addSql('CREATE INDEX IDX_46793A143D8CDE0 ON customer_package_date_range (medial_package_id)');
    }
}
