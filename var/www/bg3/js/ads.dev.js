(function(){
	var classes = document.body.classList;
	var height = window.innerHeight;
	if (classes.contains('skin-citizen') && height < 720) {
		console.log('Ads disabled because height < 720px.');
		return;
	}

	var query = new URLSearchParams(window.location.search);
	var provider = query.get('ad_provider');
	if (provider == null) {
		if (Math.random() < 1) {
			provider = 'playwire';
		} else {
			provider = 'publift';
		}
	}

	console.log("Enabling ads for: " + provider);

	var notice = document.getElementById('bg3wiki-ad-provider-notice');
	notice.innerText = 'Ads provided by: ' + provider;

	if (provider == 'publift') {
		// This is quite hacky but leave it like this until A/B test is done.
		// The divs for Playwire lay on top of the Publift ones and prevent
		// click-through events, so just remove them if provider is publift.
		var header = document.getElementById('bg3wiki-header-ad-ramp');
		var sidebar = document.getElementById('bg3wiki-sidebar-ad-ramp');
		var footer = document.getElementById('bg3wiki-footer-ad-ramp');
		for (const node of [ header, sidebar, footer ]) {
			if (node != null) {
				node.parentNode.removeChild(node);
			}
		}
	}

	// For Playwire
	window.ramp = {};
	window.ramp.que = [];

	var script = document.createElement('script');
	if (provider == 'playwire') {
		script.src = '//cdn.intergient.com/1025372/75208/ramp.js';
	} else {
		script.src = '//cdn.fuseplatform.net/publift/tags/2/3741/fuse.js';
	}
	script.onload = function(){
		console.log('Done loading ads JS.');
	};
	script.onerror = function(){
		console.log('Error loading ads JS.');
	};
	document.body.appendChild(script);
})()
