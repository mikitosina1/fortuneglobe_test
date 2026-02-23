<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Order;
use App\Entity\PointOfSale;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 1; $i <= 3; $i++) {
            $pos = new PointOfSale($faker->company);
            $manager->persist($pos);
            $orderCount = rand(100, 1000);
            for ($j = 1; $j <= $orderCount; $j++) {
                $order = new Order(
                    number_format(
                        $faker->randomFloat(2, 4, 600),
                        2,
                        '.',
                        ''
                    ), $pos
                );
                $order->setCreatedAt(
                    DateTimeImmutable::createFromMutable(
                        $faker->dateTimeBetween(
                            '-6 months',
                            'now'
                        )
                    )
                );
                $manager->persist($order);
            }
        }
        $manager->flush();
    }
}
