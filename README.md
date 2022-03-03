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
* Includes a `config/zepher_dev.json` file for your `dev` environment with data to get you started.
* Includes an empty `config/zepher.json` file for your `prod` environment.
* Impersonates the ROLE_SUPER_USER role (see config/zepher_extra.json).
* Includes some features and RBAC to get you started.

Quick Start
-----------

The installation includes everything you need to get started as a Super User (by impersonation).

Go anywhere and implement the Symfony is_granted('FEATURE_ACCOUNT', 'PERMISSION_UPDATE') condition. As the Super User you'll be granted access.
Now change the `dev.impersonate_role` value in the `config/zepher_extra.json` file to "ROLE_BAD" and try again.

You've just enforced RBAC, SaaS, domain access and application versioning. All in a single method.

See https://github.com/deloachtech/app-core-bundle/blob/master/src/Controller/AccessController.php
for an example controller implementation.

Usage
-----

This Symfony bundle implements many of the procedures defined in the docs. See the `config/packages/zepher.yaml` for settings that are specific to this installation.

The only logic you'll have to implement is when a new account is created.

    # When your application creates a new account:

    1. Inject the DeLoachTech\ZepherBundle\AccessService into your sevice or controller.
    2. Use the createAccount() method to initiate the new accounts existence in the access table.

The online documentation can be used for most everything else.
