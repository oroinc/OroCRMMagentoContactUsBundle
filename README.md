OroCRMMagentoContactUsBundle
=====================

This document contains information on how to download, install "OroCRM Contact Us" package.

Table of content
-----------------

- [Requirements](#requirements)
- [Installation](#installation)
- [Run unit tests](#run-unit-tests)
- [Use as dependency in composer](#use-as-dependency-in-composer)

Requirements
------------

OroCRMMagentoContactUsBundle requires OroPlatform(BAP), OroCRM and PHP 5.5.9 or above.

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
