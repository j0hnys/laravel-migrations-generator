<?php
/**
 * Created by PhpStorm.
 * User: liow.kitloong
 * Date: 2020/04/07
 */

namespace Tests\KitLoong\MigrationsGenerator\Repositories;

use Illuminate\Support\Facades\DB;
use KitLoong\MigrationsGenerator\MigrationGeneratorSetting;
use KitLoong\MigrationsGenerator\Repositories\MySQLRepository;
use Mockery\MockInterface;
use Orchestra\Testbench\TestCase;

class MySQLRepositoryTest extends TestCase
{
    public function testGetEnumPresetValues()
    {
        $this->mock(MigrationGeneratorSetting::class, function (MockInterface $mock) {
            $mock->shouldReceive('getConnection');
        });

        DB::shouldReceive('connection->select')
            ->with("SHOW COLUMNS FROM `table` where Field = 'column' AND Type LIKE 'enum(%'")
            ->andReturn([
                (object) ['Type' => "enum('value1', 'value2' , 'value3')"]
            ])
            ->once();

        /** @var MySQLRepository $repository */
        $repository = app(MySQLRepository::class);

        $value = $repository->getEnumPresetValues('table', 'column');
        $this->assertSame("['value1', 'value2' , 'value3']", $value);
    }

    public function testGetEnumPresetValuesIsNull()
    {
        $this->mock(MigrationGeneratorSetting::class, function (MockInterface $mock) {
            $mock->shouldReceive('getConnection');
        });

        DB::shouldReceive('connection->select')
            ->with("SHOW COLUMNS FROM `table` where Field = 'column' AND Type LIKE 'enum(%'")
            ->andReturn([])
            ->once();

        /** @var MySQLRepository $repository */
        $repository = app(MySQLRepository::class);

        $value = $repository->getEnumPresetValues('table', 'column');
        $this->assertNull($value);
    }

    public function testGetSetPresetValues()
    {
        $this->mock(MigrationGeneratorSetting::class, function (MockInterface $mock) {
            $mock->shouldReceive('getConnection');
        });

        DB::shouldReceive('connection->select')
            ->with("SHOW COLUMNS FROM `table` where Field = 'column' AND Type LIKE 'set(%'")
            ->andReturn([
                (object) ['Type' => "set('value1', 'value2' , 'value3')"]
            ])
            ->once();

        /** @var MySQLRepository $repository */
        $repository = app(MySQLRepository::class);

        $value = $repository->getSetPresetValues('table', 'column');
        $this->assertSame("['value1', 'value2' , 'value3']", $value);
    }

    public function testGetSetPresetValuesIsNull()
    {
        $this->mock(MigrationGeneratorSetting::class, function (MockInterface $mock) {
            $mock->shouldReceive('getConnection');
        });

        DB::shouldReceive('connection->select')
            ->with("SHOW COLUMNS FROM `table` where Field = 'column' AND Type LIKE 'set(%'")
            ->andReturn([])
            ->once();

        /** @var MySQLRepository $repository */
        $repository = app(MySQLRepository::class);

        $value = $repository->getSetPresetValues('table', 'column');
        $this->assertNull($value);
    }
}
