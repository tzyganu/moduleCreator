if (window.jQuery){
	jQuery('document').ready(function(){
		jQuery('body').prepend('<a href="https://github.com/tzyganu/moduleCreator"><img style="position: absolute; top: 0; right: 0; border: 0; z-index:1040" src="https://s3.amazonaws.com/github/ribbons/forkme_right_orange_ff7600.png" alt="Fork me on GitHub"></a>')
		jQuery('a[href^="http"]').attr('target', '_blank');
		jQuery('body p').each(function(){
			var html = jQuery(this).html();
			jQuery(this).html(html.replace(/UMC/g, '<span class="tooltip-trigger" title="Ultimate Module Creator">UMC</span>'));
		});
		jQuery('.tooltip-trigger').tooltip();
	});
}
