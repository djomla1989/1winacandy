<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Win a Candy</title>
<meta name="description" content="Win free candy. Play game and win a candy."> 
<meta name="keywords" content="slot, game, games, win, candy, win a candy, free candy, play game">
<meta http-equiv="Content-Language" content="en">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="publisher" content="Djomla"/>
<meta name="copyright" content="Djomla"/>
<meta name="page-type" content="browser game, browsergame"/>
<meta name="page-topic" content="browser game, strategy game, online game"/>
<meta name="audience" content="all"/>
<meta name="expires" content="never"/>

    <?php 
    if (is_array($css_to_load)) {
        foreach ($css_to_load as $key => $value) {
            echo '<link href="'.base_url().'public/css/'.$value.'" type="text/css" rel="stylesheet">';
        }
    }
    ?>

</head>

<script>
    var isLocal = <?php echo ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') ? 'true' : 'false';?>;
    var today   = '<?php echo $today?>';
    var maxNumberOfShots = '<?php echo $maxNumberOfShots ?>';
    var userTodayShots = '<?php echo $userShots?>';
</script>

<?php  if (!$isLocal): ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-27341533-6', 'auto');
  ga('send', 'pageview');

</script>
<?php endif;?>
<body>