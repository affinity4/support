<?php declare(strict_types=1);

namespace Affinity4\Support\Traits;

trait Dumpable
{
    /**
     * Dump the given arguments and terminate execution.
     *
     * @param  mixed  ...$args
     *
     * @return never
     */
    public function dd(...$args)
    {
        $this->dump(...$args);

        dd();
    }

    /**
     * Dump the given arguments.
     *
     * @param  mixed  ...$args
     *
     * @return self
     */
    public function dump(...$args)
    {
        dump($this, ...$args);

        return $this;
    }
}
