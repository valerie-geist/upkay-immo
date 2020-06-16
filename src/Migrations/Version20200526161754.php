<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200526161754 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE agence CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE bien CHANGE locataire_id locataire_id INT DEFAULT NULL, CHANGE type_bien_id type_bien_id INT DEFAULT NULL, CHANGE csl_id csl_id INT DEFAULT NULL, CHANGE chauffage_id chauffage_id INT DEFAULT NULL, CHANGE chauffe_eau_id chauffe_eau_id INT DEFAULT NULL, CHANGE etage etage INT DEFAULT NULL, CHANGE ascenceur ascenceur VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE categorie CHANGE intervention_id intervention_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE chauffage CHANGE type_id type_id INT DEFAULT NULL, CHANGE puissance puissance INT DEFAULT NULL, CHANGE modele modele VARCHAR(255) DEFAULT NULL, CHANGE annee_installation annee_installation DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE chauffe_eau CHANGE type_id type_id INT DEFAULT NULL, CHANGE capacite capacite INT DEFAULT NULL, CHANGE modele modele VARCHAR(255) DEFAULT NULL, CHANGE annee_installation annee_installation DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE csl CHANGE entretien_chaudiere entretien_chaudiere DATE DEFAULT NULL, CHANGE entretien_chauffe_eau entretien_chauffe_eau DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE prestation CHANGE categorie_id categorie_id INT DEFAULT NULL, CHANGE date_cloture date_cloture DATE DEFAULT NULL, CHANGE date_validation date_validation DATE DEFAULT NULL, CHANGE date_paiement date_paiement DATE DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE agence CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
        $this->addSql('ALTER TABLE bien CHANGE locataire_id locataire_id INT DEFAULT NULL, CHANGE type_bien_id type_bien_id INT DEFAULT NULL, CHANGE csl_id csl_id INT DEFAULT NULL, CHANGE chauffage_id chauffage_id INT DEFAULT NULL, CHANGE chauffe_eau_id chauffe_eau_id INT DEFAULT NULL, CHANGE etage etage INT DEFAULT NULL, CHANGE ascenceur ascenceur VARCHAR(255) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_general_ci`');
        $this->addSql('ALTER TABLE categorie CHANGE intervention_id intervention_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE chauffage CHANGE type_id type_id INT DEFAULT NULL, CHANGE puissance puissance INT DEFAULT NULL, CHANGE modele modele VARCHAR(255) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_general_ci`, CHANGE annee_installation annee_installation DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE chauffe_eau CHANGE type_id type_id INT DEFAULT NULL, CHANGE capacite capacite INT DEFAULT NULL, CHANGE modele modele VARCHAR(255) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_general_ci`, CHANGE annee_installation annee_installation DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE csl CHANGE entretien_chaudiere entretien_chaudiere DATE DEFAULT \'NULL\', CHANGE entretien_chauffe_eau entretien_chauffe_eau DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE prestation CHANGE categorie_id categorie_id INT DEFAULT NULL, CHANGE date_cloture date_cloture DATE DEFAULT \'NULL\', CHANGE date_validation date_validation DATE DEFAULT \'NULL\', CHANGE date_paiement date_paiement DATE DEFAULT \'NULL\'');
    }
}
