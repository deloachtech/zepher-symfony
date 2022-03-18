Zepher for Symfony
==================

Zepher provides RBAC, SaaS, Customer networking and fee-based app versioning. See [zepher.io](https://zepher.io) for more information.

This is the `Symfony` implementation of the Zepher object processor.


Installation
------------

    composer require deloachtech/zepher-symfony


A database table is added for Zepher access control results.

    bin/console make:migration
    bin/console doctrine:migrations:migrate

Edit `config/packages/zepher.yaml` as required.

A new installation:
* Includes a starter `config/zepher.json` object file.
* Impersonates values for developing (see `config/zepher_dev.json`).

Quick Start
-----------

The installation includes everything you need to get started as a Super User _by impersonation_ (See `config/zepher_dev.json`).

Go anywhere and implement the `Symfony` security condition.
```php 
is_granted('FEATURE_ACCOUNT', 'PERMISSION_UPDATE')
``` 
As the Super User (by impersonation), you'll be granted access.

Now change the  `config/zepher_dev.json` role value and try again.

```json
"impersonate": {
  "role": "ROLE_BAD"
}
```

You've just enforced RBAC, SaaS, domain access and application versioning. All in a single `Symfony` method.

See this [example controller implementation](https://github.com/deloachtech/app-core/blob/master/src/Controller/AccessController.php) for additional information.

Usage
-----

* This bundle implements many of the procedures defined in the [online documentation](https://zepher.io/docs). See the `config/packages/zepher.yaml` for settings that are specific to this installation.
* When your app creates a new account, either trigger the `DeLoachTech\ZepherBundle\Event\AccountCreatedEvent`, or use the `DeLoachTech\ZepherBundle\Service` to create an access record for it.
* When your app deletes an account, either trigger the `DeLoachTech\ZepherBundle\Event\AccountDeletedEvent`, or use the `DeLoachTech\ZepherBundle\Service` to delete the associated access records.
* The `DeLoachTech\ZepherBundle\Security\AccessControl` class extends Zepher and uses `DeLoachTech\ZepherBundle\Security\AccessControlVoter` for enforcement via the Symfony is_granted() method. You won't have to do anything to use the access control features. When you need it, simply inject the AccessControl class into your controller or service.


