<?php
/**
 * {ClassName}
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