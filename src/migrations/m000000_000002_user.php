<?php
/**
 * Class m000000_000002_user
 */
class m000000_000002_user extends YdDbMigration
{
    /**
     *
     */
    function safeUp()
    {
        $this->import('m000000_000002_user.sql');
    }
}