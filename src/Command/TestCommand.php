<?php declare(strict_types=1);

namespace App\Command;


use App\Component\UserFilter\ArrayCompiler;
use App\Component\UserFilter\Doctrine\CompileCondition;
use App\Component\UserFilter\UserFilterManager;
use App\Component\UserFilter\UserFilterManagerInterface;
use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Yaml\Yaml;

class TestCommand extends Command implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @var UserFilterManagerInterface
     */
    private $filterManager;

    public function __construct(UserFilterManagerInterface $filterManager)
    {
        $this->filterManager = $filterManager;
        parent::__construct();
    }

    public function configure()
    {
        $this->setName('app:test');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ([1, 2, 3] as $number) {
            $content = file_get_contents(dirname(dirname(__DIR__)) . "/input/$number.yml");

            $query = Yaml::parse($content);

            $condition = $this->filterManager->compile($query);

            $result = $this->filterManager->execute($condition);

            dump($result);
        }
    }
}