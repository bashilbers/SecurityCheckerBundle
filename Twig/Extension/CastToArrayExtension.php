<?php

namespace Adchieve\SecurityCheckerBundle\Twig\Extension;

/**
 * Simple twig filter to cast StdObject to Array
 *
 * @author bas hilbers <bas.hilbers@tribal-im.com>
 */
class CastToArrayExtension extends \Twig_Extension
{
	/**
	 * {{@inheritDoc}}
	 */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('cast_to_array', array($this, 'castFilter')),
        );
    }

	/**
	 * Casts given argument to array
	 *
	 * @param StdClass $object
	 * @return Array
	 */
    public function castFilter($object)
    {
		if (is_array($object)) {
			return $object;
		}
	
		$response = array();
		foreach (get_object_vars($object) as $key => $value) {
			$response[] = array($key, $value);
		}
		return $response;
    }

	/**
	 * In order to stay compliant with the synfony framework..
	 *
	 * @return String
	 */
    public function getName()
    {
        return 'cast_to_array';
    }
}