<?php

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