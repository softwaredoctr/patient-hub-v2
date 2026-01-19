<?php

namespace App\Command;

use App\Repository\PatientRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:test-company-context',
    description: 'Tests CompanyContext injection into TenantAwareRepository'
)]
class TestCompanyContextCommand extends Command
{
    public function __construct(
        private PatientRepository $patientRepository
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // This MUST trigger qb()
        $this->patientRepository->findAllForCompany();

        $output->writeln('<info>CompanyContext injection OK</info>');

        return Command::SUCCESS;
    }
}
