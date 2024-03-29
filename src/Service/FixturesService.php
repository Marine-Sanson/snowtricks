<?php

/**
 * FixturesService File Doc Comment
 *
 * @category Service
 * @package  App\Service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Service;

use Faker\Factory;
use Faker\Generator;
use DateTimeImmutable;


/**
 * FixturesService Class Doc Comment
 *
 * @category Service
 * @package  App\Service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */
class FixturesService
{

    /**
     * Summary of faker
     *
     * @var Generator
     */
    public Generator $faker;


    /**
     * Summary of function __construct
     */
    public function __construct()
    {

        $this->faker = Factory::create();

    }


    /**
     * Summary of function generateCreatedAt
     *
     * @return DateTimeImmutable
     */
    public function generateCreatedAt(): DateTimeImmutable
    {

        return DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $this->faker->dateTimeBetween('-6 months')->format('Y-m-d H:i:s'));

    }


    /**
     * Summary of function generateUpdatedAt
     *
     * @param DateTimeImmutable $date date
     *
     * @return DateTimeImmutable
     */
    public function generateUpdatedAt(DateTimeImmutable $date): DateTimeImmutable
    {

        return DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $this->faker->dateTimeBetween($date->format('Y-m-d H:i:s'))->format('Y-m-d H:i:s'));

    }


}
