<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220717072540 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create `post` table.';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('post');
        $table->addColumn('id', 'integer', ['autoincrement'=>true, ]);
        $table->addColumn('title', 'text', ['notnull'=>true]);
        $table->addColumn('content', 'text', ['notnull'=>true]);
        $table->addColumn('status', 'integer', ['notnull'=>true]);
        $table->addColumn('date_created', 'datetime', ['notnull'=>true]);
        $table->setPrimaryKey(['id']);
        $table->addOption('engine' , 'InnoDB');
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('post');
    }
}
