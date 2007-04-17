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

require_once "CodeGen/MySQL/Plugin/Element.php";

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

class CodeGen_MySQL_Plugin_Element_Storage
  extends CodeGen_MySQL_Plugin_Element
{
    /**
     * Constructor
     */
    function __construct()
    {
      parent::__construct();
      $this->requiresSource = true;
    }
    
    /**
     * Storage array for function handlers
     *
     * @var array
     */
    protected $functions = array();


    /**
     * Handler flags
     *
     * @var array
     */
    protected $haFlags = array();

    /**
     * Set Hander flag by name
     *
     * @param  string  flag name
     * @param  bool    flag value (default=true)
     * @return bool    success status
     */
    function setHaFlag($name, $value = true)
    {
        switch ($name) {
        case "CAN_CREATE":
        case "CLOSE_CURSORS_AT_COMMIT":
        case "ALTER_NOT_SUPPORTED":
        case "CAN_RECREATE":
        case "HIDDEN":
        case "FLUSH_AFTER_RENAME":
        case "NOT_USER_SELECTABLE":
            if (isset($this->haFlags["HTON_".$name])) {
                return PEAR::raiseError("handlerton flag '$name' set twice");
            }
            $this->haFlags["HTON_".$name] = $value;
            return true;
        default: 
            return PEAR::raiseError("unknown handlerton flag '$name'");
        }
    }

    /**
     * Set function handler code
     *
     * @param  Handler name
     * @param  Code snippet
     */
    function setFunction($name, $code)
    {
        if (!$this->isName($name)) {
            return PEAR::raiseError("'$name' is not a valid handler function");
        }
        if (isset($this->functions[$name])) {
            return PEAR::raiseError("'$name' function declared twice");
        }
        $this->functions[$name] = $code;

        return true; 
    }


    /**
     * Return function name for handler if implemented, else "NULL"
     *
     * @param  string  handler name
     * @return bool    function name if implemented, else "NULL"
    function funcName($name)
    {
        if isset($this->functions[$name]) {
            return strtolower($this->name)."_".$name;
        } else {
            return "NULL";
        }
    }


    /**
     * Plugin type specifier is needed for plugin registration
     *
     * @param  void
     * @return string
     */
    function getPluginType() 
    {
      return "MYSQL_STORAGE_ENGINE_PLUGIN";
    }
    


    /**
     * Check for valid handler function names
     *
     * @param  string  handler name
     * @return bool    true for valid handler names, else false
     */
    static function isName($name)
    {
        return in_array($name, array("close_connection",
                                     "savepoint",
                                     "savepoint_rollback",
                                     "savepoint_release",
                                     "commit",
                                     "rollback",
                                     "prepare",
                                     "recover",
                                     "commit_by_xid",
                                     "rollback_by_xid",
                                     "create_cursor_read_view",
                                     "set_cursor_read_view",
                                     "close_cursor_read_view",
                                     "create_handler",
                                     "drop_database",
                                     "panic_call",
                                     "release_temporary_latches",
                                     "update_statistics",
                                     "start_snapshot",
                                     "flush_logs",
                                     "show_status",
                                     "partition_flags",
                                     "alter_table_flags",
                                     "alter_tablespace",
                                     "fill_files_table",
                                     "binlog_func",
                                     "binlog_log_query"
                                     ));
    }


    function getPluginCode()
    {
      $name    = $this->name;
      $lowname = strtolower($name);
      $upname  = strtoupper($name);

      $code = parent::getPluginCode()."\n";

      $code.="handlerton {$lowname}_hton= {\n";
      $code.="  \"$upname\",\n";
      $code.="  SHOW_OPTION_YES,\n";
      $code.="  \"{$this->summary}\",\n"; 
      $code.="  DB_TYPE_CUSTOM,\n";
      $code.="  ".$this->funcName("init").", /* Initialize */\n";
      $code.="  0,       /* slot */\n";
      $code.="  0,       /* savepoint size. */\n";
      $code.="  ".$this->funcName("close_connection").", /* close_connection */\n";
      $code.="  ".$this->funcName("savepoint").", /* savepoint */\n";
      $code.="  ".$this->funcName("savepoint_rollback").", /* rollback to savepoint */\n";
      $code.="  ".$this->funcName("savepoint_release").", /* release savepoint */\n";
      $code.="  ".$this->funcName("commit").", /* commit */\n";
      $code.="  ".$this->funcName("rollback").", /* rollback */\n";
      $code.="  ".$this->funcName("prepare").", /* prepare */\n";
      $code.="  ".$this->funcName("recover").", /* recover */\n";
      $code.="  ".$this->funcName("commit_by_xid").", /* commit_by_xid */\n";
      $code.="  ".$this->funcName("rollback_by_xid").", /* rollback_by_xid */\n";
      $code.="  ".$this->funcName("create_cursor_read_view").", /* create_cursor_read_view */\n";
      $code.="  ".$this->funcName("set_cursor_read_view").", /* set_cursor_read_view */\n";
      $code.="  ".$this->funcName("close_cursor_read_view").", /* close_cursor_read_view */\n";
      $code.="  ".$this->funcName("create_handler").", /* Create a new handler */\n";
      $code.="  ".$this->funcName("drop_database").", /* Drop a database */\n";
      $code.="  ".$this->funcName("panic_call").", /* Panic call */\n";
      $code.="  ".$this->funcName("release_temporary_latches").", /* Release temporary latches */\n";
      $code.="  ".$this->funcName("update_statistics").", /* Update Statistics */\n";
      $code.="  ".$this->funcName("start_snapshot").", /* Start Consistent Snapshot */\n";
      $code.="  ".$this->funcName("flush_logs").", /* Flush logs */\n";
      $code.="  ".$this->funcName("show_status").", /* Show status */\n";

      $code.="  ".$this->funcName("partition_flags").", /* */\n";
      $code.="  ".$this->funcName("alter_table_flags").", /* */\n";
      $code.="  ".$this->funcName("alter_tablespace").", /* */\n";
      $code.="  ".$this->funcName("fill_files_table").", /* */\n";

      $flags = array();
      foreach ($this->haFlags as $flag => $value) {
          if ($value) {
              $flags[] = $flag;
          }
      }
      $code.="  ".join(" | ", $flags).", /* handlder flags */\n";

      $code.="  ".$this->funcName("binlog_func").", /* */\n";
      $code.="  ".$this->funcName("binlog_log_query").", /* */\n";

      $code.="};\n";
    }
}
