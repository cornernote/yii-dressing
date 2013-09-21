<?php
/**
 * Class m000000_000001_basics
 */
class m000000_000001_basics extends YdDbMigration
{
    /**
     *
     */
    function safeUp()
    {
        $this->import('m000000_000001_basics.sql');
    }
}