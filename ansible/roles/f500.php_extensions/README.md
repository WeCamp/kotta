php_extensions
========

Install PHP extensions

Requirements
------------

Debian Wheezy with the package python-pycurl and python-software-properties installed.

Role Variables
--------------

This roles is used with an array of php extensions as parameter.

    php_extensions:
        - php5-curl
        - php5-intl
        - php5-gd
        - php5-mysql

Dependencies
------------

Depends on f500.php.

Example Playbook
-------------------------

    - hosts: servers
      roles:
         - { role: f500.php_extensions, php_extensions["php5-curl","php5-intl","php5-gd","php5-mysql"] }

License
-------

LGPL

Author Information
------------------

Jasper N. Brouwer, jasper@nerdsweide.nl

Ramon de la Fuente, ramon@delafuente.nl
