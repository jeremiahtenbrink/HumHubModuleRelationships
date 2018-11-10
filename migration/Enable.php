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
 * Class enable
 */
class Enable extends Migration
{
    public function safeUp()
    {
        $tableNames = Yii::$app->db->schema->getTableNames();

        if (!isset($tableNames['relationship_category']))
        {
            $this->createTable('relationship_category', [
               'id' => $this->primaryKey(),
               'category' => $this->string(255),
            ]);

        }

        if (!isset($tableNames['relationship_type']))
        {
            $this->createTable('relationship_type', [
               'id' => $this->primaryKey(),
                'relationship_category' => $this->integer()->notNull(),
                'type' => $this->string(255)->notNull(),

            ]);

        }

        if (!isset($tableNames['relationship']))
        {
            $this->createTable('relationship', [
                'id' => $this->primaryKey(),
                'user_id' => $this->integer()->notNull(),
                'other_user_id' => $this->integer()->notNull(),
                'relationship_type' => $this->integer()->notNull(),
                'approved' => $this->boolean()->defaultValue(false),
            ]);
        }

    }

}