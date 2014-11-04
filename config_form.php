<style>
	.highlight-container,.input-block{
		display: block;
		clear: both;
		width: 100%;
		}
	.highlight-label{
		}
	label{
		font-size:1.1em;
		font-weight:700;
		}
	p.explanation{
		font-size:.9em;
		font-style: italic;
		}
	.hidden{
		display:none;
		}
</style>

<h2><?php echo __('Custom Settings'); ?></h2>

<fieldset id="settings">
	

	<h3><?php echo __('CSS'); ?></h3>
	
	
	<div class="th_header_css">
	    <div class="seven columns alpha">
	        <label for="th_header_css"><?php echo __('Styles'); ?></label>
	    </div>
	
	    <div class="inputs seven columns alpha">
	        <p class="explanation"><?php echo __("Custom CSS is embedded in the theme header before the opening &lt;body&gt; tag. <br>Omit the opening and closing &lt;style&gt; tags."); ?></p>
	
	        <div class="input-block">
	            <textarea placeholder="<?php echo __('#example{ line-height:inherit; }');?>" rows="4" class="textinput" name="th_header_css"><?php echo get_option('th_header_css'); ?></textarea>
				<?php echo syntax_highlighting('th_header_css','css',true);?>
	        </div>
	        
	    </div>
	</div>
	
	
	
	<h3><?php echo __('JavaScript'); ?></h3>
	
	
	<div class="th_header_js">
	    <div class="seven columns alpha">
	        <label for="th_header_js"><?php echo __('External Scripts'); ?></label>
	    </div>
	
	    <div class="inputs seven columns alpha">
	        <p class="explanation"><?php echo __("Links to external scripts are appended to the theme header before the opening &lt;body&gt; tag."); ?></p>
	
	        <div class="input-block">
	            <textarea placeholder="<?php echo __('<script type=&quot;text/javascript&quot; src=&quot;/path/to/example.js&quot;> </script>');?>" rows="4" class="textinput" name="th_header_js"><?php echo get_option('th_header_js'); ?></textarea>
				<?php echo syntax_highlighting('th_header_js','html',true);?>
	        </div>
	        
	    </div>
	</div>
	
	
	<div class="th_footer_js">
	    <div class="seven columns alpha">
	        <label for="th_footer_js"><?php echo __('Inline Scripts'); ?></label>
	    </div>
	
	    <div class="inputs seven columns alpha">
	        <p class="explanation"><?php echo __("Custom scripts are appended to the theme footer before the closing &lt;body&gt; tag.<br> Omit the opening and closing &lt;script&gt; tags."); ?></p>
	
	        <div class="input-block">
	            <textarea placeholder="<?php echo __('console.log(&quot;example&quot;);');?>" rows="4" class="textinput" name="th_footer_js"><?php echo get_option('th_footer_js'); ?></textarea>
				<?php echo syntax_highlighting('th_footer_js','javascript',true);?>
	        </div>
	        
	    </div>
	</div>
	
	
	<h3><?php echo __('HTML'); ?></h3>
	
	<div class="th_footer_html">
	    <div class="seven columns alpha">
	        <label for="th_footer_html"><?php echo __('Footer HTML'); ?></label>
	    </div>
	
	    <div class="inputs seven columns alpha">
	        <p class="explanation"><?php echo __("Custom HTML is appended to the theme footer."); ?></p>
	
	        <div class="input-block">
	            <textarea placeholder="<?php echo __('<div class=&quot;example&quot;></div>');?>" rows="4" class="textinput" name="th_footer_html"><?php echo get_option('th_footer_html'); ?></textarea>
				<?php echo syntax_highlighting('th_footer_html','html',true);?>
	        </div>
	        
	    </div>
	</div>

</fieldset>
        
<script>

	function th_escape(text) {
	  var map = {
	    '&': '&amp;',
	    '<': '&lt;',
	    '>': '&gt;',
	    '"': '&quot;',
	    "'": '&#039;'
	  };
	
	  return text.replace(/[&<>"']/g, function(m) { return map[m]; });
	}
	
	function th_highlight(){
		
		jQuery('pre code').each(function(i, block) {
			hljs.highlightBlock(block);
		});	
		
	}
	
	jQuery(document).ready(function() {
	  
		// run the syntax highlighting script
		th_highlight();
	
		jQuery('textarea').each(function(){
			
			if(jQuery(this).val().length == 0){
				
				// hide empty code containers
				jQuery(this).next().addClass('hidden');
			
			}
			
			jQuery(this).keyup(function(){
				
				// if the user is entering text, show the code container
				jQuery(this).next().removeClass('hidden');
				
				// mirror the user input from the textarea in the code container
			    jQuery(this).next().find('pre code').html(th_escape(this.value));
				
				}).blur(function(){
					
					// if the user mouses away and the textarea is empty, re-hide the code container
					if(jQuery(this).val().length == 0){
						jQuery(this).next().addClass('hidden');
					}	
						
					// refres the syntax highlighting each time the user leaves a textarea			
					th_highlight();
					
				});
			});	
		
		// refresh the syntax highlighting once per second
		setInterval(function(){th_highlight();}, 1000);
		
		});	
		
</script>                                       