<?php
/**
 * A class that generates MySQL Plugin soure and documenation files
 *
 * PHP versions 5
 *
 * LICENSE: This source file is subject to version 3.0 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_0.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Tools and Utilities
 * @package    CodeGen_MySQL_Plugin
 * @author     Hartmut Holzgraefe <hartmut@php.net>
 * @copyright  2005 Hartmut Holzgraefe
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/CodeGen_MySQL_Plugin
 */

/**
 * includes
 */
// {{{ includes

require_once "CodeGen/MySQL/Extension.php";

// }}} 

/**
 * A class that generates Plugin extension soure and documenation files
 *
 * @category   Tools and Utilities
 * @package    CodeGen_MySQL_Plugin
 * @author     Hartmut Holzgraefe <hartmut@php.net>
 * @copyright  2005 Hartmut Holzgraefe
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: @package_version@
 * @link       http://pear.php.net/package/CodeGen_MySQL_Plugin
 */
class CodeGen_MySQL_Plugin_Extension 
    extends CodeGen_MySQL_Extension
{
    /**
    * Current CodeGen_MySQL_Plugin version number
    * 
    * @return string
    */
    static function version() 
    {
        return "0.9.1dev";
    }

    /**
    * CodeGen_MySQL_Plugin Copyright message
    *
    * @return string
    */
    static function copyright()
    {
        return "Copyright (c) 2006 Hartmut Holzgraefe";
    }

    // {{{ member variables    

    // }}} 

    
    // {{{ constructor
    
    /**
     * The constructor
     *
     */
    function __construct() 
    {
        parent::__construct();
    }
    
    // }}} 
    
    // {{{ output generation
        
    // {{{   docbook documentation

    // {{{ header file

    /**
     * Write the complete C header file
     *
     * @access protected
     */
    function writeHeaderFile() 
    {
        $filename = "myplugin_{$this->name}.h";
        
        $this->addPackageFile('header', $filename); 

        $file =  new CodeGen_Tools_Outbuf($this->dirpath."/".$filename);
        
        $upname = strtoupper($this->name);
        
        echo $this->getLicense();
        echo "#ifndef MYPLUGIN_{$upname}_H\n";
        echo "#define MYPLUGIN_{$upname}_H\n\n";   

        echo "#endif /* MYPLUGIN_{$upname}_H */\n\n";

        return $file->write();
    }

    // }}} 



  // {{{ code file

    /**
     * Write the complete C code file
     *
     * @access protected
     */
    function writeCodeFile() {
        $filename = "{$this->name}.".$this->language;  

        $this->addPackageFile('c', $filename); 

        $file =  new CodeGen_Tools_Outbuf($this->dirpath."/".$filename);
        
        $upname = strtoupper($this->name);

        echo $this->getLicense();

        echo $this->cCodeEditorSettings();

        return $file->write();
    }

    // }}} 


    /** 
    * Generate README file (custom or default)
    *
    * @param  protected
    */
    function writeReadme() 
    {
        $file = new CodeGen_Tools_Outbuf($this->dirpath."/README");

?>
This is a MySQL plugin generetad using CodeGen_Mysql_Plugin <?php echo self::version(); ?>

...
<?php

      return $file->write();
    }


    /** 
    * Generate INSTALL file (custom or default)
    *
    * @access protected
    */
    function writeInstall() 
    {
        $file = new CodeGen_Tools_Outbuf($this->dirpath."/INSTALL");

?>
This is a MySQL plugin generetad using CodeGen_Mysql_Plugin <?php echo self::version(); ?>

...
<?php

        $file->write();
    }



}   


/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * indent-tabs-mode:nil
 * End:
 */
?>
