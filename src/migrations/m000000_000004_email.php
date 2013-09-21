<?php
/**
 * Class m000000_000004_email
 */
class m000000_000004_email extends YdDbMigration
{
    /**
     *
     */
    function safeUp()
    {
        $this->import('m000000_000004_email.sql');
    }
}