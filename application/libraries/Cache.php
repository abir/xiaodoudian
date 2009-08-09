<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Cache Class
 *
 * Partial Caching library for CodeIgniter
 *
 * @category	Libraries
 * @author		Jelmer Schreuder
 * @link		http://mpsimple.mijnpraktijk.com/mp_cache.htm
 * @license		MIT
 * @version		2.0b3
 */

class Cache
{
    private $ci;
    private $path;
	private $contents;
	private $filename;
	private $expires;
	private $default_expires;
	private $created;
	private $dependencies;
    
	/**
	 * Constructor - Initializes and references CI
	 */
    function __construct()
    {
        $this->ci =& get_instance();
        
        $this->reset();
        
        $this->path = $this->ci->config->item('cache_dir');
        $this->default_expires = $this->ci->config->item('cache_default_expires'); 
        if ($this->path == '') return FALSE;
    }
    
	/**
	 * Initialize Cache object to empty
	 *
	 * @access	public
	 * @return	void
	 */
    private function reset()
    {
    	$this->contents = null;
    	$this->name = null;
    	$this->expires = null;
    	$this->created = null;
    	$this->dependencies = array();
    }
    
	/**
	 * Call a library's cached result or create new cache
	 *
	 * @access	public
	 * @param	string
	 * @return	array
	 */
    public function library($library, $method, $arguments = array(), $expires = null)
    {
    	return $this->call($library, $method, $arguments, $expires);
    }
    
	/**
	 * Call a model's cached result or create new cache
	 *
	 * @access	public
	 * @return	array
	 */
    public function model($model, $method, $arguments = array(), $expires = null)
    {
    	return $this->call($model, $method, $arguments, $expires);
    }
    
    // Depreciated, use model() or library()
    private function call($property, $method, $arguments = array(), $expires = null)
    {
    	$this->ci->load->helper('security');
    	
    	// Clean given arguments to a 0-index array
		$arguments = array_values($arguments);
		
    	$cache_file = $property.'/'.dohash($method.serialize($arguments), 'sha1');
		
		// See if we have this cached
		$cached_responce = $this->get($cache_file);

		// Not FALSE? Return it
		if($cached_responce)
        {
        	return $cached_responce;
        }
        
        else
        {
        	// Call the model or library with the method provided and the same arguments
        	$new_responce = call_user_func_array(array($this->ci->$property, $method), $arguments);
        	$this->write($new_responce, $cache_file, $expires);
        	
        	return $new_responce;
        }
    }
	
	/**
	 * Helper functions for the dependencies property
	 */
	function set_dependencies($dependencies)
	{
		if (is_array($dependencies))
			$this->dependencies = $dependencies;
		else
			$this->dependencies = array($dependencies);
		
		// Return $this to support chaining
		return $this;
	}
	function add_dependencies($dependencies)
	{
		if (is_array($dependencies))
			$this->dependencies = array_merge($this->dependencies, $dependencies);
		else
			$this->dependencies[] = $dependencies;
		
		// Return $this to support chaining
		return $this;
	}
	function get_dependencies() { return $this->dependencies; }
	
	/**
	 * Helper function to get the cache creation date
	 */
	function get_created($created) { return $this->created; }
    
    
	/**
	 * Retrieve Cache File
	 *
	 * @access	public
	 * @param	string
	 * @param	boolean
	 * @return	mixed
	 */
    function get($filename = null, $use_expires = true)
    {
        // Check if cache was requested with the function or uses this object
        if ($filename !== null)
        {
        	$this->reset();
        	$this->filename = $filename;
        }
        
        // Check directory permissions
        if ( ! is_dir($this->path) OR ! is_really_writable($this->path))
        {
            return FALSE;
        }
        
        // Build the file path.
        $filepath = $this->path.$this->filename.'.cache';
        
        // Check if the cache exists, if not return FALSE
        if ( ! @file_exists($filepath))
        {
            return FALSE;
        }
        
        // Check if the cache can be opened, if not return FALSE
        if ( ! $fp = @fopen($filepath, FOPEN_READ))
        {
            return FALSE;
        }
    	
        // Lock the cache
        flock($fp, LOCK_SH);
        
        // If the file contains data return it, otherwise return NULL
        if (filesize($filepath) > 0)
        {
            $this->contents = unserialize(fread($fp, filesize($filepath)));
        }
        else
        {
            $this->contents = NULL;
        }
        
        // Unlock the cache and close the file
        flock($fp, LOCK_UN);
        fclose($fp);
        
        // Check cache expiration, delete and return FALSE when expired
        if ($use_expires && ! empty($this->contents['__cache_expires']) && $this->contents['__cache_expires'] < time())
        {
            $this->delete($filename);
            return false;
        }
        
        // Check Cache dependencies
        if(isset($this->contents['__cache_dependencies']))
        {
	        foreach ($this->contents['__cache_dependencies'] as $dep)
	        {
	        	$cache_created = filemtime($this->path.$this->filename.'.cache');
	        	
	        	// If dependency doesn't exist or is newer than this cache, delete and return FALSE
	        	if (! file_exists($this->path.$dep.'.cache') or filemtime($this->path.$dep.'.cache') > $cache_created)
	        	{
		            $this->delete($filename);
		            return false;
	        	}
	        }
        }
        
        // Instantiate the object variables
    	$this->expires      = @$this->contents['__cache_expires'];
    	$this->dependencies = @$this->contents['__cache_dependencies'];
    	$this->created      = @$this->contents['__cache_created'];
        
        // Cleanup the meta variables from the contents
        $this->contents = @$this->contents['__cache_contents'];
        
        // Return the cache
        log_message('debug', "Cache retrieved: ".$filename);
        return $this->contents;
    }
    
	/**
	 * Write Cache File
	 *
	 * @access	public
	 * @param	mixed
	 * @param	string
	 * @param	int
	 * @param	array
	 * @return	void
	 */
    function write($contents = null, $filename = null, $expires = null, $dependencies = array())
    {
        // Check if cache was passed with the function or uses this object
        if ($contents !== null)
        {
        	$this->reset();
        	$this->contents = $contents;
        	$this->filename = $filename;
        	$this->expires = $expires;
	        $this->dependencies = $dependencies;
        }
        
        // Put the contents in an array so additional meta variables
        // can be easily removed from the output
        $this->contents = array('__cache_contents' => $this->contents);
        
        // Check directory permissions
        if ( ! is_dir($this->path) OR ! is_really_writable($this->path))
        {
            return;
        }
        
        // check if filename contains dirs
        $subdirs = explode('/', $this->filename);
        if (count($subdirs) > 1)
        {
            array_pop($subdirs);
            $test_path = $this->path.implode('/', $subdirs);
            
            // check if specified subdir exists
            if ( ! @file_exists($test_path))
            {
                // create non existing dirs, asumes PHP5
                if ( ! @mkdir($test_path, DIR_WRITE_MODE, TRUE)) return FALSE;
            }
        }
        
        // Set the path to the cachefile which is to be created
        $cache_path = $this->path.$this->filename.'.cache';
		
        // Open the file and log if an error occures
        if ( ! $fp = @fopen($cache_path, FOPEN_WRITE_CREATE_DESTRUCTIVE))
        {
            log_message('error', "Unable to write Cache file: ".$cache_path);
            return;
        }
        
        // Meta variables
        $this->contents['__cache_created'] = time();
        $this->contents['__cache_dependencies'] = $this->dependencies;
        
        // Add expires variable if its set...
        if (! empty($this->expires))
        {
            $this->contents['__cache_expires'] = $this->expires + time();
        }
        // ...or add default expiration if its set
        elseif (! empty($this->default_expires) )
		{
			$this->contents['__cache_expires'] = $this->default_expires + time();
		}
        
        // Lock the file before writing or log an error if it failes
        if (flock($fp, LOCK_EX))
        {
            fwrite($fp, serialize($this->contents));
            flock($fp, LOCK_UN);
        }
        else
        {
            log_message('error', "Cache was unable to secure a file lock for file at: ".$cache_path);
            return;
        }
        fclose($fp);
        @chmod($cache_path, DIR_WRITE_MODE);
		
        // Log success
        log_message('debug', "Cache file written: ".$cache_path);
        
        // Reset values
        $this->reset();
    }
    
	/**
	 * Delete Cache File
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */	
    function delete($filename = null)
    {
    	if ($filename !== null) $this->filename = $filename;
    	
        $file_path = $this->path.$this->filename.'.cache';
        
        if (file_exists($file_path)) unlink($file_path);
        
        // Reset values
        $this->reset();
    }
    
	/**
	 * Delete Full Cache or Cache subdir
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */	
    function delete_all($dirname = '')
    {
        if (empty($this->path)) return false;

        $this->ci->load->helper('file');
        if (file_exists($this->path.$dirname)) delete_files($this->path.$dirname, TRUE);
        
        // Reset values
        $this->reset();
    }
}