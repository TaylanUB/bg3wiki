(function(){

if (window.innerWidth >= 320 && window.innerHeight >= 720) {
	enableAds();
} else {
	addEventListener('resize', maybeEnableAds);
}

function maybeEnableAds() {
	if (window.innerWidth < 320 || window.innerHeight < 720) {
		return;
	}

	enableAds();

	removeEventListener('resize', maybeEnableAds);
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

	if (provider == 'playwire') {
		window.ramp = {};
		window.ramp.que = [];
		window.ramp.passiveMode = true;
		window.ramp.que.push(rampSetup);
	} else {
		window.fusetag = {};
		window.fusetag.que = [];
//		window.fusetag.que.push(fuseSetup);
	}

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

function rampSetup() {
	const ramp = window.ramp;

	if (ramp.settings.device !== 'tablet') {
		ramp.spaNewPage();
		return;
	}

	if (window.innerWidth >= 728 && window.innerHeight >= 1024) {
		ramp.setPath('large-portrait-tablet').then(() => ramp.spaNewPage());
	} else {
		ramp.spaNewPage();
	}

	rampRegisterScreenResizeHandler();
}

function rampRegisterScreenResizeHandler() {
	const ramp = window.ramp;

	const thresholdWidth = 728;
	const thresholdHeight = 1024;

	let previousWidth = window.innerWidth;
	let previousHeight = window.innerHeight;

	let timeout;
	const delay = 200;
	function debouncedOnResize() {
		clearTimeout(timeout);
		timeout = setTimeout(onResize, delay);
	}

	window.addEventListener('resize', debouncedOnResize);

	function onResize() {
		const width = window.innerWidth;
		const height = window.innerHeight;

		if (!ramp.settings.slots) {
			return;
		}

		const slots = Object.keys(ramp.settings.slots);
		if (slots.some(key => key.includes("foot"))) {
			checkFooterSizeChange(width, height);
		}

		previousWidth = width;
		previousHeight = height;
	}

	function checkFooterSizeChange(width, height) {
		if ((previousWidth < thresholdWidth && width >= thresholdWidth) ||
			(previousHeight < thresholdHeight && height >= thresholdHeight)) {

			console.log("Screen size >= 728x1024");
			setFooterLargeSize();

		} else if ((previousWidth >= thresholdWidth && width < thresholdWidth) ||
				   (previousHeight >= thresholdHeight && height < thresholdHeight)) {

			console.log("Screen size < 728x1024");
			setFooterSmallSize();

		}
	}

	function setFooterLargeSize() {
		ramp.setPath('large-portrait-tablet').then(() => {
			ramp.destroyUnits('all').then(() => {
				ramp.addUnits({
					type: 'standard_iab_foot2',
					selectorId: 'bg3wiki-footer-ad-ramp',
				}).then(() => {
					ramp.displayUnits();
				});
			});
		});
	}

	function setFooterSmallSize() {
		ramp.setPath('ROS').then(() => {
			ramp.destroyUnits('all').then(() => {
				ramp.addUnits({
					type: 'standard_iab_foot1',
					selectorId: 'bg3wiki-footer-ad-ramp',
				}).then(() => {
					ramp.displayUnits();
				});
			});
		});
	}
}

})()
