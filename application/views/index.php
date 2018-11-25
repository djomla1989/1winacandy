<?php  if ($canAccess): ?>
<div class="container center" id="slotWindow">
    <div><h1>Win a candy!!!</h1></div>
	
	<div class="main-wrapper">
		<div class="slot-wrapper">
			<div id="slot1" class="slot"></div>
			<div id="slot2" class="slot"></div>
			<div id="slot3" class="slot"></div>
			<div class="clear"></div>
		</div>
		<div id="result"></div>
		<div><button <?php  if (!$isLocal): ?> onClick="ga('send', 'event', 'Start', 'Click on Start', 'We are rolling');"<?php endif;?>
                class="btn btn-primary btn-lg magicBtn" id="control">Start</button></div>
	</div>

</div>
<?php endif;?>

<div aria-hidden="false" aria-labelledby="blockModalLabel" role="dialog" tabindex="-1" id="blockModal" class="modal fade in" style="padding-right: 17px;">
    <div class="modal-backdrop fade in" style="height: 100%;"></div>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
         <!-- <a class="close" href="#">×</a> -->
          <h3 id="blockModalLabel" class="modal-title">Sorry!!!</h3>
        </div>
        <div class="modal-body">
          <form role="form" class="" name="form" action="/winacandy/index/pay" method="POST">
              <div class="form-group">
                  You have reached 50 tries for today.
                  If you want to continue you can buy more shots.
              </div>
              <div class="form-group radioPricesList">
                  <?php foreach ($prices as $key => $value) { ?>
                     <label class="radio">
                        <input type="radio" name="buy" value="<?=$key?>"><?=$value['name']?></input>
                     </label>   
                   <?php } ?>
              </div>
          </form>
        </div>
        <div class="modal-footer">
          <!--<button data-dismiss="modal" class="btn btn-default" type="button">Close</button> -->
          <button class="btn btn-primary" type="button" id="buyButton">Buy more</button>
        </div>
      </div>
    </div>
</div>

<div aria-hidden="false" aria-labelledby="winnerModalLabel" role="dialog" tabindex="-1" id="winnerModal" class="modal fade in" style="padding-right: 17px;">
    <div class="modal-backdrop fade in" style="height: 100%;"></div>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <a class="close" href="#">×</a>
          <h3 id="winnerModalLabel" class="modal-title">Congratulations!!!</h3>
        </div>
        <div class="modal-body">
          <form role="form">
            <div class="form-group">
              <label class="control-label" for="recipient-name">Recipient:</label>
              <input type="text" id="recipient-name" class="form-control">
            </div>
            <div class="form-group">
              <label class="control-label" for="message-text">Message:</label>
              <textarea id="message-text" class="form-control"></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
          <button class="btn btn-primary" type="button">Send message</button>
        </div>
      </div>
    </div>
</div>

