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
        require_once dirname(__FILE__) . '/libraries/CSSTidy/class.csstidy.php';

        $config = HTMLPurifier_Config::createDefault();
        $config->set('Filter.ExtractStyleBlocks', TRUE);
        $config->set('CSS.AllowImportant', TRUE);
        $config->set('CSS.AllowTricky', TRUE);
        $config->set('CSS.Proprietary', TRUE);
        $config->set('CSS.Trusted', TRUE);

        $purifier = new HTMLPurifier($config);
        
        $footer_html= $purifier->purify($_POST['th_footer_html']);
        $header_css	= $purifier->purify($_POST['th_header_css']);
	    
        set_option('th_footer_html', $footer_html);
        set_option('th_header_css', $header_css);
        set_option('th_footer_js', $_POST['th_footer_js']);
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

function syntax_highlighting($option=null,$class=null,$escape=false){
	
	$userCode = get_option($option);
	
	$html  = '<div class="highlight-container">';
	$html .= '<pre><code '.($class ? 'class="'.$class.'"' : null).'>';
	$html .= ($escape ? htmlspecialchars($userCode,ENT_QUOTES) : $userCode);
	$html .= '</code></pre>';
	$html .= '</div>';
	
	return $html;
	
}