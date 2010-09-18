vih.dk
==

PHP code for [Vejle Idrætshøjskole's](http://vih.dk). You are more than welcome to suggest improvements. It is based on [konstrukt](http://konstrukt.dk), version 1, but we are hoping to refactor to use the newest version of konstrukt soon.

Install source code
--

If you like to do a local installation, it best way right now is to do the following:

    pear channel-discover pear.phing.info
    pear install phing/phing
    
After installing phing, you should be able to just run:

    phing make
    
That will create a pear package, which will take care of installing all the dependencies when installing it.

    pear install VIH_Hojskole-x.x.x.tgz
    
Install database schema
--

The database schema can be found in the sql-directory. Just run them in phpmyadmin or from the command line.