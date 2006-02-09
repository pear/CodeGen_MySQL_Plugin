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
require_once "CodeGen/MySQL/ExtensionParser.php";
require_once "CodeGen/Maintainer.php";
require_once "CodeGen/Tools/Indent.php";


/**
 * A class that generates MySQL Plugin soure and documenation files
 *
 * @category   Tools and Utilities
 * @package    CodeGen_MySQL_Plugin
 * @author     Hartmut Holzgraefe <hartmut@php.net>
 * @copyright  2005 Hartmut Holzgraefe
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: @package_version@
 * @link       http://pear.php.net/package/CodeGen_MySQL_Plugin
 */
class CodeGen_MySQL_Plugin_ExtensionParser 
    extends CodeGen_MySQL_ExtensionParser
{
    function tagstart_plugin($attr) 
    {
        return $this->tagstart_extension($attr);
    }
    
    function tagend_plugin_code($attr, $data) {
        return $this->tagend_extension_code($attr, $data);
    }


    //     _____      _ _ _            _   
    //    |  ___|   _| | | |_ _____  _| |_ 
    //    | |_ | | | | | | __/ _ \ \/ / __|
    //    |  _|| |_| | | | ||  __/>  <| |_ 
    //    |_|   \__,_|_|_|\__\___/_/\_\\__|


    function tagstart_plugin_fulltext($attr)
    {
        $this->checkAttributes($attr, array(), array("name"));

        $this->pushHelper(new CodeGen_Mysql_Plugin_Element_Fulltext);
        $this->helper->setName($attr["name"]);
    }

    function tagend_plugin_fulltext($attr, $data)
    {
        $err = $this->extension->addPlugin($this->helper);

        $this->popHelper();
        return $err;        
    }

    function tagend_fulltext_init($attr, $data)
    {
        return $this->helper->setInitCode($data);
    }

    function tagend_fulltext_deinit($attr, $data)
    {
        return $this->helper->setDeinitCode($data);
    }

    function tagend_fulltext_parser($attr, $attr)
    {
        return true;
    }

    function tagend_fulltext_parser_code($attr, $data)
    {
        return $this->helper->setParserCode($data);
    }

    function tagend_fulltext_parser_init($attr, $data)
    {
        return $this->helper->setParserInit($data);
    }

    function tagend_fulltext_parser_deinit($attr, $data)
    {
        return $this->helper->setParserDeinit($data);
    }



    //    ____  _                             
    //   / ___|| |_ ___  _ __ __ _  __ _  ___ 
    //   \___ \| __/ _ \| '__/ _` |/ _` |/ _ \
    //    ___) | || (_) | | | (_| | (_| |  __/
    //   |____/ \__\___/|_|  \__,_|\__, |\___|
    //                             |___/      
        
    function tagstart_plugin_storage($attr)
    {
        $this->checkAttributes($attr, array(), array("name"));

        $this->pushHelper(new CodeGen_Mysql_Plugin_Element_Storage);
        $this->helper->setName($attr["name"]);
    }

    function tagend_plugin_storage($attr, $data)
    {
        $err = $this->extension->addPlugin($this->helper);

        $this->popHelper();
        return $err;        
    }

    function tagend_storage_init($attr, $data)
    {
        return $this->helper->setInitCode($data);
    }

    function tagend_storage_deinit($attr, $data)
    {
        return $this->helper->setDeinitCode($data);
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
