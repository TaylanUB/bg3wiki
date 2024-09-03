/*
 * Note: CSS viewport width/height doesn't match innerWidth/innerHeight!
 * Use window.matchMedia to make sure we're in sync with CSS.
 */

const ramp = window.ramp = {};
const fusetag = window.fusetag = {};

function matchMinWH(w, h) {
	return matchMedia(
		`(min-width: ${w}px) and (min-height: ${h}px)`
	);
}

let matcher = matchMinWH(320, 600);

if (matcher.matches) {
	enableAds();
} else {
	matcher.onchange = function() {
		if (matcher.matches) {
			matcher.onchange = null;
			matcher = null;
			enableAds();
		}
	};
}

function enableAds() {
	let provider = localStorage.getItem('ad_provider');
	if (provider == null) {
		const query = new URLSearchParams(location.search);
		provider = query.get('ad_provider');
	}
	if (provider == null) {
		provider = Math.random() < 0.5 ? 'playwire' : 'publift';
	}

	const notice = document.getElementById('bg3wiki-ad-provider-notice');
	notice.innerText = 'Ads provided by: ' + provider;

	loadAdScript(provider);
}

function loadAdScript(provider) {
	let src;
	if (provider == 'playwire') {
		src = '//cdn.intergient.com/1025372/75208/ramp.js';
		ramp.que = [ rampSetup ];
		ramp.passiveMode = true;
	} else {
		src = '//cdn.fuseplatform.net/publift/tags/2/3741/fuse.js';
		fusetag.que = [ fuseSetup ];
	}

	const script = document.createElement('script');
	script.async = true;
	script.src = src;
	script.onerror = function(){
		const classes = document.body.classList;
		classes.replace('mw-ads-enabled', 'mw-ads-disabled');
	};
	document.body.appendChild(script);
}

async function rampSetup() {
	const classes = document.body.classList;
	if (!classes.contains('skin-citizen')) {
		return await ramp.spaNewPage();
	}

	const footerTypes = [
		[ matchMinWH(970, 800), 'standard_iab_foot3' ],
		[ matchMinWH(728, 800), 'standard_iab_foot2' ],
		[ matchMinWH(468, 600), 'standard_iab_foot1' ],
		[ matchMinWH(320, 600), 'standard_iab_foot1' ],
	];

	function footerTypeForScreenSize() {
		for (const entry of footerTypes)
			if (entry[0].matches)
				return entry[1];
	}

	let footerType = footerTypeForScreenSize();
	refreshFooterType();

	function onResize() {
		const newType = footerTypeForScreenSize();
		if (footerType != newType) {
			footerType = newType;
			ramp.que.push(refreshFooterType);
		}
	}

	let timeout;
	const delay = 200;
	function debouncedOnResize() {
		clearTimeout(timeout);
		timeout = setTimeout(onResize, delay);
	}

	addEventListener('resize', debouncedOnResize);

	async function refreshFooterType() {
		await ramp.destroyUnits('all');
		if (!footerType) {
			return;
		}

		await ramp.addUnits({
			type: footerType,
			selectorId: 'bg3wiki-footer-ad-ramp',
		});
		await ramp.displayUnits();
	}
}

function fuseSetup() {
	const classes = document.body.classList;
	if (!classes.contains('skin-citizen')) {
		return;
	}

	const footerFuseIds = [
		[ matchMinWH(970, 800), '23201541515' ],
		[ matchMinWH(728, 800), '23200582344' ],
		[ matchMinWH(468, 600), '23200580337' ],
		[ matchMinWH(320, 600), '23200581156' ],
	];

	function footerFuseIdForScreenSize() {
		for (const entry of footerFuseIds)
			if (entry[0].matches)
				return entry[1];
	}

	let footerFuseId = footerFuseIdForScreenSize();
	replaceFooterAdZone();

	function onResize() {
		const newFuseId = footerFuseIdForScreenSize();
		if (footerFuseId != newFuseId) {
			footerFuseId = newFuseId;
			fusetag.que.push(replaceFooterAdZone);
		}
	}

	let timeout;
	const delay = 200;
	function debouncedOnResize() {
		clearTimeout(timeout);
		timeout = setTimeout(onResize, delay);
	}

	addEventListener('resize', debouncedOnResize);

	function replaceFooterAdZone() {
		const outerDivId = 'bg3wiki-footer-ad';
		const innerDivId = 'bg3wiki-footer-ad-fuse';

		const outerDiv = document.getElementById(outerDivId);
		const innerDiv = document.getElementById(innerDivId);
		if (innerDiv != null) {
			outerDiv.removeChild(innerDiv);
		}

		if (footerFuseId) {
			const newDiv = document.createElement('div');
			newDiv.id = innerDivId;
			newDiv.setAttribute('data-fuse', footerFuseId);
			outerDiv.appendChild(newDiv);

			fusetag.registerZone(innerDivId);
		}
	}
}
