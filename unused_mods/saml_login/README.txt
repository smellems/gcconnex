
![Uniquid] (http://www.yaco.es/blog/wp-content/uploads/2011/10/uniquid_logo.png)

Requirements
============

SimpleSAMLphp
-------------

This plugin uses [simpleSAMLphp](http://simplesamlphp.org/) SP. (tested with 1.8 version)

* [Installation](http://simplesamlphp.org/docs/trunk/simplesamlphp-install)
* [Configuration of simpleSAMLphp as SP](http://simplesamlphp.org/docs/trunk/simplesamlphp-sp)


Plugin Configuration
====================

* *simplesamlphppath*. Path of the SimpleSAMLPHP environment. eg: /var/www/sp/simplesamlphp
* *saml_authsource*. The SP auth source you want to connect to elgg. (Sources are located in SimpleSAMLphp at config/authsources.php)
* *usernamefield*. The attribute whose value uniquely identifies a user object, such as uid, cn or eduPersonPrincipalName
* *sign_on*. Boolean parameter to enable the user who have authenticated at the IdP to sign in Elgg
* *logout*. Boolean parameter to enable [Single Log Out](http://www.yaco.es/uniquid/#singleSignOn) (SLO)
* *new_users*. Boolean parameter to enable new users to sign up using their IdP accounts even if manual registration is disabled
* *update_userdata*. Boolean parameter to enable the option of updating elgg user accounts with the data from the IdP accounts in each login


TODO
====

* SAML attribute mapping configurable


References
==========

SAML plugin was developed by Sixto Martin, Software Engineer from Yaco Sistemas. Check this and other SAML pluglins at Uniquid [here](http://www.yaco.es/uniquid/conectores/).    

License: GPLv2

SAML plugin is based on [Facebook Connect Login for Elgg 1.8](http://community.elgg.org/pg/plugins/release/797592/developer/chetanvarshney/facebook-connect-login-for-elgg-18) from Chetan Varshney
