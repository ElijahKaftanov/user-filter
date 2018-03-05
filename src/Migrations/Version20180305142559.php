<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Faker\Factory;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180305142559 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $faker = Factory::create('ru');
        $about = ['country', 'firstname', 'state'];
        for ($i = 1; $i < 300; $i++) {
            $user = [
                'id' => $i,
                'email' => $faker->email,
                'password' => $faker->sha256,
                'role' => 'user',
                'country' => $faker->country,
                'firstname' => $faker->firstName,
                'state' => rand(0, 1)
            ];

            $query = $this->connection->createQueryBuilder()
                ->insert('users')
                ->values([
                    'email' => '?',
                    'password' => '?',
                    'role' => '?',
                ]);
            $this->connection->executeQuery($query, [
                $user['email'],
                $user['password'],
                $user['role'],
            ]);

            foreach ($about as $item) {
                $this->insertAboutValue($user['id'], $item, $user[$item]);
            }
        }
    }

    protected function insertAboutValue($userId, $item, $value)
    {
        $qb = $this->connection->createQueryBuilder()
            ->insert('users_about')
            ->values([
                'user' => '?',
                'item' => '?',
                'value' => '?'
            ]);

        $this->connection->executeQuery($qb, [
            $userId, $item, $value
        ]);
    }

    public function down(Schema $schema)
    {
        $this->connection->exec('TRUNCATE TABLE users_about; TRUNCATE TABLE users');
    }
}
