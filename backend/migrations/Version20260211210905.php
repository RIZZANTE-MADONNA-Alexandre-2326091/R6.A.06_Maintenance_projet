<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260211210905 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE championnat DROP CONSTRAINT fk_ab8c2208cf3ac81');
        $this->addSql('DROP INDEX idx_ab8c2208cf3ac81');
        $this->addSql('ALTER TABLE championnat DROP competition_id_id');
        $this->addSql('ALTER TABLE competition DROP CONSTRAINT fk_b50a2cb1e459249a');
        $this->addSql('DROP INDEX idx_b50a2cb1e459249a');
        $this->addSql('ALTER TABLE competition RENAME COLUMN epreuve_id_id TO championnat_id');
        $this->addSql('ALTER TABLE competition ADD CONSTRAINT FK_B50A2CB1627A0DA8 FOREIGN KEY (championnat_id) REFERENCES "championnat" (id)');
        $this->addSql('CREATE INDEX IDX_B50A2CB1627A0DA8 ON competition (championnat_id)');
        $this->addSql('ALTER TABLE epreuve DROP CONSTRAINT fk_d6ade47fcb38ff4e');
        $this->addSql('ALTER TABLE epreuve ADD competition_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE epreuve ADD CONSTRAINT FK_D6ADE47FCB38FF4E FOREIGN KEY (sport_id_id) REFERENCES "competition" (id)');
        $this->addSql('ALTER TABLE epreuve ADD CONSTRAINT FK_D6ADE47F7B39D312 FOREIGN KEY (competition_id) REFERENCES "competition" (id)');
        $this->addSql('CREATE INDEX IDX_D6ADE47F7B39D312 ON epreuve (competition_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "championnat" ADD competition_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "championnat" ADD CONSTRAINT fk_ab8c2208cf3ac81 FOREIGN KEY (competition_id_id) REFERENCES competition (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_ab8c2208cf3ac81 ON "championnat" (competition_id_id)');
        $this->addSql('ALTER TABLE "competition" DROP CONSTRAINT FK_B50A2CB1627A0DA8');
        $this->addSql('DROP INDEX IDX_B50A2CB1627A0DA8');
        $this->addSql('ALTER TABLE "competition" RENAME COLUMN championnat_id TO epreuve_id_id');
        $this->addSql('ALTER TABLE "competition" ADD CONSTRAINT fk_b50a2cb1e459249a FOREIGN KEY (epreuve_id_id) REFERENCES epreuve (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_b50a2cb1e459249a ON "competition" (epreuve_id_id)');
        $this->addSql('ALTER TABLE "epreuve" DROP CONSTRAINT FK_D6ADE47FCB38FF4E');
        $this->addSql('ALTER TABLE "epreuve" DROP CONSTRAINT FK_D6ADE47F7B39D312');
        $this->addSql('DROP INDEX IDX_D6ADE47F7B39D312');
        $this->addSql('ALTER TABLE "epreuve" DROP competition_id');
        $this->addSql('ALTER TABLE "epreuve" ADD CONSTRAINT fk_d6ade47fcb38ff4e FOREIGN KEY (sport_id_id) REFERENCES sport (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
