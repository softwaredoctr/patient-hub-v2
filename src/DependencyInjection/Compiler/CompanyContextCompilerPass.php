<?php

namespace App\DependencyInjection\Compiler;

use App\Repository\CompanyAwareRepositoryInterface;
use App\Security\CompanyContext;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CompanyContextCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has(CompanyContext::class)) {
            return;
        }

        $contextRef = new Reference(CompanyContext::class);

        foreach ($container->getDefinitions() as $definition) {
            $class = $definition->getClass();

            if (!$class || !is_subclass_of($class, CompanyAwareRepositoryInterface::class)) {
                continue;
            }

            $definition->addMethodCall('setCompanyContext', [$contextRef]);
        }
    }
}
