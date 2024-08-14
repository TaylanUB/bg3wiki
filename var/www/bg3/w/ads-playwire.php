<?php

$bg3wikiRampJs = '//cdn.intergient.com/1025372/75208/ramp.js';

$adsHeadScript = <<< EOF
<script data-cfasync='false'>
  window.ramp = window.ramp || {};
  window.ramp.que = window.ramp.que || [];
</script>
EOF;

$adsBodyScript = <<< EOF
<script data-cfasync='false' async src='$bg3wikiRampJs'></script>
EOF;

$adsHeaderDiv = <<< EOF
<div id='bg3wiki-header-ad-ramp' data-pw-desk='standard_iab_head1'></div>
<script type='text/javascript'>
  window.ramp.que.push(function () {
    window.ramp.addTag('standard_iab_head1');
  })
</script>
EOF;

$adsSidebarDiv = <<< EOF
<div id='bg3wiki-sidebar-ad-ramp' data-pw-desk='standard_iab_left1'></div>
<script type='text/javascript'>
  window.ramp.que.push(function () {
    window.ramp.addTag('standard_iab_left1');
  })
</script>
EOF;

$adsFooterDiv = <<< EOF
<div id='bg3wiki-footer-ad-ramp' data-pw-mobi='standard_iab_foot1'></div>
<script type='text/javascript'>
  if (window.innerHeight >= 720) {
    window.ramp.que.push(function () {
      window.ramp.addTag('standard_iab_foot1');
    })
  }
</script>
EOF;

# END
