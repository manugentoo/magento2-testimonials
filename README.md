“Manugentoo Testimonial Magento 2 Module” 
=====================
Magento 2 Manugentoo Base Module

Extension homepage: https://github.com/manugentoo/magento2-base

## CONTACTS
* Email: manugentoo@gmail.com
* LinkedIn: https://www.linkedin.com/in/manuelcsantosjr/

## DONATIONS / SUPPORT ME ON
* [Patreon](https://www.patreon.com/manugentoo)

## INSTALLATION

### COMPOSER INSTALLATION
* run composer command:
>`$> composer require manugentoo/base`

### MANUAL INSTALLATION
* extract files from an archive

* deploy files into Magento2 folder `app/code/Manugentoo/Base`

### ENABLE EXTENSION
* enable extension (use Magento 2 command line interface \*):
>`$> php bin/magento module:enable Manugentoo_Base`

* to make sure that the enabled module is properly registered, run 'setup:upgrade':
>`$> php bin/magento setup:upgrade`

* [if needed] re-compile code and re-deploy static view files:
>`$> php bin/magento setup:di:compile`
>`$> php bin/magento setup:static-content:deploy`

Enjoy!

Best regards,
Manu Gentoo
