<?php
/**
 * This file is part of the deloachtech/zepher-symfony package.
 *
 * (c) DeLoach Tech, LLC
 * https://deloachtech.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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