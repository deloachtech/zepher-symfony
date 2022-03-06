Zepher for Symfony
==================

Zepher provides RBAC, SaaS, Customer networking and fee-based app versioning. See [zepher.io](https://zepher.io) for more information.

This is the Symfony implementation of the Zepher object processor.


Installation
------------

Add the DeLoach Tech `flex-recipes` ([deloachtech/flex-recipes](https://github.com/deloachtech/flex-recipes)) endpoint to the projects `composer.json` file. (If you choose not to add the endpoint, you must manually implement the manifest.)

    "extra": {
        "symfony": {
            ...
            "endpoint": [
                "https://api.github.com/repos/deloachtech/flex-recipes/contents/index.json",
                "flex://defaults"
            ]
        }
    }

Install the bundle.

    composer require deloachtech/zepher-symfony


A database table is added for the Zepher access control data.

A new installation:
* Includes a starter `config/zepher.json` object file.
* Impersonates values for developing (see `config/zepher_dev.json`).

Quick Start
-----------

The installation includes everything you need to get started as a Super User _by impersonation_ (See `config/zepher_dev.json`).

1. Go anywhere and implement the Symfony is_granted('FEATURE_ACCOUNT', 'PERMISSION_UPDATE') condition. As the Super User you'll be granted access.
2. Now change the `impersonate.role` value in the `config/zepher_dev.json` file to "ROLE_BAD" and try again.

You've just enforced RBAC, SaaS, domain access and application versioning. All in a single method.

See an [example controller implementation](https://github.com/deloachtech/app-core-bundle/blob/master/src/Controller/AccessController.php).

Usage
-----

This Symfony bundle implements many of the procedures defined in the [online documentation](https://docs.zepher.io). See the `config/packages/zepher.yaml` for settings that are specific to this installation.

The `DeLoachTech\ZepherBundle\Security\AccessControl` class extends Zepher and uses `DeLoachTech\ZepherBundle\Security\AccessControlVoter` for enforcement via the Symfony is_granted() method. You won't have to do anything to use the access control features. When you need it, simply inject the AccessControl class into your controller or service.


