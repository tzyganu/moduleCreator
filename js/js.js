if (window.jQuery){
	jQuery('document').ready(function(){
		jQuery('body').prepend('<a href="https://github.com/tzyganu/moduleCreator"><img style="position: absolute; top: 0; right: 0; border: 0; z-index:1040" src="https://s3.amazonaws.com/github/ribbons/forkme_right_orange_ff7600.png" alt="Fork me on GitHub"></a>')
		jQuery('a[href^="http"]').attr('target', '_blank');
		jQuery('body p').each(function(){
			var html = jQuery(this).html();
			jQuery(this).html(html.replace(/UMC/g, '<span class="tooltip-trigger" title="Ultimate Module Creator">UMC</span>'));
		});
		jQuery('.tooltip-trigger').tooltip();
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-41170039-1', 'tzyganu.github.io');
			ga('send', 'pageview');
	});	
}
