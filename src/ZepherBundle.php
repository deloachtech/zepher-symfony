<?php

namespace DeLoachTech\ZepherBundle;

use DeLoachTech\ZepherBundle\DependencyInjection\ZepherExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ZepherBundle extends Bundle
{


	/**
	 * Overridden to allow for the custom extension alias.
	 */
	public function getContainerExtension()
	{
		if (null === $this->extension) {
			$this->extension = new ZepherExtension();
		}
		return $this->extension;
	}

	public function getPath(): string
	{
		return \dirname(__DIR__);
	}

}