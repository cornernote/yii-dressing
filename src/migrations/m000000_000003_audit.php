<?php
/**
 * Class m000000_000003_audit
 */
class m000000_000003_audit extends YdDbMigration
{
    /**
     *
     */
    function safeUp()
    {
        $this->import('m000000_000003_audit.sql');
    }
}