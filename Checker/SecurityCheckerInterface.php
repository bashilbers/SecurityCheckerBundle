<?php

namespace Adchieve\SecurityCheckerBundle\Checker;

/**
 * Interface which makes the SecurityChecker class testable
 *
 * @author Bas Hilbers <bas.hilbers@tribal-im.com>
 */
interface SecurityCheckerInterface
{
	/**
     * Checks a composer.lock file.
     *
     * @param string $lock   The path to the composer.lock file
     * @param string $format The return format
     *
     * @return mixed The vulnerabilities
     *
     * @throws \InvalidArgumentException When the output format is unsupported
     * @throws \RuntimeException         When the lock file does not exist
     * @throws \RuntimeException         When curl does not work or is unavailable
	 */
	public function check($lockPath, $formatReturned);
}
