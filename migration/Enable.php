<?php
/**
 * Created by PhpStorm.
 * User: jeremiah
 * Date: 11/9/2018
 * Time: 3:55 PM
 */

namespace conerd\humhub\modules\relationships\migration;

use yii\db\Migration;
use yii;
/**
 * @author CO_Nerd
 * Class enable
 */
class Enable extends Migration
{
    public function safeUp()
    {
        $tableNames = Yii::$app->db->schema->getTableNames();


        if (!in_array('relationship_category', $tableNames))
        {
            $this->createTable('relationship_category', [
               'id' => $this->primaryKey(),
               'category' => $this->string(255),
            ]);

        }

        if (!in_array('relationship_type', $tableNames))
        {
            $this->createTable('relationship_type', [
               'id' => $this->primaryKey(),
                'relationship_category' => $this->integer()->notNull(),
                'type' => $this->string(255)->notNull(),

            ]);

        }

        if (!in_array('relationship', $tableNames))
        {
            $this->createTable('relationship', [
                'id' => $this->primaryKey(),
                'user_id' => $this->integer()->notNull(),
                'other_user_id' => $this->integer()->notNull(),
                'relationship_type' => $this->integer()->notNull(),
                'approved' => $this->boolean()->defaultValue(false),
            ]);
        }

        $tables = Yii::$app->db->schema->getTableSchemas();

        $this->createForeignKey($tableNames, 'relationship', 'relationship_user_fk',
        'user_id', 'user', 'id', $tables, 'CASCADE', 'CASCADE');
        $this->createForeignKey($tableNames, 'relationship', 'relationship_other_user_fk',
            'other_user_id', 'user', 'id', $tables, 'CASCADE', 'CASCADE');
        $this->createForeignKey($tableNames, 'relationship', 'relationship_relationship_type_fk',
            'relationship_type', 'relationship_type', 'id', $tables, 'CASCADE', 'CASCADE');
        $this->createForeignKey($tableNames, 'relationship_type', 'relationship_type_category_fk',
            'relationship_category', 'relationship_category', 'id', $tables, 'CASCADE', 'CASCADE');


    }

    public function createForeignKey($tableNames, $tableName, $foreignKeyName, $tableColumn, $foreignTable, $foreignColumn,  $tables, $onDelete, $onUpdate)
    {
        /* @var $tables \yii\db\TableSchema[] */
        $tableIndex = array_search('relationship', $tableNames);
        if (!array_search($foreignKeyName, $tables[$tableIndex]->foreignKeys))
        {
            $this->addForeignKey($foreignKeyName, $tableName, $tableColumn, $foreignTable, $foreignColumn, $onDelete, $onUpdate);
        }
    }


}