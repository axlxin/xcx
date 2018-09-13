<?php
// Heading
$_['heading_title']        = 'Your order has been placed!';

// Text
$_['text_basket']          = 'Shopping Cart';
$_['text_checkout']        = 'Checkout';
$_['text_success']         = 'Success';
$_['text_customer']        = '<p>Your order has been successfully processed!</p><p>You can view your order history by going to the <a href="%s">my account</a> page and by clicking on <a href="%s">history</a>.</p><p>If your purchase has an associated download, you can go to the account <a href="%s">downloads</a> page to view them.</p><p>Please direct any questions you have to the <a href="%s">store owner</a>.</p><p>Thanks for shopping with us online!</p><!-- Socedo Tracking Code-->
<script type="text/javascript">
var _socedo = _socedo || [];(function () {var e = ["init", "track", "trackLink"], t = function (e) { return function () { _socedo.push([e].concat(Array.prototype.slice.call(arguments, 0))) } };
for (var n = 0; n < e.length; n++) _socedo[e[n]] = t(e[n])})(), _socedo.load = function (e, o) { _socedo._endpoint = e; if (o) { _socedo.init(o) };
var t = document.createElement("script"); t.type = "text/javascript", t.async = !0, t.src = ("https:" === document.location.protocol ? "https://" : "http://") + "api.socedo.com/Content/soc.js";
var n = document.getElementsByTagName("script")[0]; n.parentNode.insertBefore(t, n) };
_socedo.load(("https:" === document.location.protocol ? "https://" : "http://") + "api.socedo.com");
_socedo.track("6dFdjG", "pageview");
</script>
<noscript><img src="https://api.socedo.com/trk/6dFdjG" alt="" width="1" height="1" style="display:none"></noscript><script>
  fbq("track", "Purchase");
</script>';
$_['text_guest']           = '<p>Your order has been successfully processed!</p><p>Please direct any questions you have to the <a href="%s">store owner</a>.</p><p>Thanks for shopping with us online!</p>';