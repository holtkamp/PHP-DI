<?php

namespace DI\Definition;

use DI\Factory\RequestedEntry;

/**
 * Definition.
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
interface Definition extends RequestedEntry
{
    /**
     * Returns the name of the entry in the container.
     *
     * @return string
     */
    public function getName();
}
