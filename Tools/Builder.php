<?php

#
#   THIS SCRIPT FOR ANIME 
#   ^_^"
#   * we needed to upgrade always.
#
# POWERD BY BLACKCAT 2021 - 2022

/** BUILDER A TOOLS ON ONE CLASS.
 *  we will building all tools on one class.
 *  for use all what we wanted anytimes.
 */
class BUILDERTOOLS
{
    /**
     * this function for start to builder
     */

    ///use for keep class on builder.
    private $plugins = array();

    ///instance classes.
    public $tool = array();
    
    //Tools Base
    public $base;

    public function Running()
    {
        //Load in the plugin reflection classes
        $this->loadPlugins();
        //Build the final menu
        $this->buildMenu();
        
        //set a base tools
        $this->base = $this->tool['BaseTools']['instance'];
    }

    /**
     * this function for create a ReflectionClass by interface Tools.
     */
    public function loadPlugins()
    {
        //get all instantiated classes
        $classes = get_declared_classes();
        //check which all classes implements the basic Plugin interface
        foreach($classes as $class)
        {
            $reflectClass = new ReflectionClass($class);
            if($reflectClass->implementsInterface('Tools'))
            {
                //We are actually storing the instance reflection class itself
                //Not the class name or its object
                $this->plugins[] = $reflectClass;
 
            }
        }
        return $this->plugins;
    }

    /**
     * this fun for builder a instance classes
     */
    public function buildMenu()
    {
        foreach($this->plugins as $plugin)
        {
             //Create a new instance of the class
             $instance = $plugin->newInstance();
             $build = $instance->Base();
             $this->tool[$instance->title] = $build;
        }
    }
} 
?>