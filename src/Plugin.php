<?php

declare(strict_types=1);

namespace Devmsh\PestSmartRunner;

use Pest\Support\Str;
use Pest\TestSuite;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;

/**
 * @internal
 */
final class Plugin
{
    /**
     * @var string
     */
    private const CLASS_OPTION = 'class';

    public $class = null;

    public function handleArguments(TestSuite $testSuite, array $originals): array
    {
        $arguments = array_merge([''], array_values(array_filter($originals, function ($original): bool {
            foreach ([self::CLASS_OPTION] as $option) {
                if ($original === sprintf('--%s', $option) || Str::startsWith($original, sprintf('--%s=', $option))) {
                    return true;
                }
            }

            return false;
        })));

        $originals = array_flip($originals);
        foreach ($arguments as $argument) {
            unset($originals[$argument]);
        }
        $originals = array_flip($originals);

        $inputs   = [];
        $inputs[] = new InputOption(self::CLASS_OPTION, 'c', InputOption::VALUE_REQUIRED);

        $input = new ArgvInput($arguments, new InputDefinition($inputs));
        if ($input->getOption(self::CLASS_OPTION)) {
            $this->class = $input->getOption(self::CLASS_OPTION);
        }

        return $originals;
    }
}
