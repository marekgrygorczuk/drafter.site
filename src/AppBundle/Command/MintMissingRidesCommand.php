<?php

namespace AppBundle\Command;

    use AppBundle\Service\DrafterService;
    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;

class MintMissingRidesCommand extends Command
{

    /**
     * @var DrafterService
     */
    private $drafterService;

    public function __construct(DrafterService $drafterService)
    {
        $this->drafterService = $drafterService;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:mint-rides')

            // the short description shown while running "php bin/console list"
            ->setDescription('Creates rides from all ride stamps for next 28 days.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp("Might create duplications, but it will be handled later.")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Minting all rides.");
        $this->drafterService->mintAllRidesForNext4Weeks();
    }
}