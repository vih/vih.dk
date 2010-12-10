[vih.dk](http://vih.dk)
=======================

Requirements
------------

* PHP > 5.2
* MySQL
* PEAR

PHP code for [Vejle Idrætshøjskole](http://vih.dk). You are more than welcome to suggest improvements. It is based on [konstrukt](http://konstrukt.dk).

Install vih.dk
--------------

To do a local installation, do the following:

    pear channel-discover pear.phing.info
    pear install phing/phing
    
After installing phing, you can run:

    phing make
    
That will create a pear package, which will take care of installing all the dependencies when installing it.

    pear install VIH_Hojskole-x.x.x.tgz
    
Install database schema
-----------------------

The database schema can be found in the sql-directory. Just run them in phpmyadmin or from the command line.