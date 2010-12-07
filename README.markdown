[vih.dk](http://vih.dk)
==

PHP code for [Vejle Idrætshøjskole](http://vih.dk)'s website. You are more than welcome to suggest improvements. It is based on [konstrukt](http://konstrukt.dk).

Create PEAR package
--

If you like to do a local installation, do the following:

    pear channel-discover pear.phing.info
    pear install phing/phing
    
After installing phing, run:

    phing make
    
That will create a pear package, which will take care of installing all the dependencies for the site.

    pear install VIH_Hojskole-x.x.x.tgz
    
Install database schema
--

The database schema can be found in the sql-directory. Just run them in phpmyadmin or from the command line.