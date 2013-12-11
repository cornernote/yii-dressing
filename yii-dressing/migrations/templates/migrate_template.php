<?php
/**
 * Class {ClassName}
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-skeleton
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */
class {ClassName} extends YdDbMigration
{

    public function safeUp()
    {

        // Run single query:
        $this->q("SINGLE SQL");

        // Run multiple queries:
        $this->qs("
            FIRST SQL;
            ANOTHER SQL;
        ");

        // Import sql file:
        $this->import('{ClassName}.sql');

    }

}