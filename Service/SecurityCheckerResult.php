<?php

namespace Adchieve\SecurityCheckerBundle\Service;

/**
 * Result wrapper for usage in profiler.
 * @author bas hilber <bas.hilbers@tribal-im.com>
 */
class SecurityCheckerResult
{
	/**
	 * Class constants for checking if the result was fetched properly
	 */
	const STATUS_ERR = -1;
	const STATUS_OK = 1;
	
	/**
	 * @var String
	 */
	private $status;
	
	/**
	 * @var Array
	 */
	private $taintedPackages;
	
	/**
	 * Construct a "result" from the sensiolabs's checker service
	 *
     * @param int $status
     * @param stdClass|null $packages
     */
	public function __construct($status, $packages = null)
	{
		if (!in_array($status, self::getStatusses())) {
			throw new \InvalidArgumentException(sprintf('Invalid status "%s" given', $status));
		}
		
		if ($packages) {
			if ($packages instanceof \stdClass) {
				$copy = array();
				
				foreach (get_object_vars($packages) as $key => $value) {
					$copy[$key] = $value;
				}
				
				$packages = $copy;
			}
		
			if (!is_array($packages)) {
				throw new \InvalidArgumentException('Unsupported type for $packages given');
			}
		
			foreach($packages as $package => $details) {
				$this->addTaintedPackage($package, $details);
			}
		}
		
		$this->status = $status;
	}
	
	/**
	 * Get possible status codes
	 *
	 * @return array
	 */
	static function getStatusses()
	{
		return array(
			self::STATUS_ERR,
			self::STATUS_OK
		);
	}
	
	/**
	 * Get current status
	 *
	 * @return String
	 */
	public function getStatus()
	{
		return $this->status;
	}
	
	/**
	 * Add package information
	 * 
	 * @param String $key
	 * @param StdClass $details
	 * @return SecurityCheckerResult
	 */
	protected function addTaintedPackage($key, $details)
	{
		$this->taintedPackages[$key] = $details;
		return $this;
	}
	
	/**
	 * Get information about given package 
	 *
	 * @param String $key
	 * @return StdClass
	 */
	public function getTaintedPackage($key)
	{
		return $this->taintedPackages[$key];
	}
	
	/**
	 * Returns all tainted packages
	 *
	 * @return array
	 */
	public function getTaintedPackages()
	{
		return $this->taintedPackages;
	}
	
	/**
	 * Returns all advisories found in response
	 *
	 * @return Array
	 */
	public function getAdvisories()
	{
		$packages = $this->getTaintedPackages();
		$sorted = array();
		array_map(function($package) use ($packages, &$sorted) {
			$sorted = array_merge($sorted, (array) $package->advisories);
		}, $packages);
		return $sorted;
	}
	
	/**
	 * Returns number of packages with advisories
	 *
	 * @return Integer
	 */
	public function getNumPackages()
	{
		return count($this->getTaintedPackages());
	}
	
	/**
	 * Returns number of advisories found
	 *
	 * @return Integer
	 */
	public function getNumAdvisories()
	{
		return count($this->getAdvisories());
	}
}
