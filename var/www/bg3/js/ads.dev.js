/*
 * Note: CSS viewport width/height doesn't match innerWidth/innerHeight!
 * Use window.matchMedia to make sure we're in sync with CSS.
 */

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
	const ramp = window.ramp || (window.ramp = { que: [] });
	ramp.passiveMode = true;
	ramp.que.push(rampSetup);

	const script = document.createElement('script');
	script.async = true;
	script.src = '//cdn.intergient.com/1025372/75208/ramp.js';
	script.onerror = function(){
		const classes = document.body.classList;
		classes.replace('mw-ads-enabled', 'mw-ads-disabled');
	};
	document.body.appendChild(script);

	const notice = document.getElementById('bg3wiki-ad-provider-notice');
	if (notice) {
		notice.innerText = 'Ads provided by: playwire';
	}
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
