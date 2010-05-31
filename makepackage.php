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

$version = '1.1.0';
$notes = '* initial release as PEAR';
$web_dir = 'web';
$ignore = array(
    '.project',
    'makepackage.php',
    '*.tgz',
    'tests/',
    '.svn/',
    '.settings/',
    'build.xml'

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

// PEAR::setErrorHandling(PEAR_ERROR_DIE);
$pfm = new PEAR_PackageFileManager2();
$pfm->setOptions(
    array(
        'baseinstalldir'    => '/',
        'filelistgenerator' => 'file',
        'packagedirectory'  => dirname(__FILE__),
        'packagefile'       => 'package.xml',
        'ignore'            => $ignore,
        'dir_roles'        => array(
            $web_dir => 'web'
        ),
        'simpleoutput'      => true,
        'addhiddenfiles' => true
    )
);

$pfm->setPackage('VIH_Forside');
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

$pfm->clearDeps();
$pfm->setPhpDep('5.2.0');
$pfm->setPearinstallerDep('1.5.4');

foreach ($web_files AS $file) {
    $formatted_file = substr($file, strlen($web_dir . '/'));
    if (in_array($formatted_file, $ignore)) continue;
    $pfm->addInstallAs($file, $formatted_file);
}

$pfm->generateContents();

if (isset($_GET['make']) || (isset($_SERVER['argv']) && @$_SERVER['argv'][1] == 'make')) {
    if ($pfm->writePackageFile()) {
        exit('package file written');
    }
} else {
    $pfm->debugPackageFile();
}
?>