(function(){

let adsEnabled = false;

function maybeEnableAds(){
	if (adsEnabled) {
		return;
	}

	if (innerWidth < 320 || innerHeight < 720) {
		return;
	}

	enableAds();
	adsEnabled = true;
}

function enableAds() {
	const query = new URLSearchParams(window.location.search);
	let provider = query.get('ad_provider');
	if (provider == null) {
		if (Math.random() < 0.5) {
			provider = 'playwire';
		} else {
			provider = 'publift';
		}
	}

	console.log("Enabling ads for: " + provider);

	// For Playwire
	window.ramp = {};
	window.ramp.que = [];

	const script = document.createElement('script');
	script.async = true;
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

	const notice = document.getElementById('bg3wiki-ad-provider-notice');
	notice.innerText = 'Ads provided by: ' + provider;
}

maybeEnableAds();

addEventListener('resize', maybeEnableAds);

})()
