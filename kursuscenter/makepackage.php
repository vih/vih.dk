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

$version = '1.0.4';
$notes = '* Text changes';
$web_dir = 'web';
$stability = 'stable';
$ignore = array(
    '.svn/',
    '.project',
    'makepackage.php',
    'config.kursuscenter.php',
    '*.tgz',
);

function getFilelist($dir) {
    global $rFiles;
    $files = glob($dir.'/*');
    foreach($files as $f) {
        if(is_dir($f)) { getFileList($f); continue; }
        $rFiles[] = $f;
    }
}

getFilelist($web_dir);

$web_files = $rFiles;

PEAR::setErrorHandling(PEAR_ERROR_DIE);
$pfm = new PEAR_PackageFileManager2();
$pfm->setOptions(
    array(
        'baseinstalldir'    => '/',
        'filelistgenerator' => 'file',
        'packagedirectory'  => dirname(__FILE__),
        'packagefile'       => 'package.xml',
        'ignore'            => $ignore,
        'dir_roles'        => array(
            $web_dir => 'www'
        ),
        'simpleoutput'      => true,
        'addhiddenfiles' => true
    )
);

$pfm->setPackage('VIH_Kursuscenter');
$pfm->setSummary('VIH');
$pfm->setDescription('VIH');
$pfm->setUri('http://localhost/');
$pfm->setLicense('LGPL License', 'http://www.gnu.org/licenses/lgpl.html');
$pfm->addMaintainer('lead', 'lsolesen', 'Lars Olesen', 'lars@legestue.net');

$pfm->setPackageType('php');

$pfm->setAPIVersion($version);
$pfm->setReleaseVersion($version);
$pfm->setAPIStability($stability);
$pfm->setReleaseStability($stability);
$pfm->setNotes($notes);
$pfm->addRelease();

$pfm->resetUsesRole();

/*
// $pfm->addGlobalReplacement('package-info', '@package-version@', 'version');
$pfm->addReplacement('kursuscenter.php', 'pear-config', '@php-dir@', 'php_dir');
$pfm->addReplacement('kursuscenter.php', 'pear-config', '@www-dir@', 'web_dir');
$pfm->addReplacement('kursuscenter.php', 'pear-config', '@data-dir@', 'data_dir');
*/

$pfm->clearDeps();
$pfm->setPhpDep('5.2.0');
$pfm->setPearinstallerDep('1.5.4');

$pfm->addPackageDepWithChannel('required', 'antispambot', 'public.intraface.dk', '0.1.0');
$pfm->addPackageDepWithChannel('required', 'Template', 'public.intraface.dk', '0.2.0');

/*
foreach ($ignore as $file) {
    // $pfm->addIgnoreToRelease($file);
}

$post_install_script = $pfm->initPostinstallScript('kursuscenter.php');
$post_install_script->addParamGroup('setup',
    array(//$post_install_script->getParam('db_user', 'User', 'string', 'root'),
          //$post_install_script->getParam('db_password', 'Password', 'string', ''),
          //$post_install_script->getParam('db_host', 'Host', 'string', 'localhost'),
          //$post_install_script->getParam('db_name', 'Database', 'string', 'intraface')
    ),
    '');

$pfm->addPostInstallTask($post_install_script, 'kursuscenter.php');

foreach ($web_files AS $file) {
    $formatted_file = substr($file, strlen($web_dir . '/'));
    if (in_array($formatted_file, $ignore)) continue;
    $pfm->addInstallAs($file, 'kursuscenter.vih.dk/' . $formatted_file);
}
*/

$pfm->addInstallAs('web/index.php', 'kursuscenter.vih.dk/index.php');
$pfm->addInstallAs('web/images/borsen.jpg', 'kursuscenter.vih.dk/images/borsen.jpg');
$pfm->addInstallAs('web/images/dobbeltvaerelse.jpg', 'kursuscenter.vih.dk/images/dobbeltvaerelse.jpg');
$pfm->addInstallAs('web/images/enkeltvaerelse.jpg', 'kursuscenter.vih.dk/images/enkeltvaerelse.jpg');
$pfm->addInstallAs('web/images/forhallen.jpg', 'kursuscenter.vih.dk/images/forhallen.jpg');
$pfm->addInstallAs('web/images/globen_sh.jpg', 'kursuscenter.vih.dk/images/globen_sh.jpg');
$pfm->addInstallAs('web/images/globen1.jpg', 'kursuscenter.vih.dk/images/globen1.jpg');
$pfm->addInstallAs('web/images/globenkursuscenter.jpg', 'kursuscenter.vih.dk/images/globenkursuscenter.jpg');
$pfm->addInstallAs('web/images/hall.jpg', 'kursuscenter.vih.dk/images/hall.jpg');
$pfm->addInstallAs('web/images/lenegammelgaard.jpg', 'kursuscenter.vih.dk/images/lenegammelgaard.jpg');
$pfm->addInstallAs('web/images/modelokale.jpg', 'kursuscenter.vih.dk/images/modelokale.jpg');
$pfm->addInstallAs('web/images/naturkompagniet.jpg', 'kursuscenter.vih.dk/images/naturkompagniet.jpg');
$pfm->addInstallAs('web/images/spisesal.jpg', 'kursuscenter.vih.dk/images/spisesal.jpg');
$pfm->addInstallAs('web/images/tack.jpg', 'kursuscenter.vih.dk/images/tack.jpg');
$pfm->addInstallAs('web/faciliteter.php', 'kursuscenter.vih.dk/faciliteter.php');
$pfm->addInstallAs('web/include_kursuscenter.php', 'kursuscenter.vih.dk/include_kursuscenter.php');
$pfm->addInstallAs('web/kontakt.php', 'kursuscenter.vih.dk/kontakt.php');
$pfm->addInstallAs('web/layout.css', 'kursuscenter.vih.dk/layout.css');
$pfm->addInstallAs('web/nyhedsbrev.php', 'kursuscenter.vih.dk/nyhedsbrev.php');
$pfm->addInstallAs('web/om.php', 'kursuscenter.vih.dk/om.php');
$pfm->addInstallAs('web/produkter.php', 'kursuscenter.vih.dk/produkter.php');

$pfm->generateContents();

if (isset($_GET['make']) || (isset($_SERVER['argv']) && @$_SERVER['argv'][1] == 'make')) {
    if ($pfm->writePackageFile()) {
        exit('package file written');
    }
} else {
    $pfm->debugPackageFile();
}
?>