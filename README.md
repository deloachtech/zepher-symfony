Zepher for Symfony
==================

[Zepher](https://zepher.io) provides RBAC, SaaS, Customer networking and fee-based app versioning to an existing codebase.

This is the `Symfony` implementation of the `Zepher` object processor. It's released under the MIT license for public use.

_Note: This package is already included in the [deloachtech/app-dashboard package](https://github.com/deloachtech/app-dashboard)._

Installation
------------

The `deloachtech/package-installer` is required for a Symfony bundle installation.

    composer require deloachtech/package-installer
    composer require deloachtech/zepher-symfony


A database table is added for Zepher access control.

    bin/console make:migration
    bin/console doctrine:migrations:migrate


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

This bundle will automatically implement many of the procedures defined in the [Zepher docs](https://zepher.io/docs).

You only have `two` acccount related events to implement the access control features:

1. When your app creates a new account, either trigger the `DeLoachTech\ZepherBundle\Event\AccountCreatedEvent`, or use the `DeLoachTech\ZepherBundle\Service` to create an access record for it.
2. When your app deletes an account, either trigger the `DeLoachTech\ZepherBundle\Event\AccountDeletedEvent`, or use the `DeLoachTech\ZepherBundle\Service` to delete the associated access records.

The `DeLoachTech\ZepherBundle\Security\AccessControl` class extends Zepher and uses `DeLoachTech\ZepherBundle\Security\AccessControlVoter` for enforcement via the Symfony is_granted() method. You won't have to do anything to use the access control features. When you need it, simply inject the AccessControl class into your controller or service.
