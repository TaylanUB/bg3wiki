<?php

$bg3wikiRampJs = '//cdn.intergient.com/1025372/75208/ramp.js';

#$bg3wikiHeaderAdId  = 'bg3wiki-header-ad-ramp';
#$bg3wikiSidebarAdId = 'bg3wiki-sidebar-ad-ramp';
#$bg3wikiFooterAdId  = 'bg3wiki-footer-ad-ramp';

$bg3wikiHeaderAdId  = 'standard_iab_head1';
$bg3wikiSidebarAdId = 'standard_iab_left1';
$bg3wikiFooterAdId  = 'standard_iab_foot1';

$adsHeadScript = <<< EOF
<script>
  window.ramp = window.ramp || {};
  window.ramp.que = window.ramp.que || [];
</script>
EOF;

$adsBodyEndScript = <<< EOF
<script async src='$bg3wikiRampJs'></script>
EOF;

$adsHeaderDiv = <<< EOF
<div id='$bg3wikiHeaderAdId' data-pw-desk='$bg3wikiHeaderAdId'></div>
<script>
  window.ramp.que.push(function () {
    window.ramp.addTag('$bg3wikiHeaderAdId');
  })
</script>
EOF;

$adsSidebarDiv = <<< EOF
<div id='$bg3wikiSidebarAdId' data-pw-desk='$bg3wikiSidebarAdId'></div>
<script>
  window.ramp.que.push(function () {
    window.ramp.addTag('$bg3wikiSidebarAdId');
  })
</script>
EOF;

$adsFooterDiv = <<< EOF
<div id='$bg3wikiFooterAdId' data-pw-mobi='$bg3wikiFooterAdId'></div>
<script>
  if (window.innerHeight >= 720) {
    window.ramp.que.push(function () {
      window.ramp.addTag('$bg3wikiFooterAdId');
    })
  }
</script>
EOF;

# END
