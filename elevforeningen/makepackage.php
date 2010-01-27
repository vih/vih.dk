<?php
/**
 * package.xml generation script
 *
 * @category Application
 * @package  VIH
 * @author   Lars Olesen <lars@legestue.net>
 * @since    0.1.0
 * @version  @package-version@
 */

require_once 'PEAR/PackageFileManager2.php';

$version = '1.0.2';
$notes = '* initial release as PEAR';
$web_dir = 'www';
$ignore = array(
    'makepackage.php',
    '*.tgz',
    'tests/',
    '.svn/',
    'build.xml',
    'config.elevforeningen.php'

);
$postinstall_file = 'elevforeningen.php';

PEAR::setErrorHandling(PEAR_ERROR_DIE);
$pfm = new PEAR_PackageFileManager2();
$pfm->setOptions(
    array(
        'baseinstalldir'    => '/',
        'filelistgenerator' => 'file',
        'packagedirectory'  => dirname(__FILE__) . '/src',
        'packagefile'       => 'package.xml',
        'ignore'            => $ignore,
        'dir_roles'        => array(
            'www' => 'web'
        ),
        'simpleoutput'      => true,
        'addhiddenfiles' => true
    )
);

$pfm->setPackage('VIH_Elevforeningen');
$pfm->setSummary('VIH');
$pfm->setDescription('VIH');
$pfm->setUri('http://localhost/');
$pfm->setLicense('LGPL License', 'http://www.gnu.org/licenses/lgpl.html');
$pfm->addMaintainer('lead', 'lsolesen', 'Lars Olesen', 'lars@legestue.net');

$pfm->setPackageType('php');

$pfm->setAPIVersion($version);
$pfm->setReleaseVersion($version);
$pfm->setAPIStability('beta');
$pfm->setReleaseStability('stable');
$pfm->setNotes($notes);
$pfm->addRelease();


$pfm->resetUsesRole();
$pfm->addUsesRole('web', 'Role_Web', 'pearified.com');
$pfm->addPackageDepWithChannel('required', 'Role_Web', 'pearified.com', '1.1.1');

// $pfm->addGlobalReplacement('package-info', '@package-version@', 'version');
$pfm->addReplacement($postinstall_file, 'pear-config', '@php-dir@', 'php_dir');
$pfm->addReplacement($postinstall_file, 'pear-config', '@web-dir@', 'web_dir');
$pfm->addReplacement($postinstall_file, 'pear-config', '@data-dir@', 'data_dir');

$pfm->clearDeps();
$pfm->setPhpDep('5.2.0');
$pfm->setPearinstallerDep('1.5.4');

$pfm->addPackageDepWithChannel('required', 'MDB2', 'pear.php.net', '2.4.0');
$pfm->addPackageDepWithChannel('required', 'MDB2_Driver_mysql', 'pear.php.net', '1.4.0');
$pfm->addPackageDepWithChannel('required', 'Validate', 'pear.php.net', '0.7.0');
$pfm->addPackageDepWithChannel('required', 'Validate_DK', 'pear.php.net', '0.1.1');
$pfm->addPackageDepWithChannel('required', 'Image_Transform', 'pear.php.net', '0.9.0');
$pfm->addPackageDepWithChannel('required', 'HTTP_Upload', 'pear.php.net', '0.9.1');
$pfm->addPackageDepWithChannel('required', 'HTML_QuickForm', 'pear.php.net', '2.0.0');
$pfm->addPackageDepWithChannel('required', 'antispambot', 'public.intraface.dk', '0.1.0');
$pfm->addPackageDepWithChannel('required', 'Template', 'public.intraface.dk', '0.2.0');
$pfm->addPackageDepWithChannel('required', 'IntrafacePublic_Contact_XMLRPC', 'public.intraface.dk', '0.1.2');
$pfm->addPackageDepWithChannel('required', 'IntrafacePublic_Debtor_XMLRPC', 'public.intraface.dk', '0.1.0');
$pfm->addPackageDepWithChannel('required', 'IntrafacePublic_Shop_XMLRPC', 'public.intraface.dk', '0.1.0');
$pfm->addPackageDepWithChannel('required', 'PHPMarkdown', 'pear.michelf.com', '1.0.1');
$pfm->addPackageDepWithChannel('required', 'PHPSmartyPants', 'pear.michelf.com', '1.5.1');
$pfm->addPackageDepWithChannel('required', 'fpdf', 'public.intraface.dk', '1.53.0');
$pfm->addPackageDepWithChannel('required', 'phpmailer', 'public.intraface.dk', '1.73.0');
$pfm->addPackageDepWithChannel('required', 'Quickpay', 'public.intraface.dk', '1.17.1');

/*
foreach ($ignore AS $file) {
    // $pfm->addIgnoreToRelease($file);
}

$post_install_script = $pfm->initPostinstallScript($postinstall_file);
$post_install_script->addParamGroup('setup',
    array($post_install_script->getParam('db_user', 'User', 'string', 'root'),
          $post_install_script->getParam('db_password', 'Password', 'string', ''),
          $post_install_script->getParam('db_host', 'Host', 'string', 'localhost'),
          $post_install_script->getParam('db_name', 'Database', 'string', 'intraface'),
          $post_install_script->getParam('path_root', 'Root path', 'string', '/home/intraface/'),
          $post_install_script->getParam('path_www', 'WWW Path', 'string', '/'),
          $post_install_script->getParam('path_template', 'template path', 'string', '/'),
          $post_install_script->getParam('path_template_kundelogin', 'kundelogin template', 'string', '/'),
          $post_install_script->getParam('intraface_private_key', 'Intraface key', 'string', '/'),
          $post_install_script->getParam('quickpay_merchant_id', 'Quickpay merchant', 'string', '/'),
          $post_install_script->getParam('quickpay_md5_secret', 'Quickpay secret', 'string', '/'),

    ),
    '');

$pfm->addPostInstallTask($post_install_script, $postinstall_file);
*/
$pfm->addInstallAs('www/.htaccess', 'elevforeningen.vih.dk/.htaccess');
$pfm->addInstallAs('www/index.php', 'elevforeningen.vih.dk/index.php');
$pfm->addInstallAs('www/gfx/images/vih75x151.gif', 'elevforeningen.vih.dk/gfx/images/vih75x151.gif');
$pfm->addInstallAs('www/gfx/images/widepics/hangingout1.jpg', 'elevforeningen.vih.dk/gfx/images/widepics/hangingout1.jpg');

$pfm->generateContents();

if (isset($_GET['make']) || (isset($_SERVER['argv']) && @$_SERVER['argv'][1] == 'make')) {
    if ($pfm->writePackageFile()) {
        exit('package file written');
    }
} else {
    $pfm->debugPackageFile();
}
?>