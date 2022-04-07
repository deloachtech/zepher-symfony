Zepher for Symfony
==================

[Zepher](https://zepher.io) integrates RBAC, SaaS, Customer networking and fee-based app versioning into an existing codebase.

> This package is specifically designed for Symfony applications. See [deloachtech/zepher-php](https://github.com/deloachtech/zepher-php) for a vanilla version of Zepher for PHP.

This is the Symfony implementation of the [DeLoachTech\Zepher\Zepher](https://github.com/deloachtech/zepher-php/blob/master/src/Zepher.php) object processor. It's released under the MIT license for public use.

> This package includes the [free version](https://zepher.io/pricing.html) of Zepher with a minimal `config/zepher.json` file. You can modify it manually , or create your own using the [zepher.io dashboard](https://zepher.io). 

> This package is already included in the [deloachtech/app-core](https://github.com/deloachtech/app-core) package.

Installation
------------

```bash
# The deloachtech/package-installer is required for a Symfony bundle installation.
$ composer require deloachtech/package-installer

# The package.
$ composer require deloachtech/zepher-symfony

# Initialize the database table(s).
$ bin/console make:migration
$ bin/console doctrine:migrations:migrate
```


Quick Start
-----------

The installation includes everything you need to get started as a Super User _by impersonation_ (See `config/zepher_dev.json`).

Go anywhere and implement the Symfony security condition.
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

You've just enforced RBAC, SaaS, domain access and application versioning using a single method.

See the [DeLoachTech\AppCoreBundle\Controller\AccountUserController](https://github.com/deloachtech/app-core/blob/master/src/Controller/AccountUserController.php) for an example use case.

You won't have to do anything to use the access control (RBAC) features. When you need it, simply inject the `DeLoachTech\ZepherBundle\Security\AccessControl` class into your controller or service.

> The [DeLoachTech\ZepherBundle\Security\AccessControl](https://github.com/deloachtech/zepher-symfony/blob/master/src/Security/AccessControl.php) class extends the [DeLoachTech\Zepher\Zepher](https://github.com/deloachtech/zepher-php/blob/master/src/Zepher.php) object processor and uses the [DeLoachTech\ZepherBundle\Security\AccessControlVoter](https://github.com/deloachtech/zepher-symfony/blob/master/src/Security/AccessControlVoter.php) for enforcement of the Symfony is_granted() method. 


Usage
-----

This bundle will automatically implement many of the procedures defined in the [Zepher docs](https://zepher.io/docs).

You have `two` account related events to implement:

1. When your app creates a new account, either trigger the [DeLoachTech\ZepherBundle\Event\AccountCreatedEvent](https://github.com/deloachtech/zepher-symfony/blob/master/src/Event/AccountCreatedEvent.php), or use the [DeLoachTech\ZepherBundle\Service](https://github.com/deloachtech/zepher-symfony/blob/master/src/Service/AccessService.php) to create an access record for it.
2. When your app deletes an account, either trigger the [DeLoachTech\ZepherBundle\Event\AccountDeletedEvent](https://github.com/deloachtech/zepher-symfony/blob/master/src/Event/AccountDeletedEvent.php), or use the [DeLoachTech\ZepherBundle\Service](https://github.com/deloachtech/zepher-symfony/blob/master/src/Service/AccessService.php) to delete the associated access records.

### Related Usage

If you're using any deloachtech packages, you can list all features and permissions being used.

```bash
$ bin/console deloachtech:features
$ bin/console deloachtech:permissions
```