<?php
/**
 * Class m000000_000001_app
 */
class m000000_000001_app extends DbMigration
{
    /**
     *
     */
    function up()
    {
        $this->import('m000000_000001_app.sql');
    }
}