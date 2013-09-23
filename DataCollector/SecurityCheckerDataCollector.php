<?php

namespace Adchieve\SecurityCheckerBundle\DataCollector;

use 
	Symfony\Component\HttpKernel\DataCollector\DataCollector,
	Symfony\Component\HttpFoundation\Request,
	Symfony\Component\HttpFoundation\Response
;

use 
	Adchieve\SecurityCheckerBundle\Service\SecurityCheckerResult,
	Adchieve\SecurityCheckerBundle\Checker\SecurityCheckerInterface
;

/**
 * Symfony data collector for security advise
 *
 * @author Bas Hilbers <bas.hilbers@tribal-im.com>
 * @package Adchieve\SecurityCheckerBundle\DataCollector
 */
class SecurityCheckerDataCollector extends DataCollector
{
	const FORMAT_TEXT = 'text';
	const FORMAT_JSON = 'json';

	/**
     * @var \SensioLabs\Security\SecurityChecker\SecurityChecker
     */
	private $checker;
	
	/**
     * @var String
     */
	private $lockPath;
	
	/**
	 * @param \Adchieve\SecurityCheckerBundle\Checker\SecurityCheckerInterface $checker
	 * @param String $lockPath
	 */
	public function __construct(SecurityCheckerInterface $checker, $lockPath)
	{
		$this->checker = $checker;
		$this->lockPath = $lockPath;
	}
	
	/**
     * {{@inheritDoc}}
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
	{
		$this->data = $this->call();
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function call($format = self::FORMAT_JSON) 
	{
		try {
			$response = json_decode($this->checker->check($this->lockPath, $format));
		} catch (\Exception $e) {
			return new SecurityCheckerResult(
				SecurityCheckerResult::STATUS_ERR
			);
		}
		
        return new SecurityCheckerResult(
            SecurityCheckerResult::STATUS_OK,
            $response
        );
	}
	
	/**
	 * @return mixed
	 */
	public function getData()
	{
		return $this->data;
	}

    /**
     * {{@inheritDoc}}
     */
    public function getName()
	{
		return 'security_checker';
	}
}
