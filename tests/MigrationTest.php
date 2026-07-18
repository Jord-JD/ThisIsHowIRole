<?php

namespace JordJD\ThisIsHowIRole\Tests;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Facades\Facade;
use PHPUnit\Framework\TestCase;

class MigrationTest extends TestCase
{
    public function testPackagedMigrationCreatesExpectedTable()
    {
        $capsule = new Capsule();
        $capsule->addConnection(array(
            'driver' => 'sqlite',
            'database' => ':memory:',
        ));
        $capsule->setAsGlobal();
        $capsule->getContainer()->instance('db', $capsule->getDatabaseManager());
        $capsule->getContainer()->instance('db.schema', $capsule->schema());
        Facade::setFacadeApplication($capsule->getContainer());

        require_once dirname(__DIR__).'/database/migrations/2017_02_13_000000_create_tihir_roles_table.php';

        $migration = new \CreateThisIsHowIRolePackageRolesTable();
        $migration->up();

        $schema = $capsule->schema();
        $this->assertTrue($schema->hasTable('tihir_roles'));
        $this->assertTrue($schema->hasColumn('tihir_roles', 'class_name'));
        $this->assertTrue($schema->hasColumn('tihir_roles', 'foreign_id'));
        $this->assertTrue($schema->hasColumn('tihir_roles', 'roles'));

        $migration->down();
        $this->assertFalse($schema->hasTable('tihir_roles'));
    }
}
