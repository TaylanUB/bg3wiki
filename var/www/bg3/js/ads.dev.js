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
