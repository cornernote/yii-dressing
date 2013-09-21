<?php
/**
 * Class m000000_000005_menu
 */
class m000000_000005_menu extends YdDbMigration
{
    /**
     *
     */
    function safeUp()
    {
        $this->import('m000000_000005_menu.sql');
    }
}