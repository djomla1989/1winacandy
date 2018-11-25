<footer class="footer">
    <div class="share col-xs-12 col-md-3 col-md-offset-5 col-xs-offset-2">
        <div class="share-facebook col-xs-3">
            <div class="fb-share-button" data-href="https://winacandy.com" data-type="button"></div>
        </div>
        <div class="share-twitter col-xs-3">
            <a href="https://twitter.com/share" class="twitter-share-button" data-count="none">Tweet</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
        </div>
        <div class="share-google col-xs-3">
            <!-- Place this tag where you want the +1 button to render. -->
            <div class="g-plusone" data-size="medium" data-annotation="none"></div>
        </div>
    </div>
    <div class="donation col-xs-12 col-xs-offset-5 col-xs-1 col-md-offset-3">
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
            <input type="hidden" name="cmd" value="_donations">
            <input type="hidden" name="business" value="djomla1989@hotmail.com">
            <input type="hidden" name="lc" value="US">
            <input type="hidden" name="item_name" value="winacandy">
            <input type="hidden" name="no_note" value="0">
            <input type="hidden" name="currency_code" value="USD">
            <input type="hidden" name="bn" value="PP-DonationsBF:btn_donate_SM.gif:NonHostedGuest">
            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
            <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
        </form>

    </div>
</footer>
    <?php 
    if (is_array($js_to_load)) {
        foreach ($js_to_load as $key => $value) {
            echo '<script type="text/javascript" src="'.base_url().'public/js/'.$value.'"></script>';
        }
    }
    ?>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
</body>



<!-- Place this tag after the last +1 button tag. -->
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/platform.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>

</html>