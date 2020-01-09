# OroMagentoContactUsBundle

OroMagentoContactUsBundle extends [OroContactUsBundle](https://github.com/oroinc/crm/tree/master/src/Oro/Bundle/ContactUsBundle) to add the Magento Contact Us [embedded form](https://github.com/oroinc/platform/tree/master/src/Oro/Bundle/EmbeddedFormBundle) into Oro applications, which helps collect additional information about customer organization, preferred contact method, phone, etc. from Magento websites.

Table of content
-----------------

- [Requirements](#requirements)
- [Installation](#installation)
- [Run unit tests](#run-unit-tests)
- [Use as dependency in composer](#use-as-dependency-in-composer)

Requirements
------------

OroMagentoContactUsBundle requires OroPlatform(BAP), OroCRM and PHP 7.1 or above.

Installation
------------

Package is available through Oro Package Manager.
For development purposes it might be cloned from github repository directly.

```bash
git clone https://github.com/laboro/OroCRMMagentoContactUsBundle.git
```

Run unit tests
--------------

To run unit tests for this package:

```bash
phpunit -c PACKAGE_ROOT/phpunit.xml.dist
```

Use as dependency in composer
-----------------------------

```yaml
    "require": {
        "oro/crm-magento-embedded-contact-us": "dev-master",
    }
```

Resources
---------

  * [OroCommerce, OroCRM and OroPlatform Documentation](https://doc.oroinc.com)
  * [Contributing](https://doc.oroinc.com/community/contribute/)
