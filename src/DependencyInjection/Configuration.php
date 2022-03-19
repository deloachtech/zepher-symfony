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

namespace DeLoachTech\ZepherBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{


	public function getConfigTreeBuilder(): TreeBuilder
	{
		$treeBuilder = new TreeBuilder('zepher');

		// @formatter:off
		$treeBuilder->getRootNode()
			->children()
                ->scalarNode('object_file')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('app_domain_id')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('api_key')->end()
                ->scalarNode('feature_id_prefix')->isRequired()->cannotBeEmpty()->end()
                ->arrayNode('feature_id_map')
                    ->variablePrototype()->cannotBeEmpty()->end()
                ->end()
                ->arrayNode('permission_id_map')
                    ->variablePrototype()->cannotBeEmpty()->end()
                ->end()
                ->arrayNode('session_keys')
                    ->children()
                        ->scalarNode('account_id')->end()
                        ->scalarNode('user_roles')->end()
                    ->end()
                ->end()
			->end();
		// @formatter:on

		return $treeBuilder;
	}

}