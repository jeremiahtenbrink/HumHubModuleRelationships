<?php
/**
 * Created by PhpStorm.
 * User: jeremiah
 * Date: 10/10/2018
 * Time: 7:47 PM
 */
namespace conerd\humhub\modules\relationships\migration;

use yii\db\Migration;
use Yii;

class Uninstall extends Migration
{

    public function up()
    {
        $tables = Yii::$app->db->schema->getTableNames();
        if (isset($tables['relationship_category']))
        {
            $this->dropTable('relationship_category');
        }

        if (isset($tables['relationship_type']))
        {
            $this->dropTable('relationship_type');
        }

        if (isset($tables['relationship'])){
            $this->dropTable('relationship');
        }


    }

    public function down()
    {
        echo "uninstall does not support migration down.\n";
        return false;
    }

}