<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220717073258 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create `tag` table.';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('tag');
        $table->addColumn('id', 'integer', ['autoincrement'=>true]);
        $table->addColumn('name', 'string', ['notnull'=>true]);
        $table->setPrimaryKey(['id']);
        $table->addOption('engine' , 'InnoDB');
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('tag');
    }
}
