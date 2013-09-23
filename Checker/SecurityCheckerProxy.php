<?php

namespace Adchieve\SecurityCheckerBundle\Checker;

use Adchieve\SecurityCheckerBundle\Checker\SecurityCheckerInterface;
use SensioLabs\Security\SecurityChecker;

/**
 * Proxy object to make Sensiolab's SecurityChecker implement a generic interface
 *
 * @author Bas Hilbers <bas.hilbers@tribal-im.com>
 */
class SecurityCheckerProxy extends SecurityChecker implements SecurityCheckerInterface
{

}