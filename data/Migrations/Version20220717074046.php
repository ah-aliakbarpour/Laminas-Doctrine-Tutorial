<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220717074046 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adds indexes and foreign key constraints.';
    }

    public function up(Schema $schema): void
    {
        // Add index to post table
        $table = $schema->getTable('post');
        $table->addIndex(['date_created'], 'date_created_index');

        // Add index and foreign key to comment table
        $table = $schema->getTable('comment');
        $table->addIndex(['post_id'], 'post_id_index');
        $table->addForeignKeyConstraint('post', ['post_id'], ['id'], [], 'comment_post_id_fk');

        // Add indexes and foreign keys to post_tag table
        $table = $schema->getTable('post_tag');
        $table->addIndex(['post_id'], 'post_id_index');
        $table->addIndex(['tag_id'], 'tag_id_index');
        $table->addForeignKeyConstraint('post', ['post_id'], ['id'], [], 'post_tag_post_id_fk');
        $table->addForeignKeyConstraint('tag', ['tag_id'], ['id'], [], 'post_tag_tag_id_fk');
    }

    public function down(Schema $schema): void
    {
        $table = $schema->getTable('post_tag');
        $table->removeForeignKey('post_tag_post_id_fk');
        $table->removeForeignKey('post_tag_tag_id_fk');
        $table->dropIndex('post_id_index');
        $table->dropIndex('tag_id_index');

        $table = $schema->getTable('comment');
        $table->dropIndex('post_id_index');
        $table->removeForeignKey('comment_post_id_fk');

        $table = $schema->getTable('post');
        $table->dropIndex('date_created_index');
    }
}
