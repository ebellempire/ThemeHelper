<?php

class ThemeHelperPlugin extends Omeka_Plugin_AbstractPlugin
{
    


    protected $_hooks = array(
    	'install', 
    	'uninstall',
        'config_form', 
        'config',
        'admin_head',
        'public_footer',
        'public_head');

	protected $_filters = array();


    protected $_options = array(
        'th_footer_html' => null,
        'th_footer_js' => null,
        'th_header_css'=>null,
        'th_header_js'=>null,
    );


        
    /*
    ** Plugin options
    */
    
    public function hookConfigForm()
    {
        require dirname(__FILE__) . '/config_form.php';
    }	
        
    public function hookConfig()
    {
        set_option('th_footer_js', $_POST['th_footer_js']);
        set_option('th_footer_html', $_POST['th_footer_html']);
        set_option('th_header_css', $_POST['th_header_css']);
        set_option('th_header_js', $_POST['th_header_js']);
    }	
    
    
    /*
	** Admin header
	*/
	
	public function hookAdminHead(){
		queue_js_file('highlight/highlight.pack');
		queue_css_file('highlight/monokai_sublime');
	}
	

    /*
	** Theme header
	*/
	
	public function hookPublicHead(){
		
		echo ( $opt=get_option('th_header_js') ) ? '<!-- ThemeHelper Ext JS -->'.$opt : null;
		echo ( $opt=get_option('th_header_css') ) ? '<!-- ThemeHelper CSS --><style type="text/css">'.$opt.'</style>' : null;
	
	}


    /*
	** Theme footer
	*/
	
	public function hookPublicFooter(){
		
		echo ( $opt=get_option('th_footer_html') ) ? '<!-- ThemeHelper Footer HTML -->'.$opt : null;
		echo ( $opt=get_option('th_footer_js') ) ? '<!-- ThemeHelper Footer JS --><script type="text/javascript">'.$opt.'</script>' : null;
		
	}

    /**
     * Install the plugin.
     */
    public function hookInstall()
    {		
		$this->_installOptions();    
    
    }

    /**
     * Uninstall the plugin.
     */
    public function hookUninstall()
    {        
		$this->_uninstallOptions();	
		
    }	
}

function syntax_highlighting($option=null,$class=null,$escape=false,$label=null){
	
	$userCode = get_option($option);
	
	return '<div class="highlight-container"><pre><code '.($class ? 'class="'.$class.'"' : null).'>'.($escape ? htmlspecialchars($userCode,ENT_QUOTES) : $userCode).'</code></pre>'.($label ? '<span class="highlight-label">'.$label.'</span>' : null).'</div>';
	
}