<?php
/**
 * Created by PhpStorm.
 * User: liow.kitloong
 * Date: 2020/03/29
 * Time: 15:13
 */

namespace KitLoong\MigrationsGenerator\Generators;

use KitLoong\MigrationsGenerator\Repositories\MySQLRepository;

class EnumField
{
    private $decorator;

    private $mysqlRepository;

    public function __construct(Decorator $decorator, MySQLRepository $mySQLRepository)
    {
        $this->decorator = $decorator;
        $this->mysqlRepository = $mySQLRepository;
    }

    public function makeField(string $tableName, array $field): array
    {
        $value = $this->mysqlRepository->getEnumPresetValues($tableName, $field['field']);
        if ($value !== null) {
            $field['args'][] = $value;
        }

        return $field;
    }
}
